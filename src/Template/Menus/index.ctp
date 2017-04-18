<?php
echo $this->Html->css('AdminLTE./plugins/datatables/dataTables.bootstrap', ['block' => 'css']);
echo $this->Html->script(
    [
        'AdminLTE./plugins/datatables/jquery.dataTables.min',
        'AdminLTE./plugins/datatables/dataTables.bootstrap.min',
        'Menu.datatables.init'
    ],
    [
        'block' => 'scriptBotton'
    ]
);
?>
<section class="content-header">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h4><?= __('Menus'); ?></h4>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="pull-right">
                <div class="btn-group btn-group-sm" role="group">
                <?= $this->Html->link(
                    '<i class="fa fa-plus"></i> ' . __('Add'),
                    ['action' => 'add'],
                    ['escape' => false, 'title' => __('Add'), 'class' => 'btn btn-default']
                ); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="box box-solid">
        <div class="box-body">
            <table class="table table-hover table-condensed table-vertical-align table-datatable">
                <thead>
                    <tr>
                        <th><?= __('Name') ?></th>
                        <th><?= __('Active') ?></th>
                        <th class="actions"><?= __('Actions'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($menus as $menu) : ?>
                    <tr>
                        <td><?= h($menu->name) ?></td>
                        <td><?= $menu->active ? __('Yes') : __('No') ?></td>
                        <td class="actions">
                            <div class="btn-toolbar" role="toolbar">
                                <div class="btn-group btn-group-xs" role="group">
                                <?= $this->Html->link(
                                    '<i class="fa fa-eye"></i>',
                                    ['action' => 'view', $menu->id],
                                    ['title' => __('View'), 'class' => 'btn btn-default', 'escape' => false]
                                ) ?>
                                <?= $this->Html->link(
                                    '<i class="fa fa-pencil"></i>',
                                    ['action' => 'edit', $menu->id],
                                    ['title' => __('Edit'), 'class' => 'btn btn-default', 'escape' => false]
                                ) ?>
                                <?= $this->Form->postLink(
                                    '<i class="fa fa-trash"></i>',
                                    ['action' => 'delete', $menu->id],
                                    [
                                        'confirm' => __('Are you sure you want to delete # {0}?', $menu->name),
                                        'title' => __('Delete'),
                                        'class' => 'btn btn-default',
                                        'escape' => false
                                    ]
                                ) ?>
                                </div>
                                <div class="btn-group btn-group-xs" role="group">
                                <?= $this->Html->link(
                                    '<i class="fa fa-circle-o"></i>',
                                    ['controller' => 'MenuItems', 'action' => 'add', $menu->id],
                                    ['title' => __('Create menu item'), 'class' => 'btn btn-default', 'escape' => false]
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
</section>