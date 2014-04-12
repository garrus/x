<?php
$this->pageTitle=Yii::app()->name . ' - Test';

$this->menu = array(
	array('label' => 'Read Logs', 'url' => array('status/readlog'), 'linkOptions' => array('target' => '_blank')),
);

?>

<?php
foreach ($list as $type => $l) {
	foreach ($l as $method) {
		$this->menu[] = array('label' => "{$type} {$method}", 'url' => array("tdd/{$type}{$method}"), 'linkOptions' => array('class' => 'ajax_link'));
	}
}
?>

<div id="test_report">
</div>
