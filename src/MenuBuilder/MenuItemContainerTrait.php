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

trait MenuItemContainerTrait
{
    /**
     * @var array List of menu items
     */
    private $menuItems = [];

    /**
     *  Adds the specified menu item to this container
     *  If the menu item has been part of another menu, removes it from that menu.
     *
     * @param MenuItemInterface $item the menu item to be added
     * @return void
     */
    public function addMenuItem(MenuItemInterface $item): void
    {
        array_push($this->menuItems, $item);
    }

    /**
     *  Returns the menu items.
     *
     * @return array List of menu items
     */
    public function getMenuItems(): array
    {
        usort($this->menuItems, function ($a, $b) {
            return $a->getOrder() > $b->getOrder();
        });

        return $this->menuItems;
    }

    /**
     * Removes the specified menu item from this container.
     * If the provided item is not in this container, this method does nothing.
     *
     * @param MenuItemInterface $item  The item to be removed from the menu.
     * @return void
     */
    public function removeMenuItem(MenuItemInterface $item): void
    {
        $key = array_search($item, $this->menuItems, true);
        if ($key !== false) {
            unset($this->menuItems[$key]);
        }
    }
}
