<?php
/**
 * @var Product $model
 */
$this->renderPartial('prod/_menu');?>

<h1>修改产品</h1>
<hr>
<?php echo $this->renderPartial('prod/_form',array('model'=>$model)); ?>