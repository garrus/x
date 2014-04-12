<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),

	array(
        'import'=>array(
            'application.controllers.*',
            'application.tests.utils.*',
        ),

		'components'=>array(

            'session' => array(
                'class' => 'HttpSession',
            ),

			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),
			/* uncomment the following to provide test database connection
			'db'=>array(
				'connectionString'=>'DSN for test database',
			),
			*/
		),
	)
);
