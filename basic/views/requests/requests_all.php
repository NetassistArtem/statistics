<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use Yii;
use app;

$url_table = Yii::$app->request->url."/table";
$url_details = Yii::$app->request->url.'-'.Yii::$app->formatter->asDate('now', 'yyyy');

?>

<div class="col-lg-12 col-md-12 col-sm-12">
    <?php
    NavBar::begin([
        'options' => [
            'class' => 'navbar navbar-default t',
        ],
    ]);
    ?>


    <?php
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => [
            ['label' => 'Кузя', 'url' => "/requests/1", 'active' => ("/requests/1" == Yii::$app->request->url || "/requests/1/line" == Yii::$app->request->url)],
            ['label' => 'Альфа', 'url' => "/requests/2", 'active' => ("/requests/2" == Yii::$app->request->url || "/requests/2/line" == Yii::$app->request->url)],
            ['label' => 'NLine', 'url' => "/requests/3", 'active' => ("/requests/3" == Yii::$app->request->url || "/requests/3/line" == Yii::$app->request->url)],
            ['label' => 'Другие', 'url' => "/requests/4", 'active' => ("/requests/4" == Yii::$app->request->url || "/requests/4/line" == Yii::$app->request->url)],
            ['label' => 'Без Сетки', 'url' => "/requests/6", 'active' => ("/requests/6" == Yii::$app->request->url || "/requests/6/line" == Yii::$app->request->url)],
            ['label' => 'Все', 'url' => "/requests/5", 'active' => ("/requests/5" == Yii::$app->request->url || "/requests/5/line" == Yii::$app->request->url)],
            "<li class='batton_position_9'><p ><a class='btn btn-default btn-lg' href='$url_details'> Детальный график </a></p></li>",
           // "<li class='batton_position_10'><p ><a class='btn btn-default btn-lg' href=".$url_table.">Таблица данных</a></p></li>"
        ],
    ]);
    NavBar::end();
    ?>
</div>


<div class="margin-bottom " id='all'></div>

<h3 class="text-center margin-top"><?= $name ?></h3>

<div class="row-fluid">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <?= Html::img("@web/images/$name_file.png", ['class' => 'img-responsive']) ?>
    </div>




    <?php if($line !=1): ?>
        <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 month_details">
            <div class="row-fluid"></div>

            <a href="/requests/<?=$org_id ?>-<?=$start_period ?>">
                <span style="width: <?= $css_data['column_w'] ?>%; margin-left: <?= $css_data['marg'] + $css_data['marg_left']?>%; margin-right: <?= $css_data['marg'] ?>%" class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column "></span>
            </a>

            <?php for($i = ($start_period + 1); $i <($start_period + $years_number); $i++ ): ?>

            <a href="/requests/<?=$org_id ?>-<?=$i ?>">
                <span style="width: <?= $css_data['column_w'] ?>%; margin-left: <?= $css_data['marg'] ?>%; margin-right: <?= $css_data['marg'] ?>%" class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column "></span>
            </a>
            <?php endfor; ?>

        </div>

    <?php endif; ?>





</div>