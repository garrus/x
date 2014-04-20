<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="content row-fluid">
    <div class="span2">
        <?php
        $this->widget('TbMenu', array(
            'items'=>$this->menu,
            'htmlOptions'=>array('class'=>'operations'),
        ));
        ?>
    </div>

    <div class="span9">
        <?php echo $content; ?>
    </div>

</div>
<?php $this->endContent(); ?>