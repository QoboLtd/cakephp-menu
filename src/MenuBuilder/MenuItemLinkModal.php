<?php
/**
 * Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
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
