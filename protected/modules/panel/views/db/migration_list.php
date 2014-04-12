<h1>Database Migration</h1>
<?php /*
$this->widget('zii.widgets.CMenu', array(
	'id' => 'migration-action-list',
	'items' => array(
		array('label' => 'All', 'url' => array('db/listMigration')),
		array('label' => 'Applied', 'url' => array('db/listMigration', 'applied' => '1')),
		array('label' => 'Not Applied', 'url' => array('db/listMigration', 'applied' => '0')),
	),
));
*/

?>
<p class="note">Click on migration name to view details</p>
<div id="migration-list-container">
<?php
$this->widget('zii.widgets.CListView', array(
	'id' => 'db-migration-list',
	'dataProvider' => $dataProvider,
	'itemView' => '_migration_view',
	'tagName' => 'ul',
));
?>
</div>
<?php
Yii::app()->clientScript->registerScript('migration-list', <<<TEXT
$('#migration-list-container').delegate('a.migration_desc', 'click', function(e){
	e.preventDefault();
	var link = $(this), mig_v = link.attr('id');
	var c = $('#migration_content_' + link.attr('id'));
	if ( !c.html().length ) {
		c.hide().load(link.attr('href'), function(){
			$(this).slideDown();
		});
	} else {
		c.slideToggle();
	}
	$('.migration_content').not(c).hide();
	return false;
});
TEXT
, CClientScript::POS_END);
