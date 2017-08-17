<?php
namespace Menu\Event;

use MyCLabs\Enum\Enum;

/**
 * Event Name enum
 */
class EventName extends Enum
{
    const GET_MENU_ITEMS = 'Menu.Menu.getMenuItems';
    const GET_MENU = 'Menu.Menu.getMenu';
    const MENU_BEFORE_RENDER = 'Menu.Menu.beforeRender';
}
