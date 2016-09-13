<?php
use yii\helpers\Html;

$this->title = 'Запрашиваемые данные отсутствуют';

?>

<div class="">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
       Запрос на количество TODO  - <?= $todo_type ?>.
    </p>
    <p>
        Дата <?= $request_date ?>.
    </p>
    <p>
        Данные отсутствуют!
    </p>

</div>