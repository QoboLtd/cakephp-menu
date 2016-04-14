<?php
namespace Menu\View\Helper;

use Cake\Core\Configure;
use Cake\Utility\Hash;
use Cake\View\Helper;
use Cake\View\Helper\UrlHelper;
use Cake\View\View;

class MenuHelper extends Helper
{

    /**
     * Method that retrieves all defined capabilities.
     * Available options:
     * - fullBaseUrl Boolean value
     *
     * @param string $name of the menu
     * @param array $options Options of handling the menu
     * @return array menu
     */
    public function getMenu($name, array $options = [])
    {
        $allControllers = Configure::read('Menu.allControllers');
        $fullBaseUrl = Hash::get($options, 'fullBaseUrl');
        $menu = [];
        // get all controllers
        $controllers = $this->_getAllControllers();
        foreach ($controllers as $controller) {
            if (is_callable([$controller, 'getMenu'])) {
                $menu = array_merge($menu, $controller::getMenu($name));
            }

            if (!$allControllers) {
                break;
            }
        }
        if ($fullBaseUrl) {
            $menu = $this->_setFullBaseUrl($menu);
        }

        return $menu;
    }

    /**
     * Set the full base URL recursivelly for all the menu and their childs.
     *
     * @param array $menu Given menu
     * @return array $menus
     */
    protected function _setFullBaseUrl(array $menu = [])
    {
        $menu = array_map(
            function ($v) {
                $url = Hash::get($v, 'url');
                $children = Hash::get($v, 'children');
                if ($url) {
                    $v['url'] = UrlHelper::build($url, true);
                }
                if (is_array($children)) {
                    $v['children'] = $this->_setFullBaseUrl($children);
                }

                return $v;
            },
            $menu
        );

        return $menu;
    }

    /**
     * Method that returns all controller names.
     * @param  bool  $includePlugins flag for including plugin controllers
     * @return array                 controller names
     */
    protected function _getAllControllers($includePlugins = true)
    {
        $controllers = $this->_getDirControllers(APP . 'Controller' . DS);
        if ($includePlugins === true) {
            $plugins = \Cake\Core\Plugin::loaded();
            foreach ($plugins as $plugin) {
                // plugin path
                $path = \Cake\Core\Plugin::path($plugin) . 'src' . DS . 'Controller' . DS;
                $controllers = array_merge($controllers, $this->_getDirControllers($path, $plugin));
            }
        }
        return $controllers;
    }

    /**
     * Method that retrieves controller names
     * found on the provided directory path.
     * @param  string $path   directory path
     * @param  string $plugin plugin name
     * @param  bool   $fqcn   flag for using fqcn
     * @return array          controller names
     */
    protected function _getDirControllers($path, $plugin = null, $fqcn = true)
    {
        $controllers = [];
        if (file_exists($path)) {
            $dir = new \DirectoryIterator($path);
            foreach ($dir as $fileinfo) {
                $className = $fileinfo->getBasename('.php');
                if ($fileinfo->isFile() && 'AppController' !== $className) {
                    if (!empty($plugin)) {
                        $className = $plugin . '.' . $className;
                    }
                    if ($fqcn === true) {
                        $className = \Cake\Core\App::className($className, 'Controller');
                    }
                    $controllers[] = $className;
                }
            }
        }
        return $controllers;
    }
}
