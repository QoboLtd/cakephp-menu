<?php

namespace Menu\MenuBuilder;

/**
 *  MenuItemInterface
 *
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
}
