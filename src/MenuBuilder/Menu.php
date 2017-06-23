<?php

namespace Menu\MenuBuilder;

use Menu\MenuBuilder\MenuItem;
use Menu\MenuBuilder\MenuItemRenderFactory;

/**
 *  Menu class
 *
 */
class Menu
{

    /**
     * @var $menuItems
     */
    protected $menuItems = [];

    protected $format = [];

    /**
     *  addMenuItem method
     *
     * @param array $item menu item definition
     */
    public function addMenuItem($item)
    {
        array_push($this->menuItems, $item);
    }

    public function addFormat($format)
    {
        $this->format = $format;
    }

    /**
     *  render method
     *
     *
     */
    public function render()
    {
        $html = !empty($this->format['header']) ? $this->format['header'] : '';
        $html .= $this->format['menuStart'];

        foreach ($this->menuItems as $index => $menuItem) {
            $html .= MenuItemRenderFactory::render('menu_item', $menuItem, $this->format);
        }
        $html .= $this->format['menuEnd'];

        return $html;
    }
}
