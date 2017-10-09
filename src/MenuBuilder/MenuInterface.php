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
