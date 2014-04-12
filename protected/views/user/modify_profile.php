<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14-3-30
 * Time: 上午1:03
 * @var User $model
 * @var boolean $success
 */

if ($success):?>
<div class="notice-success">
    <?php echo Yii::t('user', 'Your profile is saved successfully.');?>
</div>
<?php endif;?>

<?php
/**
 * @var TbActiveForm $form
 * @var XAController $this
 */
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'user-form',
    'enableAjaxValidation'=>false,
)); ?>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldRow($model,'login_name',array('class'=>'span5','maxlength'=>16, 'disabled' => $model->isNewRecord ? '' : 'disabled')); ?>

<?php echo $form->passwordFieldRow($model,'password',array('class'=>'span5','maxlength'=>32)); ?>

<?php echo $form->textFieldRow($model,'first_name',array('class'=>'span5','maxlength'=>8)); ?>

<?php echo $form->textFieldRow($model,'last_name',array('class'=>'span5','maxlength'=>8)); ?>

<?php echo $form->textFieldRow($model,'display_name',array('class'=>'span5','maxlength'=>16)); ?>

<?php echo $form->dropDownListRow($model, 'role', $model->getRoleList());?>

<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>128)); ?>

<?php echo $form->textFieldRow($model,'address',array('class'=>'span5','maxlength'=>128)); ?>

<?php echo $form->textFieldRow($model,'phone',array('class'=>'span5','maxlength'=>16)); ?>

<?php echo $form->textFieldRow($model,'mobile',array('class'=>'span5','maxlength'=>16)); ?>

<?php echo $form->textFieldRow($model,'qq',array('class'=>'span5','maxlength'=>16)); ?>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'label'=> $model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Save'),
    )); ?>
</div>

<?php $this->endWidget(); ?>
