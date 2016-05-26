<?php
use Cake\Routing\Router;

Router::plugin(
    'Menu',
    ['path' => '/menu'],
    function ($routes) {
        $routes->extensions(['json']);
        $routes->fallbacks('DashedRoute');
    }
);
