<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use Yii;
use app;

$url_table = Yii::$app->request->url."/table";
$url_compare = '/charges/multi-years';

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
            ['label' => 'Домашние', 'url' => "/charges/1-$year", 'active' => ("/charges/1-$year" == Yii::$app->request->url || "/charges/1-$year/line" == Yii::$app->request->url)],
            ['label' => 'Бизнес-домосеть', 'url' => "/charges/2-$year", 'active' => ("/charges/2-$year" == Yii::$app->request->url || "/charges/2-$year/line" == Yii::$app->request->url)],
            ['label' => 'Бизнес-магистральные', 'url' => "/charges/3-$year", 'active' => ("/charges/3-$year" == Yii::$app->request->url || "/charges/3-$year/line" == Yii::$app->request->url)],
            ['label' => 'Домосеть', 'url' => "/charges/4-$year", 'active' => ("/charges/4-$year" == Yii::$app->request->url || "/charges/4-$year/line" == Yii::$app->request->url)],
            ['label' => 'Провайдеры', 'url' => "/charges/6-$year", 'active' => ("/charges/6-$year" == Yii::$app->request->url || "/charges/6-$year/line" == Yii::$app->request->url)],
            ['label' => 'Корпоративы', 'url' => "/charges/7-$year", 'active' => ("/charges/7-$year" == Yii::$app->request->url || "/charges/7-$year/line" == Yii::$app->request->url)],
            ['label' => 'Все', 'url' => "/charges/5-$year", 'active' => ("/charges/5-$year" == Yii::$app->request->url || "/charges/5-$year/line" == Yii::$app->request->url)],
            "<li class='batton_position_1'><p ><a class='btn btn-default btn-lg' href='$url_compare'> График сравнения </a></p></li>",
            "<li class='batton_position_2'><p ><a class='btn btn-default btn-lg' href=".$url_table.">Таблица данных</a></p></li>"
        ],
    ]);
    NavBar::end();
    ?>
</div>


<div class="margin-bottom " id='all'></div>

<h3 class="text-center margin-top">Денежный сбор. <?= $name ?> за <?= $year ?> год</h3>

<div class="row-fluid">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <?= Html::img("@web/images/$name_file.png", ['class' => 'img-responsive']) ?>
    </div>
<?php if($line !=1): ?>
        <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 month_details">
            <div class="row-fluid"></div>
            <a href="/charges/<?=$user_type ?>-<?=$year ?>-01">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column month_column_left"></span>
            </a>
            <a href="/charges/<?=$user_type ?>-<?=$year ?>-02">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column"></span>
            </a>
            <a href="/charges/<?=$user_type ?>-<?=$year ?>-03">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column"></span>
            </a>
            <a href="/charges/<?=$user_type ?>-<?=$year ?>-04">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column"></span>
            </a>
            <a href="/charges/<?=$user_type ?>-<?=$year ?>-05">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column"></span>
            </a>
            <a href="/charges/<?=$user_type ?>-<?=$year ?>-06">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column"></span>
            </a>
            <a href="/charges/<?=$user_type ?>-<?=$year ?>-07">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column"></span>
            </a>
            <a href="/charges/<?=$user_type ?>-<?=$year ?>-08">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column"></span>
            </a>
            <a href="/charges/<?=$user_type ?>-<?=$year ?>-09">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column"></span>
            </a>
            <a href="/charges/<?=$user_type ?>-<?=$year ?>-10">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column month_column_right"></span>
            </a>
            <a href="/charges/<?=$user_type ?>-<?=$year ?>-11">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column"></span>
            </a>
            <a href="/charges/<?=$user_type ?>-<?=$year ?>-12">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column month_column_right"></span>
            </a>
        </div>

<?php endif ?>
</div>

