<?php
$this->extend('QoboAdminPanel./Common/panel-wrapper');
$this->assign('panel-title', __d('QoboAdminPanel', 'Menu information'));
?>
<?= $this->Form->create($navMenu); ?>
<fieldset>
    <legend><?= __('Add {0}', ['Menu']) ?></legend>
    <?php
    echo $this->Form->input('name');
    echo $this->Form->input('active');
    ?>
</fieldset>
<?= $this->Form->button(__("Add")); ?>
<?= $this->Form->end() ?>
