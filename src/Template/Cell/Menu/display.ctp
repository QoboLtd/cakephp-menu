<?php

use Cake\Event\Event;
use Menu\MenuBuilder\MainMenuRenderAdminLte;
use Menu\MenuBuilder\Menu;
use Menu\MenuBuilder\MenuItemFactory;
use Menu\MenuBuilder\SystemMenuRenderAdminLte;

$event = new Event('Menu.Menu.beforeRender', $this, ['menu' => $menuItems, 'user' => $user]);
$this->eventManager()->dispatch($event);
if (!empty($event->result)) {
    $menuItems = $event->result;
}

$menu = new Menu();
foreach ($menuItems as $item) {
    $menuItem = MenuItemFactory::createMenuItem($item);
    $menu->addMenuItem($menuItem);
}

if ($name == 'main_menu') {
    $menu->title('<li class="header">MAIN NAVIGATION</li>');
    $renderClass = 'Menu\\MenuBuilder\\MainMenuRenderAdminLte';
} else {
    $renderClass = 'Menu\\MenuBuilder\\SystemMenuRenderAdminLte';
}

$render = new $renderClass($menu);
echo $render->render();
