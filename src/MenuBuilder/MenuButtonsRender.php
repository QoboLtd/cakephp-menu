<?php
namespace Menu\MenuBuilder;

use Cake\View\View;

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
     * @param \Menu\MenuBuilder\Menu $menu Menu collection
     * @param \Cake\View\View $viewEntity View instance
     * @return void
     */
    public function __construct(Menu $menu, View $viewEntity)
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
