<div style="width: 1000px; position: relative; left: -280px;">
<h1>Table details of <em><?php echo $tableSchema->name;?></em></h1>
<hr>
<h2>Table Structure <a href="javascript:void(0);" onclick="$('#table-schema-details').slideToggle('fast');;" style="margin: 0 0 0 20px; font-weight: 200px; font-size: 12px;">toggle</a></h2>

<?php


$foreignKeys = '';
foreach ($tableSchema->foreignKeys as $keyName => $info) {
	$table = str_replace($db->tablePrefix, '', $info[0]);
	$link = CHtml::link(implode('.', $info), array('db/table', 'table' => $table), array('style' => 'color: green; text-decoration: none; font-style: italic;'));
	$foreignKeys .= '<li><span style="color: blue;">'.$keyName.'</span>  =>  '.$link.'</li>';
}

$pk = is_array($tableSchema->primaryKey) ? implode(', ', $tableSchema->primaryKey) : $tableSchema->primaryKey;
$this->widget('zii.widgets.CListView', array(
	'cssFile' => false,
	'tagName' => 'tbody',
	'dataProvider' => new CArrayDataProvider(array_values($tableSchema->columns), array(
		'keyField' => 'name',
		)
	),
	'itemView' => '_table_column_view',
	'viewData' => array(
		'foreignKeys' => $tableSchema->foreignKeys,
		'tablePrefix' => $db->tablePrefix,
	),
	'template' => <<<TEMPLATE
<div id="table-schema-details" style="display: none;">
<ul>
	<li>
		<label style="font-weight: bold;display:inline-block; width: 10em;">
			PrimaryKey
		</label>
		<span style="color: red;">{$pk}</span>
	</li>
	<li>
		<label style="font-weight: bold;display:inline-block; width: 10em;">
			SequenceName
		</label>
		<span>{$tableSchema->sequenceName}</span>
	</li>
	<li>
		<label style="font-weight: bold;display:inline-block; width: 10em;">
			ForeignKeys
		</label>
		<ul style="vertical-align: top;margin-left: 0; padding-left: 0; display: inline-block; list-style: none;">{$foreignKeys}</ul>
	</li>
</ul>

<table>
	<thead>
		<tr>
			<th>name</th>
			<th>isNull</th>
			<th>type</th>
			<th>default</th>
			<th>size</th>
			<th>precision</th>
			<th>scale</th>
			<th>isPK</th>
			<th>isFK</th>
			<th>AI</th>
		</tr>
	</thead>
	{items}
</table>
</div>
TEMPLATE
));

$cmpList = array(
	'=', '!=', '>', '<', '>=', '<=', 'like', 'not like', 'in', 'not in', 'is null', 'not null'
);
$cmpList = array_combine($cmpList, $cmpList);
$search_condition = null;
$request = Yii::app()->request;
$default_cond_row = array('sf' => '', 'cmp' => '=', 'sv' => '', 'opt' => null);
if ( null !== ($cond_in_params = $request->getParam('s', null)) ) {
	$search_condition = is_array($cond_in_params) ? $cond_in_params : json_decode(base64_decode($cond_in_params), true);
}

if ( !is_array($search_condition) ) {
	$search_condition = array($default_cond_row);
} else {
	$search_condition = array_slice($search_condition, 0); // rebuild index
}

$criteria = new CDbCriteria();

$attrs = $tableSchema->getColumnNames();
foreach ($search_condition as $index => $condition) {
	$condition = array_merge(array('sf' => '', 'cmp' => '=', 'sv' => '', 'opt' => 'AND'), $condition);
	if ( in_array($condition['sf'], $attrs) && in_array($condition['cmp'], $cmpList) && strlen($condition['sv']) ) {
		$column = $condition['sf'];
		$value = $condition['sv'];
		$cmp = $condition['cmp'];
		$opt = (isset($condition['opt']) && strtoupper($condition['opt']) == 'AND') ? 'AND' : 'OR';
		switch ($cmp) {
			case '=':
				$criteria->compare( $column, $value, false, $opt );
				break;
			case '!=':
			case '>':
			case '<':
			case '>=':
			case '<=':
				$criteria->compare( $column, $cmp. $value, false, $opt );
				break;
			case 'like':
				$criteria->compare( $column, $value, true, $opt );
				break;
			case 'not like':
				$criteria->addCondition("$column NOT LIKE '%$value%'", $opt);
				break;
			case 'in':
				$criteria->addInCondition( $column, preg_split('/[,\s]/', $value, PREG_SPLIT_NO_EMPTY), $opt );
				break;
			case 'not in':
				$criteria->addNotInCondition($column, preg_split('/[,\s]/', $value, PREG_SPLIT_NO_EMPTY), $opt );
				break;
			case 'is null':
				$criteria->addCondition("ISNULL($column)", $opt);
				$search_condition[$index]['sv'] = '';
				break;
			case 'not null':
				$criteria->addCondition("!ISNULL($column)", $opt);
				$search_condition[$index]['sv'] = '';
				break;
			default:
				break;
		}
	} else {
		if ($index !== 0) {
			unset($search_condition[$index]);
		}
	}
}

$serialized_search_condition = base64_encode(json_encode($search_condition));
?>
<hr>
<h2>Table Data</h2>

<div id="advanced-panel" style="border: 1px solid #ccc; padding: 10px; border-radius: 15px;">
<h6 style="margin-bottom: 10px;">Display columns</h6>
<ul id="column_display_control" style="margin: 0 0 10px 0; padding-left: 0px;">
<?php 

foreach ($attrs as $attr) :
	$columns[] = array('header' => $attr, 'name' => $attr);
endforeach;

foreach ( $columns as $index => $column ) :
	echo '<li style="display: inline-block; margin: 0px 10px; ">';
	echo '<input type="checkbox" id="col_'. $index. '" checked="checked">';
	echo '<label for="col_'. $index. '">'. $column['header']. '</label>';
	echo '</li>';
endforeach;?>
</ul>

<hr/>

<h6 style="margin-bottom: 10px;">Search by column</h6>
<?php echo CHtml::form(array('/'. $this->route, 'table' => str_replace($db->tablePrefix, '', $tableSchema->name)), 'post');
	$columnList = array('' => '');
	foreach ($columns as $column) {
		$columnList[$column['header']] = $column['name'];
	}

	echo '<ul id="search_cond_list">';
	foreach ($search_condition as $index => $condition) {
		$condition = array_merge(array('sf' => '', 'cmp' => '=', 'sv' => '', 'opt' => null), $condition);

		echo '<li class="search_cond_raw">';
		echo CHtml::dropDownList('s['. $index. '][sf]', $condition['sf'], $columnList);
		echo CHtml::dropDownList('s['. $index. '][cmp]', $condition['cmp'], $cmpList);
		echo CHtml::textField('s['. $index. '][sv]', $condition['sv']);
		if ($index !== 0) {
			echo CHtml::dropDownList('s['. $index. '][opt]', isset($condition['opt']) ? $condition['opt'] : 'AND', array('AND' => 'and', 'OR' => 'or'));
			echo CHtml::button('Remove', array('class' => 'remove-cond'));
		}
		echo '</li>';
	}
	echo '</ul>';
	
	echo CHtml::button('Add more condition', array('id' => 'add-cond'));
	echo CHtml::submitButton('Search', array('style' => 'margin-left: 10px;'));
	echo CHtml::endForm();
	if ($criteria->condition) {
		echo '<pre style="margin: 10px 10px 5px 10px;">';
		echo 'SELECT * from '. $tableSchema->name. ' WHERE ';
		echo str_replace(array_keys($criteria->params), array_values($criteria->params), $criteria->condition);
		echo '</pre>';
	}
?>
</div>

<?php
$count = $db->createCommand()
	->select('COUNT(*)')
	->from($tableSchema->name);
if ($criteria->condition) {
	$count->where($criteria->condition, $criteria->params);
}
$count = $count->queryScalar();

$sql = $db->createCommand()
->select('*')
->from($tableSchema->name);
if ($criteria->condition) {
	$sql->where($criteria->condition, $criteria->params);
}

$this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'model-grid',
	'dataProvider' => new CSqlDataProvider($sql->getText(), array(
		'db' => $db,
		'params' => $sql->params,
		'keyField' => $tableSchema->primaryKey ? (is_array($tableSchema->primaryKey) ? $tableSchema->primaryKey[0] : $tableSchema->primaryKey) : array_shift($tableSchema->getColumnNames()),
		'totalItemCount' => $count,
		'pagination' => array(
			'pageSize' => 25,
			'params' => array_merge($_GET, array('table' => $tableSchema->name, 's' => $serialized_search_condition)),
		),
		'sort' => array(
			'attributes' => $columnList,
		),
	)),
	'template' => '{pager}{summary}{items}',
	'columns' => $columns,
));

ob_start();
echo '<li class="search_cond_raw">';
echo CHtml::dropDownList('s[__INDEX__][sf]', '', $columnList);
echo CHtml::dropDownList('s[__INDEX__][cmp]', '=', $cmpList);
echo CHtml::textField('s[__INDEX__][sv]', '');
echo CHtml::dropDownList('s[__INDEX__][opt]', 'AND', array('AND' => 'and', 'OR' => 'or'));
echo CHtml::button('Remove', array('class' => 'remove-cond'));
echo '</li>';

$cond_row_content = json_encode(ob_get_clean());

?>
</div>

<?php 
Yii::app()->clientScript->registerScript('funcs', <<<SCRIPT_TEXT

function toggle_column(offset, toggle){
	$('#model-grid tr').each(function(){
		var tr = $(this);
		if (toggle) {
			tr.children('td').eq(offset).show().animate({opacity: 1}, 500);
			tr.children('th').eq(offset).show().animate({opacity: 1}, 500);
		} else {
			tr.children('td').eq(offset).animate({opacity: 0}, 300, function(){
				$(this).hide();
			});
			tr.children('th').eq(offset).animate({opacity: 0}, 300, function(){
				$(this).hide();
			});
		}
	});
}

function repaint_columns(configs){
	for(var offset in configs) {
		toggle_column(offset, configs[offset]);
	}
}
SCRIPT_TEXT
, CClientScript::POS_HEAD);


Yii::app()->clientScript->registerScript('column_display_control', <<<SCRIPT_TEXT

$('#column_display_control').delegate('input[type=checkbox]', 'click', function(){
	var cb = $(this), offset = cb.attr('id').split('_').pop(), toggle = !!cb.attr('checked');
	toggle_column(offset, toggle);
});

$('#add-cond').bind('click', function(){
	var list = $('#search_cond_list');
	var index = list.children('li').length;
	list.append({$cond_row_content}.replace(/__INDEX__/g, index));
});

$('#search_cond_list').delegate('.remove-cond', 'click', function(){
	$(this).parent('li').remove();
});

window.scrollBy(0, 400);
SCRIPT_TEXT
, CClientScript::POS_READY);
