<?php
echo $this->Html->css(
    [
        'AdminLTE./plugins/iCheck/all',
        'AdminLTE./plugins/select2/select2.min',
        'Menu.select2-bootstrap.min',
        'Menu.select2-style'
    ],
    ['block' => 'css']
);
echo $this->Html->script(
    [
        'AdminLTE./plugins/iCheck/icheck.min',
        'AdminLTE./plugins/select2/select2.full.min',
        'Menu.select2.init'
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

foreach ($icons as $k => $v) {
    $icons[$v] = '<i class="fa fa-' . $v . '"></i>&nbsp;&nbsp;' . $v;
    unset($icons[$k]);
}
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
                            <?= $this->Form->input('url', ['label' => __('URL')]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->input('parent_id', [
                                'type' => 'select',
                                'options' => $parentMenuItems,
                                'class' => 'select2',
                                'empty' => true
                            ]) ?>
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
                    <div class="row">
                        <div class="col-md-6">
                            <?= $this->Form->input('icon', [
                                'type' => 'select',
                                'options' => $icons,
                                'class' => 'select2',
                                'empty' => true
                            ]) ?>
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