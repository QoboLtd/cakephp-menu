<?php
namespace Menu\Test\TestCase\MenuBuilder;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use Menu\MenuBuilder\BaseMenuRenderClass;
use Menu\MenuBuilder\Menu;
use Menu\MenuBuilder\MenuItemButton;

class BaseMenuRenderClassTest extends TestCase
{
    public $view;
    public $instance;

    public function testConstruct()
    {
        $menu = new Menu();
        $this->view = new View();

        $button = new MenuItemButton();
        $button->setUrl('http://example.com');
        $button->setLabel('Test');

        $menu->addMenuItem($button);
        $this->instance = new BaseMenuRenderClass($menu, $this->view);

        $this->instance->setFormat([
            'menuStart' => '<ul>',
            'menuEnd' => '</ul>',
            'itemStart' => '<li>',
            'itemEnd' => '</li>',
        ]);

        $result = $this->instance->render();
        $this->assertNotEmpty($result);
    }
}
