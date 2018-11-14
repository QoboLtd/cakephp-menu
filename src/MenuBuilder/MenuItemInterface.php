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

use Cake\View\View;

/**
 *  MenuItemInterface
 *
 * interface for all menu item classes
 */
interface MenuItemInterface extends MenuItemContainerInterface
{

    /**
     * Sets the enabled flag to the provided value
     * @param bool $enabled Indicates whether this Menu item is enabled
     * @return void
     */
    public function setEnabled(bool $enabled): void;

    /**
     * Sets the enabled flag to true.
     * Alias for setEnabled(true)
     * @see MenuItemInterface::setEnabled()
     * @return void
     */
    public function enable(): void;

    /**
     * Sets the enabled flag to false.
     * Alias for setEnabled(false)
     * @see MenuItemInterface::setEnabled()
     * @return  void
     */
    public function disable(): void;

    /**
     * Adds a new condition to determine whether this item must be disabled
     * @param callable $callback Callback to be evaluated as a boolean expression
     * @return void
     */
    public function disableIf(callable $callback): void;

    /**
     * Returns true only and only if:
     * - enabled flag is set to true
     * - all defined conditions are being evaluated to false
     * - if having child menu items, one of them is enabled
     * @return bool
     */
    public function isEnabled(): bool;

    /**
     * Gets the text label for this menu item.
     *
     * @return string the label of this menu item, or null if this menu item has no label.
     */
    public function getLabel(): string;

    /**
     * Sets the text label for this menu item to the specified label.
     *
     * @param string $label the new label, or null for no label.
     * @return void
     */
    public function setLabel(string $label): void;

    /**
     * Gets the icon for this menu item.
     *
     * @return string the icon of this menu item, or null if this menu item has no icon.
     */
    public function getIcon(): string;

    /**
     * Sets the icon for this menu item to the specified icon.
     * The specified icon can be any CSS Icon name as provided by an icon library, like Font Awesome.
     *
     * @param string $icon the new icon, or null for no icon.
     * @return void
     */
    public function setIcon(string $icon): void;

    /**
     * Gets the text description for this menu item.
     *
     * @return string the description of this menu item, or null if this menu item has no description.
     */
    public function getDescription(): string;

    /**
     * Sets the text description for this menu item to the specified description.
     *
     * @param string $descr the new description, or null for no description.
     * @return void
     */
    public function setDescription(string $descr): void;

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
    public function setUrl($url): void;

    /**
     * Gets the order position for this menu item.
     * Default position is 0.
     *
     * @return int the position of this menu item.
     */
    public function getOrder(): int;

    /**
     * Sets the order position for this menu item to the specified order.
     *
     * @param int $order the new position.
     * @return void
     */
    public function setOrder(int $order): void;

    /**
     * Gets the target for this menu item.
     * Default target is _self
     *
     * @return string the target of this menu item.
     */
    public function getTarget(): string;

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
    public function setTarget(string $target): void;

    /**
     * Returns the raw HTML for this menu item.
     *
     * @return string the raw HTML for this menu item, or null if no HTML was provided.
     */
    public function getRawHtml(): string;

    /**
     * Sets the raw HTML for this menu item to the specified HTML.
     *
     * @param string $rawHtml the new HTML, or null for no HTML.
     * @return void
     */
    public function setRawHtml(string $rawHtml): void;

    /**
     * Assigns a view element to be rendered and appended to the auto generated menu item.
     * This can be used to extend default behaviour like invoke modals or vue applications
     *
     * @param string $name Name of template file
     * @param mixed[] $data Array of data to be made available to the rendered view (i.e. the Element)
     * @param mixed[] $options Array of options.
     * @see View::element()
     * @return void
     */
    public function setViewElement(string $name, array $data = [], array $options = []): void;

    /**
     * Renders the view element provided by setViewElement by using the provided view instance.
     * Returns null if no view element was defined.
     *
     * @param View $view View instance that will be used for rendering
     * @return null|string
     */
    public function renderViewElement(View $view): ?string;

    /**
     * Adds an HTML attribute for this menu item.
     * If the attribute already exists it will be overwritten.
     *
     * @param string $attributeName Attribute's name
     * @param string|array $attributeValue Attribute's value
     * @return void
     */
    public function addAttribute(string $attributeName, $attributeValue): void;

    /**
     * Returns an associative array including all the defined attributes.
     * The array's key defines the attribute name.
     *
     * @return string[]
     */
    public function getAttributes(): array;

    /**
     * Set Wrapper Start for MenuItem class
     *
     * Allows wrapping Html string within HTML div-like containers.
     * Pretty useful for UI elements like button groups.
     *
     * @param string $value of the wrapper
     * @return void
     */
    public function setWrapperStart(string $value): void;

    /**
     * Set Wrapper End for MenuItem class
     *
     * Allows wrapping Html string of MenuItem with div-like containers.
     *
     * @param string $value closing of the wrapper
     * @return void
     */
    public function setWrapperEnd(string $value): void;

    /**
     * Return Wrapper start of MenuItem
     *
     * @return string
     */
    public function getWrapperStart(): string;

    /**
     * Return Wrapper end of MenuItem
     *
     * @return string
     */
    public function getWrapperEnd(): string;
}
