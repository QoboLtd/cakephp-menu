<?php
namespace Menu\Test\TestCase\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Menu\Model\Table\MenuItemsTable;

/**
 * Menu\Model\Table\MenuItemsTable Test Case
 */
class MenuItemsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Menu\Model\Table\MenuItemsTable
     */
    public $MenuItems;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.menu.menu_items',
        'plugin.menu.menus'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('MenuItems') ? [] : ['className' => 'Menu\Model\Table\MenuItemsTable'];
        $this->MenuItems = TableRegistry::get('MenuItems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MenuItems);

        parent::tearDown();
    }
}
