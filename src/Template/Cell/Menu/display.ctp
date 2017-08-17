<?php
use Cake\Event\Event;
use Menu\Event\EventName;
use Menu\MenuBuilder\MainMenuRenderAdminLte;
use Menu\MenuBuilder\Menu;
use Menu\MenuBuilder\MenuItemFactory;
use Menu\MenuBuilder\SystemMenuRenderAdminLte;

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

$params = [];
if ($name == 'main_menu') {
    $renderClass = 'Menu\\MenuBuilder\\MainMenuRenderAdminLte';
    $params['title'] = '<li class="header">MAIN NAVIGATION</li>';
} else {
    $renderClass = 'Menu\\MenuBuilder\\SystemMenuRenderAdminLte';
}

$render = new $renderClass($menu, $this);
echo $render->render($params);
