<?php

namespace Menu\MenuBuilder;

/**
 *  MenuInterface
 *
 * interface for any menu class
 */
interface MenuInterface
{
    /**
     *  addMenuItem method
     *
     * @param Menu\MenuBuilder\MenuItem $item menu item definition
     * @return void
     */
    public function addMenuItem($item);

    /**
     *  getMenuItems method
     *
     * @return array of menu items sorted according to menu item property
     */
    public function getMenuItems();
}
