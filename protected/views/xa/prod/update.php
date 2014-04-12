<?php
/**
 * @var Product $model
 */
$this->renderPartial('prod/_menu');?>

    <h1>Update Product <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('prod/_form',array('model'=>$model)); ?>