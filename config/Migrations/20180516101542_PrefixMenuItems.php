<?php
use Migrations\AbstractMigration;

class PrefixMenuItems extends AbstractMigration
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
        $this->table('menu_items')
            ->rename('qobo_menu_items')
            ->update();
    }
}
