<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace tollbackend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/dev.css',
        'css/style.css',
    ];
    public $js = [
        //'js/jquery.min.js',
        'https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyDeWpP7Y-UOu810O0MLLlIMXHceUEfUQN4',
        'js/angular-1.5.5/angular.min.js',
        'js/angular-1.5.5/angular-animate.min.js',
        'js/angular-1.5.5/angular-cookies.min.js',
        'js/angular-1.5.5/angular-route.min.js',
        'js/RouteBoxer.js',
        'js/scripts.js',
        'js/scrolltopcontrol.js',
        'js/gMap.js',
        'js/app.js',
        'js/ConsessCtrl.js',
        'js/autocomplete.js',
        'http://d3js.org/d3.v3.min.js',
        'js/c3.js',
        'https://rawgithub.com/eligrey/FileSaver.js/master/FileSaver.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    /*public $css = [
        'css/site.css',
    ];
    public $js = [
        'https://maps.googleapis.com/maps/api/js?v=3&sensor=true',
        'js/gMap.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];*/


}
