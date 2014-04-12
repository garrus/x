<?php
/**
 * @var User $model
 */
$this->renderPartial('usr/_menu');?>

<h1><?php echo Yii::t('admin', 'Create User');?></h1>

<?php echo $this->renderPartial('usr/_form', array('model'=>$model)); ?>