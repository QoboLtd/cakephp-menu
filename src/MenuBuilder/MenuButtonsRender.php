<?php

namespace Menu\MenuBuilder;

use Cake\View\Helper\UrlHelper;

/**
 *  MenuButtonsRender class
 *
 *  rendering menu with buttons
 */
class MenuButtonsRender extends BaseMenuRenderClass
{
    public function __construct(Menu $menu)
    {
        parent::__construct($menu);
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
    }
}
