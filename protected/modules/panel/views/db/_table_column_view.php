<tr>
	<td>
		<?php if ($data->isPrimaryKey) :?>
		<span style="color: red;"><?php echo $data->name;?></span>

		<?php elseif ($data->isForeignKey) :
			$keyInfo = $foreignKeys[$data->name];
			$table = str_replace($tablePrefix, '', $keyInfo[0]);
			$link = CHtml::link($data->name, array('db/table', 'table' => $table), array('style' => 'color: blue;'));
			echo $link;

		else :
			echo $data->name;
		endif;?>
	</td>
	<td><?php echo (int) $data->allowNull; ?></td>
	<td><?php echo $data->dbType; ?></td>
	<td><?php echo $data->defaultValue; ?></td>
	<td><?php echo $data->size; ?></td>
	<td><?php echo $data->precision; ?></td>
	<td><?php echo var_export($data->scale, true); ?></td>
	<td><?php echo (int) $data->isPrimaryKey; ?></td>
	<td><?php echo (int) $data->isForeignKey; ?></td>
	<td><?php echo (int) $data->autoIncrement; ?></td>
</tr>
