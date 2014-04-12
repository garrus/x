<?php
/**
 * @var User $model
 */
$this->renderPartial('usr/_menu');?>

<h1>Update User <?php echo $model->getDisplayName; ?></h1>

<?php echo $this->renderPartial('usr/_form',array('model'=>$model)); ?>