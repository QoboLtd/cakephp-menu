<?php
echo $this->Html->css('AdminLTE./plugins/datatables/dataTables.bootstrap', ['block' => 'css']);
echo $this->Html->script(
    [
        'AdminLTE./plugins/datatables/jquery.dataTables.min',
        'AdminLTE./plugins/datatables/dataTables.bootstrap.min'
    ],
    [
        'block' => 'scriptBotton'
    ]
);
echo $this->Html->scriptBlock(
    '$(".table-datatable").DataTable({
        "ordering": false
    });',
    ['block' => 'scriptBotton']
);
?>
<section class="content-header">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h4><?= __('Menu Items'); ?> <small><?= $navMenu->name ?></small></h4>
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
                        <th><?= __('Label') ?></th>
                        <th><?= __('URL') ?></th>
                        <th><?= __('New window') ?></th>
                        <th class="actions"><?= __('Actions'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($menuItems as $menuItem) : ?>
                    <tr>
                        <td><?= $menuItem->node ?></td>
                        <td><?= $this->Html->link($menuItem->url, $menuItem->url, ['target' => '_blank']) ?></td>
                        <td><?= $menuItem->new_window ? __('Yes') : __('No') ?></td>
                        <td class="actions">
                            <div class="btn-toolbar" role="toolbar">
                                <div class="btn-group btn-group-xs" role="group">
                                <?= $this->Html->link(
                                    '<i class="fa fa-eye"></i>',
                                    ['action' => 'view', $menuItem->id],
                                    ['title' => __('View'), 'class' => 'btn btn-default', 'escape' => false]
                                ) ?>
                                <?= $this->Html->link(
                                    '<i class="fa fa-pencil"></i>',
                                    ['action' => 'edit', $menuItem->id],
                                    ['title' => __('Edit'), 'class' => 'btn btn-default', 'escape' => false]
                                ) ?>
                                <?= $this->Form->postLink(
                                    '<i class="fa fa-trash"></i>',
                                    ['action' => 'delete', $menuItem->id],
                                    [
                                        'confirm' => __('Are you sure you want to delete # {0}?', $menuItem->label),
                                        'title' => __('Delete'),
                                        'class' => 'btn btn-default',
                                        'escape' => false
                                    ]
                                ) ?>
                                </div>
                                <?php if ($menuItem->parent_id) : ?>
                                <div class="btn-group btn-group-xs" role="group">
                                <?= $this->Html->link(
                                    '<i class="fa fa-arrow-up"></i>',
                                    ['action' => 'move_node', $menuItem->id, 'up'],
                                    ['title' => __('Move up'), 'class' => 'btn btn-default', 'escape' => false]
                                ) ?>
                                <?= $this->Html->link(
                                    '<i class="fa fa-arrow-down"></i>',
                                    ['action' => 'move_node', $menuItem->id, 'down'],
                                    ['title' => __('Move down'), 'class' => 'btn btn-default', 'escape' => false]
                                ) ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>