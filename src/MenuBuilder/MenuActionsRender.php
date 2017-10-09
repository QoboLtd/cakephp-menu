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

use Cake\View\View;

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
     * @param \Menu\MenuBuilder\Menu $menu Menu collection
     * @param \Cake\View\View $viewEntity View instance
     * @return void
     */
    public function __construct(Menu $menu, View $viewEntity)
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
