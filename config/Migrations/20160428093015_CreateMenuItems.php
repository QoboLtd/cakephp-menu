<?php
use Migrations\AbstractMigration;

class CreateMenuItems extends AbstractMigration
{
    public $autoId = false;

    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('menu_items');
        $table->addColumn('id', 'uuid', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('menu_id', 'uuid', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('label', 'string', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('url', 'string', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('new_window', 'boolean', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('parent_id', 'uuid', [
                'default' => null,
                'null' => true,
        ]);
        $table->addColumn('lft', 'integer', [
                'default' => null,
                'null' => false,
        ]);
        $table->addColumn('rght', 'integer', [
                'default' => null,
                'null' => false,
        ]);
        $table->addPrimaryKey([
            'id',
        ]);
        $table->create();
    }
}
