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
     * @param MenuItemInterface $item menu item
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

    /**
     * Sets the enabled flag to the provided value
     * @param boolean $enabled
     * @return mixed
     */
    public function setEnabled($enabled);

    /**
     * Sets the enabled flag to true.
     * Alias for setEnabled(true)
     * @see MenuItemInterface::setEnabled()
     * @return void
     */
    public function enable();

    /**
     * Sets the enabled flag to false.
     * Alias for setEnabled(false)
     * @see MenuItemInterface::setEnabled()
     * @return  void
     */
    public function disable();

    /**
     * Adds a new condition to determine whether this item must be disabled
     * @param callable $callback
     * @return void
     */
    public function disableIf(callable $callback);

    /**
     * Returns true only and only if:
     * - enabled flag is set to true
     * - all defined conditions are being evaluated to false
     * @return boolean
     */
    public function isEnabled();
}
