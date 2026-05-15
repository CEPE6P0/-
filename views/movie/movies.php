<?php
use yii\helpers\Html;

$this->registerCssFile('@web/css/content-card.css');
$this->registerJsFile('@web/js/content-card.js');
$this->title = 'Фильмы';
?>

<h1 class="mb-4">🎬 <?= Html::encode($this->title) ?></h1>

<div class="content-grid">
    <?php foreach ($movies as $movie): ?>
        <?= $this->render('//common/_content_card', [
            'item' => $movie,
            'type' => 'movie'
        ]) ?>
    <?php endforeach; ?>
</div>
