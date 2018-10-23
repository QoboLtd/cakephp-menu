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
namespace Qobo\Menu\MenuBuilder;

/**
 *  Menu class
 *
 */
class Menu implements MenuInterface
{
    use MenuItemContainerTrait;

    /**
     * @const MENU_BUTTONS_TYPE
     */
    const MENU_BUTTONS_TYPE = 'buttons';

    /**
     * @const MENU_ACTIONS_TYPE
     */
    const MENU_ACTIONS_TYPE = 'actions';
}
