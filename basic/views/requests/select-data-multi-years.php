<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\ActiveForm;



$url_total = '/requests/5';
$url_table = Yii::$app->request->url . '/table?years='.$year_string.'&requests_type='.$requests_type.'&requests_org='.$requests_org;
$url_years = '/requests/'.$requests_org.'-'.$date_today;


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

        <div class=" col-lg-4 col-md-4 col-sm-4 button-position">
            <?php $model_multi_years_form->years = $years_selected;
            echo $form->field($model_multi_years_form, 'years')
                ->inline()
                ->label(false)
                ->checkboxList($year_array_all, ['class' => 'checkbox_left'])

            ?>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 button-position">
            <?php $model_multi_years_form->requests_org = $requests_org;
            echo $form->field($model_multi_years_form, 'requests_org')->label('Сеть')
                ->dropDownList($org_id_array, ['prompt' => 'Выберите сеть'])?>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 button-position">
            <?php $model_multi_years_form->requests_type = $requests_type;
            echo $form->field($model_multi_years_form, 'requests_type')->label('Тип заявки')
                ->dropDownList($requests_type_array, ['prompt' => 'Выберите состояние заявок'])?>
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
        <!--
        <div class="col-lg-offset-1 col-md-offset-1 col-sm-offset-1    col-lg-2 col-md-2 col-sm-2   button-position" >
            <p ><a class='btn btn-default btn-lg' href="<?= $url_table ?>">Таблица данных</a></p>
        </div>
        -->
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

<h3 class="text-center margin-top"><?= $name ?></h3>

<div class="row-fluid">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <?= Html::img("@web/images/$name_file.png", ['class' => 'img-responsive']) ?>
    </div>

</div>