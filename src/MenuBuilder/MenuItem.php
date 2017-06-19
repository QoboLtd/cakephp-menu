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

    /**
     *  set method
     *
     * @param string $property property name
     * @param string $value property value
     * @return void
     */
    public function set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
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
}
