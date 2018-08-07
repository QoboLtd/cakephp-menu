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

    /**
     *  addMenuItem method
     *
     * @param \Menu\MenuBuilder\MenuItemInterface $item menu item definition
     * @return void
     */
    public function addMenuItem($item)
    {
        $this->add($item);
    }

    /**
     *  getMenuItems method
     *
     * @return array of menu items
     */
    public function getMenuItems()
    {
        return $this->getAll();
    }
}
