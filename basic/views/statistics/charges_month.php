<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use Yii;
use app;

$url_table = Yii::$app->request->url."/table";
$url_years = '/charges/'.$user_type.'-'.$year;

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
        'items' => $menu_items_month,

    ]);
    ?>

    <div class="col-lg-11 col-md-11 col-sm-11">
        <div class="test"></div>
    </div>


    <?php
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => [
            ['label' => 'Домашние', 'url' => "/charges/1-$year-$month", 'active' => ("/charges/1-$year-$month" == Yii::$app->request->url || "/charges/1-$year-$month/line" == Yii::$app->request->url)],
            ['label' => 'Бизнес-домосеть', 'url' => "/charges/2-$year-$month", 'active' => ("/charges/2-$year-$month" == Yii::$app->request->url || "/charges/2-$year-$month/line" == Yii::$app->request->url)],
            ['label' => 'Бизнес-магистральные', 'url' => "/charges/3-$year-$month", 'active' => ("/charges/3-$year-$month" == Yii::$app->request->url || "/charges/3-$year-$month/line" == Yii::$app->request->url)],
            ['label' => 'Домосеть', 'url' => "/charges/4-$year-$month", 'active' => ("/charges/4-$year-$month" == Yii::$app->request->url || "/charges/4-$year-$month/line" == Yii::$app->request->url)],
            ['label' => 'Провайдеры', 'url' => "/charges/6-$year-$month", 'active' => ("/charges/6-$year-$month" == Yii::$app->request->url || "/charges/6-$year-$month/line" == Yii::$app->request->url)],
            ['label' => 'Корпоративы', 'url' => "/charges/7-$year-$month", 'active' => ("/charges/7-$year-$month" == Yii::$app->request->url || "/charges/7-$year-$month/line" == Yii::$app->request->url)],
            ['label' => 'Все', 'url' => "/charges/5-$year-$month", 'active' => ("/charges/5-$year-$month" == Yii::$app->request->url || "/charges/5-$year-$month/line" == Yii::$app->request->url)],
            "<li class='batton_position_1'><p ><a class='btn btn-default btn-lg' href='$url_years'>График по месяцам</a></p></li>",
            "<li class='batton_position_2'><p ><a class='btn btn-default btn-lg' href=".$url_table.">Таблица данных</a></p></li>"

        ],
    ]);
    //echo "<p class='batton_position'><a class=\"btn btn-default btn-lg\" href=\"#\">Таблица данных</a></p>";
   // echo "<p class='batton_position'><a class=\"btn btn-default btn-lg\" href=\"#\">График по годам</a></p>";

    NavBar::end();
    ?>

</div>


<h3 class="text-center margin-top">Денежный сбор. <?= $name ?> за <?= $year ?> год <?= $month ?> месяц </h3>

<div class="row-fluid">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <?= Html::img("@web/images/$name_file.png", ['class' => 'img-responsive']) ?>
    </div>
</div>
