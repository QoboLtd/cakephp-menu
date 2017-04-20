<?php
use Migrations\AbstractMigration;

class AddDenyEditDenyDeleteToMenus extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('menus');
        $table->addColumn('deny_edit', 'boolean', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('deny_delete', 'boolean', [
            'default' => null,
            'null' => false,
        ]);
        $table->update();
    }
}
