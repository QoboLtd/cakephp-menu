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
            'childMenuStart' => '<ul class="dropdown-menu">',
            'childMenuEnd' => '</ul>',
            'itemStart' => '',
            'itemEnd' => '',
            'childItemStart' => '<li>',
            'childItemEnd' => '</li>',
            'itemWithChildrenStart' => '<div class="btn-group btn-group-sm">',
            'itemWithChildrenEnd' => '</div>',
            'itemLabelPostfix' => '<span class="caret"></span>',
        ];
        $this->class = 'btn btn-default';
    }
}
