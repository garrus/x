<?php
/* @var $this SiteController */

$themeBaseUrl = Yii::app()->theme->baseUrl;
$this->pageTitle=Yii::app()->name;
?>

<div class="banner" id="homepage-banner">
    <ul>
        <li class="slide-1">
            <div class="inner">
                <h1>The jQuery slider that just slides.</h1>
                <p>No fancy effects or unnecessary markup, and it’s less than 3kb.</p>
            </div>
        </li>

        <li class="slide-2">
            <div class="inner">
                <h1>Fluid, flexible, fantastically minimal.</h1>
                <p>Use any HTML in your slides, extend with CSS. You have full control.</p>
            </div>
        </li>

        <li class="slide-3">
            <div class="inner">
                <h1>Open-source.</h1>
                <p>Everything to do with Unslider is hosted on GitHub.</p>

            </div>
        </li>

        <li class="slide-4">
            <div class="inner">
                <h1>Uh, that’s about it.</h1>
                <p>I just wanted to show you another slide.</p>
            </div>
        </li>
    </ul>
</div>

<div class="features">
    <ul class="wrap">
        <li class="browser">
            <b>Cross-browser happy</b>
            <p>Unslider’s been tested in all the latest browsers, and it falls back magnificently for the not-so-latest ones.</p>
        </li>

        <li class="keyboard">
            <b>Keyboard support</b>
            <p>If you want to, you can add keyboard arrow support. Try it: hit left and right arrow keys.</p>
        </li>

        <li class="height">
            <b>Adjusts for height</b>
            <p>Not all slides are created equal, and Unslider knows it. It’ll stylishly transition heights with no extra code.</p>
        </li>

        <li class="responsive">
            <b>Yep, it’s responsive</b>
            <p>You’ll be hard pressed to find a site that’s not responsive these days. Unslider’s got your back.</p>
        </li>
    </ul>
</div>

<?php Yii::app()->clientScript->registerScript('index-banner', <<<'SCRIP_TEXT'
    if (window.chrome) {
        $('.banner li').css('background-size', '100% 100%');
    }
    $('#homepage-banner').unslider({
        arrows: false,
        fluid: true,
        dots: true
    });
SCRIP_TEXT
, CClientScript::POS_READY);