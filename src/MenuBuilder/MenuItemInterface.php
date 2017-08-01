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
     * @return array list of child items
     */
    public function getChildren();

    /**
     *  addChild method
     *
     * @param MenuItem $item menu item
     * @return void
     */
    public function addChild(MenuItemInterface $item);

    /**
     * removeChild method
     *
     * @param string $childId to identify child item to be removed
     * @return void
     */
    public function removeChild($childId);
}
