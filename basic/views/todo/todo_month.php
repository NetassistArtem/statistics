<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use Yii;
use app;

$url_table = Yii::$app->request->url . "/table";
$url_years = '/todo/' . $todo_type . '-' . $year;
$url_compare = '/todo/multi-years';

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
            ['label' => 'Подключения', 'url' => "/todo/1-$year-$month", 'active' => ("/todo/1-$year-$month" == Yii::$app->request->url || "/todo/1-$year-$month/line" == Yii::$app->request->url)],
            ['label' => 'Отключения', 'url' => "/todo/6-$year-$month", 'active' => ("/todo/6-$year-$month" == Yii::$app->request->url || "/todo/6-$year-$month/line" == Yii::$app->request->url)],
            ['label' => 'Обращение в суппорт', 'url' => "/todo/2-$year-$month", 'active' => ("/todo/2-$year-$month" == Yii::$app->request->url || "/todo/2-$year-$month/line" == Yii::$app->request->url)],
            ['label' => 'Вызовы на дом', 'url' => "/todo/3-$year-$month", 'active' => ("/todo/3-$year-$month" == Yii::$app->request->url || "/todo/3-$year-$month/line" == Yii::$app->request->url)],
            ['label' => 'Аварии', 'url' => "/todo/4-$year-$month", 'active' => ("/todo/4-$year-$month" == Yii::$app->request->url || "/todo/4-$year-$month/line" == Yii::$app->request->url)],
            ['label' => 'Админ-аварии', 'url' => "/todo/5-$year-$month", 'active' => ("/todo/5-$year-$month" == Yii::$app->request->url || "/todo/5-$year-$month/line" == Yii::$app->request->url)],
            "<li class='batton_position_5'><p ><a class='btn btn-default btn-lg' href='$url_years'> График по месяцам </a></p></li>",
            "<li class='batton_position_6'><p ><a class='btn btn-default btn-lg' href=" . $url_table . ">Табл. данных</a></p></li>"


        ],
    ]);
    //echo "<p class='batton_position'><a class=\"btn btn-default btn-lg\" href=\"#\">Таблица данных</a></p>";
    // echo "<p class='batton_position'><a class=\"btn btn-default btn-lg\" href=\"#\">График по годам</a></p>";

    NavBar::end();
    ?>

</div>


<h3 class="text-center margin-top">Количество заявок. <?= $name ?> за <?= $year ?> год <?= $month ?> месяц </h3>

<div class="row-fluid">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <?= Html::img("@web/images/$name_file.png", ['class' => 'img-responsive']) ?>
    </div>
</div>
