<?php

namespace Menu\MenuBuilder;

/**
 *  MenuRenderInterface interface
 *
 */
interface MenuRenderInterface
{
    /**
     *  render method
     *
     * @param $menu Menu\MenuBuilder\Menu  menu object
     */
    public function render(Menu $menu);
}
