<?php
use Cake\Routing\Router;

Router::plugin(
    'Menu',
    ['path' => '/menu'],
    function ($routes) {
        $routes->fallbacks('DashedRoute');
    }
);
