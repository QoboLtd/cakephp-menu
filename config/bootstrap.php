<?php
use Cake\Core\Configure;

/**
 * Menu configuration
 */
// get app level config
$config = Configure::read('Menu');
$config = $config ? $config : [];
// load default plugin config
Configure::load('Menu.menu');
Configure::load('Menu.icons');
// overwrite default plugin config by app level config
Configure::write('Menu', array_replace_recursive(
    Configure::read('Menu'),
    $config
));

if (!defined('MENU_ADMIN')) {
    define('MENU_ADMIN', 'admin_menu');
}

if (!defined('MENU_MAIN')) {
    define('MENU_MAIN', 'main_menu');
}

/**
 * Render As types
 */
if (!defined('RENDER_AS_LIST')) {
    define('RENDER_AS_LIST', 'list');
}

if (!defined('RENDER_AS_DROPDOWN')) {
    define('RENDER_AS_DROPDOWN', 'dropdown');
}

if (!defined('RENDER_AS_NONE')) {
    define('RENDER_AS_NONE', 'none');
}

if (!defined('RENDER_AS_PROVIDED')) {
    define('RENDER_AS_PROVIDED', 'provided');
}
