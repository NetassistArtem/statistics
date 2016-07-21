<?php
use yii\helpers\Html;
use yii\bootstrap;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use Yii;
use app;


if(isset($user_type) && isset($year) && isset($month)){
    $url_last_part = $user_type.'-'.$year.'-'.$month;
    $t_y = '';
    $t_m = '';
}elseif(isset($user_type) && isset($year)) {
    $url_last_part = $user_type . '-' . $year;
    $t_y = '';
    $t_m = '';
}elseif(isset($start_period) && isset($end_period)){
    $url_last_part = 'select-data';

    $t_y = 'за период '. ($start_period+2000).'-01';
    $t_m = ' - '. ($end_period+2000).'-12';
}elseif(isset($year_string) && isset($url_part_2) && $url_part_2 == 'multi-years'){
    $url_last_part = 'multi-years';
    $t_y = 'за года '.$year_string;
    $t_m = '';
}elseif(isset($year_string) && !isset($url_part_2) ){
    $url_last_part = $user_type.'/'.$year_string;
    $t_y = 'за года '.$year_string;
    $t_m = '';
}else{
    $url_last_part = $user_type;
    $t_y = '';
    $t_m = '';
}
$year_today = Yii::$app->formatter->asDate(time(),'Y');
$year_month_today = Yii::$app->formatter->asDate('now','yyyy-MM');
?>

<div class="col-lg-12 col-md-12 col-sm-12">
    <?php
    NavBar::begin([
        'options' => [
            'class' => "navbar navbar-default navbar-charges thead_$user_type",
        ],
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => [
            ['label' => 'Вернуться к графику', 'url' => "/charges/$url_last_part", 'options' =>['class' => 'ttt']],
            ['label' => 'График общий', 'url' => "/charges", 'options' =>['class' => 'ttt']],
            ['label' => 'График по месяцам', 'url' => "/charges/$user_type-$year_today", 'options' =>['class' => 'ttt']],
            ['label' => 'График по дням', 'url' => "/charges/$user_type-$year_month_today", 'options' =>['class' => 'ttt']],
        ],
    ]);
    NavBar::end();
    ?>
</div>


<div class="margin-bottom " id='all'></div>

<h3 class="text-center margin-top">Денежный сбор. <?= $name ?> <?= isset($year)? 'за '.$year.' год ': $t_y?>  <?= isset($month)? $month.' месяц' : $t_m?></h3>

<div class="col-lg-12 col-md-12 col-sm-12">
    <?php if (!empty($data)): ?>
        <table class="table table-hover table-responsive">
            <thead class="th">
            <tr class="thead_<?= $user_type ?>">
                <td><?= $label['ts'] ?></td>

                <td><?= $label['pay'] ?></td>
            </tr>
            </thead>
            <tbody>
            <?php
            if(!isset($year_string)):
            foreach ($data as $val): ?>
                <tr>
                    <td><?= $val['ts'] ?></td>

                    <td><?= $val['pay'] ?></td>

                </tr>
            <?php endforeach;
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
