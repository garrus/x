<?php

class m140315_095606_init_tables extends CDbMigration
{
	public function up()
	{
        $this->createTable('product', array(
            'id' => 'smallint(5) unsigned not null auto_increment',
            'name' => 'varchar(128) not null',
            'description' => 'varchar(1024) not null default ""',
            'is_deleted' => 'tinyint(1) unsigned not null default 0',
            'create_time' => 'timestamp not null default CURRENT_TIMESTAMP',
            'update_time' => 'timestamp not null default 0 on update CURRENT_TIMESTAMP',
            'Primary Key(id)',
        ), 'Engine=InnoDb Default Charset=utf8');
	}

	public function down()
	{
        $this->dropTable('product');
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