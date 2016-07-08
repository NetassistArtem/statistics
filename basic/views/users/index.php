<?php

use yii\helpers\Html;

?>


<h1>Users</h1>
<table border="1">
<tr>
    <td><?= $label['id'] ?></td>
    <td><?= $label['switch_id']?></td>
    <td><?= $label['switch_ip'] ?></td>
    <td><?= $label['port'] ?></td>
    <td><?= $label['manufacturer'] ?></td>
    <td><?= $label['switch_model'] ?></td>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user->id ?></td>
            <td><?= $user->switch_id?></td>
            <td><?= $user->switch_ip ?></td>
            <td><?= $user->port ?></td>
            <td><?= Html::encode("{$user->manufacturer}") ?></td>
            <td><?= Html::encode("{$user->switch_model}") ?></td>

        </tr>
    <?php endforeach; ?>
</table>

<div>
    <?= Html::img('@web/images/example1.png') ?>

</div>
