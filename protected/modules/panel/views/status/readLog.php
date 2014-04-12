<?php
$this->renderPartial('_menu');
?>
<h2 id="report-title"><?php echo Yii::t('site', 'Read Logs'); ?></h2>

<i class="clear left container quiet append-bottom">
	Note: This page is available only in debug mode (when <em>YII_DEBUG</em> is defined as true).
</i>

<?php
if (empty($list)) {
	echo '<h4>(No logs are found.)</h4>';
} else {
	echo CHtml::openTag('ul');
	$prefix = '';
	foreach ($list as $log) {
		list($realname, ) = explode('.', $log);
		if ($realname !== $prefix) {
			if ($prefix !== '') {
				echo CHtml::closeTag('li');
			}
			echo CHtml::openTag('li', array('style' => 'line-height: 24px;'));
			$prefix = $realname;
		}

		echo CHtml::link($log, CHtml::normalizeUrl(array('status/readlog', 'log' => $log)), array('class' => 'log', 'target' => '_blank', 'style' => 'margin-right: 20px;'));
	}
	if ($prefix !== '') {
		echo CHtml::closeTag('li');
	}
	echo CHtml::closeTag('ul');
}

Yii::app()->clientScript->registerScript('load-log', <<<SCRIPT
$('.log').bind('click', function(){
	$('#log-content').show().load($(this).attr('href'), function(){
		window.scrollTo(0, $('#report-title').offset().top-10);
	}).css('width', parseInt($('body').css('width')) - 120);
	return false;
});
SCRIPT
, CClientScript::POS_READY);
?>
<div id="log-content" class="box code_holder" style="position: absolute;
left: 20px;
right: 20px;
bottom: 20px;
top: 213px;
padding: 20px;
box-shadow: 0 0 5px 2px silver;
border-radius: 5px;
overflow-x: visible;
overflow-y: auto;
max-height: 650px; display:none;">

</div>
