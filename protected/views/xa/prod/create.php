<?php
/**
 * @var Product $model
 */
$this->renderPartial('prod/_menu');?>

    <h1><?php echo Yii::t('admin', 'Add Product');?></h1>

<?php echo $this->renderPartial('prod/_form', array('model'=>$model)); ?>