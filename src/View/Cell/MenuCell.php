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
namespace Menu\View\Cell;

use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\View\Cell;
use Exception;
use InvalidArgumentException;
use Menu\Event\EventName;
use Menu\MenuBuilder\Menu;

class MenuCell extends Cell
{
    /**
     * Default menu renderer class
     */
    const DEFAULT_RENDERER = 'Menu\\MenuBuilder\\SystemMenuRenderAdminLte';

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
     * Menu item defaults.
     *
     * @var array
     */
    protected $_defaults = [
        'url' => '#',
        'label' => 'Undefined',
        'icon' => 'circle-o',
        'order' => 0,
        'target' => '_self',
        'children' => [],
        'desc' => ''
    ];

    /**
     * Default display method.
     *
     * Retrieves menu items and rendering format and passes them to the Cell View.
     *
     * @param string $name Menu name
     * @param array $user User info
     * @param bool $fullBaseUrl Full-base URL flag
     * @param string $renderer Menu renderer class name
     * @param mixed $context The object that generates the menu to be used as the event subject
     * @return void
     */
    public function display($name, array $user, $fullBaseUrl = false, $renderer = null, $context = null)
    {
        // validate menu name
        $this->_validateName($name);

        if (is_null($renderer)) {
            $renderer = static::DEFAULT_RENDERER;
        }

        $this->loadModel('Menu.Menus');

        $this->user = $user;
        $this->fullBaseUrl = (bool)$fullBaseUrl;

        // get menu
        try {
            $menu = $this->Menus->findByName($name)->firstOrFail();

            $menuItems = $menu->default ?
                $this->_getMenuItemsFromEvent($name, [], $context) :
                $this->_getMenuItemsFromTable($menu);
        } catch (Exception $e) {
            $menuItems = $this->_getMenuItemsFromEvent($name, [], $context);
        }

        // maintain backwards compatibility for menu arrays
        if (is_array($menuItems)) {
            $menuItems = $this->_normalizeItems($menuItems);
            if ($menu->default) {
                $menuItems = $this->_sortItems($menuItems);
            }
        }

        $this->set('menuItems', $menuItems);
        $this->set('user', $this->user);
        $this->set('name', $name);
        $this->set('renderer', $renderer);
    }

    /**
     * Menu items getter using Event.
     *
     * @param string $menuName Menu name
     * @param array $modules Modules to fetch menu items for
     * @param null|mixed $subject Event subject to be used. $this will be used in null
     * @return array
     */
    protected function _getMenuItemsFromEvent($menuName, array $modules = [], $subject = null)
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
        $this->eventManager()->dispatch($event);

        return $event->result ? $event->result : [];
    }

    /**
     * Menu items getter using database table.
     *
     * @param \Cake\Datasource\EntityInterface $menu Menu entity
     * @return array
     */
    protected function _getMenuItemsFromTable(EntityInterface $menu)
    {
        $this->loadModel('Menu.MenuItems');

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
            $item = $this->_getMenuItem($menu, $entity->toArray(), ++$count);

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
     * @param array $item Menu item
     * @param int $order Menu item order
     * @return array
     */
    protected function _getMenuItem(EntityInterface $menu, array $item, $order = 0)
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
                $children[$key] = $this->_getMenuItem($menu, $child, ++$count);
            }
        }

        if (static::TYPE_MODULE === $type) {
            $item = $this->_getMenuItemsFromEvent($menu->get('name'), [$item['url']]);
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
    protected function _validateName($name)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException('Menu [name] must be a string.');
        }

        if (empty($name)) {
            throw new InvalidArgumentException('Menu [name] cannot be empty.');
        }
    }

    /**
     * Menu items normalization method.
     *
     * @param array $items Menu items
     * @return array
     */
    protected function _normalizeItems(array $items)
    {
        // merge item properties with defaults
        $func = function (&$item, $k) use (&$func) {
            if (!empty($item['children'])) {
                array_walk($item['children'], $func);
            }

            $item = array_merge($this->_defaults, $item);
        };
        array_walk($items, $func);

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
     * @param array $items List of items to be sorted
     * @param string $key Sort-by key
     * @return array
     */
    protected function _sortItems(array $items, $key = 'order')
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
