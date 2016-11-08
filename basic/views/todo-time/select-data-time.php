<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\ActiveForm;
use app\components\debugger\Debugger;


$url_table = Yii::$app->request->url . "/table?year_start=" . $start_period . '&year_end=' . ($end_period) . '&todo_type=' . $todo_type . '&todo_status=' . $todo_status;
//$url_total = '/todo/2';
//$url_years = '/todo/' . $todo_type . '-' . ($end_year + 1999);
//$url_line = '/todo/select-data/line?todo_type='.$todo_type.'&start_period='.$start_period.'&end_period='.$end_period. '&todo_status=' . $todo_status . '&todo_location=' . $todo_location;

NavBar::begin([
    'options' => [
        'class' => 'navbar navbar-default',
    ],
]);


?>


<div><?php echo Yii::$app->session->has('dateHight') ? Yii::$app->session->getFlash('dateHight')[0] : ''; ?></div>
<div class="row">

    <?php $form = ActiveForm::begin(['id' => 'todo-form', 'options' => ['class' => '']]); ?>

    <div class=" col-lg-2 col-md-2 col-sm-2 button-position">
        <?= $form->field($model_todo_form, 'year_from')->textInput()->label('Начало периода, год')
            ->dropDownList($years_array, ['prompt' => 'Год']) ?>
    </div>

    <div class="col-lg-2 col-md-2 col-sm-2 button-position">
        <?= $form->field($model_todo_form, 'year_to')->textInput()->label('Конец периода, год')
            ->dropDownList($years_array, ['prompt' => 'Год']);

        ?>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-2 button-position">
        <?= $form->field($model_todo_form, 'todo_type')->textInput()->label('Тип TODO')
            ->dropDownList($todo_type_a, ['prompt' => 'Тип TODO']) ?>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-2 button-position">
        <?= $form->field($model_todo_form, 'todo_status')->textInput()->label('Cтатус TODO')
            ->dropDownList($todo_status_a, ['prompt' => 'Статус TODO']) ?>
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
        <div class="  col-lg-2 col-md-2 col-sm-2   button-position">
            <p><a class='btn btn-default btn-lg' href="<?= $url_table ?>">Таблица данных</a></p>
        </div>

        <div class="  col-lg-2 col-md-2 col-sm-2 button-position">

            <?php if ($graph_type == 1): ?>
                <p><a class='btn btn-default btn-lg' href="<?= Yii::$app->request->url ?>/two-columns">График
                        двухколоночный</a></p>
                <?php elseif ($graph_type == 2) : ?>
                <p><a class='btn btn-default btn-lg' href="<?= str_replace('/two-columns', '', Yii::$app->request->url)  ?>">График
                        одноколоночный</a></p>

            <?php endif; ?>
        </div>


    </div>


</div>

<?php
NavBar::end();
?>


<h3 class="text-center">Среднее время обработки TODO. Тип TODO: <?= $name ?>. Статус TODO: "<?= $todo_status_name ?>".
    За период с <?= $start_year + 2000 ?>-01 по
    <?= $end_year + 1999 ?> -12 </h3>

<div class="row-fluid">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <?= Html::img("@web/images/$name_file.png", ['class' => 'img-responsive']) ?>
    </div>
</div>
