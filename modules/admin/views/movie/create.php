<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Movie $model */

$this->title = 'Создать фильм или сериал';
?>
<div class="movie-create">

    <?= $this->render('_form', [
        'model' => $model,
        'genres' => $genres,
        'countries' => $countries,
        'types' => $types,
    ]) ?>

</div>
