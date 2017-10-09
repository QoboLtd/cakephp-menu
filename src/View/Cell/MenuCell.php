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
use InvalidArgumentException;
use Menu\Event\EventName;

class MenuCell extends Cell
{
    /**
     * Module type identifier
     */
    const TYPE_MODULE = 'module';

    /**
     * Current session user.
     *
     * @var array
     */
    protected $_user = [];

    /**
     * Menu rendering format.
     *
     * @var array
     */
    protected $_format = [];

    /**
     * Full-base URL flag.
     *
     * @var boolean
     */
    protected $_fullBaseUrl = false;

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
     * Supported render formats.
     *
     * @var array
     */
    protected $_renderFormats = [
        RENDER_AS_PROVIDED => [
            'menuStart' => '',
            'menuEnd' => '',
            'itemStart' => '',
            'itemEnd' => '',
            'item' => '%label%',
        ],
        RENDER_AS_LIST => [
            'menuStart' => '<ul>',
            'menuEnd' => '</ul>',
            'itemStart' => '<li>',
            'itemEnd' => '</li>',
            'item' => '<a href="%url%"><i class="fa fa-%icon%"></i> %label%</a>',
        ],
        RENDER_AS_DROPDOWN => [
            'menuStart' => '<select>',
            'menuEnd' => '</select>',
            'itemStart' => '<option>',
            'itemEnd' => '</option>',
            'item' => '<i class="fa fa-%icon%"></i> %label%',
        ],
        RENDER_AS_NONE => [
            'menuStart' => '',
            'menuEnd' => '',
            'itemStart' => '',
            'itemEnd' => '',
            'item' => '',
        ]
    ];

    /**
     * Default display method.
     *
     * Retrieves menu items and rendering format and passes them to the Cell View.
     *
     * @param string $name Menu name
     * @param string|array $renderAs Rendering format name or data array
     * @param array $user User info
     * @param bool $fullBaseUrl Full-base URL flag
     * @return void
     */
    public function display($name, $renderAs, array $user = [], $fullBaseUrl = false)
    {
        // validate menu name
        $this->_validateName($name);

        $this->_format = $this->_getFormat($renderAs);

        $this->loadModel('Menu.Menus');

        $this->_user = !empty($user) ? $user : $this->_getUser($user);
        $this->_fullBaseUrl = (bool)$fullBaseUrl;

        // get menu
        $menu = $this->Menus->findByName($name)->firstOrFail();

        $menuItems = $menu->default ?
            $this->_getMenuItemsFromEvent($menu) :
            $this->_getMenuItemsFromTable($menu);

        $menuItems = $this->_normalizeItems($menuItems);

        if ($menu->default) {
            $menuItems = $this->_sortItems($menuItems);
        }

        $this->set('menuItems', $menuItems);
        $this->set('user', $this->_user);
        $this->set('format', $this->_format);
        $this->set('name', $name);
    }

    /**
     * Menu items getter using Event.
     *
     * @param \Cake\Datasource\EntityInterface $menu Menu entity
     * @param array $modules Modules to fetch menu items for
     * @return array
     */
    protected function _getMenuItemsFromEvent(EntityInterface $menu, array $modules = [])
    {
        $event = new Event((string)EventName::GET_MENU_ITEMS(), $this, [
            'name' => $menu->name,
            'user' => $this->_user,
            'fullBaseUrl' => $this->_fullBaseUrl,
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
            $item = $this->_getMenuItemsFromEvent($menu, [$item['url']]);
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
     * Current session user getter method.
     *
     * Uses PHP's $_SESSION global variable to fetch current session user.
     *
     * @return array
     */
    protected function _getUser()
    {
        if (isset($_SESSION['Auth']['User'])) {
            return $_SESSION['Auth']['User'];
        };

        return [];
    }

    /**
     * Menu rendering format getter.
     *
     * @param string|array $renderAs Rendering format name or data array
     * @return array
     * @throws \InvalidArgumentException
     */
    protected function _getFormat($renderAs)
    {
        $defaults = [
            'menuStart' => '<ul>',
            'menuEnd' => '</ul>',
            'childMenuStart' => '<ul>',
            'childMenuEnd' => '</ul>',
            'itemStart' => '<li>',
            'itemEnd' => '</li>',
            'item' => '%label%',
        ];

        if (is_string($renderAs)) {
            if (!array_key_exists($renderAs, $this->_renderFormats)) {
                throw new InvalidArgumentException('Render format [' . $renderAs . '] not found.');
            }

            return $renderFormats[$renderAs];
        }

        if (is_array($renderAs)) {
            return array_merge($defaults, $renderAs);
        }

        throw new InvalidArgumentException('[renderAs] variable must be an array or string.');
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
