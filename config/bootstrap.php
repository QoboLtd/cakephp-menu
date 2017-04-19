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
// overwrite default plugin config by app level config
Configure::write('Menu', array_replace_recursive(
    Configure::read('Menu'),
    $config
));

if (!defined('MENU_SIDEBAR')) {
    define('MENU_SIDEBAR', 'sidebar');
}

if (!defined('MENU_TOP')) {
    define('MENU_TOP', 'top');
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
