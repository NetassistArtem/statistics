<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\ActiveForm;


$url_table = Yii::$app->request->url . "/table?year_start=" . $start_period . '&year_end=' . ($end_period - 1) . '&user_type=' . $user_type;
$url_total = '/charges';
$url_years = '/charges/' . $user_type . '-' . ($end_period + 1999);
$url_compare = '/charges/multi-years';
$url_line = '/charges/select-data/line?user_type='.$user_type.'&start_period='.$start_period.'&end_period='.$end_period;

NavBar::begin([
    'options' => [
        'class' => 'navbar navbar-default',
    ],
]);


?>

<?php if(Yii::$app->session->has('dateHight')): ?>
<div class="alert alert-danger custom-position-alert" ><?=Yii::$app->session->getFlash('dateHight')[0];?></div>
<?php endif; ?>
<div class="row">

    <?php $form = ActiveForm::begin(['id' => 'charges-form', 'options' => ['class' => '']]); ?>

    <div class=" col-lg-offset-1 col-md-offset-1  col-lg-2 col-md-2 col-sm-2 button-position">
        <?= $form->field($model_charges_form, 'year_from')->textInput()->label(false)
            ->dropDownList($years_array, ['prompt' => 'Начало периода, год']) ?>
    </div>

    <div class="col-lg-2 col-md-2 col-sm-2 button-position">
        <?= $form->field($model_charges_form, 'year_to')->textInput()->label(false)
            ->dropDownList($years_array, ['prompt' => 'Конец периода, год', 'options' => [($end_period-1) => ['selected' => true]]]);

        ?>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 button-position">
        <?= $form->field($model_charges_form, 'users_type')->textInput()->label(false)
            ->dropDownList($users_type_a, ['prompt' => 'Выберите тип пользователей']) ?>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-2">
        <div class="form-group button-position">
            <?= Html::submitButton('Получить график', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

    <div class="col-lg-11 col-md-11 col-sm-11">
        <div class="test"></div>
    </div>
    <div class="row">
        <div class="  col-lg-2 col-md-2 col-sm-2   button-position">
            <p><a class='btn btn-default btn-lg' href="<?= $url_table ?>">Таблица    данных</a></p>
        </div>

        <div class="  col-lg-2 col-md-2 col-sm-2 button-position">
            <p><a class='btn btn-default btn-lg' href="<?= $url_years ?>">График по месяцам</a></p>
        </div>

        <div class="col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-lg-2 col-md-2 col-sm-2 button-position">
            <p><a class='btn btn-default btn-lg' href="<?= $url_total ?>"> График общий </a></p>
        </div>

        <div class=" col-lg-1 col-md-1 col-sm-1 button-position">
            <p><a class='btn btn-default btn-lg' href="<?= $url_compare ?>"> График сравнения </a></p>
        </div>

        <div class="col-lg-offset-1 col-md-offset-1 col-sm-offset-1  col-lg-1 col-md-1 col-sm-1 button-position">
            <p><a class='btn btn-default btn-lg' href="<?= $url_line ?>"> Линейный график </a></p>
        </div>


    </div>


</div>

<?php
NavBar::end();
?>


<h3 class="text-center">Денежный сбор. <?= $name ?> за период с <?= $start_period + 2000 ?>-01 по
    <?= $end_period + 1999 ?> -12 </h3>

<div class="row-fluid">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <?= Html::img("@web/images/$name_file.png", ['class' => 'img-responsive']) ?>
    </div>
</div>
