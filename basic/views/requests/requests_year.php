<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use Yii;
use app;

$url_table = Yii::$app->request->url."/table";
$url_compare = '/requests/multi-years';
$url_all = '/requests/'.$org_id;

?>

<div class="col-lg-12 col-md-12 col-sm-12">
    <?php
    NavBar::begin([
        'options' => [
            'class' => 'navbar navbar-default t',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left '],
        'items' => $menu_items_years,

    ]);
    ?>

    <div class="col-lg-11 col-md-11 col-sm-11">
        <div class="test"></div>
    </div>


    <?php
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => [
            ['label' => 'Кузя', 'url' => "/requests/1-$year", 'active' => ("/requests/1-$year" == Yii::$app->request->url || "/requests/1-$year/line" == Yii::$app->request->url)],
            ['label' => 'Альфа', 'url' => "/requests/2-$year", 'active' => ("/requests/2-$year" == Yii::$app->request->url || "/requests/2-$year/line" == Yii::$app->request->url)],
            ['label' => 'NLine', 'url' => "/requests/3-$year", 'active' => ("/requests/3-$year" == Yii::$app->request->url || "/requests/3-$year/line" == Yii::$app->request->url)],
            ['label' => 'Другие', 'url' => "/requests/4-$year", 'active' => ("/requests/4-$year" == Yii::$app->request->url || "/requests/4-$year/line" == Yii::$app->request->url)],
            ['label' => 'Без Сетки', 'url' => "/requests/6-$year", 'active' => ("/requests/6-$year" == Yii::$app->request->url || "/requests/6-$year/line" == Yii::$app->request->url)],

            "<li class='batton_position_9'><p ><a class='btn btn-default btn-lg' href='$url_all'> Общий график </a></p></li>",
           // "<li class='batton_position_10'><p ><a class='btn btn-default btn-lg' href=".$url_table.">Таблица данных</a></p></li>"
        ],
    ]);
    NavBar::end();
    ?>
</div>


<div class="margin-bottom " id='all'></div>

<h3 class="text-center margin-top"><?= $name ?> </h3>

<div class="row-fluid">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <?= Html::img("@web/images/$name_file.png", ['class' => 'img-responsive']) ?>
    </div>
    <?php if($line !=1): ?>
        <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 month_details">
            <div class="row-fluid"></div>
            <a href="/requests/<?=$org_id ?>-<?=$year ?>-01">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column_2 month_column_left_2"></span>
            </a>
            <a href="/requests/<?=$org_id ?>-<?=$year ?>-02">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column_2"></span>
            </a>
            <a href="/requests/<?=$org_id ?>-<?=$year ?>-03">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column_2"></span>
            </a>
            <a href="/requests/<?=$org_id ?>-<?=$year ?>-04">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column_2"></span>
            </a>
            <a href="/requests/<?=$org_id ?>-<?=$year ?>-05">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column_2"></span>
            </a>
            <a href="/requests/<?=$org_id ?>-<?=$year ?>-06">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column_2"></span>
            </a>
            <a href="/requests/<?=$org_id ?>-<?=$year ?>-07">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column_2"></span>
            </a>
            <a href="/requests/<?=$org_id ?>-<?=$year ?>-08">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column_2"></span>
            </a>
            <a href="/requests/<?=$org_id ?>-<?=$year ?>-09">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column_2"></span>
            </a>
            <a href="/requests/<?=$org_id ?>-<?=$year ?>-10">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column_2 month_column_right_2"></span>
            </a>
            <a href="/requests/<?=$org_id ?>-<?=$year ?>-11">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column_2"></span>
            </a>
            <a href="/requests/<?=$org_id ?>-<?=$year ?>-12">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column_2 month_column_right_2"></span>
            </a>
        </div>

    <?php endif; ?>
</div>

