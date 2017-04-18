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
            'contain' => ['Menus', 'ParentMenuItems', 'ChildMenuItems' => ['Menus']]
        ]);

        $this->set('menuItem', $menuItem);
        $this->set('_serialize', ['menuItem']);
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

                return $this->redirect(['action' => 'index', $menu->id]);
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

                return $this->redirect(['action' => 'index', $menuItem->menu->id]);
            } else {
                $this->Flash->error(__('The menu item could not be saved. Please, try again.'));
            }
        }
        $parentMenuItems = $this->MenuItems
            ->find('treeList', ['spacer' => self::TREE_SPACER])
            ->where(['MenuItems.menu_id' => $menuItem->menu->id]);
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
        $node = $this->MenuItems->get($id);
        $moveFunction = 'move' . $action;
        if ($this->MenuItems->{$moveFunction}($node)) {
            $this->Flash->success(__('{0} has been moved {1} successfully.', $node->label, $action));
        } else {
            $this->Flash->error(__('Fail to move {0} {1}.', $node->label, $action));
        }

        return $this->redirect($this->referer());
    }
}
