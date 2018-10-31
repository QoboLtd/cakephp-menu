<?php
namespace Menu\Test\TestCase\MenuBuilder;

use Cake\TestSuite\TestCase;
use Menu\MenuBuilder\BaseMenuItem;
use Menu\MenuBuilder\MenuItemButton;
use Menu\Model\Entity\MenuItem;

class MenuItemButtonTest extends TestCase
{
    /**
     * @var BaseMenuItem
     */
    public $menuItem;

    public function setUp()
    {
        $this->menuItem = new MenuItemButton();
    }

    /**
     * @dataProvider providerGetButtonLabels
     */
    public function testGetLabel(string $data, string $expected): void
    {
        $this->menuItem->setLabel($data);
        $result = $this->menuItem->getLabel();

        $this->assertEquals($result, $expected);
    }

    /**
     * @return mixed[]
     */
    public function providerGetButtonLabels(): array
    {
        return [
            ['', ''],
            ['foobar', 'foobar'],
        ];
    }

    /**
     * @dataProvider providerGetButtonIcons
     */
    public function testGetIcon(string $data, string $expected): void
    {
        $this->menuItem->setIcon($data);
        $result = $this->menuItem->getIcon();

        $this->assertEquals($result, $expected);
    }

    /**
     * @return mixed[]
     */
    public function providerGetButtonIcons(): array
    {
        return [
            ['fa fa-smile-o', 'fa fa-smile-o'],
            ['', ''],
        ];
    }

    /**
     * @dataProvider providerConfirmMsg
     * @param mixed $data Data
     * @param string $expected Expected result
     */
    public function testConfigMessage($data, string $expected): void
    {
        $this->menuItem->setConfirmMsg($data);
        $this->assertEquals($expected, $this->menuItem->getConfirmMsg());
    }

    /**
     * @return mixed[]
     */
    public function providerConfirmMsg(): array
    {
        return [
            ['', ''],
            ["It's a trap!", "It's a trap!"],
        ];
    }

    /**
     * @dataProvider providerButtonUrls
     */
    public function testGetUrl(string $data, string $expected, string $msg): void
    {
        $this->menuItem->setUrl($data);
        $this->assertEquals($expected, $this->menuItem->getUrl(), $msg);
    }

    /**
     * @return mixed[]
     */
    public function providerButtonUrls(): array
    {
        return [
            ['foobar', 'foobar', "Basic setter"],
            ['<script>alert("XSS?");</script>', '<script>alert("XSS?");</script>', "Nicely executed"],
        ];
    }

    /**
     * @dataProvider providerButtonDescription
     */
    public function testDescription(string $data, string $expected, string $msg): void
    {
        $this->menuItem->setDescription($data);
        $this->assertEquals($data, $this->menuItem->getDescription(), $msg);
    }

    /**
     * @return mixed[]
     */
    public function providerButtonDescription(): array
    {
        return [
            ['foobar content', 'foobar content', "Couldn't set basic content"],
            ['', '', "Didn't work out with empty values"],
        ];
    }

    /**
     * @dataProvider providerButtonExtraAttributes
     * @param mixed $data Data
     * @param mixed $expected Expected result
     * @param string $msg Message
     */
    public function testExtraAttributes($data, $expected, string $msg): void
    {
        $this->menuItem->setExtraAttribute($data);
        $this->assertEquals($expected, $this->menuItem->getExtraAttribute(), "Doesn't match");
    }

    /**
     * @return mixed[]
     */
    public function providerButtonExtraAttributes(): array
    {
        return [
            ['foo', 'foo', "Didn't work with strings"],
        ];
    }

    /**
     * @dataProvider providerButtonOrder
     * @param mixed $data Data
     * @param int $expected Expected result
     * @param string $msg Message
     */
    public function testOrder($data, int $expected, string $msg): void
    {
        $this->menuItem->setOrder($data);
        $this->assertEquals($expected, $this->menuItem->getOrder(), $msg);
    }

    /**
     * @return mixed[]
     */
    public function providerButtonOrder(): array
    {
        return [
            [1, 1, "Cannot get integers running"],
        ];
    }

    /**
     * @dataProvider providerButtonDataType
     */
    public function testDataType(string $data, string $expected, string $msg): void
    {
        $this->menuItem->setDataType($data);
        $this->assertEquals($expected, $this->menuItem->getDataType(), $msg);
    }

    /**
     * @return mixed[]
     */
    public function providerButtonDataType(): array
    {
        return [
            ['foo', 'foo', 'Cannot set a string'],
        ];
    }

    /**
     * @dataProvider providerButtonTarget
     */
    public function testTarget(string $data, string $expected, string $msg): void
    {
        $this->menuItem->setTarget($data);
        $this->assertEquals($expected, $this->menuItem->getTarget(), $msg);
    }

    /**
     * @return mixed[]
     */
    public function providerButtonTarget(): array
    {
        return [
            ['foo', 'foo', "Cannot set a string to Target"],
        ];
    }

    /**
     * @dataProvider providerButtonChildren
     * @param mixed $data Data
     * @param mixed $expected Expected result
     * @param string $msg Message
     */
    public function testAddChild($data, $expected, string $msg): void
    {
        $this->menuItem->addMenuItem($data);
        $this->assertEquals($expected, $this->menuItem->getMenuItems(), $msg);
    }

    /**
     * @return mixed[]
     */
    public function providerButtonChildren(): array
    {
        $dummy = new MenuItemButton();

        return [
            [$dummy, [$dummy], "Cannot identify an objects array"],
        ];
    }

    public function testEnabledFlag(): void
    {
        $item = new MenuItemButton();
        $this->assertTrue($item->isEnabled());
        $item->disable();
        $this->assertFalse($item->isEnabled());
        $item->enable();
        $this->assertTrue($item->isEnabled());
    }

    public function testConditions(): void
    {
        $item = new MenuItemButton();
        $item->disableIf(function () {
            return false;
        });
        $this->assertTrue($item->isEnabled());
        $item->disableIf(function () {
            return true;
        });
        $this->assertFalse($item->isEnabled());
    }

    public function testEnabledFlagNested(): void
    {
        $child1 = new MenuItemButton();

        $child2 = new MenuItemButton();
        $child2->disable();

        $item = new MenuItemButton();
        $item->addMenuItem($child1);
        $item->addMenuItem($child2);
        $this->assertTrue($item->isEnabled());

        $child1->disable();
        $this->assertFalse($item->isEnabled());
    }

    public function testAttributes(): void
    {
        $item = new MenuItemButton();
        $item->addAttribute('one', '1');
        $attrs = $item->getAttributes();
        $this->assertEquals('1', $attrs['one']);
    }
}
