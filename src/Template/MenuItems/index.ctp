<?php
$this->extend('QoboAdminPanel./Common/panel-wrapper');
$this->assign('panel-title', __d('QoboAdminPanel', 'View all'));
?>
<table class="table table-striped" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('menu_id'); ?></th>
            <th><?= $this->Paginator->sort('label'); ?></th>
            <th><?= $this->Paginator->sort('url'); ?></th>
            <th><?= $this->Paginator->sort('new_window'); ?></th>
            <th class="actions"><?= __('Actions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($menuItems as $menuItem): ?>
        <tr>
            <td><?= h($menuItem->id) ?></td>
            <td>
                <?= $menuItem->has('menu') ? $this->Html->link($menuItem->menu->name, ['controller' => 'Menus', 'action' => 'view', $menuItem->menu->id]) : '' ?>
            </td>
            <td><?= h($menuItem->label) ?></td>
            <td><?= h($menuItem->url) ?></td>
            <td><?= h($menuItem->new_window) ?></td>
            <td>
                <?= $menuItem->has('parent_menu_item') ? $this->Html->link($menuItem->parent_menu_item->id, ['controller' => 'MenuItems', 'action' => 'view', $menuItem->parent_menu_item->id]) : '' ?>
            </td>
            <td><?= $this->Number->format($menuItem->lft) ?></td>
            <td class="actions">
                <?= $this->Html->link('', ['action' => 'view', $menuItem->id], ['title' => __('View'), 'class' => 'btn btn-default glyphicon glyphicon-eye-open']) ?>
                <?= $this->Html->link('', ['action' => 'edit', $menuItem->id], ['title' => __('Edit'), 'class' => 'btn btn-default glyphicon glyphicon-pencil']) ?>
                <?= $this->Form->postLink('', ['action' => 'delete', $menuItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $menuItem->id), 'title' => __('Delete'), 'class' => 'btn btn-default glyphicon glyphicon-trash']) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->prev('< ' . __('previous')) ?>
        <?= $this->Paginator->numbers(['before' => '', 'after' => '']) ?>
        <?= $this->Paginator->next(__('next') . ' >') ?>
    </ul>
    <p><?= $this->Paginator->counter() ?></p>
</div>