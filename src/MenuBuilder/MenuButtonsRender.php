<?php

namespace Menu\MenuBuilder;

/**
 *  MenuButtonsRender class
 *
 *  rendering menu with buttons
 */
class MenuButtonsRender extends BaseMenuRenderClass
{
    /**
     *  __construct method
     *
     * @param Menu\MenuBuilder\Menu $menu menu collection
     * @return void
     */
    public function __construct(Menu $menu, $viewEntity)
    {
        parent::__construct($menu, $viewEntity);
        $this->format = [
            'menuStart' => '<div class="btn-group btn-group-sm">',
            'menuEnd' => '</div>',
            'childMenuStart' => '<ul>',
            'childMenuEnd' => '</ul>',
            'itemStart' => '',
            'itemEnd' => '',
            'itemWithChildrenStart' => '<div class="btn-group btn-group-sm">',
            'itemWithChildrenEnd' => '</div>',
        ];
        $this->class = 'btn btn-default';
    }
}
