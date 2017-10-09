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
namespace Menu\Model\Entity;

use Cake\ORM\Entity;

/**
 * MenuItem Entity.
 *
 * @property string $id
 * @property string $menu_id
 * @property \Menu\Model\Entity\Menu $menu
 * @property string $label
 * @property string $url
 * @property bool $new_window
 * @property string $parent_id
 * @property \Menu\Model\Entity\MenuItem $parent_menu_item
 * @property int $lft
 * @property int $rght
 * @property \Menu\Model\Entity\MenuItem[] $child_menu_items
 */
class MenuItem extends Entity
{
    protected $_virtual = ['target'];

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    /**
     * Virtual Field: target
     *
     * @return string
     */
    protected function _getTarget()
    {
        return $this->new_window ? '_blank' : '_self';
    }
}
