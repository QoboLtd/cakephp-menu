<?php
namespace Menu\View\AppView;

class AppView extends View
{
    public function initialize()
    {
        parent::initialize();
        $this->loadHelper('Menu.Menu');
    }
}