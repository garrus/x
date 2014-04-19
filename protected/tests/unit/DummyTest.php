<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14-4-19
 * Time: 下午2:43
 */

require_once dirname(__DIR__). DIRECTORY_SEPARATOR. 'utils/BaseTestCase.php';

class DummyTest extends BaseTestCase{

    public function testDummy(){
        $this->assertTrue(true);
    }

} 