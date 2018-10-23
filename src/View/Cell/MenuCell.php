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
namespace Qobo\Menu\View\Cell;

use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\View\Cell;
use Exception;
use InvalidArgumentException;
use Qobo\Menu\Event\EventName;
use Qobo\Menu\MenuBuilder\Menu;
use Qobo\Menu\MenuBuilder\MenuFactory;

class MenuCell extends Cell
{
    /**
     * Default menu renderer class
     */
    const DEFAULT_RENDERER = 'Qobo\\Menu\\MenuBuilder\\SystemMenuRenderAdminLte';

    /**
     * Default display method.
     *
     * Retrieves menu items and rendering format and passes them to the Cell View.
     *
     * @param string $name Menu name
     * @param array $user User info
     * @param bool $fullBaseUrl Full-base URL flag
     * @param string $renderer Menu renderer class name
     * @param mixed $context The object that generates the menu to be used as the event subject
     * @return void
     */
    public function display($name, array $user, $fullBaseUrl = false, $renderer = null, $context = null)
    {
        if (empty($renderer)) {
            $renderer = self::DEFAULT_RENDERER;
        }

        trigger_error('Using Menu cell is deprecated. Use Menu element instead', E_USER_DEPRECATED);

        $this->set('menuItems', MenuFactory::getMenu($name, $user, $fullBaseUrl, $context));
        $this->set('user', $user);
        $this->set('name', $name);
        $this->set('renderer', $renderer);
    }
}
