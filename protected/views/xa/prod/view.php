<?php
/**
 * @var Product $model
 */
$this->renderPartial('prod/_menu');?>

<h1>View Product <?php echo $model->name; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
    'data'=>$model,
    'attributes'=>array(
        'id',
        'name',
        'description',
        'is_deleted',
        'create_time',
        'update_time',
    ),
)); ?>
