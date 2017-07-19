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
     * @param array $item menu item definition
     */
    public function addMenuItem(array $item);

    /**
     *  getMenuItems method
     *
     * @return array of menu items sorted according to menu item property
     */
    public function getMenuItems();
}
