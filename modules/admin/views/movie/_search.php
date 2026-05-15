<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\admin\models\MovieSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="movie-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'poster') ?>

    <?= $form->field($model, 'trailer_url') ?>

    <?php // echo $form->field($model, 'year') ?>

    <?php // echo $form->field($model, 'release_date') ?>

    <?php // echo $form->field($model, 'duration') ?>

    <?php // echo $form->field($model, 'rating_avg') ?>

    <?php // echo $form->field($model, 'rating_count') ?>

    <?php // echo $form->field($model, 'views') ?>

    <?php // echo $form->field($model, 'likes') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
