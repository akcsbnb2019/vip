<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Asset bundle for the Twitter bootstrap css files.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class WapAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
		'mobile/css/framework7.min.css',
		'mobile/css/app.css',
		'mobile/css/menu.css',
    ];
    public $js = [
		'mobile/js/framework7.min.js',
		'mobile/js/app.js',
		'mobile/js/menu.js',
        'js/plugins/layer_mobile/layer.js',
		'mobile/js/mBase.js',
		'mobile/js/public.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
    
    /**
     * 加载指定js
     * @param unknown $view
     * @param unknown $js
     * @param string $dir
     * @param string $url
     * @param string $type
     */
    public static function wapJs($view,$js,$dir = 'mobile/js/',$url = '@web/',$type = '.js'){
        $view->registerJsFile($url.$dir.$js.$type,[WapAsset::className(),'depends' => ['frontend\assets\WapAsset']]);
    }
    
    /**
     * 加载指定css
     * @param unknown $view
     * @param unknown $css
     * @param string $dir
     * @param string $url
     * @param string $type
     */
    public static function wapCss($view,$css,$dir = 'mobile/css/',$url = '@web/',$type = '.css'){
        $view->registerCssFile($url.$dir.$css.$type,[WapAsset::className(),'depends' => ['frontend\assets\WapAsset']]);
    }

    /**
     * 保留小数 去0
     * @param unknown $num
     * @param number $len
     */
    public function dec($num,$len = 2){
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
