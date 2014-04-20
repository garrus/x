<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'错误',
);
?>

<div style="margin: 20px;">
<h2>出错了！<?php echo $code; ?></h2>

<div class="error">
<?php echo CHtml::encode($message); ?>
</div>

</div>