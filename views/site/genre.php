<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Movie[] $movies */
$this->registerCssFile('@web/css/content-card.css');
$this->title = 'Фильмы по жанру';
?>

    <h1><?= $genre->name ?></h1>

    <div class="content-grid">
        <?php foreach ($movies as $movie): ?>
            <div class="movie-card">
                <?= $this->render('//common/_content_card', [
                    'item' => $movie,
                    'type' => 'movie'
                ]) ?>
            </div>
        <?php endforeach; ?>
    </div>




