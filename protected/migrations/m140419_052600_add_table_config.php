<?php

class m140419_052600_add_table_config extends CDbMigration
{
	public function up()
	{
        $this->createTable('config', array(
            'name' => 'varchar(64) not null',
            'value' => 'varchar(1024) not null',
            'primary key (`name`)'
        ));

        $salt = md5(mt_rand(1000000, 9999999). md5(mt_rand(1000000, 9999999)));
        $adminPassword = 'password';
        $initConfig = array(
            'adminId' => 'admin',
            'adminSalt' => $salt,
            'adminPassword' => UserIdentity::encryptPassword($adminPassword, $salt),
        );

        foreach ($initConfig as $name => $value) {
            $this->insert('config', array('name' => $name, 'value' => $value));
        }
	}

	public function down()
	{
		$this->dropTable('config');
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