<?php
/**
 * Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

namespace Menu\MenuBuilder;

use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\Event\EventDispatcherTrait;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\View\View;
use Exception;
use InvalidArgumentException;
use Menu\Event\EventName;
use Menu\MenuBuilder\Menu;
use Menu\MenuBuilder\MenuItemFactory;

/**
 * Class MenuFactory
 *
 * Facilitates the construction of new menus by using database or php array configuration
 *
 * @package Menu\MenuBuilder
 */
class MenuFactory
{
    use EventDispatcherTrait;

    /**
     * Module type identifier
     */
    const TYPE_MODULE = 'module';

    /**
     * Current session user.
     *
     * @var array
     */
    protected $user = [];

    /**
     * Full-base URL flag.
     *
     * @var boolean
     */
    protected $fullBaseUrl = false;

    /**
     * @var \Cake\ORM\Table
     */
    protected $Menus;

    /**
     * @var \Cake\ORM\Table
     */
    protected $MenuItems;

    /**
     * MenuFactory constructor.
     * @param mixed[] $user User information
     * @param bool $fullBaseUrl Full-base URL flag
     */
    public function __construct(array $user, bool $fullBaseUrl = false)
    {
        $this->Menus = TableRegistry::get('Menu.Menus');
        $this->MenuItems = TableRegistry::get('Menu.MenuItems');

        $this->user = $user;
        $this->fullBaseUrl = $fullBaseUrl;
    }

    /**
     * Returns a menu instance based on the provided name.
     * If the name was found in database, it is checked whether the default option is enabled
     * If was found and the default option is disabled, the instance is constructed through events
     * Otherwise, the menu instance is constructed base on the menu settings defined in database
     *
     * @param string $name Menu name
     * @param mixed[] $user User info
     * @param bool $fullBaseUrl Full-base URL flag
     * @param mixed $context The object that generates the menu to be used as the event subject
     * @return \Menu\MenuBuilder\Menu
     */
    public static function getMenu(string $name, array $user, bool $fullBaseUrl = false, $context = null)
    {
        $instance = new self($user, $fullBaseUrl);

        return $instance->getMenuByName($name, $context);
    }

    /**
     * Extends the provided menu container by adding the provided menu array
     *
     * @param \Menu\MenuBuilder\Menu $menu Menu to be extended
     * @param mixed[] $items List of items to be appended to the provided menu instance
     * @return void
     */
    public static function addToMenu(Menu $menu, array $items): void
    {
        $normalisedItems = self::normaliseItems($items);
        foreach ($normalisedItems as $item) {
            $menu->addMenuItem(MenuItemFactory::createMenuItem($item));
        }
    }

    /**
     * Constructs a menu instance by using the provided menu array
     *
     * @param mixed[] $menu Menu configuration
     * @return \Menu\MenuBuilder\Menu
     */
    public static function createMenu(array $menu): \Menu\MenuBuilder\Menu
    {
        $menuInstance = new Menu();
        self::addToMenu($menuInstance, $menu);

        return $menuInstance;
    }

    /**
     * Creates and returns an instance of the specified menu renderer name (can be the short or the fully qualified name)
     *
     * @param string $renderer Renderer short name or FQN
     * @param \Menu\MenuBuilder\Menu $menu Menu to be rendered
     * @param \Cake\View\View $view View to be used for rendering
     * @return \Menu\MenuBuilder\MenuRenderInterface
     * @throws Exception
     */
    public static function getMenuRenderer(string $renderer, \Menu\MenuBuilder\Menu $menu, View $view)
    {
        $renderClass = $renderer;
        if (!class_exists($renderClass)) {
            $renderClass = 'Menu\\MenuBuilder\\Menu' . ucfirst($renderer) . 'Render';
            if (!class_exists($renderClass)) {
                throw new InvalidArgumentException('Menu render class [' . $renderClass . '] is not found!');
            }
        }

        return new $renderClass($menu, $view);
    }

    /**
     * Returns a menu instance based on the provided name
     *
     * @param string $name Menu's name
     * @param null|mixed $context  The object that generates the menu to be used as the event subject
     * @return \Menu\MenuBuilder\Menu
     */
    protected function getMenuByName(string $name, $context = null)
    {
        // validate menu name
        $this->validateName($name);

        // get menu
        $menuEntity = null;
        try {
            $menuEntity = $this->Menus->findByName($name)->firstOrFail();

            $menuInstance = $menuEntity->default ?
                $this->getMenuItemsFromEvent($name, [], $context) :
                $this->getMenuItemsFromTable($menuEntity);
        } catch (Exception $e) {
            $menuInstance = static::getMenuItemsFromEvent($name, [], $context);
        }

        // maintain backwards compatibility for menu arrays
        if (is_array($menuInstance)) {
            $menuInstance = self::normaliseItems($menuInstance);
            if ($menuEntity instanceof EntityInterface && $menuEntity->default) {
                $menuInstance = $this->sortItems($menuInstance);
            }

            $menuInstance = self::createMenu($menuInstance);
        }

        return $menuInstance;
    }

    /**
     * Menu items getter using Event.
     *
     * @param string $menuName Menu name
     * @param mixed[] $modules Modules to fetch menu items for
     * @param null|mixed $subject Event subject to be used. $this will be used in null
     * @return \Menu\MenuBuilder\Menu
     */
    protected function getMenuItemsFromEvent(string $menuName, array $modules = [], $subject = null)
    {
        if (empty($subject)) {
            $subject = $this;
        }

        $event = new Event((string)EventName::GET_MENU_ITEMS(), $subject, [
            'name' => $menuName,
            'user' => $this->user,
            'fullBaseUrl' => $this->fullBaseUrl,
            'modules' => $modules
        ]);
        $this->getEventManager()->dispatch($event);

        return $event->result ? $event->result : [];
    }

    /**
     * Menu items getter using database table.
     *
     * @param \Cake\Datasource\EntityInterface $menu Menu entity
     * @return array
     */
    protected function getMenuItemsFromTable(EntityInterface $menu)
    {
        $query = $this->MenuItems->find('threaded', [
            'conditions' => ['MenuItems.menu_id' => $menu->id],
            'order' => ['MenuItems.lft']
        ]);

        if ($query->isEmpty()) {
            return [];
        }

        $result = [];
        $count = 0;
        foreach ($query->all() as $entity) {
            $item = $this->getMenuItem($menu, $entity->toArray(), ++$count);

            if (empty($item)) {
                continue;
            }
            $result[] = $item;
        }

        return $result;
    }

    /**
     * Menu item getter.
     *
     * @param \Cake\Datasource\EntityInterface $menu Menu entity
     * @param mixed[] $item Menu item
     * @param int $order Menu item order
     * @return mixed[]
     */
    protected function getMenuItem(EntityInterface $menu, array $item, int $order = 0): array
    {
        if (empty($item)) {
            return [];
        }

        $label = $item['label'];
        $icon = $item['icon'];
        $type = $item['type'];

        $children = !empty($item['children']) ? $item['children'] : [];

        if (!empty($children)) {
            $count = 0;
            foreach ($children as $key => $child) {
                $children[$key] = $this->getMenuItem($menu, $child, ++$count);
            }
        }

        if (static::TYPE_MODULE === $type) {
            $item = $this->getMenuItemsFromEvent($menu->get('name'), [$item['url']]);
            reset($item);
            $item = current($item);
        }

        if (!empty($children)) {
            $item['children'] = $children;
        }

        if (empty($item)) {
            return [];
        }

        if (static::TYPE_MODULE === $type) {
            $item['label'] = $label;
            $item['icon'] = $icon;
        }

        $item['order'] = $order;

        return $item;
    }

    /**
     * Validates menu name and throws appropriate
     * exceptions if the validation fails.
     *
     * @param string $name Menu name
     * @return void
     * @throws \InvalidArgumentException
     */
    protected function validateName(string $name): void
    {
        if (empty($name)) {
            throw new InvalidArgumentException('Menu [name] cannot be empty.');
        }
    }

    /**
     * Applies the menu defaults on the provided menu item.
     * Defaults will be loaded from Configuration Menu.defaults if the provided array is empty
     *
     * @param mixed[] $items List of menu items
     * @param array|null $defaults List of default values for a menu item
     * @return mixed[] The provided list of menu items including the defaults
     */
    public static function applyDefaults(array $items, array $defaults = null): array
    {
        $defaults = empty($defaults) ? Configure::readOrFail('Menu.defaults') : $defaults;

        // merge item properties with defaults
        $func = function (&$item, $k) use (&$func, $defaults) {
            if (!empty($item['children'])) {
                array_walk($item['children'], $func);
            }

            $item = array_merge($defaults, $item);
        };
        array_walk($items, $func);

        return $items;
    }

    /**
     * Normalises the provided array menu items for the given module
     * Part of the normalisation is to
     * - merge duplicated labels, recursively
     * - apply defaults defined in Menu.defaults, recursively
     *
     * @param mixed[] $items Menu items
     * @return mixed[]
     */
    public static function normaliseItems(array $items): array
    {
        // merge item properties with defaults
        $items = self::applyDefaults($items);

        // merge duplicated labels recursively
        $result = [];
        foreach ($items as $item) {
            if (!array_key_exists($item['label'], $result)) {
                $result[$item['label']] = $item;
                continue;
            }

            $result[$item['label']]['children'] = array_merge_recursive(
                $item['children'],
                $result[$item['label']]['children']
            );
        }

        return $result;
    }

    /**
     * Method for sorting array items by specified key.
     *
     * @param mixed[] $items List of items to be sorted
     * @param string $key Sort-by key
     * @return mixed[]
     */
    protected function sortItems(array $items, string $key = 'order'): array
    {
        $cmp = function (&$a, &$b) use (&$cmp, $key) {
            if (!empty($a['children'])) {
                usort($a['children'], $cmp);
            }

            if (!empty($b['children'])) {
                usort($b['children'], $cmp);
            }

            return $a[$key] > $b[$key];
        };

        usort($items, $cmp);

        return $items;
    }
}
