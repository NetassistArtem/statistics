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
            ['label' => 'Домосеть', 'url' => '#homenetwork'],
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

<div class="row">
    <div class="col-lg-offset-1 col-md-offset-1 col-sm-offset-1    col-lg-2 col-md-2 col-sm-2"><p><a class='btn btn-default btn-lg btn-color-1' href="/charges/1-2016">Детальный график</a></p></div>
    <div class="col-lg-offset-1 col-md-offset-1 col-sm-offset-1   col-lg-5 col-md-5 col-sm-5">
        <h3 class="">Денежный сбор - домашние абоненты</h3>
    </div>
    <div class=" col-lg-2 col-md-2 col-sm-2"><p><a class='btn btn-default btn-lg' href="/charges/1-2016/table">Таблица данных</a></p></div>
</div>

<div class="row">

    <div class="col-lg-12 col-md-12 col-sm-12">
        <?= Html::img("@web/images/$chart_name_home.png", ['class' => 'img-responsive']) ?>
    </div>
</div>
<div class="margin-bottom " id='business_homenetwork'></div>

<div class="row">
    <div class=" col-lg-2 col-md-2 col-sm-2"><p><a class='btn btn-default btn-lg btn-color-2' href="/charges/2-2016">Детальный график</a></p></div>
    <div class="col-lg-offset-1 col-md-offset-1 col-sm-offset-1  col-lg-7 col-md-7 col-sm-7">
        <h3 class="">Денежный сбор - бизнес абоненты с домосетью</h3>
    </div>
    <div class=" col-lg-1 col-md-1 col-sm-1"><p><a class='btn btn-default btn-lg' href="/charges/2-2016/table">Таблица данных</a></p></div>
</div>



<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <?= Html::img("@web/images/$chart_name_business_homenetwork.png", ['class' => 'img-responsive']) ?>
    </div>
</div>

<div class="margin-bottom " id='business_trunk'></div>

<div class="row">
    <div class="   col-lg-2 col-md-2 col-sm-2"><p><a class='btn btn-default btn-lg btn-color-3' href="/charges/3-2016">Детальный график</a></p></div>
    <div class=" col-lg-offset-1 col-md-offset-1 col-sm-offset-1  col-lg-7 col-md-7 col-sm-7">
        <h3 class="">Денежный сбор - магистральные бизнес абоненты</h3>
    </div>
    <div class="  col-lg-1 col-md-1 col-sm-1"><p><a class='btn btn-default btn-lg' href="/charges/3-2016/table">Таблица данных</a></p></div>
</div>



<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <?= Html::img("@web/images/$chart_name_business_trunk.png", ['class' => 'img-responsive']) ?>
    </div>
</div>

<div class="margin-bottom " id='homenetwork'></div>

<div class="row">
    <div class="col-lg-offset-1 col-md-offset-1 col-sm-offset-1    col-lg-2 col-md-2 col-sm-2"><p><a class='btn btn-default btn-lg btn-color-4' href="/charges/4-2016">Детальный график</a></p></div>
    <div class="col-lg-offset-1 col-md-offset-1 col-sm-offset-1   col-lg-5 col-md-5 col-sm-5">
        <h3 class="">Денежный сбор - абонентов домосети</h3>
    </div>
    <div class=" col-lg-2 col-md-2 col-sm-2"><p><a class='btn btn-default btn-lg' href="/charges/4-2016/table">Таблица данных</a></p></div>
</div>



<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <?= Html::img("@web/images/$chart_name_homenetwork.png", ['class' => 'img-responsive']) ?>
    </div>
</div>

<div class="margin-bottom " id='all'></div>

<div class="row">
    <div class="col-lg-offset-1 col-md-offset-1 col-sm-offset-1    col-lg-2 col-md-2 col-sm-2"><p><a class='btn btn-default btn-lg btn-color-5' href="/charges/5-2016">Детальный график</a></p></div>
    <div class="col-lg-offset-1 col-md-offset-1 col-sm-offset-1   col-lg-5 col-md-5 col-sm-5">
        <h3 class="">Денежный сбор - все абоненты</h3>
    </div>
    <div class=" col-lg-2 col-md-2 col-sm-2"><p><a class='btn btn-default btn-lg' href="/charges/5-2016/table">Таблица данных</a></p></div>
</div>



<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <?= Html::img("@web/images/$chart_name_all.png", ['class' => 'img-responsive']) ?>
    </div>
</div>







