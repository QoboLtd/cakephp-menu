<?php

namespace Menu\MenuBuilder;

use Cake\View\Helper\UrlHelper;
use Menu\MenuBuilder\Menu;

/**
 *  BaseMenuRenderClass class
 *
 *  Base class for menu renders
 */
class BaseMenuRenderClass
{
    /**
     * @var $format array with formats
     */
    protected $format = [];

    /**
     * @var $menu list of menu items
     */
    protected $menu = null;

    /**
     *  __construct method
     *
     * @param Menu\MenuBuilder\Menu $menu menu to render
     * @param array $format optional options to format menu
     * @return void
     */
    public function __construct($menu, array $format = [])
    {
        $this->menu = $menu;
        if (!empty($format)) {
            $this->format = $format;
        }
    }

    /**
     *  render method
     *
     * @return string rendered menu as HTML
     */
    public function render()
    {
        $html = $this->format['menuStart'];
        $html .= !empty($this->menu->title()) ? $this->menu->title() : '';

        foreach ($this->menu->getMenuItems() as $index => $menuItem) {
            $html .= $this->_renderMenuItem($menuItem);
        }
        $html .= $this->format['menuEnd'];

        return $html;
    }

    /**
     *  _renderMenuItem method
     *
     * @param Menu\MenuBuilder\MenuItem $item menu item definition
     * @return string rendered menu item as HTML
     */
    protected function _renderMenuItem(MenuItem $item)
    {
        $children = $item->getChildren();

        $html = $this->format['itemStart'];
        $itemFormat = !empty($children) ? $this->format['itemWithChildren'] : $this->format['item'];
        foreach ($item->getProperties() as $attr) {
            if (false === strpos($itemFormat, $attr)) {
                continue;
            }
            $val = $item->get($attr);
            if ($attr == 'url') {
                $val = is_array($val) ? UrlHelper::build($val) : $val;
            }
            $itemFormat = str_replace('%' . $attr . '%', $val, $itemFormat);
        }

        $html .= $itemFormat;

        if (!empty($children)) {
            $html .= $this->format['childMenuStart'];
            foreach ($children as $childItem) {
                $html .= $this->_renderMenuItem($childItem);
            }
            $html .= $this->format['childMenuEnd'];
        }
        $this->format['itemEnd'];

        return $html;
    }
}
