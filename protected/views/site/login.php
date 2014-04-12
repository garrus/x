<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::t('site', 'Login');
$this->breadcrumbs=array(
	Yii::t('site', 'Login'),
);
?>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'login-form',
    'htmlOptions' => array('class' => 'form-signin'),
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); ?>

    <h2 class="form-signin-heading"><?php echo Yii::t('site', 'Please sign in');?></h2>

    <?php echo $form->textField($model, 'username', array('class' => 'input-block-level', 'placeholder' => YiI::t('site', 'Login Name')));?>
    <?php echo $form->error($model, 'username');?>

    <?php echo $form->passwordField($model, 'password', array('class' => 'input-block-level', 'placeholder' => YiI::t('site', 'Password')));?>
    <?php echo $form->error($model, 'password');?>

    <label class="checkbox">
        <?php echo $form->checkBox($model, 'rememberMe');?>
        <?php echo $model->getAttributeLabel('rememberMe');?>
    </label>
    <?php echo CHtml::submitButton(Yii::t('site', 'Sign In'), array('class' => 'btn btn-large btn-primary'))?>

<?php $this->endWidget(); ?>
