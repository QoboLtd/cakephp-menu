<?php
$this->extend('QoboAdminPanel./Common/panel-wrapper');
$this->assign('panel-title', __d('QoboAdminPanel', 'Edit Menu'));
?>
<?= $this->Form->create($navMenu); ?>
<fieldset>
    <?php
    echo $this->Form->input('name');
    echo $this->Form->input('active');
    ?>
</fieldset>
<?= $this->Form->button(__("Save")); ?>
<?= $this->Form->end() ?>
