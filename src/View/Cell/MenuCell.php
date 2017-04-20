<?php
namespace Menu\View\Cell;

use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\View\Cell;
use InvalidArgumentException;

class MenuCell extends Cell
{
    /**
     * Supported render formats.
     *
     * @var array
     */
    protected $_renderFormats = [
        RENDER_AS_PROVIDED => [
            'menuStart' => '',
            'menuEnd' => '',
            'itemStart' => '',
            'itemEnd' => '',
            'item' => '%label%',
        ],
        RENDER_AS_LIST => [
            'menuStart' => '<ul>',
            'menuEnd' => '</ul>',
            'itemStart' => '<li>',
            'itemEnd' => '</li>',
            'item' => '<a href="%url%"><i class="fa fa-%icon%"></i> %label%</a>',
        ],
        RENDER_AS_DROPDOWN => [
            'menuStart' => '<select>',
            'menuEnd' => '</select>',
            'itemStart' => '<option>',
            'itemEnd' => '</option>',
            'item' => '<i class="fa fa-%icon%"></i> %label%',
        ],
        RENDER_AS_NONE => [
            'menuStart' => '',
            'menuEnd' => '',
            'itemStart' => '',
            'itemEnd' => '',
            'item' => '',
        ]
    ];

    public function display($name, $renderAs, $user = [], $fullBaseUrl = false)
    {
        $this->loadModel('Menu.Menus');

        $name = $this->_validateName($name);

        // get menu
        $menu = $this->Menus->findByName($name)->firstOrFail();

        $menuItems = (bool)$menu->default ?
            $this->_getMenuItemsFromEvent($menu, $user, (bool)$fullBaseUrl) :
            $this->_getMenuItemsFromTable($menu);


        $this->set('menuItems', $menuItems);
        $this->set('user', $this->_normalizeUser($user));
        $this->set('format', $this->_getFormat($renderAs));
        $this->set('fullBaseUrl', (bool)$fullBaseUrl);
    }

    protected function _getMenuItemsFromEvent(EntityInterface $menu, $user, $fullBaseUrl)
    {
        $event = new Event('Menu.Menu.getMenu', $this, [
            'name' => $menu->name,
            'user' => $user,
            'fullBaseUrl' => $fullBaseUrl
        ]);
        $this->eventManager()->dispatch($event);

        return $event->result ? $event->result : [];
    }

    protected function _validateName($name)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException('Menu [name] must be a string.');
        }

        if (empty($name)) {
            throw new InvalidArgumentException('Menu [name] cannot be empty.');
        }

        return $name;
    }

    protected function _normalizeUser($user)
    {
        if (!empty($user)) {
            return $user;
        }

        if (isset($_SESSION['Auth']['User'])) {
            $user = $_SESSION['Auth']['User'];
        };

        return $user;
    }

    protected function _getFormat($renderAs)
    {
        $defaults = [
            'menuStart' => '<ul>',
            'menuEnd' => '</ul>',
            'childMenuStart' => '<ul>',
            'childMenuEnd' => '</ul>',
            'itemStart' => '<li>',
            'itemEnd' => '</li>',
            'item' => '%label%',
        ];

        if (is_string($renderAs)) {
            if (!array_key_exists($renderAs, $this->_renderFormats)) {
                throw new InvalidArgumentException('Render format [' . $renderAs . '] not found.');
            }

            return $renderFormats[$renderAs];
        }

        if (is_array($renderAs)) {
            return array_merge($defaults, $renderAs);
        }

        throw new InvalidArgumentException('[renderAs] variable must be an array or string.');
    }
}
