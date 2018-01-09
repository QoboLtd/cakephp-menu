<?php
namespace Menu\Test\TestCase\MenuBuilder;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use Menu\MenuBuilder\BaseMenuRenderClass;
use Menu\MenuBuilder\Menu;
use Menu\MenuBuilder\MenuItemButton;
use Menu\MenuBuilder\MenuItemLinkButtonModal;

class BaseMenuRenderClassTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->view = new View();
        $this->menu = new Menu();

        $this->menuRenderer = new BaseMenuRenderClass($this->menu, $this->view);
        $this->menuRenderer->setFormat([
            'menuStart' => '<ul>',
            'menuEnd' => '</ul>',
            'itemStart' => '<li>',
            'itemEnd' => '</li>'
        ]);
    }

    public function tearDown()
    {
        unset($this->menuRenderer);
        unset($this->menu);
        unset($this->view);

        parent::tearDown();
    }

    public function testRenderEmptyMenu()
    {
        $expected = '<ul></ul>';

        $this->assertEquals($expected, $this->menuRenderer->render());
    }

    public function testRenderMenuWithButton()
    {
        $item = new MenuItemButton();
        $item->setUrl('http://example.com');
        $item->setLabel('Test');

        $this->menu->addMenuItem($item);

        $expected = '<ul><li><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Test</button></ul>';

        $this->assertEquals($expected, $this->menuRenderer->render());
    }

    public function testRenderMenuWithModal()
    {
        $item = new MenuItemLinkButtonModal();
        $item->setUrl('http://example.com');
        $item->setLabel('Modal');

        $this->menu->addMenuItem($item);

        $expected = '<ul><li><a href="#" class="btn btn-default" data-toggle="modal" data-target="#" title="Modal" target="_self"><i class="menu-icon fa fa-"></i> Modal</a></ul>';

        $this->assertEquals($expected, $this->menuRenderer->render());
    }
}
