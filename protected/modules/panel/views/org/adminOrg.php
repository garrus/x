<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'orgList',
	'template' => '{items}{pager}',
	'htmlOptions' => array('class' => 'grid-view report'),
	'dataProvider' => $orgList,
	'columns' => array(
       array(
			'header' => 'Org',
			'value' => '$data["orgName"]',
			'headerHtmlOptions' => array(
				'width' => '15%',
				'style' => 'text-align:center;'
			),
			'htmlOptions' => array(
				'style' => 'text-align:center;',
			),
		),
		array(
			"type"=>"HTML",
			'header' => 'Member',
			'value' => '$data["memberList"]',
			'headerHtmlOptions' => array(
				'width' => '70%',
				'style' => 'text-align:center;'
			),
			'htmlOptions' => array(
			),
		),
		array(
			"type"=>"HTML",
			'header' => 'OrgAdmin',
			'value' => '$data["orgAdmin"]',
			'headerHtmlOptions' => array(
				'width' => '15%',
				'style' => 'text-align:center;'
			),
			'htmlOptions' => array(
				'style' => 'text-align:center;',
			),
		)

	),
));
