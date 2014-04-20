<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14-4-20
 * Time: 下午6:19
 */

class ProdGrid extends CWidget {

    public function run(){
        $data = Product::model()->findAll(array(
            'condition' => 'is_deleted=0',
            'limit' => Yii::app()->config->prodGridRows * 3,
            'order' => 'create_time DESC',
        ));
        $this->renderContent($data);
    }

    public function renderContent($data) {

        echo '<h3 id="home-intro-block-title">最新产品</h3>';

        echo '<div id="home-intro-block">';

        foreach ($data as $index => $prod) {
            if ($index % 3 == 0) echo '<div class="intro-block-row">';
                echo '<div class="intro-block">';
                echo '<h4 class="title">', CHtml::link($prod->name, array('prod/view', 'id' => $prod->id)), '</h4>';
                echo '<p class="info">', $prod->description, '</p>';
                echo '</div>';
                if ($index % 3 == 2)echo '</div>';
        }
        if ($index % 3 != 2) echo '</div>';
        echo '</div>';
    }
}