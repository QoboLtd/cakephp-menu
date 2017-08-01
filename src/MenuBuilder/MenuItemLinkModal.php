<?php

namespace Menu\MenuBuilder;

class MenuItemLinkModal extends MenuItemLink
{
    /**
     * @var $modalTarget
     */
    protected $modalTarget = null;

    /**
     * getModalTarget method
     *
     * @return string modal target ID
     */
    public function getModalTarget()
    {
        return $this->modalTarget;
    }

    /**
     * setModalTarget method
     *
     * @param string $modalTarget ID
     * @return void
     */
    public function setModalTarget($modalTarget)
    {
        $this->modalTarget = $modalTarget;
    }
}
