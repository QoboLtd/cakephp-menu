<?php

namespace Menu\Controller;

use App\Controller\AppController as BaseController;

class AppController extends BaseController
{
    const TREE_SPACER = '&nbsp;&nbsp;&nbsp;&nbsp;';

    /**
     * {inheritedDoc}
     * Loads Request handler.
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }
}
