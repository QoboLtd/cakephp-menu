<?php

use Qobo\Menu\MenuBuilder\MenuFactory;

$context = isset($context) ? $context : null;

$menu = MenuFactory::getMenu($name, $user, false, $context);
$renderer = MenuFactory::getMenuRenderer($renderer, $menu, $this);
echo $renderer->render();
