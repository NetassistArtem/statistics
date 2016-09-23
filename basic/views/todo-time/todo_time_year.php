<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use Yii;
use app;
use app\components\debugger\Debugger;

$url_table = Yii::$app->request->url . "/table";
$url_compare = '/todo/multi-years';
$url_all = '/todo/' . $todo_type;

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
            ['label' => 'Подключения', 'url' => "/todo-time/1-$year-$todo_status", 'active' => ("/todo-time/1-$year-$todo_status" == Yii::$app->request->url || "/todo-time/1-$year-$todo_status/line" == Yii::$app->request->url)],
            ['label' => 'Обращение в суппорт', 'url' => "/todo-time/2-$year-$todo_status", 'active' => ("/todo-time/2-$year-$todo_status" == Yii::$app->request->url || "/todo-time/2-$year-$todo_status/line" == Yii::$app->request->url)],
            ['label' => 'Вызовы на дом', 'url' => "/todo-time/3-$year-$todo_status", 'active' => ("/todo-time/3-$year-$todo_status" == Yii::$app->request->url || "/todo-time/3-$year-$todo_status/line" == Yii::$app->request->url)],
            ['label' => 'Аварии', 'url' => "/todo-time/4-$year-$todo_status", 'active' => ("/todo-time/4-$year-$todo_status" == Yii::$app->request->url || "/todo-time/4-$year-$todo_status/line" == Yii::$app->request->url)],
            ['label' => 'Админ-аварии', 'url' => "/todo-time/5-$year-$todo_status", 'active' => ("/todo-time/5-$year-$todo_status" == Yii::$app->request->url || "/todo-time/5-$year-$todo_status/line" == Yii::$app->request->url)],
            // "<li class='batton_position_5'><p ><a class='btn btn-default btn-lg' href='$url_all'> Общий график </a></p></li>",
            // "<li class='batton_position_6'><p ><a class='btn btn-default btn-lg' href=".$url_table.">Табл. данных</a></p></li>"
        ],
    ]); ?>

    <div class="col-lg-11 col-md-11 col-sm-11", style="background-color: rgb(23,45,56); opacity: 50">
        <div class="test"></div>
    </div>

    <?php

    foreach ($menu_status_todo as $k => $v):
        $r_color = $todo_status_array[$k]['color'][0];
        $g_color = $todo_status_array[$k]['color'][1];
        $b_color = $todo_status_array[$k]['color'][2];
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-left  todo-status-border','style' => "border: 2px solid rgb($r_color,$g_color,$b_color)"],
            'items' => $v,
        ]); ?>

        <?php
    endforeach;
    NavBar::end();
    ?>
</div>


<div class="margin-bottom " id='all'></div>

<h3 class="text-center margin-top">Среднее время обработки TODO.Тип TODO: <?= $name ?>. Статус TODO:
    "<?= $todo_status_name ?>". Период: <?= $year ?> год.</h3>

<div class="row-fluid">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <?= Html::img("@web/images/$name_file.png", ['class' => 'img-responsive']) ?>
    </div>

</div>