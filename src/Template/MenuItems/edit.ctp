<?php
echo $this->Html->css('AdminLTE./plugins/iCheck/all', ['block' => 'css']);
echo $this->Html->script(
    [
        'AdminLTE./plugins/iCheck/icheck.min',
        'Menu.ajax'
    ],
    ['block' => 'scriptBotton']
);
echo $this->Html->scriptBlock(
    '$(\'input[type="checkbox"].square, input[type="radio"].square\').iCheck({
        checkboxClass: "icheckbox_square",
        radioClass: "iradio_square"
    });',
    ['block' => 'scriptBotton']
);
$menusUrl = $this->Url->build(['controller' => $this->request->controller, 'action' => 'menuItems', '_ext' => 'json']);
?>
<section class="content-header">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h4><?= __('Create {0}', ['Menu']) ?></h4>
        </div>
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="box box-solid">
                <div class="box-body">
                <?= $this->Form->create($menuItem); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $this->Form->input('menu_id', [
                                'id' => 'menus',
                                'rel' => $menusUrl,
                                'options' => $menus
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->input('parent_id', [
                                'id' => 'fetch-menu-items',
                                'empty' => true,
                                'escape' => false,
                                'default' => $menuItem->parent_id
                            ]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?= $this->Form->input('url') ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $this->Form->input('label') ?>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->input('new_window', [
                                'type' => 'checkbox',
                                'class' => 'square',
                                'label' => false,
                                'templates' => [
                                    'inputContainer' => '<div class="{{required}}">' . $this->Form->label('Menu.new_window') . '<div class="clearfix"></div>{{content}}</div>'
                                ]
                            ]); ?>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</section>