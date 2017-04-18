<section class="content-header">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h4><?= $this->Html->link(__('Menu'), ['action' => 'index']) . ' &raquo; ' . h($navMenu->name) ?></h4>
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
                        <dt><?= __('Name') ?></dt>
                        <dd><?= h($navMenu->name) ?></dd>
                        <dt><?= __('Active') ?></dt>
                        <dd><?= $navMenu->active ? __('Yes') : __('No') ?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    <?php if (!empty($navMenu->menu_items)) : ?>
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><?= __('Related Menu Items') ?></h3>
        </div>
        <div class="box-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th><?= __('Label') ?></th>
                        <th><?= __('Url') ?></th>
                        <th><?= __('New Window') ?></th>
                        <th><?= __('Parent Id') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($navMenu->menu_items as $menuItem) : ?>
                    <tr>
                        <td><?= h($menuItem->label) ?></td>
                        <td><?= $this->Html->link($menuItem->url, $menuItem->url, ['target' => '_blank']) ?></td>
                        <td><?= $menuItem->new_window ? __('Yes') : __('No') ?></td>
                        <td><?= $menuItem->has('parent_menu_item')
                            ? h($menuItem->parent_menu_item->label)
                            : null ?>
                        </td>
                        <td class="actions">
                            <div class="btn-group btn-group-xs" role="group">
                            <?= $this->Html->link(
                                '<i class="fa fa-eye"></i>',
                                ['controller' => 'MenuItems', 'action' => 'view', $menuItem->id],
                                ['title' => __('View'), 'class' => 'btn btn-default', 'escape' => false]
                            ) ?>
                            <?= $this->Html->link(
                                '<i class="fa fa-pencil"></i>',
                                ['controller' => 'MenuItems', 'action' => 'edit', $menuItem->id],
                                ['title' => __('Edit'), 'class' => 'btn btn-default', 'escape' => false]
                            ) ?>
                            <?= $this->Form->postLink(
                                '<i class="fa fa-trash"></i>',
                                ['controller' => 'MenuItems', 'action' => 'delete', $menuItem->id],
                                [
                                    'confirm' => __('Are you sure you want to delete # {0}?', $menuItem->label),
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
