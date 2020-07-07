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
namespace Menu\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Qobo\Utils\Utility;

/**
 * MenuItems Controller
 *
 * @property \Menu\Model\Table\MenuItemsTable $MenuItems
 */
class MenuItemsController extends AppController
{
    /**
     * {@inheritDoc}
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        $icons = Utility::getIcons(Configure::read('Icons'));

        $this->set('icons', $icons);
    }

    /**
     * Add method
     *
     * @param string $menuId Menu id
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add(string $menuId): void
    {
        $menu = TableRegistry::getTableLocator()->get('Menu.Menus')->get($menuId);
        $menuItem = $this->MenuItems->newEntity();
        if ($this->request->is('post')) {
            $data = (array)$this->request->getData();
            $data['menu_id'] = $menu->get('id');
            $menuItem = $this->MenuItems->patchEntity($menuItem, $data);
            if ($this->MenuItems->save($menuItem)) {
                $this->Flash->success((string)__d('Qobo/Menu', 'The menu item has been saved.'));
                $this->redirect(['controller' => 'Menus', 'action' => 'view', $menu->id]);

                return;
            } else {
                $this->Flash->error((string)__d('Qobo/Menu', 'The menu item could not be saved. Please, try again.'));
            }
        }

        $parentMenuItems = $this->MenuItems
            ->find('treeList', ['spacer' => self::TREE_SPACER])
            ->where(['MenuItems.menu_id' => $menu->id]);

        $this->set(compact('menuItem', 'parentMenuItems'));
        $this->set('_serialize', ['menuItem']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Menu Item id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function edit(string $id = null): void
    {
        $menuItem = $this->MenuItems->get($id, [
            'contain' => ['Menus'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = (array)$this->request->getData();
            $menuItem = $this->MenuItems->patchEntity($menuItem, $data);
            if ($this->MenuItems->save($menuItem)) {
                $this->Flash->success((string)__d('Qobo/Menu', 'The menu item has been saved.'));
                $this->redirect(['controller' => 'Menus', 'action' => 'view', $menuItem->get('menu')->get('id')]);

                return;
            } else {
                $this->Flash->error((string)__d('Qobo/Menu', 'The menu item could not be saved. Please, try again.'));
            }
        }

        $parentMenuItems = $this->MenuItems
            ->find('treeList', ['spacer' => self::TREE_SPACER])
            ->where(['MenuItems.menu_id' => $menuItem->get('menu')->get('id'), 'MenuItems.id !=' => $id]);

        $this->set(compact('menuItem', 'parentMenuItems'));
        $this->set('_serialize', ['menuItem']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Menu Item id.
     * @return void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $id = null): void
    {
        $this->request->allowMethod(['post', 'delete']);
        $menuItem = $this->MenuItems->get($id);
        if ($this->MenuItems->delete($menuItem)) {
            $this->Flash->success((string)__d('Qobo/Menu', 'The menu item has been deleted.'));
        } else {
            $this->Flash->error((string)__d('Qobo/Menu', 'The menu item could not be deleted. Please, try again.'));
        }

        $this->redirect($this->referer());
    }

    /**
     * Move the node.
     *
     * @param  string $id menu id
     * @param  string $action move action
     * @return void Redirects to index or referer.
     */
    public function moveNode(string $id = null, string $action = ''): void
    {
        $moveActions = ['up', 'down'];
        if (!in_array($action, $moveActions)) {
            $this->Flash->error((string)__d('Qobo/Menu', 'Unknown move action.'));
            $this->redirect(['action' => 'index']);

            return;
        }
        $menuItem = $this->MenuItems->get($id);
        $moveFunction = 'move' . $action;
        if ($this->MenuItems->{$moveFunction}($menuItem)) {
            $this->Flash->success((string)__d('Qobo/Menu', '{0} has been moved {1} successfully.', $menuItem->get('label'), $action));
        } else {
            $this->Flash->error((string)__d('Qobo/Menu', 'Fail to move {0} {1}.', $menuItem->get('label'), $action));
        }

        $this->redirect($this->referer());
    }
}
