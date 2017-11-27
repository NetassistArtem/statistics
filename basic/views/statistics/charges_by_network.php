<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

?>


<div class="col-lg-12 col-md-12 col-sm-12">
    <?php

    NavBar::begin([
        'options' => [
            'class' => 'navbar navbar-default navbar-charges',
        ],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left '],
        'items' => [
            ['label' => 'Общий график', 'url' => '#all_in_one'],
            ['label' => 'Домашние', 'url' => '#home'],

            ['label' => 'Бизнес-домосеть', 'url' => '#business_homenetwork'],
            ['label' => 'Бизнес-магистральные', 'url' => '#business_trunk'],
            ['label' => 'Провайдеры', 'url' => '#provider'],
            ['label' => 'Домосеть', 'url' => '#homenetwork'],
            ['label' => 'Корпоративы', 'url' => '#corporate'],
            ['label' => 'Все', 'url' => '#all'],
        ],
    ]);
    NavBar::end();
    ?>
</div>

<div id='all_in_one' class="margin-bottom"></div>

<h3 class="text-center ">Денежный сбор - общий график</h3>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <?= Html::img("@web/images/$chart_name_allinone.png", ['class' => 'img-responsive']) ?>
    </div>
</div>

<div id='home' class="margin-bottom"></div>




<?php foreach($data as $k => $v): ?>

<div class="margin-bottom " id="<?= $k ?>"></div>

<div class="row">
    <div class="col-lg-offset-1 col-md-offset-1 col-sm-offset-1    col-lg-2 col-md-2 col-sm-2"><p><a class='btn btn-default btn-lg btn-color-<?=$v['n'] ?>' href="/charges/<?=$v['n'] ?>-<?= $year_now ?>">Детальный график</a></p></div>
    <div class="col-lg-offset-1 col-md-offset-1 col-sm-offset-1   col-lg-5 col-md-5 col-sm-5">
        <h3 class="">Денежный сбор - <?= $v['name'] ?></h3>
    </div>
    <div class=" col-lg-2 col-md-2 col-sm-2"><p><a class='btn btn-default btn-lg' href="/charges/<?=$v['n'] ?>-<?= $year_now ?>/table">Таблица данных</a></p></div>
</div>



<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <?= Html::img("@web/images/{$v['chart_name']}.png", ['class' => 'img-responsive']) ?>
    </div>
</div>

    <?php endforeach; ?>







