<?php

namespace Menu\MenuBuilder;

/**
 *  BaseMenuItemRenderClass class
 *
 * abstract base class for menu rendering
 */
abstract class BaseMenuItemRenderClass implements MenuItemRenderInterface
{
    /**
     *  render method
     *
     * @param Menu\MenuBuilder\MenuItem $menuItem  menu item object
     */
    abstract public function render($menuItem, $format);
}
