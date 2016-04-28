<?php

namespace Menu\Controller;

use App\Controller\AppController as BaseController;

class AppController extends BaseController
{

    /**
     * Initialization hook method.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->viewBuilder()->layout('QoboAdminPanel.basic');
    }
}
