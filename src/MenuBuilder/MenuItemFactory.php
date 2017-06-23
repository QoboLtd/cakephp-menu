<?php

namespace Menu\MenuBuilder;

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
        $menuItem = new MenuItem();

        foreach ($item as $key => $value) {
            if ($key == 'children') {
                foreach ($value as $k => $v) {
                    $childItem = static::createMenuItem($v);
                    $menuItem->addChild($childItem);
                }
            } else {
                $menuItem->set($key, $value);
            }
        }

        return $menuItem;
    }
}
