<?php

namespace Menu\MenuBuilder;

use Cake\View\Helper\UrlHelper;

/**
 *  MenuLinkRender class
 *
 *  rendering menu with links
 */
class MenuLinkRender extends BaseMenuRenderClass
{
    public function __construct(Menu $menu)
    {
        parent::__construct($menu);
        $this->format = [
            'menuStart' => '<ul class="sidebar-menu">',
            'menuEnd' => '</ul>',
            'childMenuStart' => '<ul class="treeview-menu">',
            'childMenuEnd' => '</ul>',
            'itemStart' => '<li class="treeview">',
            'itemEnd' => ' /li>',
            'item' => '<a href="%url%" target="%target%"><i class="fa fa-%icon%"></i> <span>%label%</span></a>',
            'header' => '<li class="header">MAIN NAVIGATION</li>',
            'itemWithChildren' => '<a href="%url%" target="%target%"><i class="fa fa-%icon%"></i> <span>%label%</span><i class="fa fa-angle-left pull-right"></i></a>',
        ];
    }
}
