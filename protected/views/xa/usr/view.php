<?php
/**
 * @var User $model
 */
$this->renderPartial('usr/_menu');?>

<h1>View User <?php echo $model->getDisplayName(); ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'login_name',
		'password',
		'salt',
		'first_name',
		'last_name',
		'display_name',
		'role',
		'status',
		'last_login_time',
		'email',
		'address',
		'phone',
		'mobile',
		'qq',
		'create_time',
	),
)); ?>
