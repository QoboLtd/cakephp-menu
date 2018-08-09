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

use Cake\Datasource\EntityInterface;
use Cake\Utility\Inflector;
use Menu\MenuBuilder\BaseMenuItem;

/**
 *  MenuItemFactory class
 *
 * @author Michael Stepanov <m.stepanov@qobo.biz>
 */
final class MenuItemFactory
{
    /**
     *  createMenuItem method
     *
     * @param array $item menu item definition
     * @return \Menu\MenuBuilder\MenuItemInterface object
     */
    public static function createMenuItem($item)
    {
        $menuItem = static::_getMenuItemObject($item);
        foreach ($item as $key => $value) {
            if ($key == 'children') {
                foreach ($value as $k => $v) {
                    $childItem = static::createMenuItem($v);
                    $menuItem->addMenuItem($childItem);
                }
            } else {
                $method = 'set' . ucfirst(Inflector::camelize($key));
                if (method_exists($menuItem, $method)) {
                    $menuItem->$method($value);
                }
            }
        }

        return $menuItem;
    }

    /**
     * Iterates through the specified query and creates a new menu item for each record found.
     * Returns the created menu items as an array
     *
     * @param array $query List of EntityInterface
     * @param string $labelColumn Column to be used as the label
     * @param string|array $url  Menu URL using %s as the ID placeholder
     * @param string $icon Menu icon to be used
     * @param int $order The starting menu order
     * @return array List of created menu items
     */
    public static function createMenuItemsFromQuery($query, $labelColumn, $url, $icon, $order)
    {
        $items = [];

        /**
         * @var int $i
         * @var EntityInterface $entity
         */
        foreach ($query as $i => $entity) {
            $items[] = MenuItemFactory::createMenuItem([
                'label' => $entity->get($labelColumn),
                'url' => sprintf($url, $entity->get('id')),
                'icon' => $icon,
                'order' => $order + $i,
            ]);
        }

        return $items;
    }

    /**
     * _getMenuItemObject method
     *
     * @param array $data menu definition
     * @return \Menu\MenuBuilder\MenuItemInterface object or throw exception
     */
    protected static function _getMenuItemObject($data)
    {
        $itemType = !empty($data['type']) ? $data['type'] : BaseMenuItem::DEFAULT_MENU_ITEM_TYPE;

        $className = __NAMESPACE__ . '\\' . BaseMenuItem::MENU_ITEM_CLASS_PREFIX . ucfirst(Inflector::camelize($itemType));
        $interface = __NAMESPACE__ . '\\' . BaseMenuItem::MENU_ITEM_INTERFACE;

        if (class_exists($className) && in_array($interface, class_implements($className))) {
            return new $className();
        }

        throw new \InvalidArgumentException("Unknown menu item type [$itemType]!");
    }
}
