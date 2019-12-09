<?php
namespace Menu\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MenuItemsFixture
 *
 */
class MenuItemsFixture extends TestFixture
{
    public $table = 'qobo_menu_items';
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'menu_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'label' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'url' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'type' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'icon' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'new_window' => ['type' => 'boolean', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'parent_id' => ['type' => 'uuid', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'lft' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'rght' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => '00000000-0000-0000-0000-000000000001',
            'menu_id' => '00000000-0000-0000-0000-000000000001',
            'label' => 'menu 1 item 1',
            'url' => 'http://www.google.com',
            'new_window' => 1,
            'parent_id' => null, // this is a root menu item
            'type' => 'link',
            'icon' => 'my_icon',
            'lft' => 1,
            'rght' => 1,
        ],
        [
            'id' => '00000000-0000-0000-0000-000000000003',
            'menu_id' => '00000000-0000-0000-0000-000000000002',
            'label' => 'menu 2 item 1',
            'url' => 'http://www.google.com',
            'new_window' => 1,
            'parent_id' => null, // this is a root menu item
            'type' => 'link',
            'icon' => 'my_icon',
            'lft' => 1,
            'rght' => 1,
        ],
        [
            'id' => '00000000-0000-0000-0000-000000000004',
            'menu_id' => '00000000-0000-0000-0000-000000000002',
            'label' => 'menu 2 item 2',
            'url' => 'http://www.google.com',
            'new_window' => 1,
            'parent_id' => null,
            'type' => 'link',
            'icon' => 'my_icon',
            'lft' => 1,
            'rght' => 1,
        ],
        [
            'id' => '00000000-0000-0000-0000-000000000005',
            'menu_id' => '00000000-0000-0000-0000-000000000002',
            'label' => 'menu 2 item 2 sub-item 1',
            'url' => 'http://www.google.com',
            'new_window' => 1,
            'parent_id' => '00000000-0000-0000-0000-000000000004',
            'type' => 'link',
            'icon' => 'my_icon',
            'lft' => 1,
            'rght' => 1,
        ],
    ];
}
