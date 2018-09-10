<?php

use Menu\MenuBuilder\MenuFactory;

$entity = isset($entity) ? $entity : null;

$menu = MenuFactory::getMenu($name, $user, false, $entity);
$renderer = MenuFactory::getMenuRenderer($renderer, $menu, $this);
echo $renderer->render();
