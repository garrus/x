<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14-4-12
 * Time: 下午10:26
 */

class ProdListWidget extends CWidget{


    public function run(){

        $prodList = Product::getList();

        $menuItems = array();
        foreach ($prodList as $cate => $subList) {

            $subItems = array();
            foreach ($subList as $index => $prod) {
                $subItems[] = array('label' => $prod['name'], 'url' => array('prod/view', 'id' => $prod['id']));
            }
            $menuItems[] = array('label' => $cate, 'items' => $subItems);
        }


        $this->widget('zii.widgets.CMenu', array(
            'items' => $menuItems,
        ));
    }

} 