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

use Cake\Http\Response;
use Cake\ORM\TableRegistry;
use Menu\Controller\AppController;

/**
 * Menus Controller
 *
 * @property \Menu\Model\Table\MenusTable $Menus
 */
class MenusController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index(): void
    {
        $menus = $this->Menus->find('all');

        $this->set(compact('menus'));
        $this->set('_serialize', ['navMenu']);
    }

    /**
     * View method
     *
     * @param string|null $id Menu id.
     * @return void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(string $id = null): void
    {
        $menu = $this->Menus->get($id, [
            'contain' => [
                'MenuItems' => function ($q) {
                    return $q->order(['MenuItems.lft' => 'ASC']);
                }
            ]
        ]);

        if ($menu->get('menu_items')) {
            $tree = TableRegistry::get('Menu.MenuItems')
                ->find('treeList', ['spacer' => self::TREE_SPACER])
                ->where(['MenuItems.menu_id' => $menu->id])
                ->toArray();
            // create node property in the entity object
            foreach ($menu->get('menu_items') as $menuItem) {
                if (!array_key_exists($menuItem->id, $tree)) {
                    continue;
                }
                $menuItem->node = $tree[$menuItem->id];
            }
        }

        $this->set('navMenu', $menu);
        $this->set('_serialize', ['navMenu']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add(): void
    {
        $menu = $this->Menus->newEntity();
        if ($this->request->is('post')) {
            $data = (array)$this->request->getData();
            $menu = $this->Menus->patchEntity($menu, $data);
            if ($this->Menus->save($menu)) {
                $this->Flash->success(__('The menu has been saved.'));
                $this->redirect(['action' => 'index']);

                return;
            } else {
                $this->Flash->error(__('The menu could not be saved. Please, try again.'));
            }
        }
        $this->set('navMenu', $menu);
        $this->set('_serialize', ['navMenu']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Menu id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     */
    public function edit(string $id = null): void
    {
        $menu = $this->Menus->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = (array)$this->request->getData();
            $menu = $this->Menus->patchEntity($menu, $data);
            if ($this->Menus->save($menu)) {
                $this->Flash->success(__('The menu has been saved.'));
                $this->redirect(['action' => 'index']);

                return;
            } else {
                $this->Flash->error(__('The menu could not be saved. Please, try again.'));
            }
        }
        $this->set('navMenu', $menu);
        $this->set('_serialize', ['navMenu']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Menu id.
     * @return void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $id = null): void
    {
        $this->request->allowMethod(['post', 'delete']);
        $menu = $this->Menus->get($id);
        if ($this->Menus->delete($menu)) {
            $this->Flash->success(__('The menu has been deleted.'));
        } else {
            $this->Flash->error(__('The menu could not be deleted. Please, try again.'));
        }

        $this->redirect(['action' => 'index']);
    }
}
