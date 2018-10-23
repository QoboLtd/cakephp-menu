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

use Cake\Event\Event;
use Qobo\Menu\Event\EventName;
use Qobo\Menu\MenuBuilder\Menu;
use Qobo\Menu\MenuBuilder\MenuItemFactory;

if ($menuItems instanceof Menu) {
    $menu = $menuItems;
} else {
    // maintain backwards compatibility for menu arrays
    $event = new Event((string)EventName::MENU_BEFORE_RENDER(), $this, ['menu' => $menuItems, 'user' => $user]);
    $this->eventManager()->dispatch($event);
    if (!empty($event->result)) {
        $menuItems = $event->result;
    }
    $menu = new Menu();
    foreach ($menuItems as $item) {
        if (is_array($item) && !empty($item)) {
            $menuItem = MenuItemFactory::createMenuItem($item);
            $menu->addMenuItem($menuItem);
        }
    }
}

$render = new $renderer($menu, $this);
echo $render->render();
