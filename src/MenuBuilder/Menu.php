<?php

namespace Menu\MenuBuilder;

use Menu\MenuBuilder\MenuItem;

/**
 *  Menu class
 *
 */
class Menu {
    
    /**
     * @var $menuItems
     */
    protected $menuItems = [];

    /**
     *  addMenuItem method
     *
     * @param array $item menu item definition
     */
    public function addMenuItem($item)
    {
        array_push($this->menuItems, $item);
    }
}
