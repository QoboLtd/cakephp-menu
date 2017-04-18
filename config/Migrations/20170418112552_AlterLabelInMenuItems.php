<?php
use Migrations\AbstractMigration;

class AlterLabelInMenuItems extends AbstractMigration
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
        $table = $this->table('menu_items');
        $table->changeColumn('label', 'string', [
            'null' => false
        ]);
        $table->update();
    }
}
