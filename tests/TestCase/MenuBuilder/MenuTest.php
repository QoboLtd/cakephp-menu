<?php
namespace Qobo\Menu\Test\TestCase\MenuBuilder;

use Cake\TestSuite\TestCase;
use Qobo\Menu\MenuBuilder\Menu;
use Qobo\Menu\MenuBuilder\MenuItemButton;

class MenuTest extends TestCase
{
    /**
     * @var Menu
     */
    public $instance;

    public function setUp()
    {
        $this->instance = new Menu();
    }

    /**
     * @dataProvider providerMenuItems
     * @param mixed $data Data
     * @param mixed[] $expected Expected result
     * @param string $msg
     */
    public function testAddMenuItem($data, array $expected, string $msg): void
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

    public function testAddRemove(): void
    {
        $item = new MenuItemButton();
        $this->instance->addMenuItem($item);
        $this->assertEquals(1, count($this->instance->getMenuItems()));

        $this->instance->removeMenuItem(new MenuItemButton());
        $this->assertEquals(1, count($this->instance->getMenuItems()));

        $this->instance->removeMenuItem($item);
        $this->assertEquals(0, count($this->instance->getMenuItems()));
    }

    /**
     * @return mixed[]
     */
    public function providerMenuItems(): array
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
