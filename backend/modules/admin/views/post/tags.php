<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Post $model */
/** @var int $selectedCategory */
/** @var array $categories */
/** @var yii\widgets\ActiveForm $form */
/** @var array $selectedTags */
/** @var array $tags */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= Html::dropDownList('tags', $selectedTags, $tags, ['class'=>'form-control', 'multiple'=>true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Загрузить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

