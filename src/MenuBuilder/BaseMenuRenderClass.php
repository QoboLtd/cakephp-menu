<?php

namespace Menu\MenuBuilder;

/**
 *  BaseMenuRenderClass class
 *
 * abstract base class for menu rendering
 */
abstract class BaseMenuRenderClass implements MenuRenderInterface
{
    /**
     *  render method
     *
     * @param $menu Menu\MenuBuilder\Menu   menu object
     */
    abstract public function render(Menu $menu);
}
