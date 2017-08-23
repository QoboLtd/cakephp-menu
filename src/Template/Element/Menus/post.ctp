<?php
echo $this->Html->css('AdminLTE./plugins/iCheck/all', ['block' => 'css']);
echo $this->Html->script('AdminLTE./plugins/iCheck/icheck.min', ['block' => 'scriptBottom']);
echo $this->Html->scriptBlock(
    '$(\'input[type="checkbox"].square, input[type="radio"].square\').iCheck({
        checkboxClass: "icheckbox_square",
        radioClass: "iradio_square"
    });',
    ['block' => 'scriptBottom']
);
?>
<section class="content-header">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h4><?= __(('add' === $this->request->action ? 'Create' : 'Edit') . ' {0}', ['Menu']) ?></h4>
        </div>
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="box box-solid">
                <div class="box-body">
                <?= $this->Form->create($navMenu); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $this->Form->input('name', [
                                'disabled' => $navMenu->deny_edit
                            ]); ?>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->input('active', [
                                'type' => 'checkbox',
                                'disabled' => $navMenu->deny_edit,
                                'class' => 'square',
                                'label' => false,
                                'templates' => [
                                    'inputContainer' => '<div class="{{required}}">' . $this->Form->label('Menu.active') . '<div class="clearfix"></div>{{content}}</div>'
                                ]
                            ]); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $this->Form->input('default', [
                                'type' => 'checkbox',
                                'class' => 'square',
                                'label' => false,
                                'templates' => [
                                    'inputContainer' => '<div class="{{required}}">' . $this->Form->label('Menu.default') . '<div class="clearfix"></div>{{content}}</div>'
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
