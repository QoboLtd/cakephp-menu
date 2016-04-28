<?php
$this->extend('QoboAdminPanel./Common/panel-wrapper');
$this->assign('panel-title', __d('QoboAdminPanel', 'Add menu item'));
?>
<?= $this->Form->create($menuItem); ?>
<fieldset>
    <?php
    echo $this->Form->input('parent_id', ['options' => $parentMenuItems]);
    echo $this->Form->input('menu_id', ['options' => $menus]);
    echo $this->Form->input('label');
    echo $this->Form->input('url');
    echo $this->Form->input('new_window');
    ?>
</fieldset>
<?= $this->Form->button(__("Add")); ?>
<?= $this->Form->end() ?>
