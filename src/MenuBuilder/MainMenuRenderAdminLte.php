<?php
/**
 * Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Menu\MenuBuilder;

use Cake\Core\Configure;
use Cake\View\View;

/**
 *  MainMenuRender class
 *
 *  rendering Main Admin LTE menu
 */
class MainMenuRenderAdminLte extends BaseMenuRenderClass
{
    /**
     *  __construct method
     *
     * @param \Menu\MenuBuilder\Menu $menu Collection of menu items
     * @param \Cake\View\View $viewEntity View instance
     * @return void
     */
    public function __construct(Menu $menu, View $viewEntity)
    {
        parent::__construct($menu, $viewEntity);
        $format = [
            'menuStart' => '<ul class="sidebar-menu" data-widget="tree">',
            'menuEnd' => '</ul>',
            'childMenuStart' => '<ul class="treeview-menu">',
            'childMenuEnd' => '</ul>',
            'itemStart' => '<li>',
            'itemStartWithChildren' => '<li class="treeview">',
            'itemEnd' => '</li>',
            'itemEndWithChildren' => '</li>',
            'itemWrapperStart' => '<span>',
            'itemWrapperEnd' => '</span>',
            'itemWithChildren' => '<a href="%url%" target="%target%"><i class="' . Configure::read('Icons.prefix') . '%icon%"></i> <span>%label%</span><i class="' . Configure::read('Icons.prefix') . 'left pull-right"></i></a>',
            'itemWithChildrenPostfix' => '<span class="pull-right-container"><i class="' . Configure::read('Icons.prefix') . 'angle-left pull-right"></i></span>',
        ];

        $this->setFormat($format);
    }
}
