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
     * @param string $attr attribute name
     * @param string $value attribute value
     * @return void
     */
    public function set($attr, $value)
    {
        if (property_exists($this, $attr)) {
            $this->$attr = $value;
        }
    }

    /**
     *  get method
     *
     * @param string $attr attribute name
     * @return mixed result
     */
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

    /**
     *  getProperties method
     *
     * @return array list of menu properties
     */
    public function getProperties()
    {
        return $this->propertiesList;
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
