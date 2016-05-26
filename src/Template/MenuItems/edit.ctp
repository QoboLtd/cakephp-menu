<?php
$this->extend('QoboAdminPanel./Common/panel-wrapper');
$this->assign('panel-title', __d('QoboAdminPanel', 'Edit menu item'));
?>
<?= $this->Form->create($menuItem); ?>
<fieldset>
    <?php
    $url = $this->Url->build(['controller' => $this->request->controller, 'action' => 'menuItems', '_ext' => 'json']);
    echo $this->Form->input('menu_id', ['id' => 'menus', 'rel' => $url, 'options' => $menus]);
    echo $this->Form->input('parent_id', ['id' => 'fetch-menu-items', 'empty' => __d('menu', 'No Parent'), 'escape' => false]);
    echo $this->Form->input('label');
    echo $this->Form->input('url');
    echo $this->Form->input('new_window');
    ?>
</fieldset>
<?= $this->Form->button(__("Save")); ?>
<?= $this->Form->end() ?>
<?= $this->Html->script('Menu.ajax', ['block' => 'scriptBottom']); ?>
