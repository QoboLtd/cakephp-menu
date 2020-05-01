<?php
namespace Menu\Test\TestCase\MenuBuilder;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Menu\MenuBuilder\MenuFactory;
use Menu\MenuBuilder\MenuInterface;
use ReflectionClass;

/**
 * Test Class for MenuFactory
 */
class MenuFactoryTest extends TestCase
{
    /**
     * MenuFactory istance
     * @var \Menu\MenuBuilder\MenuFactory
     */
    public $instance;

    /**
     * Model Menus
     * @var \Cake\ORM\Table
     */
    public $Menus;

    /**
     * Model MenusItems
     * @var \Cake\ORM\Table
     */
    public $MenuItems;

    /**
     * Need to use the fixure
     * @var array
     */
    public $fixtures = [
        'plugin.Menu.Menus',
        'plugin.Menu.MenuItems',
    ];

    public function setUp()
    {
        parent::setUp();
        $configMenus = TableRegistry::getTableLocator()->exists('Menus') ? [] : ['className' => 'Menu\Model\Table\MenusTable'];
        $configMenuItems = TableRegistry::getTableLocator()->exists('MenuItems') ? [] : ['className' => 'Menu\Model\Table\MenuItemsTable'];
        $this->Menus = TableRegistry::getTableLocator()->get('Menus', $configMenus);
        $this->MenuItems = TableRegistry::getTableLocator()->get('MenuItems', $configMenuItems);

        $this->instance = new MenuFactory(['user1'], true);
    }

    /**
     * Access protected and private method
     * @param  \Menu\MenuBuilder\MenuFactory $object Class to access
     * @param  string $methodName Method name
     * @param  mixed[] $parameters arguments of the methods
     * @return mixed
     */
    public function invokeMethod(\Menu\MenuBuilder\MenuFactory &$object, string $methodName, array $parameters = [])
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * test GetMenu() when default = 1
     * @return void
     */
    public function testGetMenuFromEvents(): void
    {
        $results = MenuFactory::getMenu('menu_from_event', []);
        $this->assertTrue($results instanceof MenuInterface);
        $this->assertEmpty($results->getMenuItems());
    }

    /**
     * test GetMenu() when default = 0
     * @return void
     */
    public function testGetMenuFromTable(): void
    {
        $results = MenuFactory::getMenu('main_menu', []);
        $this->assertTrue($results instanceof MenuInterface);
        $this->assertCount(2, $results->getMenuItems());
        $this->assertCount(1, $results->getMenuItems()[1]->getMenuItems());
    }

    /**
     * test protected GetMenuItem()
     * @return void
     */
    public function testGetMenuItemEmpty(): void
    {
        $item = [];
        $entity = $this->Menus->find('all')->first();
        $results = $this->invokeMethod($this->instance, 'getMenuItem', [$entity, $item]);

        $this->assertEmpty($results);
    }

    /**
     * test protected GetMenuItem()
     * @return void
     */
    public function testGetMenuItemWithChildren(): void
    {
        $children1 = [
                        'label' => 'CHmy label',
                        'icon' => 'CHmy icon',
                        'type' => 'module',
                        'children' => [],
                        'url' => 'http://www.url.com',
                        'order' => 4,
                    ];
        $children2 = [
                        'label' => 'CH2my label',
                        'icon' => 'CH2my icon',
                        'type' => 'not module',
                        'children' => [],
                        'url' => 'http://www.url.com',
                        'order' => 2,
                    ];
        $item = [
            'label' => 'my label',
            'icon' => 'my icon',
            'type' => 'type 1',
            'children' => [$children1, $children2],
            'url' => 'http://www.url.com',
            'order' => 0,
        ];

        $entity = $this->Menus->find('all')->first();
        $results = $this->invokeMethod($this->instance, 'getMenuItem', [$entity, $item]);

        $assertResult = [
            'label' => 'my label',
            'icon' => 'my icon',
            'type' => 'type 1',
            'children' => [[], $children2],
            'url' => 'http://www.url.com',
            'order' => 0,
        ];

        $this->assertEquals($assertResult, $results);
    }

    /**
     * test protected GetMenuItem()
     * @return void
     */
    public function testGetMenuItemEmptyChildren(): void
    {
        $children = [];
        $item = [
            'label' => 'my label',
            'icon' => 'my icon',
            'type' => 'type 1',
            'children' => $children,
            'url' => 'http://www.url.com',
            'order' => 0,
        ];
        $entity = $this->Menus->find('all')->first();
        $results = $this->invokeMethod($this->instance, 'getMenuItem', [$entity, $item]);
        $this->assertEquals($item, $results);
    }
}
