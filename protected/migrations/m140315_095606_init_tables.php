<?php

class m140315_095606_init_tables extends CDbMigration
{
	public function up()
	{
        $this->createTable('user', array(
            'id' => 'int(11) unsigned not null auto_increment',
            'login_name' => 'varchar(16) not null',
            'password' => 'char(32) not null',
            'salt' => 'char(32) not null',
            'first_name' => 'varchar(8) not null',
            'last_name' => 'varchar(8) not null',
            'display_name' => 'varchar(16) not null',
            'role' => 'enum("admin", "rep", "customer") not null default "customer"',
            'status' => 'enum("pending", "normal", "block") not null default "pending"',
            'last_login_time' => 'timestamp not null default 0',
            'email' => 'varchar(128) not null default ""',
            'address' => 'varchar(128) not null default ""',
            'phone' => 'varchar(16) not null default ""',
            'mobile' => 'varchar(16) not null default ""',
            'qq' => 'varchar(16) not null default ""',
            'create_time' => 'timestamp not null default CURRENT_TIMESTAMP',
            'Primary Key(id)',
        ), 'Engine=InnoDb Default Charset=utf8');

        $this->createIndex('user_login_name', 'user', 'login_name', true);
        $this->createIndex('user_role', 'user', 'role');


        $this->createTable('customer_relation', array(
            'rep_id' => 'int(11) unsigned not null',
            'customer_id' => 'int(11) unsigned not null',
            'Primary Key(rep_id, customer_id)'
        ), 'Engine=InnoDb Default Charset=utf8');

        $this->createIndex('customer', 'customer_relation', 'customer_id', true);
        $this->addForeignKey('fk_relation_customer', 'customer_relation', 'customer_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_relation_rep', 'customer_relation', 'rep_id', 'user', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('product', array(
            'id' => 'smallint(5) unsigned not null auto_increment',
            'name' => 'varchar(128) not null',
            'description' => 'varchar(1024) not null default ""',
            'is_deleted' => 'tinyint(1) unsigned not null default 0',
            'create_time' => 'timestamp not null default CURRENT_TIMESTAMP',
            'update_time' => 'timestamp not null default 0 on update CURRENT_TIMESTAMP',
            'Primary Key(id)',
        ), 'Engine=InnoDb Default Charset=utf8');

        $this->createTable('product_visit', array(
            'product_id' => 'smallint(5) unsigned not null',
            'customer_id' => 'int(11) unsigned not null',
            'times' => 'smallint(5) unsigned not null default 0',
            'last_visit_time' => 'timestamp default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP',
            'Primary Key(product_id, customer_id)'
        ), 'Engine=InnoDb Default Charset=utf8');

        $this->createIndex('product_visit_history', 'product_visit', 'customer_id');
        $this->addForeignKey('fk_visited_product', 'product_visit', 'product_id', 'product', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_product_visitor', 'product_visit', 'customer_id', 'user', 'id', 'RESTRICT', 'CASCADE');

	}

	public function down()
	{
		$this->dropTable('product_visit');
        $this->dropTable('product');
        $this->dropTable('customer_relation');
        $this->dropTable('user');
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