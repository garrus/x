<?php
/**
 * @var CActiveDataProvider $dataProvider
 */
$this->renderPartial('prod/_menu');?>

<h1><?php echo Yii::t('admin', 'Products');?></h1>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'dataProvider'=>$dataProvider,
    'columns' => array(
        'name',
        array(
            'class' => 'TbButtonColumn',
            'viewButtonUrl' => 'array(\'xa/prodView\', \'id\' => $data->id)',
            'updateButtonUrl' => 'array(\'xa/prodUpdate\', \'id\' => $data->id)',
            'deleteButtonUrl' => 'array(\'xa/prodDelete\', \'id\' => $data->id)',
        )
    )
));
