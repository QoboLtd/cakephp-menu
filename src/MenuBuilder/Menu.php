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
     * @param \Menu\MenuBuilder\MenuItemInterface $item menu item definition
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

    /**
     * @inheritdoc
     *
     * @param MenuItemInterface $item the menu item to be added
     * @return void
     */
    public function add(MenuItemInterface $item)
    {
        $this->addMenuItem($item);
    }

    /**
     * @inheritdoc
     *
     * @return array List of menu items
     */
    public function getAll()
    {
        return $this->getMenuItems();
    }

    /**
     * Removes the specified menu item from this container.
     * If the provided item is not in this container, this method does nothing.
     *
     * @param MenuItemInterface $item The item to be removed from the menu.
     * @return void
     */
    public function remove(MenuItemInterface $item)
    {
        $key = array_search($item, $this->menuItems);
        if ($key !== false) {
            unset($this->menuItems[$key]);
        }
    }
}
