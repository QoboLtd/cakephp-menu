<?php

namespace Menu\MenuBuilder;

class MenuLinksSystemBuilder extends BaseMenuRenderClass
{
    public function __construct(Menu $menu)
    {
        parent::__construct($menu);
        
        $this->format = [
            'menuStart' => '<ul class="control-sidebar-menu">',
            'menuEnd' => '</ul>',
            'childMenuStart' => '<ul>',
            'childMenuEnd' => '</ul>',
            'itemStart' => '<li>',
            'itemEnd' => '</li>',
            'item' => '<a href="%url%"><i class="menu-icon fa fa-%icon%"></i> <div class="menu-info"><h4 class="control-sidebar-subheading">%label%</h4><p>%desc%</p></div></a>',
        ];
    }
}
