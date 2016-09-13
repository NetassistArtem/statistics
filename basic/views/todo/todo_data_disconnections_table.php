<?php
use yii\helpers\Html;
use yii\bootstrap;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\components\debugger\Debugger;
use Yii;
use app;


if (isset($todo_type) && isset($year) && isset($month)) {
    $url_last_part = $todo_type . '-' . $year . '-' . $month;
    $t_y = '';
    $t_m = '';
    $years_month_day = 3;
} elseif (isset($todo_type) && isset($year) && !isset($todo_type_a)) {
    $url_last_part = $todo_type . '-' . $year;
    $t_y = '';
    $t_m = '';
    $years_month_day = 2;
} elseif (isset($start_period) && isset($end_period) && !isset($years_number) && isset($todo_type_a)) {
    $url_last_part = 'select-data';

    $t_y = 'за период ' . ($start_year + 2000) . '-01';
    $t_m = ' - ' . ($end_year + 1999) . '-12';
    $years_month_day = 4;
} elseif (isset($todo_type)) {
    $url_last_part = $todo_type;
    $t_y = '';
    $t_m = '';
    $years_month_day = 1;
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
            ['label' => 'Вернуться к графику', 'url' => "/todo/$url_last_part", 'options' => ['class' => 'ttt']],
            //   ['label' => 'График общий', 'url' => "/charges", 'options' =>['class' => 'ttt']],
            ['label' => 'График по месяцам', 'url' => "/todo/$todo_type-$year_today", 'options' => ['class' => 'ttt']],
            //    ['label' => 'График по дням', 'url' => "/charges/$user_type-$year_month_today", 'options' =>['class' => 'ttt']],
        ],
    ]);
    NavBar::end();
    ?>
</div>


<div class="margin-bottom " id='all'></div>

<h3 class="text-center margin-top">Количество
    отключений. <?= $name ?> <?= isset($year) ? 'за ' . $year . ' год ' : $t_y ?>  <?= isset($month) ? $month . ' месяц' : $t_m ?>
    <?= isset($todo_status) ? 'TODO в статусе - "'.$todo_status_name.'".' : '' ?>
    <?= isset($todo_location) ? 'Сетка - "'.$todo_location_name.'" ' : ''  ?>
</h3>

<div class="col-lg-12 col-md-12 col-sm-12">
    <?php if (!empty($data)): ?>
        <table class="table table-hover table-responsive">
            <thead class="th">
            <tr class="thead_<?= $todo_type ?>">
                <td><?= $label_disconnection['acc_id'] ?></td>

                <td><?= $label_disconnection['last'] ?></td>

                <td><?= $label_disconnection['user_name'] ?></td>

                <td><?= $label_disconnection['net_id'] ?></td>

                <td><?= $label_disconnection['user_addr'] ?></td>
                <td><?= $label_disconnection['del_mark'] ?></td>
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
                                    <td><?= isset($val_m['acc_id']) ? $val_m['acc_id'] : '' ?></td>

                                    <td><?= isset($val_m['last']) ? $val_m['last'] : '' ?></td>

                                    <td><?= isset($val_m['user_name']) ? $val_m['user_name'] : '' ?></td>

                                    <td><?= isset($val_m['net_id']) ? $val_m['net_id'] : '' ?></td>

                                    <td><?= isset($val_m['user_addr']) ? $val_m['user_addr'] : '' ?></td>

                                    <td><?= isset($val_m['del_mark']) ? $val_m['del_mark'] : '' ?></td>

                                </tr>
                            <?php endif;
                        endforeach; ?>
                        <tr class="thead_<?= $todo_type ?>">
                            <td colspan="6">Количесто отключений за <?= $key ?> месяц = <b><?= $val['count'] ?></b></td>
                        </tr>
                    <?php endforeach;

                elseif ($years_month_day == 3):
                    foreach ($data[(int)str_replace(20, '', $year)][(int)$month] as $key => $val):
                        foreach ($val as $key_d => $val_d):
                            if (is_array($val_d)):
                                ?>
                                <tr>
                                    <td><?= isset($val_d['acc_id']) ? $val_d['acc_id'] : '' ?></td>

                                    <td><?= isset($val_d['last']) ? $val_d['last'] : '' ?></td>

                                    <td><?= isset($val_d['user_name']) ? $val_d['user_name'] : '' ?></td>

                                    <td><?= isset($val_d['net_id']) ? $val_d['net_id'] : '' ?></td>

                                    <td><?= isset($val_d['user_addr']) ? $val_d['user_addr'] : '' ?></td>

                                    <td><?= isset($val_d['del_mark']) ? $val_d['del_mark'] : '' ?></td>

                                </tr>

                            <?php endif;
                        endforeach; ?>

                        <tr class="thead_<?= $todo_type ?>">
                            <td colspan="6">Количесто отключений за <?= $key ?> число <?= $month ?> месяца =
                                <b><?= $val['count'] ?> </b></td>
                        </tr>

                    <?php endforeach;


                elseif ($years_month_day == 1):
                    foreach ($data as $key => $val):
                        foreach ($val as $val_y):
                            if (is_array($val_y)):
                                ?>
                                <tr>
                                    <td><?= isset($val_y['acc_id']) ? $val_y['acc_id'] : '' ?></td>

                                    <td><?= isset($val_y['last']) ? $val_y['last'] : '' ?></td>

                                    <td><?= isset($val_y['user_name']) ? $val_y['user_name'] : '' ?></td>

                                    <td><?= isset($val_y['net_id']) ? $val_y['net_id'] : '' ?></td>

                                    <td><?= isset($val_y['user_addr']) ? $val_y['user_addr'] : '' ?></td>

                                    <td><?= isset($val_y['del_mark']) ? $val_y['del_mark'] : '' ?></td>
                                </tr>

                            <?php endif;
                        endforeach; ?>

                        <tr class="thead_<?= $todo_type ?>">
                            <td colspan="6">Количесто отключений за <?= $key ?> год = <b><?= $val['count'] ?> </b></td>
                        </tr>

                    <?php endforeach;

                elseif ($years_month_day == 4):

                    foreach ($data as $key => $val):
                        foreach ($val as $key_m => $val_m):
                            foreach ($val_m as $key_d => $val_d):

                                if (is_array($val_d)):
                                    ?>
                                    <tr>
                                        <td><?= isset($val_d['acc_id']) ? $val_d['acc_id'] : '' ?></td>

                                        <td><?= isset($val_d['last']) ? $val_d['last'] : '' ?></td>

                                        <td><?= isset($val_d['user_name']) ? $val_d['user_name'] : '' ?></td>

                                        <td><?= isset($val_d['net_id']) ? $val_d['net_id'] : '' ?></td>

                                        <td><?= isset($val_d['user_addr']) ? $val_d['user_addr'] : '' ?></td>

                                        <td><?= isset($val_d['del_mark']) ? $val_d['del_mark'] : '' ?></td>

                                    </tr>

                                <?php endif;
                            endforeach;

                            if ($key_m < 13):
                                ?>

                                <tr class="thead_<?= $todo_type ?>">
                                    <td colspan="6">Количесто TODO (<?= $name ?>) за <?= $key ?> год, <?= $key_m ?> месяц  =
                                        <b><?= $val_m['count'] ?> </b></td>
                                </tr>

                            <?php endif;
                        endforeach;

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