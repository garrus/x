<?php

$tableMenu = array();
foreach ($tableList as $tableName) {
	$tableMenu[] = array(
		'label' => $tableName,
		'url' => array('', 'table' => $tableName),
		'linkOptions' => array('title' => $tablePrefix.$tableName),
		'active' => (empty($tableSchema) ? false : $tablePrefix.$tableName == $tableSchema->name),
	);
}
$this->widget('zii.widgets.CMenu', array(
	'id' => 'tablename-list',
	'items' => $tableMenu,
	'htmlOptions' => array(
		'style' => 'min-height: 120px;',
	),
));

if ( !empty($tableSchema) ) {
	$this->renderPartial('_table_detail', array(
		'tableSchema' => $tableSchema,
		'db' => $db,
	));
}
