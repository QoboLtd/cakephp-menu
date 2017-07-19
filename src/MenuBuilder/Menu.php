<?php

namespace Menu\MenuBuilder;

use Menu\MenuBuilder\MenuItem;
use Menu\MenuBuilder\MenuItemRenderFactory;

/**
 *  Menu class
 *
 */
class Menu implements MenuInterface
{
    /**
     * @var $title
     */
    protected $title = '';

    /**
     * @var $menuItems
     */
    protected $menuItems = [];

    /**
     *  addMenuItem method
     *
     * @param array $item menu item definition
     */
    public function addMenuItem(array $item)
    {
        array_push($this->menuItems, $item);
    }

    /**
     *  getMenuItems method
     *
     * @return array of menu items
     */
    public function getMenuItems()
    {
        return $this->menuItems;
    }

    /**
     *  title method
     * @param string $title set desire title for menu
     * @return string menu title
     */
    public function title($title = null)
    {
        if (!empty($title)) {
            $this->title = $title;
        }

        return $this->title;
    }
}
