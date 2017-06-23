<?php
use Cake\Event\Event;
use Menu\MenuBuilder\Menu;
use Menu\MenuBuilder\MenuItemFactory;

$itemDefaults = [
    'url' => '#',
    'label' => 'Undefined',
    'icon' => 'circle-o',
    'target' => '_self',
    'desc' => ''
];

$event = new Event('Menu.Menu.beforeRender', $this, ['menu' => $menuItems, 'user' => $user]);
$this->eventManager()->dispatch($event);
if (!empty($event->result)) {
    $menuItems = $event->result;
}

$menu = new Menu();
$menu->addFormat($format);
foreach ($menuItems as $item) {
    $item['url'] = is_array($item['url']) ? $this->Url->build($item['url']) : $item['url'];
    $menuItem = MenuItemFactory::createMenuItem($item);
    $menu->addMenuItem($menuItem);
}

echo $menu->render();
