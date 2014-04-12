<?php $this->beginContent('/layouts/main'); ?>
	<div class="span-20" style="margin-right:0px;">
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>

	<div style="display:none;" class="span-6 last">

		<div id="sidebar">
		<?php

			$this->beginWidget('zii.widgets.CPortlet', array(
				'title' => 'Operation',
			));

			$this->widget('zii.widgets.CMenu', array(
				'items'=>$this->menu,
				'htmlOptions'=>array('class'=>'operations'),
			));
			$this->endWidget();
		?>
		</div><!-- sidebar -->

	</div>

<?php Yii::app()->clientScript->registerScript('Ajax_link', <<<'SCRIPT'
$('.ajax_link').bind('click', function(){
	var link = $(this);
	link.parent().parent().children('li').toggleClass('current', false);
	$('#content').fadeTo(100, 0.2).load(link.attr('href'), function(){
		$(this).fadeTo(400, 1);
	});
	link.parent().toggleClass('current', true);
	$('.breadcrumbs span').last().html(link.html());
	return false;
});
SCRIPT
, CClientScript::POS_READY);?>

<?php $this->endContent();
