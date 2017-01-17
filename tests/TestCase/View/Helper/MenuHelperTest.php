<?php
namespace Menu\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use Menu\View\Helper\MenuHelper;

class MenuHelperTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $View = new View();
        $this->Menu = new MenuHelper($View);
    }
}
