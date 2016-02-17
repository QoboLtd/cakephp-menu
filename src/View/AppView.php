<?php
namespace Menu\View\AppView;

class AppView extends View
{
    /**
     * [initialize description]
     * {@inheritdoc } In addition, it loads Menu helper.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadHelper('Menu.Menu');
    }
}
