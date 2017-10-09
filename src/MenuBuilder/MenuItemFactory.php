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
     * @return MenuItem object
     */
    public static function createMenuItem($item)
    {
        $menuItem = static::_getMenuItemObject($item);
        foreach ($item as $key => $value) {
            if ($key == 'children') {
                foreach ($value as $k => $v) {
                    $childItem = static::createMenuItem($v);
                    $menuItem->addChild($childItem);
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
     * _getMenuItemObject method
     *
     * @param array $data menu definition
     * @return MenuItem object or throw exception
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
