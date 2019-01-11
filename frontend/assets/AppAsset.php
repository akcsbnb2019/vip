<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/font-awesome.min93e3.css?v=4.4.0',
    ];
    public $js = [
        'js/mBase.js',
        'js/plugins/layer/layer.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
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
        $view->registerJsFile($url.$dir.$js.$type,[AppAsset::className(),'depends' => ['frontend\assets\AppAsset']]);
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
        $view->registerCssFile($url.$dir.$css.$type,[AppAsset::className(),'depends' => ['frontend\assets\AppAsset']]);
    }

    /**
     * 保留小数 去0
     * @param unknown $num
     * @param number $len
     */
    public static function dec($num,$len = 2){
        if(floor($num) == $num){
            return floor($num);
        }
        if($len == 3){
            $num = sprintf("%.3f",substr(sprintf("%.5f", $num), 0, -2));
        }else{
            $num = sprintf("%.2f",substr(sprintf("%.4f", $num), 0, -2));
        }
        if($len == 3){
            if($num == substr($num,0,-2)){
                return substr($num,0,-2);
            }
        }
        if($num == substr($num,0,-1)){
            return substr($num,0,-1);
        }
        return $num;
    }
}
