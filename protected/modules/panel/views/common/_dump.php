<fieldset style="border:4px double #359;box-shadow:0px 0px 5px #972;margin:9px;padding:7px 10px;overflow-x:auto;">
	<legend style="font-weight:600;font-size:1.1em;border:1px solid #359;background-color:<?php echo is_bool($error) ? ($error ? '#F66' : '#0d0') : 'white'; ?>;box-shadow:2px 2px 3px #972;padding:3px 6px;">
		<?php
			echo CHtml::encode($title);
		?>
	</legend>
	<div>
		<?php echo $content; ?>
	</div>
</fieldset>
