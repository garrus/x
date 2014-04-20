<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14-4-20
 * Time: 下午4:12
 * @var array $items
 * @var array $labels
 */

?>
<h2>配置管理</h2>
<hr>

<?php if (Yii::app()->request->isPostRequest):?>
    <div class="alert alert-success">
        配置已保存。
    </div>
<?php endif;?>

<form class="form-horizontal" method="post" action="<?php echo CHtml::normalizeUrl(array('xa/config'));?>">

    <div class="control-group">
        <label class="control-label" for="admin_password">修改管理员密码</label>
        <div class="controls">
            <input type="password" name="adminPassword" id="admin_password">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="contact_qq_code">客服QQ代码</label>
        <div class="controls">
            <textarea rows="5" style="width: 400px;" name="contactQQCode" id="contact_qq_code"><?php echo $items['contactQQCode'];?></textarea>
        </div>
    </div>

    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn btn-primary">保存</button>
        </div>
    </div>

</form>

<?php /*$form = CHtml::beginForm();?>
<?php foreach ($items as $key => $value):
    $label = $labels[$key];
    $id = 'config_'. $key;
    echo CHtml::label($label, $id);
    if (stripos($key, 'password') !== false) :
        echo CHtml::passwordField($key, '', array('id' => $id));
    else :
        echo CHtml::textArea($key, $value, array('id' => $id));
    endif;
endforeach;

echo CHtml::submitButton('保存', array('class' => 'btn btn-primary'));
?>*/
