<?php
namespace Menu\Controller;

use Menu\Controller\AppController;

/**
 * MenuItems Controller
 *
 * @property \Menu\Model\Table\MenuItemsTable $MenuItems
 */
class MenuItemsController extends AppController
{
    const TREE_SPACER = '&nbsp;&nbsp;&nbsp;&nbsp;';

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $tree = $this->MenuItems
            ->find('treeList', ['spacer' => self::TREE_SPACER])
            ->toArray();
        $menuItems = $this->MenuItems
            ->find('all')
            ->order(['lft' => 'ASC']);
        //Create node property in the entity object
        foreach ($menuItems as $menuItem) {
            if (in_array($menuItem->id, array_keys($tree))) {
                $menuItem->node = $tree[$menuItem->id];
            }
        }
        $this->set(compact('menuItems'));
        $this->set('_serialize', ['menuItems']);
    }

    /**
     * View method
     *
     * @param string|null $id Menu Item id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $menuItem = $this->MenuItems->get($id, [
            'contain' => ['Menus', 'ParentMenuItems', 'ChildMenuItems']
        ]);

        $this->set('menuItem', $menuItem);
        $this->set('_serialize', ['menuItem']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $menuItem = $this->MenuItems->newEntity();
        if ($this->request->is('post')) {
            $menuItem = $this->MenuItems->patchEntity($menuItem, $this->request->data);
            if ($this->MenuItems->save($menuItem)) {
                $this->Flash->success(__('The menu item has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The menu item could not be saved. Please, try again.'));
            }
        }
        $menus = $this->MenuItems->Menus->find('list', ['limit' => 200]);
        $parentMenuItems = $this->MenuItems->ParentMenuItems->find('list', ['limit' => 200]);
        $this->set(compact('menuItem', 'menus', 'parentMenuItems'));
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
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $menuItem = $this->MenuItems->patchEntity($menuItem, $this->request->data);
            if ($this->MenuItems->save($menuItem)) {
                $this->Flash->success(__('The menu item has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The menu item could not be saved. Please, try again.'));
            }
        }
        $menus = $this->MenuItems->Menus->find('list', ['limit' => 200]);
        $parentMenuItems = $this->MenuItems->ParentMenuItems->find('list', ['limit' => 200]);
        $this->set(compact('menuItem', 'menus', 'parentMenuItems'));
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
        return $this->redirect(['action' => 'index']);
    }
}
