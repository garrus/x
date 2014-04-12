<?php $this->beginContent('/layouts/main'); ?>
<div class="span-20" style="margin-right:0px;">
    <div id="content">
        <?php echo $content; ?>
    </div><!-- content -->
</div>

<div style="display:none;" class="span-6 last">

    <div id="sidebar">
        <?php
        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => 'Operation',
        ));

        $this->widget('zii.widgets.CMenu', array(
            'items'=>$this->menu,
            'htmlOptions'=>array('class'=>'operations'),
        ));
        $this->endWidget();
        ?>
    </div><!-- sidebar -->

</div>
<?php $this->endContent('/layouts/main'); ?>