<?php
/**
 * @var Product $model
 * @var TbActiveForm $form
 * @var XAController $this
 */

$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'product-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    ),
    'type' => TbActiveForm::TYPE_HORIZONTAL,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name', array('class'=>'span5','maxlength'=>128)); ?>

	<?php echo $form->textAreaRow($model,'description',array('class'=>'span5')); ?>

    <?php echo $form->fileFieldRow($model, 'file');?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
