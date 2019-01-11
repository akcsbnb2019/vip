<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'layui/css/layui.css',
    ];
    public $js = [
        'layui/layui.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        /*'yii\bootstrap\BootstrapAsset',*/
    ];
    
    /**
     * 加载指定js
     * @param unknown $view
     * @param unknown $js
     * @param string $dir
     * @param string $url
     * @param string $type
     */
    public static function addJs($view,$js,$dir = 'js/',$url = '@web/',$type = '.js'){
        $view->registerJsFile($url.$dir.$js.$type,[AppAsset::className(),'depends' => ['backend\assets\AppAsset']]);
    }
    
    /**
     * 加载指定css
     * @param unknown $view
     * @param unknown $css
     * @param string $dir
     * @param string $url
     * @param string $type
     */
    public static function addCss($view,$css,$dir = 'css/',$url = '@web/',$type = '.css'){
        $view->registerCssFile($url.$dir.$css.$type,[AppAsset::className(),'depends' => ['backend\assets\AppAsset']]);
    }
}
