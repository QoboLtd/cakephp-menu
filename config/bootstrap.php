<?php
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

use Cake\Core\Configure;

/**
 * flag for calling getMenu method from all controllers or from a single one
 */
Configure::write('Menu.allControllers', true);
