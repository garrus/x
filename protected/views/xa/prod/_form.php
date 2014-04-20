<?php
/**
 * @var Product $model
 * @var TbActiveForm $form
 * @var XAController $this
 */

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'product-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">带<span class="required">*</span>项目为必填.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model, 'name', array('class'=>'span5', 'maxlength'=>128, 'placeholder' => '产品名称，不超过30字')); ?>
    <?php echo $form->textFieldRow($model, 'cate', array('class' => 'span5', 'placeholder' => '不超过15字')); ?>
    <?php echo $form->radioButtonListInlineRow($model, 'is_deleted', array('1' => '是', '0' => '否'));?>
    <p class="help-block">隐藏的产品不会在产品列表中显示（但是管理界面仍然可见）</p>
	<?php echo $form->textAreaRow($model, 'description', array(
        'class'=>'span5',
        'placeholder' => '出现在产品列表和产品页面的简短介绍性文字，不超过300字',
        'style' => 'height:120px;width:500px;')); ?>

<?php
    echo $form->labelEx($model, 'content');
    if (!$model->content) $model->content = '产品详情';
    $this->widget('ext.wdueditor.WDueditor',array(
        'model' => $model,
        'attribute' => 'content',
        'htmlOptions' => array(
            'style' => 'height: 800px;',
        ),
        'height' => '800px',
    ));?>

<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'保存',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
