<?php
/**
 * @var CActiveDataProvider $dataProvider
 */
$this->renderPartial('usr/_menu');?>

<h1><?php echo Yii::t('admin', 'Users');?></h1>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'dataProvider'=>$dataProvider,
    'columns' => array(
        'first_name',
        'last_name',
        'display_name',
        'role',
        'email',
        'qq',
        'last_login_time',
        array(
            'class' => 'TbButtonColumn',
            'viewButtonUrl' => 'array(\'xa/usrView\', \'id\' => $data->id)',
            'updateButtonUrl' => 'array(\'xa/usrUpdate\', \'id\' => $data->id)',
            'deleteButtonUrl' => 'array(\'xa/usrDelete\', \'id\' => $data->id)',
        )
    )
));
