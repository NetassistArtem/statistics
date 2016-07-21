<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\ActiveForm;



$url_total = '/charges';
$url_table = Yii::$app->request->url . '/table?years='.$year_string.'&user_type='.$user_type;
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

    ]);
    ?>
<div class="row">
    <?php $form = ActiveForm::begin(['id' => 'charges-form', 'options' => ['class' => '']]); ?>

    <div class=" col-lg-6 col-md-6 col-sm-6 button-position">
        <?= $form->field($model_multi_years_form, 'years[]')
            ->inline()
            ->textInput()->label(false)
            ->checkboxList($year_array, ['class' => 'checkbox_left'])

        ?>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 button-position">
        <?= $form->field($model_multi_years_form, 'users_type')->textInput()->label(false)
            ->dropDownList($users_type_a, ['prompt' => 'Выберите тип пользователей', 'options' =>[3=>['selected'=>true]]])?>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-2">
        <div class="form-group button-position">
            <?= Html::submitButton('Получить график', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

    <div class="col-lg-11 col-md-11 col-sm-11">
        <div class="test"></div>
    </div>






    <div class="row">
        <div class="col-lg-offset-1 col-md-offset-1 col-sm-offset-1    col-lg-2 col-md-2 col-sm-2   button-position" >
            <p ><a class='btn btn-default btn-lg' href="<?= $url_table ?>">Таблица данных</a></p>
        </div>
        <div class="col-lg-offset-1 col-md-offset-1 col-sm-offset-1  col-lg-2 col-md-2 col-sm-2 button-position" >
            <p ><a class='btn btn-default btn-lg' href="<?=$url_years ?>">График по месяцам</a></p>
        </div>
        <div class="col-lg-offset-1 col-md-offset-1 col-sm-offset-1  col-lg-2 col-md-2 col-sm-2 button-position" >
            <p ><a class='btn btn-default btn-lg' href="<?= $url_total ?>"> График общий </a></p
        </div>
    </div>








    <?php

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