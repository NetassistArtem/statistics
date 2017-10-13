<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\ActiveForm;
use app\components\debugger\Debugger;


$url_table = Yii::$app->request->url . "/table?year_start=" . $start_period . '&year_end=' . ($end_period) . '&org_id=' . $org_id;
$url_total = '/requests/5';
$url_years = '/requests/' . $org_id . '-' . ($end_year + 1999);
//$url_line = '/requests/select-data/line?todo_type='.$todo_type.'&start_period='.$start_period.'&end_period='.$end_period. '&todo_status=' . $todo_status . '&todo_location=' . $todo_location;

NavBar::begin([
    'options' => [
        'class' => 'navbar navbar-default',
    ],
]);


?>

<?php if(Yii::$app->session->has('dateHight')): ?>
<div class="alert alert-danger custom-position-alert"><?=Yii::$app->session->getFlash('dateHight')[0];?></div>
<?php endif; ?>
<div class="row">

    <?php $form = ActiveForm::begin(['id' => 'todo-form', 'options' => ['class' => '']]); ?>

    <div class=" col-lg-2 col-md-2 col-sm-2 button-position">
        <?php $model_requests_form->year_from = $start_year;
        echo  $form->field($model_requests_form, 'year_from')->label('Начало периода, год')
            ->dropDownList($years_array, ['prompt' => 'Год']) ?>
    </div>

    <div class="col-lg-2 col-md-2 col-sm-2 button-position">
        <?php


        $model_requests_form->year_to = ($end_year-1);
        echo $form->field($model_requests_form, 'year_to')->label('Конец периода, год')
            ->dropDownList($years_array, ['prompt' => 'Год']);

        ?>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-2 button-position">
        <?php $model_requests_form->requests_org = $org_id;
        echo $form->field($model_requests_form, 'requests_org')->label('Сеть')
            ->dropDownList($org_id_array, ['prompt' => 'Сеть', 'value' => 1]) ?>
    </div>
    <div class=" col-lg-4 col-md-4 col-sm-4 button-position">
        <?php

        $model_requests_form->requests_type = $selected_requests_type_array;

       // Debugger::PrintR($model_requests_form->requests_type);
        echo $form->field($model_requests_form, 'requests_type')->label(false)->checkboxList($requests_type_array, ['class' => 'checkbox_left'])

        ?>
    </div>

    <div class="col-lg-2 col-md-2 col-sm-2">
        <div class="form-group button-position">
            <?= Html::submitButton('Получить график', ['class' => 'btn btn-primary btn-graf-position']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

    <div class="col-lg-11 col-md-11 col-sm-11">
        <div class="test"></div>
    </div>
    <div class="row">
        <!--
        <div class="  col-lg-2 col-md-2 col-sm-2   button-position batton_position_11">
            <p><a class='btn btn-default btn-lg' href="<?= $url_table ?>">Таблица    данных</a></p>
        </div>
        -->

        <div class="  col-lg-2 col-md-2 col-sm-2 button-position batton_position_12">
            <p><a class='btn btn-default btn-lg' href="<?= $url_years ?>">График по месяцам</a></p>
        </div>

        <div class=" col-lg-2 col-md-2 col-sm-2 button-position batton_position_13">
            <p><a class='btn btn-default btn-lg' href="<?= $url_total ?>"> График общий </a></p>
        </div>



    </div>


</div>

<?php
NavBar::end();
?>


<h3 class="text-center"><?= $name ?></h3>

<div class="row-fluid">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <?= Html::img("@web/images/$name_file.png", ['class' => 'img-responsive']) ?>
    </div>
</div>
