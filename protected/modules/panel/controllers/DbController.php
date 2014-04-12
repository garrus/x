<?php

/**
 * This controller allow you to view db data.
 *
 * @package test.controllers
 * @author yaowenh
 *
 */
class DbController extends PanelController{

	public $defaultAction='index';

	public $menu = array(
		array('label' => 'Data Tables', 'url' => array('/panel/db/table')),
		array('label' => 'Migration', 'url' => array('/panel/db/listMigration')),
	);

	public function actionIndex(){
		$this->render('index', array(
			'db' => Yii::app()->db,
		));
	}

	public function actionTable($table=''){

		$db = Yii::app()->db;
		$tableList = $db->getSchema()->getTableNames();
		$tablePrefix = Yii::app()->db->tablePrefix ?: '';
		if ($tablePrefix) {
			$tableList = array_filter($tableList, create_function('$v', "return stripos(\$v, '$tablePrefix') === 0;"));
			$table = $db->tablePrefix. $table;
		}

		if ( in_array($table, $tableList) ) {
			$tableSchema = $db->getSchema()->getTable($table);
		}

		array_walk($tableList, function(&$value, $key, $prefix){
			if ($prefix != '' && stripos($value, $prefix) === 0) {
				$value = substr($value, strlen($prefix));
			}
		}, $tablePrefix);

		$this->render('db_tables', array(
			'tableList' => $tableList,
			'tableSchema' => isset($tableSchema) ? $tableSchema : null,
			'tablePrefix' => $tablePrefix,
			'db' => $db,
		));
	}

	public function actionListMigration(){

		$migrations = Yii::app()->db->createCommand()
			->select('*')
			->from('tbl_migration')
			->where('version!=\'m000000_000000_base\'')
			->order('apply_time DESC')
			->queryAll(true);

		$migration_files = array();

		$path = Yii::getPathOfAlias('application.migrations');
		foreach ( new DirectoryIterator($path) as $file ) {
			if ( $file->isFile() && $file->getExtension() == 'php' ) {
				$migration_files[] = $file->getBasename('.php');
			}
		}

		$all = array();
		foreach ($migrations as $index => $row) {
			$record = array('version' => $row['version'], 'applied' => true, 'apply_time' => $row['apply_time']);
			if ( !in_array( $row['version'], $migration_files ) ) {
				$record['error'] = 'The migration file is not found for this version.';
			}
			$all[$row['version']] = $record;
		}

		foreach ($migration_files as $version) {
			if ( !isset($all[$version]) ) {
				$all[$version] = array('version' => $version, 'applied' => false, 'apply_time' => 0);
			}
		}

		krsort($all);
		$dp = new CArrayDataProvider($all, array(
			'keyField' => 'version',
			'pagination' => array(
				'pageSize' => 20
			)
		));

		$this->render('migration_list', array(
			'dataProvider' => $dp
		));
	}

	public function actionMigration(){
		$sql = Yii::app()->db->createCommand()
		->select('*')
		->from('tbl_migration')
		->where('version!=\'m000000_000000_base\'')
		->order('apply_time DESC')
		->getText();

		$dp = new CSqlDataProvider($sql, array(
				'keyField' => 'version',
				'pagination' => array(
						'pageSize' => 20
				)
		));

		$this->render('migration_list', array(
				'dataProvider' => $dp
		));
	}

	public function actionMigrationView($ver){

		$path = Yii::getPathOfAlias('application.migrations');
		$file_name = $path. '/'. $ver. '.php';
		$file = new SplFileInfo($file_name);

		if ( $file->isFile() && $file->isReadable() ) {
			$fileObj = new SplFileObject($file_name, 'r');
			highlight_file($file->getPathname());
		} else {
			echo '<h3 class="red">File for migration "'. $ver. '" is not found.</h3>';
		}

	}

	protected function getModelNameByTableName($tableName){
		$table = str_replace(' ', '',
				ucwords(
					str_replace(
						array(Yii::app()->db->tablePrefix, '_'),
						array('', ' '),
						$tableName)));
	}

}
