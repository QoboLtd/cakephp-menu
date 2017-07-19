<?php

namespace Menu\MenuBuilder;

/**
 *  MenuActionsRender class
 *
 *  rendering menu with buttons
 */
class MenuActionsRender extends BaseMenuRenderClass
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
            'menuStart' => '<div class="btn-group btn-group-xs">',
            'menuEnd' => '</div>',
            'childMenuStart' => '',
            'childMenuEnd' => '',
            'itemStart' => '',
            'itemEnd' => '',
            'item' => '<a href="%url%" title="%label%" class="btn btn-default" data-type="%dataType%" data-confirm-msg="%confirmMsg%"><i class="fa fa-%icon%"></i></a>',
            'itemWithChildren' => '',
        ];

        $this->noLabel = true;
    }
}
