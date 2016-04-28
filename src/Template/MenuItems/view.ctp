<?php
$this->extend('QoboAdminPanel./Common/panel-wrapper');
$this->assign('panel-title', __d('QoboAdminPanel', 'View {0}', $menuItem->label));
?>
<table class="table table-striped" cellpadding="0" cellspacing="0">
    <tr>
        <td><?= __('Id') ?></td>
        <td><?= h($menuItem->id) ?></td>
    </tr>
    <tr>
        <td><?= __('Menu') ?></td>
        <td><?= $menuItem->has('menu') ? $this->Html->link($menuItem->menu->name, ['controller' => 'Menus', 'action' => 'view', $menuItem->menu->id]) : '' ?></td>
    </tr>
    <tr>
        <td><?= __('Label') ?></td>
        <td><?= h($menuItem->label) ?></td>
    </tr>
    <tr>
        <td><?= __('Url') ?></td>
        <td><?= h($menuItem->url) ?></td>
    </tr>
    <tr>
        <td><?= __('Parent Menu Item') ?></td>
        <td><?= $menuItem->has('parent_menu_item') ? $this->Html->link($menuItem->parent_menu_item->id, ['controller' => 'MenuItems', 'action' => 'view', $menuItem->parent_menu_item->id]) : '' ?></td>
    </tr>
    <tr>
        <td><?= __('Lft') ?></td>
        <td><?= $this->Number->format($menuItem->lft) ?></td>
    </tr>
    <tr>
        <td><?= __('Rght') ?></td>
        <td><?= $this->Number->format($menuItem->rght) ?></td>
    </tr>
    <tr>
        <td><?= __('New Window') ?></td>
        <td><?= $menuItem->new_window ? __('Yes') : __('No'); ?></td>
    </tr>
</table>
<div class="panel panel-default">
    <!-- Panel header -->
    <div class="panel-heading">
        <h3 class="panel-title"><?= __('Related MenuItems') ?></h3>
    </div>
    <?php if (!empty($menuItem->child_menu_items)): ?>
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
            <?php foreach ($menuItem->child_menu_items as $childMenuItems): ?>
                <tr>
                    <td><?= h($childMenuItems->id) ?></td>
                    <td><?= h($childMenuItems->menu_id) ?></td>
                    <td><?= h($childMenuItems->label) ?></td>
                    <td><?= h($childMenuItems->url) ?></td>
                    <td><?= h($childMenuItems->new_window) ?></td>
                    <td><?= h($childMenuItems->parent_id) ?></td>
                    <td><?= h($childMenuItems->lft) ?></td>
                    <td><?= h($childMenuItems->rght) ?></td>
                    <td class="actions">
                        <?= $this->Html->link('', ['controller' => 'MenuItems', 'action' => 'view', $childMenuItems->id], ['title' => __('View'), 'class' => 'btn btn-default glyphicon glyphicon-eye-open']) ?>
                        <?= $this->Html->link('', ['controller' => 'MenuItems', 'action' => 'edit', $childMenuItems->id], ['title' => __('Edit'), 'class' => 'btn btn-default glyphicon glyphicon-pencil']) ?>
                        <?= $this->Form->postLink('', ['controller' => 'MenuItems', 'action' => 'delete', $childMenuItems->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childMenuItems->id), 'title' => __('Delete'), 'class' => 'btn btn-default glyphicon glyphicon-trash']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="panel-body">no related MenuItems</p>
    <?php endif; ?>
</div>
