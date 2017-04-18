<section class="content-header">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h4><?= $this->Html->link(
                __('Menu Items'),
                ['action' => 'index', $menuItem->menu->id]
            ) . ' &raquo; ' . h($menuItem->label) ?></h4>
        </div>
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <i class="fa fa-info-circle"></i>
                    <h3 class="box-title">Details</h3>
                </div>
                <div class="box-body">
                    <dl class="dl-horizontal">
                        <dt><?= __('Label') ?></dt>
                        <dd><?= h($menuItem->label) ?></dd>
                        <dt><?= __('Url') ?></dt>
                        <dd><?= $this->Html->link($menuItem->url, $menuItem->url, ['target' => '_blank']) ?></dd>
                        <dt><?= __('Menu') ?></dt>
                        <dd><?= $menuItem->has('menu') ?
                            $this->Html->link($menuItem->menu->name, [
                                'controller' => 'Menus',
                                'action' => 'view',
                                $menuItem->menu->id
                            ]) : __('No') ?>
                        </dd>
                        <dt><?= __('Parent Menu Item') ?></dt>
                        <dd><?= $menuItem->has('parent_menu_item') ?
                            $this->Html->link($menuItem->parent_menu_item->label, [
                                'controller' => 'MenuItems',
                                'action' => 'view',
                                $menuItem->parent_menu_item->id
                            ]) : __('No') ?>
                        </dd>
                        <dt><?= __('New Window') ?></dt>
                        <dd><?= $menuItem->new_window ? __('Yes') : __('No') ?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    <?php if (!empty($menuItem->child_menu_items)) : ?>
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><?= __('Child Menu Items') ?></h3>
        </div>
        <div class="box-body">
            <table class="table table-hover table-condensed table-vertical-align table-datatable">
                <thead>
                    <tr>
                        <th><?= __('Label') ?></th>
                        <th><?= __('Url') ?></th>
                        <th><?= __('New Window') ?></th>
                        <th><?= __('Menu') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($menuItem->child_menu_items as $childMenuItem) : ?>
                    <tr>
                        <td><?= h($childMenuItem->label) ?></td>
                        <td><?= $this->Html->link($childMenuItem->url, $childMenuItem->url, ['target' => '_blank']) ?></td>
                        <td><?= $childMenuItem->new_window ? __('Yes') : __('No') ?></td>
                        <td><?= $childMenuItem->has('menu') ?
                            $this->Html->link($childMenuItem->menu->name, [
                                'controller' => 'Menus',
                                'action' => 'view',
                                $childMenuItem->menu->id
                            ]) : __('No') ?>
                        </td>
                        <td class="actions">
                            <div class="btn-group btn-group-xs" role="group">
                            <?= $this->Html->link(
                                '<i class="fa fa-eye"></i>',
                                ['action' => 'view', $childMenuItem->id],
                                ['title' => __('View'), 'class' => 'btn btn-default', 'escape' => false]
                            ) ?>
                            <?= $this->Html->link(
                                '<i class="fa fa-pencil"></i>',
                                ['action' => 'edit', $childMenuItem->id],
                                ['title' => __('Edit'), 'class' => 'btn btn-default', 'escape' => false]
                            ) ?>
                            <?= $this->Form->postLink(
                                '<i class="fa fa-trash"></i>',
                                ['action' => 'delete', $childMenuItem->id],
                                [
                                    'confirm' => __('Are you sure you want to delete # {0}?', $childMenuItem->label),
                                    'title' => __('Delete'),
                                    'class' => 'btn btn-default',
                                    'escape' => false
                                ]
                            ) ?>
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
