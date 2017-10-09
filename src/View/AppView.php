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
namespace Menu\View\AppView;

class AppView extends View
{
    /**
     * [initialize description]
     * {@inheritdoc } In addition, it loads Menu helper.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadHelper('Menu.Menu');
    }
}
