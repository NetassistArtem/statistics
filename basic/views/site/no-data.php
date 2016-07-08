<?php
use yii\helpers\Html;

$this->title = 'Данные отсутствуют';

?>

<div class="">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Данных после <?= $date_today ?> не существует!
    </p>
    <p>
        Данные до <?= $date_before ?> отсутствуют.
    </p>
    <p>
        Даные доступны в диапазоне  c <?= $date_before ?>  до <?= $date_today ?> !
    </p>


</div>
