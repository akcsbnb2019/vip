<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Asset bundle for the Twitter bootstrap css files.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class BootsAsset extends AssetBundle
{
    public $sourcePath = '@bower/bootstrap/dist';
    public $css = [
        'css/bootstrap.css',
        '/layui/css/layui.css',
    ];
    public $js = [
        '/layui/layui.js',
    ];
    
    /**
     * 加载指定js
     * @param unknown $view
     * @param unknown $js
     * @param string $dir
     * @param string $url
     * @param string $type
     */
    public static function bootJs($view,$js,$dir = 'js/',$url = '@web/',$type = '.js'){
        $view->registerJsFile($url.$dir.$js.$type,[BootsAsset::className(),'depends' => ['backend\assets\BootsAsset']]);
    }
    
    /**
     * 加载指定css
     * @param unknown $view
     * @param unknown $css
     * @param string $dir
     * @param string $url
     * @param string $type
     */
    public static function bootCss($view,$css,$dir = 'css/',$url = '@web/',$type = '.css'){
        $view->registerCssFile($url.$dir.$css.$type,[BootsAsset::className(),'depends' => ['backend\assets\BootsAsset']]);
    }
}
