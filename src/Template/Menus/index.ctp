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

use Cake\Core\Configure;
use Cake\Utility\Inflector;

echo $this->Html->css('Qobo/Utils./plugins/datatables/css/dataTables.bootstrap.min', ['block' => 'css']);

echo $this->Html->script(
    [
        'Qobo/Utils./plugins/datatables/datatables.min',
        'Qobo/Utils./plugins/datatables/js/dataTables.bootstrap.min',
    ],
    ['block' => 'scriptBottom']
);

echo $this->Html->scriptBlock(
    '$(".table-datatable").DataTable({
        stateSave: true,
        stateDuration: ' . (int)(Configure::read('Session.timeout') * 60) . '
    });',
    ['block' => 'scriptBottom']
);
?>
<section class="content-header">
    <div class="row">
        <div class="col-xs-12">
            <h4><?= __d('Qobo/Menu', 'Menus'); ?></h4>
        </div>
    </div>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-body">
            <table class="table table-hover table-condensed table-vertical-align table-datatable">
                <thead>
                    <tr>
                        <th><?= __d('Qobo/Menu', 'Name') ?></th>
                        <th><?= __d('Qobo/Menu', 'Active') ?></th>
                        <th><?= __d('Qobo/Menu', 'Default') ?></th>
                        <th class="actions"><?= __d('Qobo/Menu', 'Actions'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($menus as $menu) : ?>
                    <tr>
                        <td><?= h(Inflector::humanize($menu->name)) ?></td>
                        <td><?= $menu->active ? __d('Qobo/Menu', 'Yes') : __d('Qobo/Menu', 'No') ?></td>
                        <td><?= $menu->default ? __d('Qobo/Menu', 'Yes') : __d('Qobo/Menu', 'No') ?></td>
                        <td class="actions">
                            <div class="btn-toolbar" role="toolbar">
                                <div class="btn-group btn-group-xs" role="group">
                                <?= $this->Html->link(
                                    '<i class="' . Configure::read('Icons.prefix') .'eye"></i>',
                                    ['action' => 'view', $menu->id],
                                    ['title' => __d('Qobo/Menu', 'View'), 'class' => 'btn btn-default', 'escape' => false]
                                ) ?>
                                <?= $this->Html->link(
                                    '<i class="' . Configure::read('Icons.prefix') . 'pencil"></i>',
                                    ['action' => 'edit', $menu->id],
                                    ['title' => __d('Qobo/Menu', 'Edit'), 'class' => 'btn btn-default', 'escape' => false]
                                ) ?>
                                <?php if (!$menu->deny_delete) : ?>
                                    <?= $this->Form->postLink(
                                        '<i class="' . Configure::read('Icons.prefix') .'trash"></i>',
                                        ['action' => 'delete', $menu->id],
                                        [
                                            'confirm' => __d('Qobo/Menu', 'Are you sure you want to delete # {0}?', $menu->name),
                                            'title' => __d('Qobo/Menu', 'Delete'),
                                            'class' => 'btn btn-default',
                                            'escape' => false
                                        ]
                                    ) ?>
                                <?php endif; ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
