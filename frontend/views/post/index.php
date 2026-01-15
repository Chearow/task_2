<?php
/** @var yii\data\ActiveDataProvider $dataProvider */

use yii\widgets\ListView;

$this->title = 'Все посты';
?>

<h1><?= $this->title ?></h1>

<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_post_item',
    'layout' => "{items}\n{pager}",
]) ?>
