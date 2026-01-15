<?php

use yii\helpers\Url;

/** @var $model \common\models\Post */
?>

<div class="mb-4 pb-3 border-bottom">
    <h2>
        <a href="<?= Url::to(['post/view', 'id' => $model->id]) ?>">
            <?= $model->title ?>
        </a>
    </h2>

    <?php
    if ($model->image): ?>
        <p>
            <img src="uploads/<?= $model->image ?>" class="img-fluid" alt=""
        </p>
    <?php
    endif; ?>

    <p><?= $model->content ?></p>

    <p>
        <strong>Категория:</strong>
        <?= $model->category ? $model->category->name : 'Без категории' ?>
    </p>

    <p>
        <strong>Теги:</strong>
        <?php
        foreach ($model->tags as $tag): ?>
            <span class="badge bg-secondary"><?= $tag->title ?></span>
        <?php
        endforeach; ?>
    </p>
</div>
