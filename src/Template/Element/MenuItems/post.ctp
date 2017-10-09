<?php
/**
 * Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Menu\Type\TypeFactory;

echo $this->Html->css(
    [
        'AdminLTE./plugins/iCheck/all',
        'AdminLTE./plugins/select2/select2.min',
        'Qobo/Utils.select2-bootstrap.min',
        'Qobo/Utils.select2-style'
    ],
    ['block' => 'css']
);
echo $this->Html->script(
    [
        'AdminLTE./plugins/iCheck/icheck.min',
        'AdminLTE./plugins/select2/select2.full.min',
        'Qobo/Utils.select2.init',
        'Menu.view-post'
    ],
    ['block' => 'scriptBottom']
);
echo $this->Html->scriptBlock(
    '$(\'input[type="checkbox"].square, input[type="radio"].square\').iCheck({
        checkboxClass: "icheckbox_square",
        radioClass: "iradio_square"
    });',
    ['block' => 'scriptBottom']
);

foreach ($icons as $k => $v) {
    $icons[$v] = '<i class="fa fa-' . $v . '"></i>&nbsp;&nbsp;' . $v;
    unset($icons[$k]);
}

$moduleType = TypeFactory::create('module');
?>
<section class="content-header">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h4><?= __(('add' === $this->request->action ? 'Create' : 'Edit') . ' {0}', ['Menu Item']) ?></h4>
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
                            <?= $this->Form->input('label') ?>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->input('icon', [
                                'type' => 'select',
                                'options' => $icons,
                                'class' => 'select2',
                                'empty' => true
                            ]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $this->Form->input('type', [
                                'type' => 'select',
                                'options' => TypeFactory::getList(),
                                'class' => 'select2',
                                'empty' => true,
                                'id' => 'item-type'
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <div id="type-inner-container">
                            <?php if ('custom' === $menuItem->type) : ?>
                                <div id="item-<?= $menuItem->type ?>">
                                    <?= $this->Form->input('url', [
                                        'label' => __('URL')
                                    ]) ?>
                                </div>
                            <?php endif; ?>
                            <?php if ('module' === $menuItem->type) : ?>
                                <div id="item-<?= $menuItem->type ?>">
                                    <?= $this->Form->input('url', [
                                        'type' => 'select',
                                        'options' => $moduleType->getList(),
                                        'class' => 'select2',
                                        'empty' => true,
                                        'label' => __('Module'),
                                        'id' => 'item-module'
                                    ]) ?>
                                </div>
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $this->Form->input('parent_id', [
                                'type' => 'select',
                                'options' => $parentMenuItems,
                                'class' => 'select2',
                                'empty' => true
                            ]) ?>
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
                <div class="hidden" id="type-outer-container">
                <?php if ('custom' !== $menuItem->type) : ?>
                    <div id="item-custom">
                        <?= $this->Form->input('url', [
                            'label' => __('URL')
                        ]) ?>
                    </div>
                <?php endif; ?>
                <?php if ('module' !== $menuItem->type) : ?>
                    <div id="item-module">
                        <?= $this->Form->input('url', [
                            'type' => 'select',
                            'options' => $moduleType->getList(),
                            'class' => 'select2',
                            'empty' => true,
                            'label' => __('Module'),
                            'id' => 'item-module'
                        ]) ?>
                    </div>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
