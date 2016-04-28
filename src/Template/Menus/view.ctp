<?php
$this->extend('QoboAdminPanel./Common/panel-wrapper');
$this->assign('panel-title', __d('QoboAdminPanel', 'View {0}', h($navMenu->name)));
?>
<table class="table table-striped" cellpadding="0" cellspacing="0">
    <tr>
        <td><?= __('Id') ?></td>
        <td><?= h($navMenu->id) ?></td>
    </tr>
    <tr>
        <td><?= __('Name') ?></td>
        <td><?= h($navMenu->name) ?></td>
    </tr>
    <tr>
        <td><?= __('Created') ?></td>
        <td><?= h($navMenu->created) ?></td>
    </tr>
    <tr>
        <td><?= __('Modified') ?></td>
        <td><?= h($navMenu->modified) ?></td>
    </tr>
    <tr>
        <td><?= __('Active') ?></td>
        <td><?= $navMenu->active ? __('Yes') : __('No'); ?></td>
    </tr>
</table>

<?php if (!empty($navMenu->menu_items)): ?>
    <table class="table table-striped">
        <thead>
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Menu Id') ?></th>
            <th><?= __('Label') ?></th>
            <th><?= __('Url') ?></th>
            <th><?= __('New Window') ?></th>
            <th><?= __('Parent Id') ?></th>
            <th><?= __('Lft') ?></th>
            <th><?= __('Rght') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($navMenu->menu_items as $menuItems): ?>
            <tr>
                <td><?= h($menuItems->id) ?></td>
                <td><?= h($menuItems->menu_id) ?></td>
                <td><?= h($menuItems->label) ?></td>
                <td><?= h($menuItems->url) ?></td>
                <td><?= h($menuItems->new_window) ?></td>
                <td><?= h($menuItems->parent_id) ?></td>
                <td><?= h($menuItems->lft) ?></td>
                <td><?= h($menuItems->rght) ?></td>
                <td class="actions">
                    <?= $this->Html->link('', ['controller' => 'MenuItems', 'action' => 'view', $menuItems->id], ['title' => __('View'), 'class' => 'btn btn-default glyphicon glyphicon-eye-open']) ?>
                    <?= $this->Html->link('', ['controller' => 'MenuItems', 'action' => 'edit', $menuItems->id], ['title' => __('Edit'), 'class' => 'btn btn-default glyphicon glyphicon-pencil']) ?>
                    <?= $this->Form->postLink('', ['controller' => 'MenuItems', 'action' => 'delete', $menuItems->id], ['confirm' => __('Are you sure you want to delete # {0}?', $menuItems->id), 'title' => __('Delete'), 'class' => 'btn btn-default glyphicon glyphicon-trash']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="panel-body">no related MenuItems</p>
<?php endif; ?>

