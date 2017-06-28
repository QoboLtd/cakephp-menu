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
            'childMenuStart' => '',
            'childMenuEnd' => '',
            'itemStart' => '',
            'itemEnd' => '',
            'item' => '<a href="%url%" title="%label%" class="btn btn-default"><i class="fa fa-%icon%"></i> %label%</a>',
            'itemWithChildren' => '',
        ];
        $this->class = 'btn btn-default';
    }
}
