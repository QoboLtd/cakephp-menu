<?php
namespace Qobo\Menu\Test\TestCase\MenuBuilder;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use Qobo\Menu\MenuBuilder\BaseMenuRenderClass;
use Qobo\Menu\MenuBuilder\Menu;
use Qobo\Menu\MenuBuilder\MenuInterface;
use Qobo\Menu\MenuBuilder\MenuItemButton;
use Qobo\Menu\MenuBuilder\MenuItemLink;
use Qobo\Menu\MenuBuilder\MenuItemLinkButton;
use Qobo\Menu\MenuBuilder\MenuItemLinkButtonModal;
use Qobo\Menu\MenuBuilder\MenuItemLinkModal;
use Qobo\Menu\MenuBuilder\MenuItemPostlink;
use Qobo\Menu\MenuBuilder\MenuItemPostlinkButton;
use Qobo\Menu\MenuBuilder\MenuItemSeparator;
use Qobo\Menu\MenuBuilder\MenuRenderInterface;

class BaseMenuRenderClassTest extends TestCase
{
    /**
     * @var View
     */
    private $view;

    /**
     * @var MenuInterface
     */
    private $menu;

    /**
     * @var MenuRenderInterface
     */
    private $menuRenderer;

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
            'itemEnd' => '</li>',
            'childMenuStart' => '<ul>',
            'childMenuEnd' => '</ul>',
            'childItemStart' => '<lo>',
            'childItemEnd' => '</lo>',
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

    public function testRenderMenuWithDisabledItem()
    {
        $item = new MenuItemLink();
        $item->setUrl('http://example.com');
        $item->setLabel('Link');
        $item->disable();
        $this->menu->addMenuItem($item);

        $expected = '<ul></ul>';
        $this->assertEquals($expected, $this->menuRenderer->render());
    }

    public function testRenderMenuWithNestedDisabledItem()
    {
        $item = new MenuItemLink();
        $item->setUrl('#');
        $item->setLabel('Link');
        $this->menu->addMenuItem($item);

        $subitem = new MenuItemLink();
        $subitem->setUrl('http://example.com');
        $subitem->setLabel('SubLink');
        $subitem->disable();
        $item->addMenuItem($subitem);

        $expected = '<ul></ul>';
        $this->assertEquals($expected, $this->menuRenderer->render());
    }

    public function testRenderMenuWithButton()
    {
        $item = new MenuItemButton();
        $item->setUrl('http://example.com');
        $item->setLabel('Button');

        $this->menu->addMenuItem($item);

        $expected = '<ul><li><button type="button" class="btn btn-default">Button</button></li></ul>';

        $this->assertEquals($expected, $this->menuRenderer->render());
    }

    public function testRenderMenuWithLinkButton()
    {
        $item = new MenuItemLinkButton();
        $item->setUrl('http://example.com');
        $item->setLabel('Link Button');

        $this->menu->addMenuItem($item);

        $expected = '<ul><li><a href="http://example.com" class="btn btn-default" title="Link Button" target="_self"><i class="menu-icon fa fa-"></i> Link Button</a></li></ul>';

        $this->assertEquals($expected, $this->menuRenderer->render());
    }

    public function testRenderMenuWithLinkButtonModal()
    {
        $item = new MenuItemLinkButtonModal();
        $item->setUrl('http://example.com');
        $item->setLabel('Button Modal');

        $this->menu->addMenuItem($item);

        $expected = '<ul><li><a href="#" class="btn btn-default" data-toggle="modal" data-target="#" title="Button Modal" target="_self"><i class="menu-icon fa fa-"></i> Button Modal</a></li></ul>';

        $this->assertEquals($expected, $this->menuRenderer->render());
    }

    public function testRenderMenuWithLinkModal()
    {
        $item = new MenuItemLinkModal();
        $item->setUrl('http://example.com');
        $item->setLabel('Modal');

        $this->menu->addMenuItem($item);

        $expected = '<ul><li><a href="#" data-toggle="modal" data-target="#" title="Modal" target="_self"><i class="menu-icon fa fa-"></i> Modal</a></li></ul>';

        $this->assertEquals($expected, $this->menuRenderer->render());
    }

    public function testRenderMenuWithPostLink()
    {
        $item = new MenuItemPostlink();
        $item->setUrl('http://example.com');
        $item->setLabel('Post Link');

        $this->menu->addMenuItem($item);

        $pattern = '<ul><li><form name="post_' .
            '\w+' .
            '" style="display:none;" method="post" action="http:\/\/example.com"><input ' .
            'type="hidden" name="_method" value="POST"\/><\/form><a href="#" title="Post Link" ' .
            'onclick="document.post_' .
            '\w+' .
            '.submit\(\); event.returnValue = false; return false;"><i class="fa fa-"><\/i> Post Link<\/a><\/li><\/ul>';

        $this->assertRegExp('/' . $pattern . '/', $this->menuRenderer->render());
    }

    public function testRenderMenuWithPostlinkButton()
    {
        $item = new MenuItemPostlinkButton();
        $item->setUrl('http://example.com');
        $item->setLabel('Postlink Button');

        $this->menu->addMenuItem($item);

        $pattern = '<ul><li><form name="post_' .
            '(\w+)' .
            '" style="display:none;" method="post" action="http:\/\/example.com"><input ' .
            'type="hidden" name="_method" value="POST"\/><\/form><a href="#" class="btn ' .
            'btn-default" title="Postlink Button" onclick="document.post_' .
            '(\w+)' .
            '.submit\(\); event.returnValue = false; return false;"><i class="fa fa-"><\/i> Postlink Button<\/a><\/li><\/ul>';

        $this->assertRegExp('/' . $pattern . '/', $this->menuRenderer->render());
    }

    public function testRenderMenuWithSeparator()
    {
        $item = new MenuItemSeparator();

        $this->menu->addMenuItem($item);

        $expected = '<ul><li><hr class="separator" /></li></ul>';

        $this->assertEquals($expected, $this->menuRenderer->render());
    }

    public function testRenderMenuWithViewElement()
    {
        $item = new MenuItemButton();
        $item->setUrl('http://example.com');
        $item->setLabel('Button');
        $item->setViewElement('custom-button', ['text' => 'custom-button']);

        $this->menu->addMenuItem($item);

        $expected = '<ul><li><button type="button" class="btn btn-default">Button</button><div>custom-button</div></li></ul>';

        $this->assertEquals($expected, $this->menuRenderer->render());
    }
}
