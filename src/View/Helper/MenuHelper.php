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
     * Set the full base URL recursivelly for all the menu and their children.
     *
     * @param array $menu Given menu
     * @return array $menus
     */
    public function setFullBaseUrl(array $menu = [])
    {
        $menu = array_map(
            function ($v) {
                $url = Hash::get($v, 'url');
                $children = Hash::get($v, 'children');
                if ($url) {
                    $v['url'] = UrlHelper::build($url, [
                        'fullBase' => true
                    ]);
                }
                if (is_array($children)) {
                    $v['children'] = $this->setFullBaseUrl($children);
                }

                return $v;
            },
            $menu
        );

        return $menu;
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
