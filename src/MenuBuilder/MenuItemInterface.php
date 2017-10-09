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
 *  MenuItemInterface
 *
 * interface for all menu item classes
 */
interface MenuItemInterface
{

    /**
     *  getChildren method
     *
     * @return array list of child items
     */
    public function getChildren();

    /**
     *  addChild method
     *
     * @param MenuItem $item menu item
     * @return void
     */
    public function addChild(MenuItemInterface $item);

    /**
     * removeChild method
     *
     * @param string $childId to identify child item to be removed
     * @return void
     */
    public function removeChild($childId);
}
