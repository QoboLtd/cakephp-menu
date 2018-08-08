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
interface MenuItemInterface extends MenuItemContainerInterface
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
     * @param bool $enabled Indicates whether this Menu item is enabled
     * @return void
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
     * @param callable $callback Callback to be evaluated as a boolean expression
     * @return void
     */
    public function disableIf(callable $callback);

    /**
     * Returns true only and only if:
     * - enabled flag is set to true
     * - all defined conditions are being evaluated to false
     * @return bool
     */
    public function isEnabled();

    /**
     * Gets the text label for this menu item.
     *
     * @return string the label of this menu item, or null if this menu item has no label.
     */
    public function getLabel();

    /**
     * Sets the text label for this menu item to the specified label.
     *
     * @param string $label the new label, or null for no label.
     * @return void
     */
    public function setLabel($label);

    /**
     * Gets the icon for this menu item.
     *
     * @return string the icon of this menu item, or null if this menu item has no icon.
     */
    public function getIcon();

    /**
     * Sets the icon for this menu item to the specified icon.
     * The specified icon can be any CSS Icon name as provided by an icon library, like Font Awesome.
     *
     * @param string $icon the new icon, or null for no icon.
     * @return void
     */
    public function setIcon($icon);

    /**
     * Gets the text description for this menu item.
     *
     * @return string the description of this menu item, or null if this menu item has no description.
     */
    public function getDescription();

    /**
     * Sets the text description for this menu item to the specified description.
     *
     * @param string $descr the new description, or null for no description.
     * @return void
     */
    public function setDescription($descr);

    /**
     * Gets the URL for this menu item.
     *
     * @return string|array the URL of this menu item, or null if this menu item has no URL.
     */
    public function getUrl();

    /**
     * Sets the URL for this menu item to the specified URL.
     *
     * @param string|array $url the new URL, or null for no URL.
     * @return void
     */
    public function setUrl($url);

    /**
     * Gets the order position for this menu item.
     * Default position is 0.
     *
     * @return int the position of this menu item.
     */
    public function getOrder();

    /**
     * Sets the order position for this menu item to the specified order.
     *
     * @param int $order the new position.
     * @return void
     */
    public function setOrder($order);

    /**
     * Gets the target for this menu item.
     * Default target is _self
     *
     * @return string the target of this menu item.
     */
    public function getTarget();

    /**
     * Sets target for this menu item to the specified target.
     * Default target is _self
     * The specified target can be one of the following:
     * - _self      Load in the same frame as it was clicked
     * - _blank     Load in a new window
     * - _parent    Load in the parent frameset
     * - _top       Load in the full body of the window
     * - framename  Load in a named frame
     *
     * @param string $target the new target.
     * @return void
     */
    public function setTarget($target);

    /**
     * Returns the raw HTML for this menu item.
     *
     * @return string the raw HTML for this menu item, or null if no HTML was provided.
     */
    public function getRawHtml();

    /**
     * Sets the raw HTML for this menu item to the specified HTML.
     *
     * @param string $rawHtml the new HTML, or null for no HTML.
     * @return void
     */
    public function setRawHtml($rawHtml);
}
