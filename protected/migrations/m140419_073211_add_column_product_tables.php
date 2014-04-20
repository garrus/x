<?php

class m140419_073211_add_column_product_tables extends CDbMigration
{
	public function up()
	{
        $this->addColumn('product', 'cate', 'varchar(64) not null');
        $this->addColumn('product', 'content', 'blob');
        $this->createIndex('product_cate', 'product', 'cate');
	}

	public function down()
	{
		$this->dropColumn('product', 'cate');
		$this->dropColumn('product', 'content');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}