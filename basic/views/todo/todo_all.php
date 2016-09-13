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
            ['label' => 'Подключения', 'url' => "/todo/1", 'active' => ("/todo/1" == Yii::$app->request->url || "/todo/1/line" == Yii::$app->request->url)],
            ['label' => 'Отключения', 'url' => "/todo/6", 'active' => ("/todo/6" == Yii::$app->request->url || "/todo/6/line" == Yii::$app->request->url)],
            ['label' => 'Обращение в суппорт', 'url' => "/todo/2", 'active' => ("/todo/2" == Yii::$app->request->url || "/todo/2/line" == Yii::$app->request->url)],
            ['label' => 'Вызовы на дом', 'url' => "/todo/3", 'active' => ("/todo/3" == Yii::$app->request->url || "/todo/3/line" == Yii::$app->request->url)],
            ['label' => 'Аварии', 'url' => "/todo/4", 'active' => ("/todo/4" == Yii::$app->request->url || "/todo/4/line" == Yii::$app->request->url)],
            ['label' => 'Админ-аварии', 'url' => "/todo/5", 'active' => ("/todo/5" == Yii::$app->request->url || "/todo/5/line" == Yii::$app->request->url)],
            "<li class='batton_position_5'><p ><a class='btn btn-default btn-lg' href='$url_details'> Детальный график </a></p></li>",
            "<li class='batton_position_6'><p ><a class='btn btn-default btn-lg' href=".$url_table.">Табл. данных</a></p></li>"
        ],
    ]);
    NavBar::end();
    ?>
</div>


<div class="margin-bottom " id='all'></div>

<h3 class="text-center margin-top">Количество заявок. <?= $name ?> за весь период</h3>

<div class="row-fluid">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <?= Html::img("@web/images/$name_file.png", ['class' => 'img-responsive']) ?>
    </div>




    <?php if($line !=1): ?>
        <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 month_details">
            <div class="row-fluid"></div>

            <a href="/todo/<?=$todo_type ?>-<?=$start_period ?>">
                <span style="width: <?= $css_data['column_w'] ?>%; margin-left: <?= $css_data['marg'] + $css_data['marg_left']?>%; margin-right: <?= $css_data['marg'] ?>%" class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column "></span>
            </a>

            <?php for($i = ($start_period + 1); $i <($start_period + $years_number); $i++ ): ?>

            <a href="/todo/<?=$todo_type ?>-<?=$i ?>">
                <span style="width: <?= $css_data['column_w'] ?>%; margin-left: <?= $css_data['marg'] ?>%; margin-right: <?= $css_data['marg'] ?>%" class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column "></span>
            </a>
            <?php endfor; ?>

        </div>

    <?php endif; ?>





</div>