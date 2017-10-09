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
use Menu\Controller\AppController;
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
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($menuId)
    {
        $menu = $this->MenuItems->Menus->get($menuId);
        $menuItem = $this->MenuItems->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $data['menu_id'] = $menu->id;
            $menuItem = $this->MenuItems->patchEntity($menuItem, $data);
            if ($this->MenuItems->save($menuItem)) {
                $this->Flash->success(__('The menu item has been saved.'));

                return $this->redirect(['controller' => 'Menus', 'action' => 'view', $menu->id]);
            } else {
                $this->Flash->error(__('The menu item could not be saved. Please, try again.'));
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
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $menuItem = $this->MenuItems->get($id, [
            'contain' => ['Menus']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $menuItem = $this->MenuItems->patchEntity($menuItem, $this->request->data);
            if ($this->MenuItems->save($menuItem)) {
                $this->Flash->success(__('The menu item has been saved.'));

                return $this->redirect(['controller' => 'Menus', 'action' => 'view', $menuItem->menu->id]);
            } else {
                $this->Flash->error(__('The menu item could not be saved. Please, try again.'));
            }
        }

        $parentMenuItems = $this->MenuItems
            ->find('treeList', ['spacer' => self::TREE_SPACER])
            ->where(['MenuItems.menu_id' => $menuItem->menu->id, 'MenuItems.id !=' => $id]);

        $this->set(compact('menuItem', 'parentMenuItems'));
        $this->set('_serialize', ['menuItem']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Menu Item id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $menuItem = $this->MenuItems->get($id);
        if ($this->MenuItems->delete($menuItem)) {
            $this->Flash->success(__('The menu item has been deleted.'));
        } else {
            $this->Flash->error(__('The menu item could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }

    /**
     * Move the node.
     *
     * @param  string $id menu id
     * @param  string $action move action
     * @throws InvalidPrimaryKeyException When provided id is invalid.
     * @return \Cake\Network\Response|null Redirects to index or referer.
     */
    public function moveNode($id = null, $action = '')
    {
        $moveActions = ['up', 'down'];
        if (!in_array($action, $moveActions)) {
            $this->Flash->error(__('Unknown move action.'));

            return $this->redirect(['action' => 'index']);
        }
        $menuItem = $this->MenuItems->get($id);
        $moveFunction = 'move' . $action;
        if ($this->MenuItems->{$moveFunction}($menuItem)) {
            $this->Flash->success(__('{0} has been moved {1} successfully.', $menuItem->label, $action));
        } else {
            $this->Flash->error(__('Fail to move {0} {1}.', $menuItem->label, $action));
        }

        return $this->redirect($this->referer());
    }
}
