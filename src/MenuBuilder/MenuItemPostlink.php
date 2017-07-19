<?php

namespace Menu\MenuBuilder;

/**
 *  class MenuItemPostlink
 *
 */
class MenuItemPostlink extends BaseMenuItem
{
    /**
     * @var $confirmMsg
     */
    protected $confirmMsg = '';

    /**
     *  getConfirmMsg method
     *
     * @return string confirmation message
     */
    public function getConfirmMsg()
    {
        return $this->confirmMsg;
    }

    /**
     *  setConfirmMsg method
     *
     * @param string $message for confirmation alert
     */
    public function setConfirmMsg($message)
    {
        $this->confirmMsg = $message;
    }
}
