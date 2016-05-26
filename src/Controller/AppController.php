<?php

namespace Menu\Controller;

use App\Controller\AppController as BaseController;

class AppController extends BaseController
{
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
