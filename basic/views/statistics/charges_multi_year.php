<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;


$url_table = Yii::$app->request->url."/table";
$url_years = '/charges/'.$user_type.'-'.$date_today;

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
            ['label' => 'Домашние', 'url' => "/charges/1/$year_string", 'active' => ("/charges/1/$year_string" == Yii::$app->request->url || "/charges/1/$year_string/line" == Yii::$app->request->url)],
            ['label' => 'Бизнес-домосеть', 'url' => "/charges/2/$year_string", 'active' => ("/charges/2/$year_string" == Yii::$app->request->url || "/charges/2/$year_string/line" == Yii::$app->request->url)],
            ['label' => 'Бизнес-магистральные', 'url' => "/charges/3/$year_string", 'active' => ("/charges/3/$year_string" == Yii::$app->request->url || "/charges/3/$year_string/line" == Yii::$app->request->url)],
            ['label' => 'Домосеть', 'url' => "/charges/4/$year_string", 'active' => ("/charges/4/$year_string" == Yii::$app->request->url || "/charges/4/$year_string/line" == Yii::$app->request->url)],
            ['label' => 'Все', 'url' => "/charges/5/$year_string", 'active' => ("/charges/5/$year_string" == Yii::$app->request->url || "/charges/5/$year_string/line" == Yii::$app->request->url)],
            "<li class='batton_position_1'><p ><a class='btn btn-default btn-lg' href='$url_years'> График по месяцам </a></p></li>",
            "<li class='batton_position_2'><p ><a class='btn btn-default btn-lg' href=".$url_table.">Таблица данных</a></p></li>"
        ],
    ]);
    NavBar::end();
    ?>
</div>


<div class="margin-bottom " id='all'></div>

<h3 class="text-center margin-top">Денежный сбор. <?= $name ?> за <?= $year_string ?> годa</h3>

<div class="row-fluid">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <?= Html::img("@web/images/$name_file.png", ['class' => 'img-responsive']) ?>
    </div>

</div>