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
namespace Menu\Shell\Task;

use Cake\Console\Shell;
use Cake\Core\Configure;
use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

class ImportTask extends Shell
{
    /**
     * {@inheritDoc}
     */
    public function main()
    {
        $this->out('Task: import system menus');
        $this->hr();

        $table = TableRegistry::get('Menu.Menus');

        $data = $this->_getSystemMenus();
        $errors = [];
        foreach ($data as $menu) {
            if ($table->exists(['name' => $menu['name']])) {
                $errors[] = [
                    'message' => 'Menu [' . $menu['name'] . '] already exists',
                    'details' => []
                ];

                continue;
            }
            $entity = $table->newEntity();
            foreach ($menu as $k => $v) {
                $entity->{$k} = $v;
            }
            $saved = $table->save($entity);
            if ($saved) {
                $this->out('Menu [' . $entity->name . '] imported successfully');
            } else {
                $validationErrors = $this->_getValidationErrors($entity);
                $errors[] = [
                    'message' => 'Failed to import menu [' . $entity->name . ']',
                    'details' => !empty($validationErrors) ? $validationErrors : []
                ];
            }
        }

        if (empty($errors)) {
            $this->out('<success>System menus importing task completed</success>');
        } else {
            foreach ($errors as $error) {
                $this->err($error['message']);
                if (empty($error['details'])) {
                    continue;
                }
                $this->out(implode("\n", $error['details']));
            }
        }
    }

    /**
     * Get system menus.
     *
     * @return array
     */
    protected function _getSystemMenus()
    {
        $data = [
            [
                'name' => MENU_MAIN,
                'active' => true,
                'default' => true,
                'deny_edit' => true,
                'deny_delete' => true
            ],
            [
                'name' => MENU_ADMIN,
                'active' => true,
                'default' => true,
                'deny_edit' => true,
                'deny_delete' => true
            ]
        ];

        return $data;
    }

    /**
     * Get validation errors from entity object.
     *
     * @param  \Cake\ORM\Entity $entity Entity instance
     * @return array
     */
    protected function _getValidationErrors($entity)
    {
        $result = [];
        if (!empty($entity->errors())) {
            foreach ($entity->errors() as $field => $error) {
                if (is_array($error)) {
                    $msg = implode(', ', $error);
                } else {
                    $msg = $error;
                }
                $result[] = $msg . ' [' . $entity->{$field} . '] for field [' . $field . ']';
            }
        }

        return $result;
    }
}
