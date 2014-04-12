<?php
$this->renderPartial('_menu');
?>

<h2><?php echo ucwords(str_replace('.', ' - ', $error['category']));?></h2>

<h4><?php echo date(DateTime::RFC1123, $error['logtime']); ?></h4>
<hr>
<div id="log-content" class="box code_holder" style="overflow:auto;max-height:650px;">
	<?php echo $error['message'];?>
</div>
