<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en<?php // echo $shortLang = substr($_COOKIE['hl'], 0, 2);?>" lang="en<?php //echo $shortLang;?>">
<head>
<?php $baseUrl = Yii::app()->request->baseUrl; $assetsUrl = Yii::app()->assetManager->publish(Yii::app()->basePath.'/modules/panel/css', false, -1, true);?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<link rel="alternate" type="application/rss+xml" href="<?php echo $baseUrl;?>/index.php/panel/status/errorfeed" title="CBR-website - fatal errors" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo $assetsUrl; ?>/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo $assetsUrl; ?>/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo $assetsUrl; ?>/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo $assetsUrl; ?>/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $assetsUrl; ?>/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div id="page">

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items' => array(
				array('label' => 'Back To Website', 'url'=>array('/site/index'), 'itemOptions' => array('class' => 'right')),

				array('label' => 'Home', 'url' => array('/panel/default/index')),
				array('label' => 'Database', 'url' => array('/panel/db')),
				array('label' => 'Back Up', 'url' => array('/panel/backup')),
			),
		)); ?>
	</div><!-- mainmenu -->

	<div class="container">
	<?php if(empty($this->breadcrumbs)):
		$this->breadcrumbs = array(
			ucwords($this->friendlyName) => array('/'.$this->module->id.'/'.$this->id),
			ucwords($this->action->id)
		);
		if (isset($_GET['id'])) {
			$this->breadcrumbs[] = '#' . $_GET['id'];
		}
	endif;?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
			'homeLink' => ucwords($this->module->id),
		)); ?><!-- breadcrumbs -->

		<?php echo $content; ?>
	</div>
	<div id="footer">
		Copyright &copy;: 2013, <a href="http://www.sumilux.com">Sumilux Technologies, LLC.</a> <br/>
		All Rights Reserved.
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
