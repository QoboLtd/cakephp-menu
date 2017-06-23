<?php

namespace Menu\MenuBuilder;

/**
 *  MenuItem class
 *
 */
class MenuItem extends BaseMenuItem
{
    /**
     * @var $label
     */
    protected $label = 'Undefined';

    /**
     * @var $icon
     */
    protected $icon = 'circle-o';

    /**
     * @var $target
     */
    protected $target = '_self';

    /**
     * @var $desc
     */
    protected $desc = '';

    /**
     * @var $url
     */
    protected $url = '#';

    /**
     * @var $children
     */
    protected $children = [];

    protected $propertiesList = ['label', 'icon', 'target', 'desc', 'url', 'children'];

    protected $viewObj;

    /**
     *  set method
     *
     * @param string $attr property name
     * @param string $value property value
     * @return void
     */
    public function set($attr, $value)
    {
        if (property_exists($this, $attr)) {
            $this->$attr = $value;
        }
    }

    public function get($attr)
    {
        $result = '';

        if (property_exists($this, $attr)) {
            $result = !empty($this->$attr) ? $this->$attr : '';
        }

        return $result;
    }

    /**
     *  addChild method
     *
     * @param MenuItem $child menu item
     * @return void
     */
    public function addChild(MenuItem $child)
    {
        array_push($this->children, $child);
    }

    public function getProperties()
    {
        return $this->propertiesList;
    }

    public function getChildren()
    {
        return $this->children;
    }
}
