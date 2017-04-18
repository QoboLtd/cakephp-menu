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
     * @param mixed $menuId Menu ID
     * @return \Cake\Network\Response|null
     */
    public function index($menuId = null)
    {
        if (is_null($menuId)) {
            $this->Flash->error(__d('menu', 'Please choose a menu to view its menu items'));

            return $this->redirect(['controller' => 'Menus', 'action' => 'index']);
        }

        $menu = $this->MenuItems->Menus->get($menuId);
        if (!$menu) {
            $this->Flash->error(__d('menu', 'Given menu was not found.'));

            return $this->redirect(['controller' => 'Menus', 'action' => 'index']);
        }

        $tree = $this->MenuItems
            ->find('treeList', ['spacer' => self::TREE_SPACER])
            ->where(['menu_id' => $menuId])
            ->toArray();
        $menuItems = $this->MenuItems
            ->find('all')
            ->where(['menu_id' => $menuId])
            ->order(['lft' => 'ASC']);
        //Create node property in the entity object
        foreach ($menuItems as $menuItem) {
            if (in_array($menuItem->id, array_keys($tree))) {
                $menuItem->node = $tree[$menuItem->id];
            }
        }
        $this->set('navMenu', $menu);
        $this->set(compact('menuItems'));
        $this->set('_serialize', ['menuItems']);
    }

    /**
     * View method
     *
     * @param string|null $id Menu Item id.
     * @return void
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

                return $this->redirect(['action' => 'index', $this->request->data['menu_id']]);
            } else {
                $this->Flash->error(__('The menu item could not be saved. Please, try again.'));
            }
        }
        $menus = $this->MenuItems->Menus->find('list', ['limit' => 200]);
        $parentMenuItems = $this->MenuItems->find('treeList', ['spacer' => self::TREE_SPACER]);
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

                return $this->redirect(['action' => 'index', $this->request->data['menu_id']]);
            } else {
                $this->Flash->error(__('The menu item could not be saved. Please, try again.'));
            }
        }
        $menus = $this->MenuItems->Menus->find('list', ['limit' => 200]);
        $this->set(compact('menuItem', 'menus'));
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
        $node = $this->MenuItems->get($id);
        $moveFunction = 'move' . $action;
        if ($this->MenuItems->{$moveFunction}($node)) {
            $this->Flash->success(__('{0} has been moved {1} successfully.', $node->label, $action));
        } else {
            $this->Flash->error(__('Fail to move {0} {1}.', $node->label, $action));
        }

        return $this->redirect($this->referer());
    }

    /**
     * Return the menu items of the given menu id.
     * Expected params
     * - id - parent menu id
     * - parentsOnly - top level menu items.
     *
     * @return void
     */
    public function menuItems()
    {
        $this->request->allowMethod('ajax');
        $id = $this->request->query('id');
        $parentsOnly = (bool)$this->request->query('parents_only');
        $conditions = ['menu_id' => $id];
        if ($parentsOnly) {
            $conditions['parent_id IS'] = null;
        }
        $content = $this->MenuItems->find('all')
            ->where($conditions)
            ->order(['label' => 'ASC']);
        $this->set(compact('content'));
        $this->set('_serialize', ['content']);
    }
}
