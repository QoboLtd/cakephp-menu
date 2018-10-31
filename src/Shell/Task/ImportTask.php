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
use Cake\Datasource\EntityInterface;
use Cake\ORM\TableRegistry;

/**
 * Import Task
 *
 * Import menus.
 */
class ImportTask extends Shell
{
    /**
     * Main task method
     *
     * @return bool True on success, false otherwise
     */
    public function main()
    {
        $this->info('Task: import system menus');
        $this->hr();

        $data = $this->getSystemMenus();
        if (empty($data)) {
            $this->warn("System menus are not configured.  Nothing to do.");

            return true;
        }
        // get menus table
        $table = TableRegistry::get('Menu.Menus');

        foreach ($data as $menu) {
            if (empty($menu['name'])) {
                $this->warn("Skipping menu without a name.");
                continue;
            }

            if ($table->exists(['name' => $menu['name']])) {
                $this->warn("Menu [" . $menu['name'] . "] already exists. Skipping.");
                continue;
            }

            $this->info("Menu [" . $menu['name'] . "] does not exist.  Creating.");
            $entity = $table->newEntity();
            $entity = $table->patchEntity($entity, $menu);
            $result = $table->save($entity);
            if (!$result) {
                $this->err("Errors: \n" . implode("\n", $this->getImportErrors($entity)));
                $this->abort("Failed to create menu [" . $menu['name'] . "]");
            }
        }

        $this->success('System menus imported successfully');
    }

    /**
     * Get system menus.
     *
     * @return mixed[]
     */
    protected function getSystemMenus(): array
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
     * Get import errors from entity object.
     *
     * @param \Cake\Datasource\EntityInterface $entity Entity instance
     * @return string[]
     */
    protected function getImportErrors(EntityInterface $entity): array
    {
        $result = [];

        if (empty($entity->getErrors())) {
            return $result;
        }

        foreach ($entity->getErrors() as $field => $error) {
            $msg = "[$field] ";
            $msg .= is_array($error) ? implode(', ', $error) : $error;
            $result[] = $msg;
        }

        return $result;
    }
}
