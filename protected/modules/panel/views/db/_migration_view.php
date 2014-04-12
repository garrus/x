<?php

if ( !preg_match('/^m([\d]{6}_[\d]{6})_(.+)$/', $data['version'], $matches) ) {
	return;
}
list ($version, $timestamp, $desc) = $matches;

$isApplied = $data['applied'];
if ($isApplied) {
	$applyDate = date('Y-m-d H:i:s', $data['apply_time']);
}
?>

<li class="migration_item <?php if ( $isApplied ) : echo ' applied'; endif;?>">
	<span class="timestamp">
		<?php echo $timestamp;?>
	</span>
	<span class="desc">
		<?php echo CHtml::link($desc, array('db/migrationView', 'ver' => $version), array('target' => '_blank', 'id' => $version, 'class' => 'migration_desc'));?>
	</span>

	<?php if ( $isApplied) :?>
		<span class="green">Applied on <?php echo $applyDate; ?></span>
	<?php else :?>
		<span class="highlight red">Not applied yet</span>
	<?php endif;?>

	<br>
	<?php if ( isset($data['error']) ) :?>
		<span class="red bold"><?php echo $data['error']; ?></span>
	<?php endif;?>

	<div style="display: none;" class="migration_content" id="migration_content_<?php echo $version;?>"></div>
</li>
