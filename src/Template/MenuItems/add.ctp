<?php
$this->extend('QoboAdminPanel./Common/panel-wrapper');
$this->assign('panel-title', __d('QoboAdminPanel', 'Menu item information'));
?>
<?= $this->Form->create($menuItem); ?>
<fieldset>
    <legend><?= __('Add {0}', ['Menu Item']) ?></legend>
    <?php
    echo $this->Form->input('menu_id', ['options' => $menus]);
    echo $this->Form->input('label');
    echo $this->Form->input('url');
    echo $this->Form->input('new_window');
    echo $this->Form->input('parent_id', ['options' => $parentMenuItems]);
    echo $this->Form->input('lft');
    echo $this->Form->input('rght');
    ?>
</fieldset>
<?= $this->Form->button(__("Add")); ?>
<?= $this->Form->end() ?>
