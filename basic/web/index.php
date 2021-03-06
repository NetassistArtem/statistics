<?php
$GLOBALS['start_time'] = microtime(true);
// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
//require(__DIR__ . '/../vendor/pChart/pChart/pData.class');
//require(__DIR__ . '/../vendor/pChart/pChart/pChart.class');

$config = require(__DIR__ . '/../config/web.php');
Yii::$classMap['pData'] = __DIR__ . '/../vendor/pChart/pChart/pData.class';
Yii::$classMap['pChart'] = __DIR__ . '/../vendor/pChart/pChart/pChart.class';

(new yii\web\Application($config))->run();
