<?php
namespace Menu\MenuBuilder;

use Cake\View\View;

/**
 *  SystemMenuBuilder class
 *
 *  System Admin LTE menu render
 */
class SystemMenuRenderAdminLte extends BaseMenuRenderClass
{
    /**
     *  __construct method
     *
     * @param \Menu\MenuBuilder\Menu $menu collection of menu items
     * @param \Cake\View\View $viewEntity View instance
     * @return void
     */
    public function __construct(Menu $menu, View $viewEntity)
    {
        parent::__construct($menu, $viewEntity);

        $format = [
            'menuStart' => '<ul class="control-sidebar-menu">',
            'menuEnd' => '</ul>',
            'childMenuStart' => '<ul>',
            'childMenuEnd' => '</ul>',
            'itemStart' => '<li>',
            'itemEnd' => '</li>',
            'itemHeaderStart' => '<div class="menu-info">',
            'itemWrapperStart' => '<h4 class="control-sidebar-subheading">',
            'itemWrapperEnd' => '</h4>',
            'itemHeaderEnd' => '</div>',
            'itemDescrStart' => '<p>',
            'itemDescrEnd' => '</p>',
            'item' => '<a href="%url%"><i class="menu-icon fa fa-%icon%"></i> <div class="menu-info"><h4 class="control-sidebar-subheading">%label%</h4><p>%desc%</p></div></a>',
        ];

        $this->setFormat($format);
    }
}
