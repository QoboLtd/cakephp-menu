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
     * @var $label
     */
    protected $label = '';

    /**
     * @var $icon
     */
    protected $icon = '';

    /**
     * @var $target
     */
    protected $target = '_self';

    /**
     * @var $desc
     */
    protected $description = '';

    /**
     * @var $url
     */
    protected $url = '#';

    /**
     * @var string confirmMsg
     */
    protected $confirmMsg = '';

    /**
     * @var string extraAttribute
     */
    protected $extraAttribute = '';

    /**
     * @var int order
     */
    protected $order = 1;

    /**
     * @var $dataType
     */
    protected $dataType = '';

    /**
     * @var $rawHtml
     */
    protected $rawHtml = '';

    /**
     * @var bool
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
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @inheritdoc
     *
     * @param string $label the new label, or null for no label.
     * @return void
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @inheritdoc
     *
     * @return string the icon of this menu item, or null if this menu item has no icon.
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @inheritdoc
     *
     * @param string $icon the new icon, or null for no icon.
     * @return void
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * @inheritdoc
     *
     * @return string the target of this menu item.
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @inheritdoc
     *
     * @param string $target the new target.
     * @return void
     */
    public function setTarget($target)
    {
        $this->target = $target;
    }

    /**
     * @inheritdoc
     *
     * @return string the description of this menu item, or null if this menu item has no description.
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @inheritdoc
     *
     * @param string $descr the new description, or null for no description.
     * @return void
     */
    public function setDescription($descr)
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
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     *  getConfirmMsg method
     *
     * @return string confirmation message
     */
    public function getConfirmMsg()
    {
        return $this->confirmMsg;
    }

    /**
     *  setConfirmMsg method
     *
     * @param string $message for confirmation alert
     * @return void
     */
    public function setConfirmMsg($message)
    {
        $this->confirmMsg = $message;
    }

    /**
     *  getExtraAttribute method
     *
     * @return string menu item extraAttribute
     */
    public function getExtraAttribute()
    {
        return $this->extraAttribute;
    }

    /**
     * @inheritdoc
     *
     * @return string the raw HTML for this menu item, or null if no HTML was provided.
     */
    public function getRawHtml()
    {
        return $this->rawHtml;
    }

    /**
     * @inheritdoc
     *
     * @param string $rawHtml the new HTML, or null for no HTML.
     * @return void
     */
    public function setRawHtml($rawHtml)
    {
        $this->rawHtml = $rawHtml;
    }

    /**
     *  setExtraAttribute method
     *
     * @param string $attr for menu item
     * @return void
     */
    public function setExtraAttribute($attr)
    {
        $this->extraAttribute = $attr;
    }

    /**
     * @inheritdoc
     *
     * @return int the position of this menu item.
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @inheritdoc
     *
     * @param int $order the new position.
     * @return void
     */
    public function setOrder($order)
    {
        $this->order = (int)$order;
    }

    /**
     *  getDataType method
     *
     * @return string dataType attribute
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     *  setDataType method
     *
     * @param string $dataType for menu item
     * @return void
     */
    public function setDataType($dataType)
    {
        $this->dataType = $dataType;
    }

    /**
     * @inheritdoc
     *
     * @param bool $enabled Indicates whether this Menu item is enabled
     * @return void
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @inheritdoc
     *
     * @return void
     */
    public function enable()
    {
        $this->setEnabled(true);
    }

    /**
     * @inheritdoc
     *
     * @return void
     */
    public function disable()
    {
        $this->setEnabled(false);
    }

    /**
     * @inheritdoc
     *
     * @param callable $callback Callback to be evaluated as a boolean expression
     * @return void
     */
    public function disableIf(callable $callback)
    {
        $this->conditions[] = $callback;
    }

    /**
     * @inheritdoc
     *
     * @return bool
     */
    public function isEnabled()
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
    public function addAttribute($attributeName, $attributeValue)
    {
        $this->attributes[$attributeName] = $attributeValue;
    }

    /**
     * Returns an associative array including all the defined attributes.
     * The array's key defines the attribute name.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @inheritdoc
     *
     * @param string $name Name of template file
     * @param array $data Array of data to be made available to the rendered view (i.e. the Element)
     * @param array $options Array of options.
     * @see View::element()
     * @return void
     */
    public function setViewElement($name, array $data = [], array $options = [])
    {
        $this->viewElement = [$name, $data, $options];
    }

    /**
     * @inheritdoc
     *
     * @param View $view View instance that will be used for rendering
     * @return null|string
     */
    public function renderViewElement(View $view)
    {
        if (empty($this->viewElement)) {
            return null;
        }

        return call_user_func_array([$view, 'element'], $this->viewElement);
    }
}
