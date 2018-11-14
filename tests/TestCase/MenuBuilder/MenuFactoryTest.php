<?php
namespace Menu\Test\TestCase\MenuBuilder;

use Cake\TestSuite\TestCase;
use Menu\MenuBuilder\MenuFactory;
use Menu\MenuBuilder\MenuInterface;
use ReflectionClass;
use Cake\ORM\TableRegistry;

// use Cake\TestSuite\Fixture\TestFixture;

class MenuFactoryTest extends TestCase
{
    public $instance;
    public $Menus;
    public $MenuItems;

    public $fixtures = [
        'plugin.menu.menus',
        'plugin.menu.menu_items'
    ];

    public function setUp()
    {
        parent::setUp();
        $configMenus = TableRegistry::exists('Menus') ? [] :  ['className' => 'Menu\Model\Table\MenusTable'];
        $configMenuItems = TableRegistry::exists('MenuItems') ? [] :  ['className' => 'Menu\Model\Table\MenuItemsTable'];
        $this->Menus = TableRegistry::get('Menus', $configMenus);
        $this->MenuItems = TableRegistry::get('MenuItems', $configMenuItems);
    
        $this->instance = new MenuFactory(['user1'], true);
    }
    
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    public function testGetMenuFromEvents()
    {
        $results = $this->invokeMethod($this->instance, 'getMenu', ['main_menu',['user1']]);
        $this->assertTrue($results instanceof MenuInterface);
    }
    
    public function testGetMenuFromTable()
    {
        $results = $this->invokeMethod($this->instance, 'getMenu', ['menu1',['user1']]);
        $this->assertTrue($results instanceof MenuInterface);
    }
    
    public function testGetMenuItemEmpty()
    {
        $item = [];
        $entity = $this->Menus->find('all')->first();
        $results = $this->invokeMethod($this->instance, 'getMenuItem', [$entity, $item]);
        
        $this->assertEmpty($results);
    }

    public function testGetMenuItemWithChildren()
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

    public function testGetMenuItemEmptyChildren()
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
