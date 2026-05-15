<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Movie $model */

$this->title = 'Изменить фильм или сериал: ' . $model->title;
?>
<div class="movie-update">

    <?= $this->render('_form', [
        'model' => $model,
        'genres' => $genres,
        'countries' => $countries,
        'types' => $types,
    ]) ?>

</div>
