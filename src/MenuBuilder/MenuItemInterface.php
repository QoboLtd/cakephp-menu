<?php

namespace Menu\MenuBuilder;

/**
 *  MenuItemInterface
 *
 * interface for all menu item classes
 */
interface MenuItemInterface
{

    /**
     *  getChildren method
     *
     * @result array list of child items
     */
    public function getChildren();

    /**
     *  addChild method
     *
     * @param MenuItem $item menu item
     * @return void
     */
    public function addChild(MenuItem $item);

    /**
     * removeChild method
     *
     * @param string $childId to identify child item to be removed
     */
    public function removeChild($childId);
}
