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

/**
 * Interface MenuItemContainerInterface
 * Denotes a container of menu items.
 * Menu items can be added or removed from the container.
 * @package Menu\MenuBuilder
 */
interface MenuItemContainerInterface
{
    /**
     *  Adds the specified menu item to this container
     *  If the menu item has been part of another menu, removes it from that menu.
     *
     * @param MenuItemInterface $item the menu item to be added
     * @return void
     */
    public function addMenuItem(MenuItemInterface $item): void;

    /**
     *  Returns the menu items.
     *
     * @return array List of menu items
     */
    public function getMenuItems(): array;

    /**
     * Removes the specified menu item from this container.
     * If the provided item is not in this container, this method does nothing.
     *
     * @param MenuItemInterface $item  The item to be removed from the menu.
     * @return void
     */
    public function removeMenuItem(MenuItemInterface $item): void;
}
