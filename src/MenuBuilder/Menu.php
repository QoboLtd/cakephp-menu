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
     * @const MENU_BUTTONS_TYPE
     */
    const MENU_BUTTONS_TYPE = 'buttons';

    /**
     * @const MENU_ACTIONS_TYPE
     */
    const MENU_ACTIONS_TYPE = 'actions';

    /**
     * @var $menuItems
     */
    protected $menuItems = [];

    /**
     *  addMenuItem method
     *
     * @param Menu\MenuBuilder\MenuItem $item menu item definition
     * @return void
     */
    public function addMenuItem($item)
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
        usort($this->menuItems, function ($a, $b) {
            return $a->getOrder() > $b->getOrder();
        });

        return $this->menuItems;
    }
}
