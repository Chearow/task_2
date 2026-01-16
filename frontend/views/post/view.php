<?php

use yii\helpers\Html;

/** @var $post \common\models\Post */

$this->title = $post->title;
?>

<h1><?= Html::encode($post->title) ?></h1>

<?php
if ($post->image): ?>
    <p>
        <img src="/uploads/<?= $post->image ?>" class="img-fluid" alt="">
    </p>
<?php
endif; ?>

<p><?= $post->content ?></p>

<p><strong>Категория:</strong> <?= $post->category->name ?? 'Без категории' ?></p>

<p><strong>Теги:</strong>
    <?php
    foreach ($post->tags as $tag): ?>
        <span class="badge bg-secondary"><?= $tag->title ?></span>
    <?php
    endforeach; ?>
</p>

<hr>

<h3>Комментарии</h3>

<?php
foreach ($post->comments as $comment): ?>
    <div class="mb-3">
        <strong><?= $comment->user->username ?? 'Гость' ?></strong><br>
        <?= $comment->content ?>
    </div>
<?php
endforeach; ?>

