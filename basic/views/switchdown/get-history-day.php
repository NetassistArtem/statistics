<?php
use yii\helpers\Html;
use yii\bootstrap;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\components\debugger\Debugger;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;


$year_n = $year ?  $year ." год " : '';
$month_n = $month ?  $month ." месяц " : '';
$day_n = $day ?  $day ." день " : '';
$filter = $time_post ? " Время в состоянии down больше ". $time_post .' '. $units_array[$unit_post]  : '';

$this->title = "История падения свичей. Данные за ".$year_n. $month_n . $day_n.". ". $filter;
if($n_date == 8){
    $this->title = 'История падения свичей. Данные за период  c '.$date_from_1 . ' по ' . $date_to_1 . $filter;
}
//$year_today = Yii::$app->formatter->asDate(time(), 'Y');
//$year_month_today = Yii::$app->formatter->asDate('now', 'yyyy-MM');
?>


<div class="col-lg-12 col-md-12 col-sm-12">
    <ul class="nav nav-tabs">
        <li role="presentation" class="<?= $n_date == 1 ? 'active' : '' ?>"  ><a href="/switchdown/get-history/<?= $year_now ?>">Данные по годам</a></li>
        <li role="presentation" class="<?= $n_date == 2 ? 'active' : '' ?>" ><a href="/switchdown/get-history/<?= $year_month_now ?>">Данные по месяцам</a></li>
        <li role="presentation" class="<?= $n_date == 3 ? 'active' : '' ?>" ><a href="/switchdown/get-history/<?= $year_month_day_now ?>">Данные по дням</a></li>
        <li role="presentation" class="<?= $n_date == 4 ? 'active' : '' ?>" ><a href="/switchdown/get-history/from-<?= $year_month_day_period_start ?>-to-<?= $year_month_day_now ?>">Данные с выбором периода</a></li>
    </ul>



    <?php
    NavBar::begin([
        'options' => [
            'class' => 'navbar navbar-default t',
        ],
    ]);
    if($n_date == 1): ?>
    <div class="row">

            <?php $form = ActiveForm::begin(['id' => 'charges-form', 'options' => ['class' => '']]); ?>

    <div class=" col-lg-2 col-md-2 col-sm-2 button-position">
        <?php $modelSwitchdownYearMonthForm->year = $year;
        echo $form->field($modelSwitchdownYearMonthForm, 'year')->textInput()->label('Год')
            ->dropDownList($years_array, ['prompt' => 'год'])
        ?>
    </div>
        <div class=" col-lg-5 col-md-5 col-sm-5 button-position margin-bottom-3 time-filter-block" >
            <p>Фильтр, время в состоянии DOWN. <span class="custom-legend glyphicon glyphicon-info-sign" data-title="Будут отображаться данные где down time будет меньше указанного значения фильтра. НЕ относится к суммарному времени падения за период!"></span></p>
            <!-- <p>Будут отображаться данные где down time будет меньше указанного значения фильтра</p> -->
            <div class=" col-lg-7 col-md-7 col-sm-7 button-position">
                <?php
                echo $form->field($modelSwitchdownYearMonthForm, 'time')->input('number',['prompt' => 'введите значение', 'min' => '1'])->label('Время в состоянии down')

                ?>
            </div>

            <div class="col-lg-5 col-md-5 col-sm-5 button-position">
                <?php
                echo $form->field($modelSwitchdownYearMonthForm, 'unit')->textInput()->label('Единици измерения')
                    ->dropDownList($units_array)
                ?>
            </div>
        </div>


    <div class="col-lg-2 col-md-2 col-sm-2">
        <div class="form-group button-position">
            <?= Html::submitButton('Получить данные', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>


        <?php

      elseif($n_date == 2): ?>
        <div class="row">

            <?php $form = ActiveForm::begin(['id' => 'charges-form', 'options' => ['class' => '']]); ?>

            <div class=" col-lg-2 col-md-2 col-sm-2 button-position">
                <?php $modelSwitchdownYearMonthForm->year = $year;
               echo $form->field($modelSwitchdownYearMonthForm, 'year')->textInput()->label('Год')
                    ->dropDownList($years_array, ['prompt' => 'год'])
                     ?>
            </div>
            <div class="  col-lg-2 col-md-2 col-sm-2 button-position">
                <?php
                $modelSwitchdownYearMonthForm->month = $month;
                echo $form->field($modelSwitchdownYearMonthForm, 'month')->textInput()->label('Месяц')
                    ->dropDownList($months_array, ['prompt' => 'месяц'])
                ?>
            </div>

            <div class=" col-lg-5 col-md-5 col-sm-5 button-position margin-bottom-3 time-filter-block" >
                <p>Фильтр, время в состоянии DOWN. <span class="custom-legend glyphicon glyphicon-info-sign" data-title="Будут отображаться данные где down time будет меньше указанного значения фильтра. НЕ относится к суммарному времени падения за период!"></span></p>
               <!-- <p>Будут отображаться данные где down time будет меньше указанного значения фильтра</p> -->
                <div class=" col-lg-7 col-md-7 col-sm-7 button-position">
                    <?php
                    echo $form->field($modelSwitchdownYearMonthForm, 'time')->input('number',['prompt' => 'введите значение', 'min' => '1'])->label('Время в состоянии down')

                    ?>
                </div>

                <div class="col-lg-5 col-md-5 col-sm-5 button-position">
                    <?php
                    echo $form->field($modelSwitchdownYearMonthForm, 'unit')->textInput()->label('Единици измерения')
                        ->dropDownList($units_array)
                    ?>
                </div>
            </div>



            <div class="col-lg-2 col-md-2 col-sm-2">
                <div class="form-group button-position">
                    <?= Html::submitButton('Получить данные', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>

        </div>














        <?php
    elseif($n_date == 3):?>
        <div class="row">

            <?php $form = ActiveForm::begin(['id' => 'charges-form', 'options' => ['class' => '']]); ?>

            <div class=" col-lg-2 col-md-2 col-sm-2 button-position">
                <?php $modelSwitchdownYearMonthForm->year = $date_1;
                echo $form->field($modelSwitchdownYearMonthForm, 'year')->input('date')->label('День')

                ?>
            </div>
            <div class=" col-lg-5 col-md-5 col-sm-5 button-position margin-bottom-3 time-filter-block" >
                <p>Фильтр, время в состоянии DOWN. <span class="custom-legend glyphicon glyphicon-info-sign" data-title="Будут отображаться данные где down time будет меньше указанного значения фильтра. НЕ относится к суммарному времени падения за период!"></span></p>
                <!-- <p>Будут отображаться данные где down time будет меньше указанного значения фильтра</p> -->
                <div class=" col-lg-7 col-md-7 col-sm-7 button-position">
                    <?php
                    echo $form->field($modelSwitchdownYearMonthForm, 'time')->input('number',['prompt' => 'введите значение', 'min' => '1'])->label('Время в состоянии down')

                    ?>
                </div>

                <div class="col-lg-5 col-md-5 col-sm-5 button-position">
                    <?php
                    echo $form->field($modelSwitchdownYearMonthForm, 'unit')->textInput()->label('Единици измерения')
                        ->dropDownList($units_array)
                    ?>
                </div>
            </div>


            <div class="col-lg-2 col-md-2 col-sm-2">
                <div class="form-group button-position">
                    <?= Html::submitButton('Получить данные', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>

        </div>






        <?php
    elseif($n_date == 8):?>
        <div class="row">

            <?php $form = ActiveForm::begin(['id' => 'charges-form', 'options' => ['class' => '']]); ?>

            <div class=" col-lg-2 col-md-2 col-sm-2 button-position">
                <?php $modelSwitchdownYearMonthForm->date_from = $date_from_1;
                echo $form->field($modelSwitchdownYearMonthForm, 'date_from')->input('date')->label('Начало периода')

                ?>
            </div>
            <div class=" col-lg-2 col-md-2 col-sm-2 button-position">
                <?php $modelSwitchdownYearMonthForm->date_to = $date_to_1;
                echo $form->field($modelSwitchdownYearMonthForm, 'date_to')->input('date')->label('Окончание периода')

                ?>
            </div>
            <div class=" col-lg-5 col-md-5 col-sm-5 button-position margin-bottom-3 time-filter-block" >
                <p>Фильтр, время в состоянии DOWN. <span class="custom-legend glyphicon glyphicon-info-sign" data-title="Будут отображаться данные где down time будет меньше указанного значения фильтра. НЕ относится к суммарному времени падения за период!"></span></p>
                <!-- <p>Будут отображаться данные где down time будет меньше указанного значения фильтра</p> -->
                <div class=" col-lg-7 col-md-7 col-sm-7 button-position">
                    <?php
                    echo $form->field($modelSwitchdownYearMonthForm, 'time')->input('number',['prompt' => 'введите значение', 'min' => '1'])->label('Время в состоянии down')

                    ?>
                </div>

                <div class="col-lg-5 col-md-5 col-sm-5 button-position">
                    <?php
                    echo $form->field($modelSwitchdownYearMonthForm, 'unit')->textInput()->label('Единици измерения')
                        ->dropDownList($units_array)
                    ?>
                </div>
            </div>


            <div class="col-lg-2 col-md-2 col-sm-2">
                <div class="form-group button-position">
                    <?= Html::submitButton('Получить данные', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>

        </div>








    <?php else:
        echo 'test2';
    endif;

    ?>




    <?php

    NavBar::end();
    ?>
</div>
























<div class="site-about">
    <h3><?= Html::encode($this->title) ?></h3>
    <div class="alert alert-success" role="alert">Для просмотра детальной информации, кликнуть на интересующую строку</div>
    <p></p>




    <div class="col-lg-12 col-md-12 col-sm-12">
        <table class="table table-bordered table-hover table-responsive">
            <thead class="th">
            <tr class="tr-color-3" >
                <th>№</th>
                <th>id в биллинге</th>
                <th>Адрес</th>
                <th>ip адрес</th>
                <th>Имя оборудования</th>
                <th>Модель оборудования</th>
                <th>Количество падений за период</th>
                <th>Общее время в DOWN за период, мин/часы/дни</th>
            </tr>

            </thead>
            <tbody>
            <?php foreach($data as $k => $v): ?>
                <tr data-toggle="collapse" data-target="#tr_switch_down_<?= $k ?>" >
                    <td><?= $k+1 ?> </td>
                    <td><?= $v['billing_id']?></td>
                    <td><?= $v['sw_addr'] ?></td>
                    <td><?= $v['ip_address'] ?></td>
                    <td><?= $v['sw_name'] ?></td>
                    <td><?= $v['sw_model'] ?></td>
                    <td><?= $v['n_down'] ?> </td>
                    <td>
                        <?= round(($v['duration_total'])/60 , 1 ) ?> минут <br>
                        <?= round(($v['duration_total'])/3600 , 1)  ?> часов <br>
                    </td>

                </tr>
                <tr id="tr_switch_down_<?= $k ?>" class="collapse tr-color-1">
                    <td colspan="8" >
                        <table class="table table-bordered table-responsive table-custom-1" >
                            <thead>
                            <tr class="tr-color-2" >
                                <th>№</th>
                                <th>Время падения</th>
                                <th>Время восстановления</th>
                                <th>Время в DOWN, сек</th>
                                <th>Сообщение</th>
                            </tr>
                            </thead>
                            <tbody>
                <?php
                $i=1;
                foreach($v['start_time'] as $key => $val): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= $v['start_time'][$key] ?></td>
                        <td><?= $v['end_time'][$key] ?></td>
                        <td>
                            <?= $v['duration_sec'][$key] ?> секунды <br>
                            <?= round(($v['duration_sec'][$key])/60 , 1 ) ?> минут <br>
                            <?= round(($v['duration_sec'][$key])/3600 , 1)  ?> часов <br>

                        </td>
                        <td><?= $v['output'][$key] ?></td>
                    </tr>
                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </td>
                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>
    </div>


    <div class="col-lg-12 col-md-12 col-sm-12 pagination-custom">
        <?php echo LinkPager::widget([
            'pagination' => $pages,
        ]); ?>

    </div>


</div>