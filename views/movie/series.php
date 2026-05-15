<?php
use yii\helpers\Html;

$this->registerCssFile('@web/css/content-card.css');
$this->title = 'Сериалы';
?>

<h1 class="mb-4">📺 <?= Html::encode($this->title) ?></h1>

<div class="content-grid">
    <?php foreach ($series as $serie): ?>
        <?= $this->render('//common/_content_card', [
            'item' => $serie,
            'type' => 'serie'
        ]) ?>
    <?php endforeach; ?>
</div>