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
        ordering: false,
        stateSave: true,
        stateDuration: ' . (int)(Configure::read('Session.timeout') * 60) . '
    });',
    ['block' => 'scriptBottom']
);
?>
<section class="content-header">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h4><?= $this->Html->link(__d('Qobo/Menu', 'Menu'), ['action' => 'index']) . ' &raquo; ' . h(Inflector::humanize($navMenu->name)) ?></h4>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="pull-right">
                <div class="btn-group btn-group-sm" role="group">
                <?= $this->Html->link(
                    '<i class="fa fa-plus"></i> ' . __d('Qobo/Menu', 'Add'),
                    ['controller' => 'MenuItems', 'action' => 'add', $navMenu->id],
                    ['escape' => false, 'title' => __d('Qobo/Menu', 'Add'), 'class' => 'btn btn-default']
                ); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <i class="fa fa-info-circle"></i>
                    <h3 class="box-title">Details</h3>
                </div>
                <div class="box-body">
                    <dl class="dl-horizontal">
                        <dt><?= __d('Qobo/Menu', 'Name') ?></dt>
                        <dd><?= h(Inflector::humanize($navMenu->name)) ?></dd>
                        <dt><?= __d('Qobo/Menu', 'Active') ?></dt>
                        <dd><?= $navMenu->active ? __d('Qobo/Menu', 'Yes') : __d('Qobo/Menu', 'No') ?></dd>
                        <dt><?= __d('Qobo/Menu', 'Default') ?></dt>
                        <dd><?= $navMenu->default ? __d('Qobo/Menu', 'Yes') : __d('Qobo/Menu', 'No') ?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    <?php if (!empty($navMenu->menu_items)) : ?>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= __d('Qobo/Menu', 'Related Menu Items') ?></h3>
        </div>
        <div class="box-body">
            <table class="table table-hover table-condensed table-vertical-align table-datatable">
                <thead>
                    <tr>
                        <th><?= __d('Qobo/Menu', 'Label') ?></th>
                        <th><?= __d('Qobo/Menu', 'Icon') ?></th>
                        <th><?= __d('Qobo/Menu', 'Type') ?></th>
                        <th><?= __d('Qobo/Menu', 'URL') ?></th>
                        <th><?= __d('Qobo/Menu', 'New Window') ?></th>
                        <th class="actions"><?= __d('Qobo/Menu', 'Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($navMenu->menu_items as $menuItem) : ?>
                    <tr>
                        <td><?= $menuItem->node ?></td>
                        <td><i class="fa fa-<?= h($menuItem->icon) ?>"></i></td>
                        <td><?= h($menuItem->type) ?></td>
                        <td><?= 'module' !== $menuItem->type ?
                            $this->Html->link($menuItem->url, $menuItem->url, ['target' => '_blank']) :
                            h($menuItem->url)
                        ?></td>
                        <td><?= $menuItem->new_window ? __d('Qobo/Menu', 'Yes') : __d('Qobo/Menu', 'No') ?></td>
                        <td class="actions">
                            <div class="btn-toolbar" role="toolbar">
                                <div class="btn-group btn-group-xs" role="group">
                                <?= $this->Html->link(
                                    '<i class="fa fa-pencil"></i>',
                                    ['controller' => 'MenuItems', 'action' => 'edit', $menuItem->id],
                                    ['title' => __d('Qobo/Menu', 'Edit'), 'class' => 'btn btn-default', 'escape' => false]
                                ) ?>
                                <?= $this->Form->postLink(
                                    '<i class="fa fa-trash"></i>',
                                    ['controller' => 'MenuItems', 'action' => 'delete', $menuItem->id],
                                    [
                                        'confirm' => __d('Qobo/Menu', 'Are you sure you want to delete # {0}?', $menuItem->label),
                                        'title' => __d('Qobo/Menu', 'Delete'),
                                        'class' => 'btn btn-default',
                                        'escape' => false
                                    ]
                                ) ?>
                                </div>
                                <div class="btn-group btn-group-xs" role="group">
                                    <?= $this->Form->postLink(
                                        '<i class="fa fa-arrow-up"></i>',
                                        ['controller' => 'MenuItems', 'action' => 'moveNode', $menuItem->id, 'up'],
                                        ['title' => __d('Qobo/Menu', 'Move up'), 'class' => 'btn btn-default', 'escape' => false]
                                    ) ?>
                                    <?= $this->Form->postLink(
                                        '<i class="fa fa-arrow-down"></i>',
                                        ['controller' => 'MenuItems', 'action' => 'moveNode', $menuItem->id, 'down'],
                                        ['title' => __d('Qobo/Menu', 'Move down'), 'class' => 'btn btn-default', 'escape' => false]
                                    ) ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
</section>
