<?php
/* @var $this SiteController */

$themeBaseUrl = Yii::app()->theme->baseUrl;
$this->pageTitle=Yii::app()->name;


$this->widget('ext.slider.slider', array(
        'container'=>'slideshow',
        'width'=>750,
        'height'=>240,
        'timeout'=>6000,
        'infos'=>true,
        'constrainImage'=>true,
        'images'=>array('01.jpg','02.jpg','03.jpg','04.jpg'),
        'alts'=>array('First description','Second description','Third description','Four description'),
        'defaultUrl'=>CHtml::normalizeUrl(array('prod/index')),
    )
);

$this->widget('application.widgets.prodGrid.ProdGrid');
