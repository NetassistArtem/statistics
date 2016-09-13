<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use Yii;
use app;

$url_table = Yii::$app->request->url."/table";
$url_compare = '/todo/multi-years';
$url_all = '/todo/'.$todo_type;

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
            ['label' => 'Подключения', 'url' => "/todo/1-$year", 'active' => ("/todo/1-$year" == Yii::$app->request->url || "/todo/1-$year/line" == Yii::$app->request->url)],
            ['label' => 'Отключения', 'url' => "/todo/6-$year", 'active' => ("/todo/6-$year" == Yii::$app->request->url || "/todo/6-$year/line" == Yii::$app->request->url)],
            ['label' => 'Обращение в суппорт', 'url' => "/todo/2-$year", 'active' => ("/todo/2-$year" == Yii::$app->request->url || "/todo/2-$year/line" == Yii::$app->request->url)],
            ['label' => 'Вызовы на дом', 'url' => "/todo/3-$year", 'active' => ("/todo/3-$year" == Yii::$app->request->url || "/todo/3-$year/line" == Yii::$app->request->url)],
            ['label' => 'Аварии', 'url' => "/todo/4-$year", 'active' => ("/todo/4-$year" == Yii::$app->request->url || "/todo/4-$year/line" == Yii::$app->request->url)],
            ['label' => 'Админ-аварии', 'url' => "/todo/5-$year", 'active' => ("/todo/5-$year" == Yii::$app->request->url || "/todo/5-$year/line" == Yii::$app->request->url)],
            "<li class='batton_position_5'><p ><a class='btn btn-default btn-lg' href='$url_all'> Общий график </a></p></li>",
            "<li class='batton_position_6'><p ><a class='btn btn-default btn-lg' href=".$url_table.">Табл. данных</a></p></li>"
        ],
    ]);
    NavBar::end();
    ?>
</div>


<div class="margin-bottom " id='all'></div>

<h3 class="text-center margin-top">Количество заявок. <?= $name ?> за <?= $year ?> год</h3>

<div class="row-fluid">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <?= Html::img("@web/images/$name_file.png", ['class' => 'img-responsive']) ?>
    </div>
<?php if($line !=1): ?>
        <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 month_details">
            <div class="row-fluid"></div>
            <a href="/todo/<?=$todo_type ?>-<?=$year ?>-01">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column month_column_left"></span>
            </a>
            <a href="/todo/<?=$todo_type ?>-<?=$year ?>-02">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column"></span>
            </a>
            <a href="/todo/<?=$todo_type ?>-<?=$year ?>-03">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column"></span>
            </a>
            <a href="/todo/<?=$todo_type ?>-<?=$year ?>-04">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column"></span>
            </a>
            <a href="/todo/<?=$todo_type ?>-<?=$year ?>-05">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column"></span>
            </a>
            <a href="/todo/<?=$todo_type ?>-<?=$year ?>-06">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column"></span>
            </a>
            <a href="/todo/<?=$todo_type ?>-<?=$year ?>-07">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column"></span>
            </a>
            <a href="/todo/<?=$todo_type ?>-<?=$year ?>-08">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column"></span>
            </a>
            <a href="/todo/<?=$todo_type ?>-<?=$year ?>-09">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column"></span>
            </a>
            <a href="/todo/<?=$todo_type ?>-<?=$year ?>-10">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column month_column_right"></span>
            </a>
            <a href="/todo/<?=$todo_type ?>-<?=$year ?>-11">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column"></span>
            </a>
            <a href="/todo/<?=$todo_type ?>-<?=$year ?>-12">
                <span class="col-lg-1 col-md-1 col-sm-1 col-xs-1 month_column month_column_right"></span>
            </a>
        </div>

<?php endif; ?>
</div>

