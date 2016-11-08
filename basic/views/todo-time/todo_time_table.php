<?php

use yii\helpers\Html;
use yii\bootstrap;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\components\debugger\Debugger;


if (isset($todo_type) && isset($year) && isset($todo_status)) {
    $url_last_part = $todo_type . '-' . $year . '-' . $todo_status;
    $t_y = '';
    $t_m = '';
    $years_month_day = 3;
} elseif (isset($todo_type) && isset($year)) {
    $url_last_part = $todo_type . '-' . $year;
    $t_y = '';
    $t_m = '';
    $years_month_day = 2;
} elseif (isset($todo_type) && !isset($todo_type_a)) {
    $url_last_part = $todo_type;
    $t_y = '';
    $t_m = '';
    $years_month_day = 1;
} elseif (isset($start_period) && isset($end_period) && isset($todo_type_a)) {
    $url_last_part = 'select-data';
    $years_month_day = 4;
    $t_y = 'за период ' . ($start_year + 2000) . '-01';
    $t_m = ' - ' . ($end_year + 1999) . '-12';
} elseif (isset($year_string) && isset($url_part_2) && $url_part_2 == 'multi-years') {
    $url_last_part = 'multi-years';
    $t_y = 'за года ' . $year_string;
    $t_m = '';
} elseif (isset($year_string) && !isset($url_part_2)) {
    $url_last_part = $todo_type . '/' . $year_string;
    $t_y = 'за года ' . $year_string;
    $t_m = '';
} else {
    $url_last_part = $todo_type;
    $t_y = '';
    $t_m = '';
}
$year_today = Yii::$app->formatter->asDate(time(), 'Y');
$year_month_today = Yii::$app->formatter->asDate('now', 'yyyy-MM');

//Debugger::Eho('</br>');
//Debugger::Eho('</br>');
//Debugger::Eho($years_month_day);
//Debugger::testDie();
?>

<div class="col-lg-12 col-md-12 col-sm-12">
    <?php
    NavBar::begin([
        'options' => [
            'class' => "navbar navbar-default navbar-charges thead_$todo_type",
        ],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => [
            ['label' => 'Вернуться к графику', 'url' => "/todo-time/$url_last_part", 'options' => ['class' => 'ttt']],
            //   ['label' => 'График общий', 'url' => "/charges", 'options' =>['class' => 'ttt']],
            //  ['label' => 'График по месяцам', 'url' => "/todo/$todo_type-$year_today", 'options' => ['class' => 'ttt']],
            //    ['label' => 'График по дням', 'url' => "/charges/$user_type-$year_month_today", 'options' =>['class' => 'ttt']],
        ],
    ]);
    NavBar::end();
    ?>
</div>


<div class="margin-bottom " id='all'></div>

<h3 class="text-center margin-top">Время обработки TODO. <?= $name ?>
    . <?= isset($year) ? 'За ' . $year . ' год ' : $t_y ?>  <?= isset($month) ? $month . ' месяц' : $t_m ?>.
    <?= isset($todo_status) ? 'TODO в статусе - "' . $todo_status_name . '".' : '' ?>

</h3>

<div class="col-lg-12 col-md-12 col-sm-12">
    <?php if (!empty($data)): ?>
        <table class="table table-hover table-responsive">
            <thead class="th">
            <tr class="thead_<?= $todo_type ?>">
                <td><?= $label['ts'] ?></td>

                <td><?= $label['todo_id'] ?></td>

                <td><?= $label['ref_net_id'] ?></td>

                <td><?= $label['todo_state'] ?></td>

                <td><?= $label['subj'] ?></td>

                <td><?= $label['init_time'] ?></td>

                <td><?= $label['upd_time'] ?></td>

                <td><?= $label['mon'] ?></td>

                <td><?= $label['day'] ?></td>

                <td><?= $label['hour'] ?></td>

                <td><?= $label['sum_hour'] ?></td>
            </tr>
            </thead>
            <tbody>
            <?php

            if (!isset($year_string)):
                if ($years_month_day == 2):
                    foreach ($data[(int)str_replace(20, '', $year)] as $key => $val):
                        foreach ($val as $key_m => $val_m):
                            if (is_array($val_m)):
                                ?>

                                <tr>
                                    <td><?= isset($val_m['todo_id']) ? $val_m['todo_id'] : '' ?></td>

                                    <td><?= isset($val_m['init_time']) ? $val_m['init_time'] : '' ?></td>

                                    <td><?= isset($val_m['ref_net_id']) ? $val_m['ref_net_id'] : '' ?></td>

                                    <td><?= isset($val_m['todo_state']) ? $val_m['todo_state'] : '' ?></td>

                                    <td><?= isset($val_m['subj']) ? $val_m['subj'] : '' ?></td>

                                </tr>
                            <?php endif;
                        endforeach; ?>
                        <tr class="thead_<?= $todo_type ?>">
                            <td colspan="5">Количесто TODO за <?= $key ?> месяц = <b><?= $val['count'] ?></b></td>
                        </tr>
                    <?php endforeach;

                elseif ($years_month_day == 3):

                    foreach ($data[(int)str_replace(20, '', $year)] as $key => $val):
                        foreach ($val as $key_item => $val_item):
                            if (is_array($val_item)):
                                ?>
                                <tr>

                                    <td><?= isset($val_item['ts']) ? $val_item['ts'] : '' ?></td>

                                    <td><?= isset($val_item['todo_id']) ? $val_item['todo_id'] : '' ?></td>

                                    <td><?= isset($val_item['ref_net_id']) ? $val_item['ref_net_id'] : '' ?></td>

                                    <td><?= isset($val_item['todo_state']) ? $val_item['todo_state'] : '' ?></td>

                                    <td><?= isset($val_item['subj']) ? $val_item['subj'] : '' ?></td>

                                    <td><?= isset($val_item['init_time']) ? $val_item['init_time'] : '' ?></td>

                                    <td><?= isset($val_item['upd_time']) ? $val_item['upd_time'] : '' ?></td>

                                    <td><?= isset($val_item['mon']) ? $val_item['mon'] : '' ?></td>

                                    <td><?= isset($val_item['day']) ? $val_item['day'] : '' ?></td>

                                    <td><?= isset($val_item['hour']) ? $val_item['hour'] : '' ?></td>

                                    <td><?= isset($val_item['sum_hour']) ? $val_item['sum_hour'] : '' ?></td>

                                </tr>

                            <?php endif;
                        endforeach; ?>

                        <tr class="thead_<?= $todo_type ?>">
                            <td colspan="1">Месяц</td>
                            <td colspan="5">Количество заявок</td>
                            <td colspan="5">Среднее количество часов</td>
                        </tr>
                        <tr class="thead_<?= $todo_type ?>">
                            <td colspan="1"><?= $key ?></td>
                            <td colspan="5"><?= $val['count'] ?></td>
                            <td colspan="5"><?= $val['average_hours'] ?></td>
                        </tr>

                    <?php endforeach;


                elseif ($years_month_day == 1):
                    foreach ($data as $key => $val):

                        foreach ($val as $val_y):
                            if (is_array($val_y)):
                                ?>
                                <tr>
                                    <td><?= isset($val_y['todo_id']) ? $val_y['todo_id'] : '' ?></td>

                                    <td><?= isset($val_y['init_time']) ? $val_y['init_time'] : '' ?></td>

                                    <td><?= isset($val_y['ref_net_id']) ? $val_y['ref_net_id'] : '' ?></td>

                                    <td><?= isset($val_y['todo_state']) ? $val_y['todo_state'] : '' ?></td>

                                    <td><?= isset($val_y['subj']) ? $val_y['subj'] : '' ?></td>

                                </tr>

                            <?php endif;
                        endforeach; ?>

                        <tr class="thead_<?= $todo_type ?>">
                            <td colspan="5">Количесто TODO за <?= $key ?> год = <b><?= $val['count'] ?> </b></td>
                        </tr>

                    <?php endforeach;
                elseif ($years_month_day == 4):

                  //  Debugger::PrintR($data);
                  //  Debugger::testDie();
                    foreach ($data as $key_1 => $val_1):
                        foreach ($val_1 as $key => $val):
                            foreach ($val as $key_item => $val_item):
                                if (is_array($val_item)):
                                    ?>
                                    <tr>

                                        <td><?= isset($val_item['ts']) ? $val_item['ts'] : '' ?></td>

                                        <td><?= isset($val_item['todo_id']) ? $val_item['todo_id'] : '' ?></td>

                                        <td><?= isset($val_item['ref_net_id']) ? $val_item['ref_net_id'] : '' ?></td>

                                        <td><?= isset($val_item['todo_state']) ? $val_item['todo_state'] : '' ?></td>

                                        <td><?= isset($val_item['subj']) ? $val_item['subj'] : '' ?></td>

                                        <td><?= isset($val_item['init_time']) ? $val_item['init_time'] : '' ?></td>

                                        <td><?= isset($val_item['upd_time']) ? $val_item['upd_time'] : '' ?></td>

                                        <td><?= isset($val_item['mon']) ? $val_item['mon'] : '' ?></td>

                                        <td><?= isset($val_item['day']) ? $val_item['day'] : '' ?></td>

                                        <td><?= isset($val_item['hour']) ? $val_item['hour'] : '' ?></td>

                                        <td><?= isset($val_item['sum_hour']) ? $val_item['sum_hour'] : '' ?></td>

                                    </tr>

                                <?php endif;
                            endforeach; ?>

                            <tr class="thead_<?= $todo_type ?>">
                                <td colspan="2">Год / Месяц</td>
                                <td colspan="4">Количество заявок</td>
                                <td colspan="5">Среднее количество часов</td>
                            </tr>
                            <tr class="thead_<?= $todo_type ?>">
                                <td colspan="2"><?= $key_1 + 2000 ?> / <?= $key ?></td>
                                <td colspan="4"><?= $val['count'] ?></td>
                                <td colspan="5"><?= $val['average_hours'] ?></td>
                            </tr>

                        <?php endforeach;
                    endforeach;





                endif;
            else:
                foreach ($data as $key => $val): ?>

                    <tr class="thead_<?= $user_type ?>">
                        <td><?= $key ?></td>
                        <td></td>
                    </tr>

                    <?php foreach ($val as $k => $v): ?>
                        <tr>
                            <td><?= $v['ts'] ?></td>

                            <td><?= $v['pay'] ?></td>

                        </tr>
                        <?php
                    endforeach;
                endforeach; ?>
            <?php endif;
            ?>
            </tbody>
        </table>
    <?php else: ?>
        <div>
            <p>По данному запросу данные отсуттствуют</p>
        </div>
    <?php endif; ?>

</div>
