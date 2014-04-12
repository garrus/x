<?php
$this->menu=array(
	array('label' => Yii::t('site', 'Read Logs'), 'url' => array('/panel/status/readLog')),

	array('label' => 'Report', 'url' => '#', 'linkOptions' => array('style' => 'color: gray; cursor: default;'), 'submenuOptions' => array('style' => 'margin-left: 10px;'), 'items' => array(
		array('label' => 'PHP Info', 'url' => array('/panel/status/phpInfo'), 'linkOptions' => array('target' => '_blank')),
	)),

	array('label' => 'Testing', 'url' => '#', 'linkOptions' => array('style' => 'color: gray; cursor: default;'), 'submenuOptions' => array('style' => 'margin-left: 10px;'), 'items' => array(
		array('label' => 'Show Session', 'url' => array('/panel/status/showSession'), 'linkOptions' => array('class' => 'ajax_link')),
		array('label' => 'Show Server', 'url' => array('/panel/status/showServer'), 'linkOptions' => array('class' => 'ajax_link')),
		array('label' => 'Show Constance', 'url' => array('/panel/status/showConstance'), 'linkOptions' => array('class' => 'ajax_link')),
	)),
);
