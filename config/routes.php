<?php
use Cake\Routing\Router;

Router::plugin(
    'Qobo/Menu',
    ['path' => '/menu'],
    function ($routes) {
        $routes->fallbacks('DashedRoute');
    }
);
