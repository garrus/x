<?php
/**
 * WDueditor for Yii extensions
 * @ueditorSite http://ueditor.baidu.com
 * @ueditor  https://github.com/campaign/ueditor   
 * @author WindsDeng <winds@dlf5.com> QQ:620088997 WindsDeng's Blog http://www.dlf5.com
 * @license BSD许可证
 */

class WDueditor extends CInputWidget {
    
    /**
	 * Editor language
	 * Supports: zh-cn  or en
	 */
	public $language = 'zh-cn';
    
    /**
	 * Editor toolbars
	 * Supports: 
	 */
	public $toolbars = '';
    
    /**
	 * Html options that will be assigned to the text area
	 */
	public $htmlOptions = array();
    
	/**
	 * Editor options that will be passed to the editor
	 */
	public $editorOptions = array();
    
	/**
	 * Debug mode
	 * Used to publish full js file instead of min version
	 */
    public $debug = true;
    
    /**
	 * Editor width
	 */
	public $width = '100%';
    
	/**
	 * Editor height
	 */
	public $height = '400px';
    
    /**
	 * Editor theme
     * Supports: default
	 */
	public $theme = 'default';

    public $parse = false;
    
    /**
	 * Display editor
	 */
    public function run() {

        // Get assets dir
        $baseDir = dirname(__FILE__);
        /** @var CAssetManager $am */
        $am = Yii::app()->assetManager;
        /** @var CClientScript $cs */
        $cs = Yii::app()->clientScript;

        $assets = $am->publish($baseDir.DIRECTORY_SEPARATOR.'ueditor', false, -1, true);

        if ($this->parse) {
            $cs->registerScriptFile($assets.'/' . 'ueditor.parse.min.js');
            $cs->registerScript('Yii.'.get_class($this).'#'.$this->id.'.parse', <<<TIDY_TAG_SCRIPT
uParse('#{$this->id}', {rootPath: '$assets/'});
TIDY_TAG_SCRIPT
, CClientScript::POS_READY);
            return;
        }
	
		// Resolve name and id
		list($name, $id) = $this->resolveNameID();

		// Publish required assets
		$jsFile = 'ueditor.all.min.js';
        $cs->registerScriptFile($assets.'/ueditor.config.js');
		$cs->registerScriptFile($assets.'/' . $jsFile);

        $this->htmlOptions['id'] = $id;

        if (!array_key_exists('style', $this->htmlOptions)) {
            $this->htmlOptions['style'] = "width:{$this->width};height:{$this->height}";
        }
        
        if($this->toolbars){
            $this->editorOptions['toolbars'][] = $this->toolbars;
        }

		$options = json_encode(array_merge(
            array(
                'theme'=>$this->theme,
                'lang' => $this->language,
                'UEDITOR_HOME_URL'=>"$assets/",
                'initialFrameWidth'=>$this->width,
                'initialFrameHeight'=>$this->height
            ),
            $this->editorOptions
        ));

        $config = json_encode($this->generateOverrideConfig());
        $configJs = <<<SCRIPT
$.extend(window.UEDITOR_CONFIG, {$config});
SCRIPT;
        $cs->registerScript('Yii.'.get_class($this).'#'.$id.'config', $configJs, CClientScript::POS_HEAD);

        $js =<<<EOP
UE.getEditor('$id',$options);
EOP;
		// Register js code
		$cs->registerScript('Yii.'.get_class($this).'#'.$id, $js, CClientScript::POS_READY);



		// Do we have a model
		if($this->hasModel()) {
            $html = CHtml::activeTextArea($this->model, $this->attribute, $this->htmlOptions);
        } else {
            $html = CHtml::textArea($name, $this->value, $this->htmlOptions);
        }

		echo $html;
    }

    public function generateOverrideConfig(){

        $postBaseUrl = $this->controller->createUrl('ueditor.post'). '/';
        $viewBaseUrl = $this->controller->createUrl('ueditor.view'). '/';

        return array(
            'imageUrl' => $postBaseUrl. 'imageUp.php',
            'scrawlUrl' => $postBaseUrl. 'scrawlUp.php',
            'fileUrl' => $postBaseUrl. 'fileUp.php',
            'catcherUrl' => $postBaseUrl. 'getRemoteImage.php',
            'imageManagerUrl' => $postBaseUrl. 'imageManager.php',
            'snapscreenServerUrl' => $postBaseUrl. 'imageUp.php',
            'wordImageUrl' => $postBaseUrl. 'imageUp.php',
            'videoUrl' => $postBaseUrl. 'fileUp.php',

            'imagePath' => $viewBaseUrl,
            'scrawlPath' => $viewBaseUrl,
            'filePath' => $viewBaseUrl,
            'catcherPath' => $viewBaseUrl,
            'imageManagerPath' => $viewBaseUrl,
            'snapscreenPath' => $viewBaseUrl,
            'wordImagePath' => $viewBaseUrl,
            'videoPath' => $viewBaseUrl,

        );
    }

    public static function actions(){
        return array(
            'post' => 'UEditorPostAction',
            'view' => 'UEditorViewAction',
        );
    }
}


class UEditorPostAction extends CAction{

    public function run($resource){

        list($filename,) = explode('.php', $resource);
        $filename .= '.php';
        $filePath = __DIR__. DIRECTORY_SEPARATOR. 'php'. DIRECTORY_SEPARATOR. $filename;
        if (is_file($filePath)) {
            require $filePath;
        } else {
            throw new CHttpException(404);
        }
    }
}


class UEditorViewAction extends CAction{

    public function run($resource){
        $basePath = Yii::getPathOfAlias('application.data.upload');
        $filePath = $basePath. DIRECTORY_SEPARATOR. $resource;
        if (is_file($filePath)) {
            Yii::app()->request->sendFile(basename($filePath), file_get_contents($filePath));
        } else {
            throw new CHttpException(404);
        }
    }

}
