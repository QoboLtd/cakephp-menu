<?php
/**
 * Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
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
}
