<?php
namespace Menu\Test\TestCase\MenuBuilder;

use Cake\TestSuite\TestCase;
use Menu\MenuBuilder\MenuItemButton;

class MenuItemButtonTest extends TestCase
{
    public $menuItem;

    public function setUp()
    {
        $this->menuItem = new MenuItemButton();
    }

    /**
     * @dataProvider providerGetButtonLabels
     */
    public function testGetLabel($data, $expected)
    {
        $this->menuItem->setLabel($data);
        $result = $this->menuItem->getLabel();

        $this->assertEquals($result, $expected);
    }

    public function providerGetButtonLabels()
    {
        return [
            ['', ''],
            ['foobar', 'foobar'],
        ];
    }

    /**
     * @dataProvider providerGetButtonIcons
     */
    public function testGetIcon($data, $expected)
    {
        $this->menuItem->setIcon($data);
        $result = $this->menuItem->getIcon();

        $this->assertEquals($result, $expected);
    }

    public function providerGetButtonIcons()
    {
        return [
            ['fa fa-smile-o', 'fa fa-smile-o'],
            ['', ''],
        ];
    }

    /**
     * @dataProvider providerConfirmMsg
     */
    public function testConfigMessage($data, $expected)
    {
        $this->menuItem->setConfirmMsg($data);
        $this->assertEquals($expected, $this->menuItem->getConfirmMsg());
    }

    public function providerConfirmMsg()
    {
        return [
            [null, ''],
            ["It's a trap!", "It's a trap!"],
        ];
    }

    /**
     * @dataProvider providerButtonUrls
     */
    public function testGetUrl($data, $expected, $msg)
    {
        $this->menuItem->setUrl($data);
        $this->assertEquals($expected, $this->menuItem->getUrl(), $msg);
    }

    public function providerButtonUrls()
    {
        return [
            ['foobar', 'foobar', "Basic setter"],
            ['<script>alert("XSS?");</script>', '<script>alert("XSS?");</script>', "Nicely executed"],
        ];
    }

    /**
     * @dataProvider providerButtonDescription
     */
    public function testDescription($data, $expected, $msg)
    {
        $this->menuItem->setDescription($data);
        $this->assertEquals($data, $this->menuItem->getDescription(), $msg);
    }

    public function providerButtonDescription()
    {
        return [
            ['foobar content', 'foobar content', "Couldn't set basic content"],
            ['', '', "Didn't work out with empty values"],
        ];
    }

    /**
     * @dataProvider providerButtonExtraAttributes
     */
    public function testExtraAttributes($data, $expected, $msg)
    {
        $this->menuItem->setExtraAttribute($data);
        $this->assertEquals($expected, $this->menuItem->getExtraAttribute(), "Doesn't match");
    }

    public function providerButtonExtraAttributes()
    {
        return [
            ['foo', 'foo', "Didn't work with strings" ],
            [ ['hey' => 'jude'], ['hey' => 'jude'], "Can't use arrays" ],
        ];
    }

    /**
     * @dataProvider providerButtonOrder
     */
    public function testOrder($data, $expected, $msg)
    {
        $this->menuItem->setOrder($data);
        $this->assertEquals($expected, $this->menuItem->getOrder(), $msg);
    }

    public function providerButtonOrder()
    {
        return [
            ['', 0, "Wrong casting"],
            ['abc', 0, "Wrong casting"],
            [1, 1, "Cannot get integers running"],
        ];
    }

    /**
     * @dataProvider providerButtonDataType
     */
    public function testDataType($data, $expected, $msg)
    {
        $this->menuItem->setDataType($data);
        $this->assertEquals($expected, $this->menuItem->getDataType(), $msg);
    }

    public function providerButtonDataType()
    {
        return [
            ['foo', 'foo', 'Cannot set a string'],
        ];
    }

    /**
     * @dataProvider providerButtonTarget
     */
    public function testTarget($data, $expected, $msg)
    {
        $this->menuItem->setTarget($data);
        $this->assertEquals($expected, $this->menuItem->getTarget(), $msg);
    }

    public function providerButtonTarget()
    {
        return [
            ['foo', 'foo', "Cannot set a string to Target"],
        ];
    }

    /**
     * @dataProvider providerButtonChildren
     */
    public function testAddChild($data, $expected, $msg)
    {
        $this->menuItem->addChild($data);
        $this->assertEquals($expected, $this->menuItem->getChildren(), $msg);
    }

    public function providerButtonChildren()
    {
        $dummy = new MenuItemButton();

        return [
            [$dummy, [$dummy], "Cannot identify an objects array"],
        ];
    }
}
