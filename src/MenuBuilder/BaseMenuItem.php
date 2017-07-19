<?php

namespace Menu\MenuBuilder;

use Cake\Exception\NotImplementedException;

abstract class BaseMenuItem implements MenuItemInterface
{
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
     * @var confirmMsg
     */
    protected $confirmMsg = '';

    /**
     * @var extraAttribute
     */
    protected $extraAttribute = '';

    /**
     * @var order
     */
    protected $order = 1;

    /**
     * @var $children
     */
    protected $children = [];

    /**
     *  getLabel method
     *
     * @return string menu item label
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     *  setLabel method
     *
     * @param string $label for menu item
     * @return void
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     *  getIcon method
     *
     * @return string menu item icon name
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     *  setIcon method
     *
     * @param string $icon for menu item
     * @return void
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     *  getTarget method
     *
     * @return string menu item target
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     *  setTarget method
     *
     * @param string $target for menu item
     * @return void
     */
    public function setTarget($target)
    {
        $this->target = $target;
    }
    /**
     *  getDescription method
     *
     * @return string menu item description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     *  setDescription method
     *
     * @param string $descr for menu item
     * @return void
     */
    public function setDescription($descr)
    {
        $this->description = $descr;
    }

    /**
     *  getUrl method
     *
     * @return array or string menu item URL
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     *  setUrl method
     *
     * @param string or array $url for menu item
     * @return void
     */
    public function setUrl($url)
    {
        $this->url = $url;
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
     * getOrder method
     *
     * @return int menu item order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * setOrder method
     *
     * @param int $order for menu item
     * @return void
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     *  addChild method
     *
     * @param MenuItem $child menu item
     * @return void
     */
    public function addChild(MenuItemInterface $child)
    {
        array_push($this->children, $child);
    }

    /**
     * removeChild method
     *
     * @param string $childId to be removed
     */
    public function removeChild($childId)
    {
        throw new NotImplementedException('Method ' . __METHOD__ . ' is not implemented yet!');
    }

    /**
     *  getChildren method
     *
     * @result array list of child items
     */
    public function getChildren()
    {
        return $this->children;
    }
}
