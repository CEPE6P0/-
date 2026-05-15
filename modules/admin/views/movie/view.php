<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Movie $model */

$this->title = $model->title;
?>

<div class="movie-view-cinema">
    <div class="movie-header">
        <h1><i class="fas fa-film"></i> <?= Html::encode($this->title) ?></h1>
        <div style="display: flex; gap: 10px;">
            <?= Html::a('<i class="fas fa-arrow-left"></i> Назад', ['index'], ['class' => 'btn-cinema', 'style' => 'background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.2); color:#f0f3fa;']) ?>
            <?= Html::a('<i class="fas fa-edit"></i> Редактировать', ['update', 'id' => $model->id], ['class' => 'btn-cinema btn-cinema-primary']) ?>
            <?= Html::a('<i class="fas fa-trash-alt"></i> Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn-cinema btn-cinema-danger',
                'data' => [
                    'confirm' => 'Вы уверены, что хотите удалить этот фильм?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <div class="movie-card">
        <div class="movie-info-grid">
            <div class="movie-poster">
                <?php
                $posterUrl = $model->poster

                    ? Yii::getAlias('@web/uploads/movies/') . $model->poster
                    : Yii::getAlias('@web/uploads/movies/default.jpg');
                echo Html::img($posterUrl, ['alt' => $model->title]);
                ?>
            </div>
            <div class="movie-details">
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-heading"></i> Название:</span>
                    <span class="detail-value"><?= Html::encode($model->title) ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-align-left"></i> Описание:</span>
                    <span class="detail-value"><?= nl2br(Html::encode($model->description)) ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-calendar-alt"></i> Год:</span>
                    <span class="detail-value"><?= $model->year ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-calendar-day"></i> Дата релиза:</span>
                    <span class="detail-value"><?= $model->release_date ? date('d.m.Y', strtotime($model->release_date)) : '-' ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-hourglass-half"></i> Длительность:</span>
                    <span class="detail-value">
                        <?php
                        $typeId = \app\models\MovieType::find()
                            ->where(['movie_id' => $model->id])
                            ->select('type_id')
                            ->scalar();
                        if ($typeId == 2) {
                            $n = (int)$model->duration;
                            $word = 'сезонов';
                            if ($n % 10 == 1 && $n % 100 != 11) $word = 'сезон';
                            elseif (in_array($n % 10, [2,3,4]) && !in_array($n % 100, [12,13,14])) $word = 'сезона';
                            echo $n . ' ' . $word;
                        } else {
                            $h = floor($model->duration / 60);
                            $m = $model->duration % 60;
                            echo ($h ? $h . ' ч ' : '') . ($m ? $m . ' мин' : '');
                        }
                        ?>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-star"></i> Рейтинг:</span>
                    <span class="detail-value rating-value"><?= round($model->rating_avg, 1) ?> / 10</span>
                    <span class="stars">
                        <?php
                        $stars = round($model->rating_avg / 2, 1);
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= floor($stars)) echo '★';
                            elseif ($i - $stars <= 0.5 && $stars - floor($stars) > 0) echo '½';
                            else echo '☆';
                        }
                        ?>
                    </span>
                    <span class="detail-value">(<?= $model->rating_count ?> оценок)</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-eye"></i> Просмотры:</span>
                    <span class="detail-value"><?= number_format($model->views, 0, ',', ' ') ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-heart"></i> Лайки:</span>
                    <span class="detail-value"><?= number_format($model->likes, 0, ',', ' ') ?></span>
                </div>
                <?php if ($model->trailer_url): ?>
                    <div class="detail-row">
                        <span class="detail-label"><i class="fab fa-youtube"></i> Трейлер:</span>
                        <span class="detail-value"><?= Html::a($model->trailer_url, $model->trailer_url, ['target' => '_blank']) ?></span>
                    </div>
                <?php endif; ?>
                <?php if (isset($model->genres) && $model->genres): ?>
                    <div class="detail-row">
                        <span class="detail-label"><i class="fas fa-mask"></i> Жанры:</span>
                        <span class="detail-value"><?= implode(', ', \yii\helpers\ArrayHelper::getColumn($model->genres, 'name')) ?></span>
                    </div>
                <?php endif; ?>
                <?php if (isset($model->countries) && $model->countries): ?>
                    <div class="detail-row">
                        <span class="detail-label"><i class="fas fa-globe"></i> Страны:</span>
                        <span class="detail-value"><?= implode(', ', \yii\helpers\ArrayHelper::getColumn($model->countries, 'name')) ?></span>
                    </div>
                <?php endif; ?>
                <?php if (isset($model->types) && $model->types): ?>
                    <div class="detail-row">
                        <span class="detail-label"><i class="fas fa-tag"></i> Тип:</span>
                        <span class="detail-value"><?= implode(', ', \yii\helpers\ArrayHelper::getColumn($model->types, 'name')) ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    .movie-view-cinema {
        font-family: 'Inter', sans-serif;
        margin: 0 auto;
        padding: 1rem;
    }
    .movie-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 2rem;
    }
    .movie-header h1 {
        font-size: 2rem;
        font-weight: 700;
        background: linear-gradient(135deg, #fff, #bfc9ff);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        margin: 0;
        border-left: 4px solid #e50914;
        padding-left: 1rem;
    }
    .btn-cinema {
        padding: 0.5rem 1.2rem;
        border-radius: 2rem;
        font-weight: 600;
        transition: 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: none;
    }
    .btn-cinema-primary {
        background: #e50914;
        color: white;
    }
    .btn-cinema-primary:hover {
        background: #f6121d;
        transform: translateY(-2px);
        color: white;
    }
    .btn-cinema-danger {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        color: #ff9f9f;
    }
    .btn-cinema-danger:hover {
        background: #e50914;
        border-color: #e50914;
        color: white;
        transform: translateY(-2px);
    }
    .movie-card {
        background: rgba(18, 22, 32, 0.75);
        backdrop-filter: blur(16px);
        border-radius: 2rem;
        border: 1px solid rgba(255,255,255,0.1);
        padding: 2rem;
        margin-bottom: 2rem;
    }
    .movie-info-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
    }
    .movie-poster {
        flex: 0 0 250px;
    }
    .movie-poster img {
        width: 100%;
        border-radius: 1.2rem;
        box-shadow: 0 15px 30px rgba(0,0,0,0.5);
        border: 1px solid rgba(255,255,255,0.2);
    }
    .movie-details {
        flex: 1;
    }
    .detail-row {
        margin-bottom: 0.8rem;
        border-bottom: 1px dashed rgba(255,255,255,0.1);
        padding-bottom: 0.6rem;
    }
    .detail-label {
        font-weight: 600;
        color: #e50914;
        min-width: 140px;
        display: inline-block;
    }
    .detail-value {
        color: #eef2ff;
    }
    .rating-value {
        font-weight: bold;
        color: #f5b042;
    }
    .stars {
        display: inline-block;
        letter-spacing: 2px;
        color: #ffcc00;
    }
    @media (max-width: 768px) {
        .movie-info-grid {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .detail-label {
            min-width: auto;
            display: block;
            margin-bottom: 0.3rem;
        }
    }
</style>