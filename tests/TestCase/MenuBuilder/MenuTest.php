<?php
namespace Menu\Test\TestCase\MenuBuilder;

use Cake\TestSuite\TestCase;
use Menu\MenuBuilder\Menu;
use Menu\MenuBuilder\MenuItemButton;

class MenuTest extends TestCase
{
    public $instance;

    public function setUp()
    {
        $this->instance = new Menu();
    }

    /**
     * @dataProvider providerMenuItems
     */
    public function testAddMenuItem($data, $expected, $msg)
    {
        if (is_array($data)) {
            foreach ($data as $testItem) {
                $this->instance->addMenuItem($testItem);
            }
        } else {
            $this->instance->addMenuItem($data);
        }

        $result = $this->instance->getMenuItems();
        $this->assertEquals($result, $expected, $msg);
    }

    public function providerMenuItems()
    {
        $return = [];
        $dummy = new MenuItemButton();
        $dummyTwo = clone $dummy;

        $testData[] = [$dummy, [$dummy], "Couldn't add item to array"];

        $dummyTwo->setOrder(0);
        $dummyTwo->setUrl('http://example.com');

        $testData[] = [[$dummy, $dummyTwo], [$dummyTwo, $dummy], "Couldn't sort correctly"];

        return $testData;
    }
}
