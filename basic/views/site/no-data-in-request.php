<?php
use yii\helpers\Html;

$this->title = 'Запрашиваемые данные отсутствуют';

?>

<div class="">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if(isset($todo_status)): ?>
            Запрос на среднее время обработки TODO  - <b><?= $todo_type ?></b>, в статусе <b><?= $todo_status ?></b>
            <?php else: ?>
            Запрос на количество TODO  - <b><?= $todo_type ?></b>.
        <?php endif; ?>

    </p>
    <p>
        Дата   <b><?= $request_date ?></b>.
    </p>
    <p>
        Данные отсутствуют!
    </p>

</div>