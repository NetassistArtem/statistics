<?php
use yii\helpers\Html;
use yii\bootstrap;

if(!$not_linked_switch):
foreach($linked_switch as $k => $v):
?>

    <p><?=$v['ref_sw_id'] ?></p>


<?php endforeach;
else:?>
    <p>Нет связанных свичей</p>
    <?php
    endif;
    ?>