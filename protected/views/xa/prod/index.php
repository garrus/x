<?php
/**
 * @var CActiveDataProvider $dataProvider
 */
$this->renderPartial('prod/_menu');?>

<h1>所有产品</h1>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'dataProvider'=>$dataProvider,
    'summaryText' => '总共 {count} 项',
    'columns' => array(
        'name',
        'cate',
        array(
            'name' => 'is_deleted',
            'value' => '$data->is_deleted ? \'是\' : \'否\'',
        ),
        'create_time',
        array(
            'class' => 'TbButtonColumn',
            'viewButtonLabel' => '查看详情',
            'viewButtonUrl' => 'array(\'xa/prodView\', \'id\' => $data->id)',
            'updateButtonLabel' => '修改',
            'updateButtonUrl' => 'array(\'xa/prodUpdate\', \'id\' => $data->id)',
            'deleteButtonLabel' => '删除',
            'deleteButtonUrl' => 'array(\'xa/prodDelete\', \'id\' => $data->id)',
            'deleteConfirmation' => '你确定要删除这项产品吗？（删除后无法恢复！）'. PHP_EOL. '如果只是想暂时隐藏这件产品，请点击“修改”图标，勾选“隐藏”后保存即可'
        )
    )
));
