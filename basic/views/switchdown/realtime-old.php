<?php
use yii\helpers\Html;
use yii\bootstrap;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\components\debugger\Debugger;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;


$this->title = 'Состояние свичей в реальном времени';
$year_today = Yii::$app->formatter->asDate(time(), 'Y');
$year_month_today = Yii::$app->formatter->asDate('now', 'yyyy-MM');
?>

<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>


    <ul class="nav nav-tabs">
        <li role="presentation" ><a href="/switchdown/realtime">Свичи с обновлением статуса <b>СЕЙЧАС</b></a></li>
        <li role="presentation" class="active"><a href="/switchdown/realtime-old">Свичи с обновлением статуса <b>ДАВНО</b></a></li>
    </ul>


    <h2>Обновление статуса - <b>Давно</b></h2>

    <div class="col-lg-12 col-md-12 col-sm-12">
        <table class="table table-bordered table-hover table-responsive">
            <thead class="th">
            <tr>
                <td>№</td>
                <td>id</td>
                <td>Адрес</td>
                <td>ip адрес</td>
                <td>Тип оборудования</td>
                <td>Имя оборудования</td>
                <td>Модель оборудования</td>
                <td>Дата и время падения оборудования</td>
                <td>Время в down, мин/часы/дни</td>
                <td>Дата и время последнего пинга</td>
                <td>Время с момента последнего пинга, мин/часы/дни</td>
            </tr>

            </thead>
            <tbody>
            <?php foreach($data_old_status_check as $k => $v): ?>
            <tr>
                <td><?= $k+1 ?> </td>
                <td><?= $v['switch_id']?></td>
                <td><?= $v['switch_address'] ?></td>
                <td><?= $v['ip_address'] ?></td>
                <td>

                    <?php Pjax::begin(['id' => "switch_{$v['tehnical_name']}"]); ?>

                         <a href="/switchdown/get-linked-switch?switch_id=<?= $v['switch_id'] ?>">Связанные свичи</a>

                    <?php Pjax::end(); ?>

                </td>
                <td><?= $v['tehnical_name'] ?></td>
                <td><?= $v['switch_model'] ?></td>
                <td><?= $v['start_time_down'] ?></td>
                <td>
                    <?= round(($v['time_in_down'])/60 , 1 ) ?> минут <br>
                    <?= round(($v['time_in_down'])/3600 , 1)  ?> часов <br>
                    <?= round(($v['time_in_down'])/86400 , 1)  ?> дней
                </td>
                <td><?= $v['last_check'] ?></td>
                <td>
                    <?= round(($v['time_without_ping'])/60 , 1 ) ?> минут <br>
                    <?= round(($v['time_without_ping'])/3600 , 1)  ?> часов <br>
                    <?= round(($v['time_without_ping'])/86400 , 1)  ?> дней
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



