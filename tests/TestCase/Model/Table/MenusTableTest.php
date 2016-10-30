<?php
namespace Menu\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Menu\Model\Table\MenusTable;

/**
 * Menu\Model\Table\MenusTable Test Case
 */
class MenusTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Menu\Model\Table\MenusTable
     */
    public $Menus;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.menu.menus',
        'plugin.menu.menu_items'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Menus') ? [] : ['className' => 'Menu\Model\Table\MenusTable'];
        $this->Menus = TableRegistry::get('Menus', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Menus);

        parent::tearDown();
    }
}
