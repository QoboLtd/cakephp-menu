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

abstract class BaseMenuItem implements MenuItemInterface
{
    use MenuItemContainerTrait;

    /**
     * const DEFAULT_MENU_ITEM_TYPE
     */
    const DEFAULT_MENU_ITEM_TYPE = 'link';

    /**
     * const MENU_ITEM_CLASS_PREFIX
     */
    const MENU_ITEM_CLASS_PREFIX = 'MenuItem';

    /**
     * const MENU_ITEM_INTERFACE
     */
    const MENU_ITEM_INTERFACE = 'MenuItemInterface';

    /**
     * @var string Text label for this menu item
     */
    protected $label = '';

    /**
     * @var string Icon class for this menu item
     */
    protected $icon = '';

    /**
     * @var string Target to be used in links
     */
    protected $target = '_self';

    /**
     * @var string Long description for this menu
     */
    protected $description = '';

    /**
     * @var array|string URL
     */
    protected $url = '#';

    /**
     * @var string Confirmation message
     */
    protected $confirmMsg = '';

    /**
     * @var string
     */
    protected $extraAttribute = '';

    /**
     * @var int order
     */
    protected $order = 1;

    /**
     * @var string
     */
    protected $dataType = '';

    /**
     * @var string Raw HTML
     */
    protected $rawHtml = '';

    /**
     * @var bool Indicates whether this menu item is enabled
     */
    private $enabled = true;

    /**
     * @var array List of callbacks to be evaluated as conditions
     */
    private $conditions = [];

    /**
     * @var array List of attributes to be included in menu item link or button
     */
    private $attributes = [];

    /**
     * @var array Parameters for view element to be rendered
     */
    protected $viewElement = [];

    /**
     * @inheritdoc
     *
     * @return string the label of this menu item, or null if this menu item has no label.
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @inheritdoc
     *
     * @param string $label the new label, or null for no label.
     * @return void
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    /**
     * @inheritdoc
     *
     * @return string the icon of this menu item, or null if this menu item has no icon.
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @inheritdoc
     *
     * @param string $icon the new icon, or null for no icon.
     * @return void
     */
    public function setIcon(string $icon): void
    {
        $this->icon = $icon;
    }

    /**
     * @inheritdoc
     *
     * @return string the target of this menu item.
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * @inheritdoc
     *
     * @param string $target the new target.
     * @return void
     */
    public function setTarget(string $target): void
    {
        $this->target = $target;
    }

    /**
     * @inheritdoc
     *
     * @return string the description of this menu item, or null if this menu item has no description.
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @inheritdoc
     *
     * @param string $descr the new description, or null for no description.
     * @return void
     */
    public function setDescription(string $descr): void
    {
        $this->description = $descr;
    }

    /**
     * @inheritdoc
     *
     * @return string|array the URL of this menu item, or null if this menu item has no URL.
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @inheritdoc
     *
     * @param string|array $url the new URL, or null for no URL.
     * @return void
     */
    public function setUrl($url): void
    {
        $this->url = $url;
    }

    /**
     *  getConfirmMsg method
     *
     * @return string confirmation message
     */
    public function getConfirmMsg(): string
    {
        return $this->confirmMsg;
    }

    /**
     *  setConfirmMsg method
     *
     * @param string $message for confirmation alert
     * @return void
     */
    public function setConfirmMsg(string $message): void
    {
        $this->confirmMsg = $message;
    }

    /**
     *  getExtraAttribute method
     *
     * @return string menu item extraAttribute
     */
    public function getExtraAttribute(): string
    {
        return $this->extraAttribute;
    }

    /**
     * @inheritdoc
     *
     * @return string the raw HTML for this menu item, or null if no HTML was provided.
     */
    public function getRawHtml(): string
    {
        return $this->rawHtml;
    }

    /**
     * @inheritdoc
     *
     * @param string $rawHtml the new HTML, or null for no HTML.
     * @return void
     */
    public function setRawHtml(string $rawHtml): void
    {
        $this->rawHtml = $rawHtml;
    }

    /**
     *  setExtraAttribute method
     *
     * @param string $attr Extra attributes for the menu item
     * @return void
     */
    public function setExtraAttribute(string $attr): void
    {
        $this->extraAttribute = $attr;
    }

    /**
     * @inheritdoc
     *
     * @return int the position of this menu item.
     */
    public function getOrder(): int
    {
        return $this->order;
    }

    /**
     * @inheritdoc
     *
     * @param int $order the new position.
     * @return void
     */
    public function setOrder(int $order): void
    {
        $this->order = $order;
    }

    /**
     *  getDataType method
     *
     * @return string dataType attribute
     */
    public function getDataType(): string
    {
        return $this->dataType;
    }

    /**
     *  setDataType method
     *
     * @param string $dataType for menu item
     * @return void
     */
    public function setDataType(string $dataType): void
    {
        $this->dataType = $dataType;
    }

    /**
     * @inheritdoc
     *
     * @param bool $enabled Indicates whether this Menu item is enabled
     * @return void
     */
    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    /**
     * @inheritdoc
     *
     * @return void
     */
    public function enable(): void
    {
        $this->setEnabled(true);
    }

    /**
     * @inheritdoc
     *
     * @return void
     */
    public function disable(): void
    {
        $this->setEnabled(false);
    }

    /**
     * @inheritdoc
     *
     * @param callable $callback Callback to be evaluated as a boolean expression
     * @return void
     */
    public function disableIf(callable $callback): void
    {
        $this->conditions[] = $callback;
    }

    /**
     * @inheritdoc
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        // Enabled flag is set to false
        if (!$this->enabled) {
            return false;
        }

        // Evaluate each one of the defined conditions
        foreach ($this->conditions as $condition) {
            $disabled = call_user_func($condition, $this);
            if ($disabled) {
                return false;
            }
        }

        // Parent menu items are enabled only and only if they have at least one child enabled
        if (!empty($this->menuItems)) {
            /** @var MenuItemInterface $menuItem */
            foreach ($this->menuItems as $menuItem) {
                if ($menuItem->isEnabled()) {
                    return true;
                }
            }

            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     *
     * @param string $attributeName Attribute's name
     * @param string $attributeValue Attribute's value
     * @return void
     */
    public function addAttribute(string $attributeName, string $attributeValue): void
    {
        $this->attributes[$attributeName] = $attributeValue;
    }

    /**
     * Returns an associative array including all the defined attributes.
     * The array's key defines the attribute name.
     *
     * @return string[]
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @inheritdoc
     *
     * @param string $name Name of template file
     * @param mixed[] $data Array of data to be made available to the rendered view (i.e. the Element)
     * @param mixed[] $options Array of options.
     * @see View::element()
     * @return void
     */
    public function setViewElement(string $name, array $data = [], array $options = []): void
    {
        $this->viewElement = [$name, $data, $options];
    }

    /**
     * @inheritdoc
     *
     * @param View $view View instance that will be used for rendering
     * @return null|string
     */
    public function renderViewElement(View $view): ?string
    {
        if (empty($this->viewElement)) {
            return null;
        }

        return call_user_func_array([$view, 'element'], $this->viewElement);
    }
}
