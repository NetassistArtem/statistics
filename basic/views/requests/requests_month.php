<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use Yii;
use app;

$url_table = Yii::$app->request->url . "/table";
$url_years = '/requests/' . $org_id . '-' . $year;
$url_compare = '/requests/multi-years';

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
            ['label' => 'Кузя', 'url' => "/requests/1-$year-$month", 'active' => ("/requests/1-$year-$month" == Yii::$app->request->url || "/requests/1-$year-$month/line" == Yii::$app->request->url)],
            ['label' => 'Альфа', 'url' => "/requests/2-$year-$month", 'active' => ("/requests/2-$year-$month" == Yii::$app->request->url || "/requests/2-$year-$month/line" == Yii::$app->request->url)],
            ['label' => 'NLine', 'url' => "/requests/3-$year-$month", 'active' => ("/requests/3-$year-$month" == Yii::$app->request->url || "/requests/3-$year-$month/line" == Yii::$app->request->url)],
            ['label' => 'Другие', 'url' => "/requests/4-$year-$month", 'active' => ("/requests/4-$year-$month" == Yii::$app->request->url || "/requests/4-$year-$month/line" == Yii::$app->request->url)],
            ['label' => 'Без Сетки', 'url' => "/requests/6-$year-$month", 'active' => ("/requests/6-$year-$month" == Yii::$app->request->url || "/requests/6-$year-$month/line" == Yii::$app->request->url)],

            "<li class='batton_position_9'><p ><a class='btn btn-default btn-lg' href='$url_years'> График по месяцам </a></p></li>",
          //  "<li class='batton_position_10'><p ><a class='btn btn-default btn-lg' href=".$url_table.">Таблица данных</a></p></li>"
        ],
    ]);
    //echo "<p class='batton_position'><a class=\"btn btn-default btn-lg\" href=\"#\">Таблица данных</a></p>";
    // echo "<p class='batton_position'><a class=\"btn btn-default btn-lg\" href=\"#\">График по годам</a></p>";

    NavBar::end();
    ?>

</div>


<h3 class="text-center margin-top"><?= $name ?></h3>

<div class="row-fluid">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <?= Html::img("@web/images/$name_file.png", ['class' => 'img-responsive']) ?>
    </div>
</div>
