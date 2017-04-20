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

    /**
     * Default display method.
     *
     * Retrieves menu items and rendering format and passes them to the Cell View.
     *
     * @param string $name Menu name
     * @param string|array $renderAs Rendering format name or data array
     * @param array $user User info
     * @param bool $fullBaseUrl Full-base URL flag
     * @return void
     */
    public function display($name, $renderAs, array $user = [], $fullBaseUrl = false)
    {
        $this->loadModel('Menu.Menus');

        // validate menu name
        $this->_validateName($name);

        // get menu
        $menu = $this->Menus->findByName($name)->firstOrFail();

        $menuItems = (bool)$menu->default ?
            $this->_getMenuItemsFromEvent($menu, $user, (bool)$fullBaseUrl) :
            $this->_getMenuItemsFromTable($menu);


        $this->set('menuItems', $menuItems);
        $this->set('user', !empty($user) ? $user : $this->_getUser());
        $this->set('format', $this->_getFormat($renderAs));
        $this->set('fullBaseUrl', (bool)$fullBaseUrl);
    }

    /**
     * Menu items getter using Event.
     *
     * @param \Cake\Datasource\EntityInterface $menu Menu entity
     * @param array $user User info
     * @param bool $fullBaseUrl Full-base URL flag
     * @return array
     */
    protected function _getMenuItemsFromEvent(EntityInterface $menu, array $user, $fullBaseUrl)
    {
        $event = new Event('Menu.Menu.getMenu', $this, [
            'name' => $menu->name,
            'user' => $user,
            'fullBaseUrl' => $fullBaseUrl
        ]);
        $this->eventManager()->dispatch($event);

        return $event->result ? $event->result : [];
    }

    /**
     * Menu items getter using database table.
     *
     * @param \Cake\Datasource\EntityInterface $menu Menu entity
     * @return array
     */
    protected function _getMenuItemsFromTable(EntityInterface $menu)
    {
        $this->loadModel('Menu.MenuItems');

        $query = $this->MenuItems
            ->find('all')
            ->where(['MenuItems.menu_id' => $menu->id, 'MenuItems.parent_id IS NULL']);

        if ($query->isEmpty()) {
            return [];
        }

        $result = [];
        foreach ($query->all() as $entity) {
            $item = $entity->toArray();

            // fetch children
            $query = $this->MenuItems->find('children', ['for' => $entity->id]);
            if (!$query->isEmpty()) {
                $item['children'] = [];
                foreach ($query->all() as $child) {
                    $item['children'][] = $child->toArray();
                }
            }

            $result[] = $item;
        }

        return $result;
    }

    /**
     * Validates menu name and throws appropriate
     * exceptions if the validation fails.
     *
     * @param string $name Menu name
     * @return void
     * @throws \InvalidArgumentException
     */
    protected function _validateName($name)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException('Menu [name] must be a string.');
        }

        if (empty($name)) {
            throw new InvalidArgumentException('Menu [name] cannot be empty.');
        }
    }

    /**
     * Current session user getter method.
     *
     * Uses PHP's $_SESSION global variable to fetch current session user.
     *
     * @return array
     */
    protected function _getUser()
    {
        if (isset($_SESSION['Auth']['User'])) {
            return $_SESSION['Auth']['User'];
        };

        return [];
    }

    /**
     * Menu rendering format getter.
     *
     * @param string|array $renderAs Rendering format name or data array
     * @return array
     * @throws \InvalidArgumentException
     */
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
