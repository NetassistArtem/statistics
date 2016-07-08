<?php
use yii\helpers\Html;
use yii\bootstrap;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use Yii;
use app;


if(isset($user_type) && isset($year) && isset($month)){
    $url_last_part = $user_type.'-'.$year.'-'.$month;
}elseif(isset($user_type) && isset($year)){
    $url_last_part = $user_type.'-'.$year;
}else{
    $url_last_part = $user_type;
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

<h3 class="text-center margin-top">Денежный сбор. <?= $name ?> <?= isset($year)? 'за '.$year.' год ': ''  ?>  <?= isset($month)? $month.' месяц' : '' ?></h3>

<div class="col-lg-12 col-md-12 col-sm-12">
    <?php if (!empty($data)): ?>
        <table class="table table-hover table-responsive">
            <thead class="th">
            <tr class="thead_<?= $user_type ?>">
                <td><?= $label['ts'] ?></td>

                <td><?= $label['net_id'] ?></td>
                <td><?= $label['pay_class'] ?></td>
                <td><?= $label['admin_id'] ?></td>
                <td><?= $label['acc_id'] ?></td>
                <td><?= $label['user_name'] ?></td>
                <td><?= $label['comment'] ?></td>
                <td><?= $label['pay'] ?></td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data as $val): ?>
                <tr>
                    <td><?= $val['ts'] ?></td>

                    <td><?= $val['net_id'] ?></td>
                    <td><?= $val['pay_class'] ?></td>
                    <td><?= $val['admin_id'] ?></td>
                    <td><?= $val['acc_id'] ?></td>
                    <td><?= $val['user_name'] ?></td>
                    <td><?= Html::encode("{$val['comment']}") ?></td>
                    <td><?= $val['pay'] ?></td>

                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div>
            <p>По данному запросу данные отсуттствуют</p>
        </div>
    <?php endif; ?>

</div>
