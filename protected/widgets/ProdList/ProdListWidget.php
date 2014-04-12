<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14-4-12
 * Time: 下午10:26
 */

class ProdListWidget extends CWidget{


    public function run(){

        $prodCount = Product::model()->count();
        echo '<h4>当前总共有 '. $prodCount. ' 件产品.</h4>';
    }

} 