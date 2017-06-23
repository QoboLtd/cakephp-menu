<?php

namespace Menu\MenuBuilder;

/**
 *  MenuItemRenderInterface interface
 *
 */
interface MenuItemRenderInterface
{
    /**
     *  render method
     *
     * @param Menu\MenuBuilder\MenuItem $menuItems  menu item object
     */
    public function render($menuItems, $format);
}
