<?php

use app\models\Movie;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\modules\admin\models\MovieSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Фильмы и сериалы';
?>

<div class="admin-movies-cinema">
    <h1><i class="fas fa-film me-2"></i> <?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<i class="fas fa-arrow-left"></i> Назад', ['/admin'], ['class' => 'btn-back']) ?>
        <?= Html::a('<i class="fas fa-plus"></i> Добавить фильм', ['create'], ['class' => 'btn-cinema-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <div class="grid-wrapper">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'grid-view-cinema'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

//                'id',
                'title:text:Название',
//                [
//                    'attribute' => 'description',
//                    'label' => 'Описание',
//                    'value' => function ($model) {
//                        return $model->description ? mb_substr($model->description, 0, 80) . '...' : '-';
//                    },
//                ],
//                [
//                    'attribute' => 'poster',
//                    'label' => 'Постер',
//                    'format' => 'html',
//                    'value' => function ($model) {
//                        $img = Yii::getAlias('@web') . '/uploads/movies/' . $model->poster;
//                        return Html::img($img, ['style' => 'width:50px;height:70px;border-radius:8px;object-fit:cover;']);
//                    },
//                ],
//                [
//                    'attribute' => 'trailer_url',
//                    'label' => 'Трейлер',
//                    'format' => 'url',
//                ],
                'year:text:Год',
//                [
//                    'attribute' => 'release_date',
//                    'label' => 'Дата выхода',
//                    'value' => function ($model) {
//                        return $model->release_date ? date('d.m.Y', strtotime($model->release_date)) : '-';
//                    },
//                ],
//                [
//                    'attribute' => 'duration',
//                    'label' => 'Длительность',
//                    'value' => function ($model) {
//                        $typeId = \app\models\MovieType::find()
//                            ->where(['movie_id' => $model->id])
//                            ->select('type_id')
//                            ->scalar();
//                        if ($typeId == 2) {
//                            $n = (int)$model->duration;
//                            $word = 'сезонов';
//                            if ($n % 10 == 1 && $n % 100 != 11) $word = 'сезон';
//                            elseif (in_array($n % 10, [2,3,4]) && !in_array($n % 100, [12,13,14])) $word = 'сезона';
//                            return $n . ' ' . $word;
//                        }
//                        $h = floor($model->duration / 60);
//                        $m = $model->duration % 60;
//                        return ($h ? $h . ' ч ' : '') . ($m ? $m . ' мин' : '');
//                    },
//                ],
                [
                    'attribute' => 'rating_avg',
                    'label' => 'Рейтинг',
                    'format' => 'html',
                    'value' => function ($model) {
                        $rating = round($model->rating_avg, 1);
                        $class = $rating >= 7 ? 'rating-high' : 'rating-mid';
                        return "<span class='$class'>" . $rating . " ★</span>";
                    },
                ],
                'rating_count:integer:Оценок',
                'views:integer:Просмотры',
                'likes:integer:Лайки',
                [
                    'label' => 'Страна',
                    'value' => function ($model) {
                        return implode(', ', \yii\helpers\ArrayHelper::getColumn($model->countries, 'name'));
                    },
                ],
                [
                    'label' => 'Жанры',
                    'value' => function ($model) {
                        return implode(', ', \yii\helpers\ArrayHelper::getColumn($model->genres, 'name'));
                    },
                ],
                [
                    'label' => 'Тип',
                    'value' => function ($model) {
                        return implode(', ', \yii\helpers\ArrayHelper::getColumn($model->types, 'name'));
                    },
                ],
                [
                    'class' => ActionColumn::class,
                    'header' => 'Действия',
                    'urlCreator' => function ($action, Movie $model) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    },
                    'contentOptions' => ['style' => 'white-space: nowrap;'],
                ],
            ],
        ]); ?>
    </div>

    <?php Pjax::end(); ?>
</div>

<style>
    .btn-back {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        padding: 0.7rem 1.8rem;
        border-radius: 2rem;
        font-weight: 600;
        color: #f0f3fa;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: 0.2s;
    }
    .btn-back:hover {
        background: rgba(255,255,255,0.2);
        transform: translateY(-2px);
    }

    .admin-movies-cinema {
        font-family: 'Inter', sans-serif;

    }
    .admin-movies-cinema h1 {
        font-size: 2rem;
        font-weight: 700;
        background: linear-gradient(135deg, #fff, #bfc9ff);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        margin-bottom: 1.5rem;
        display: inline-block;
        border-left: 4px solid #e50914;
        padding-left: 1rem;
    }
    .btn-cinema-success {
        text-decoration: none;
        background: #10b981;
        border: none;
        padding: 0.5rem 1.2rem;
        border-radius: 2rem;
        font-weight: 600;
        color: white;
        transition: 0.2s;
        margin-bottom: 1rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-cinema-success:hover {
        background: #059669;
        transform: translateY(-2px);
    }
    .grid-wrapper {
        background: rgba(18, 22, 32, 0.75);
        backdrop-filter: blur(16px);
        border-radius: 1.8rem;
        border: 1px solid rgba(255,255,255,0.1);
        padding: 1rem;
        overflow-x: auto;
    }
    .grid-view-cinema {
        width: 100%;
        border-collapse: collapse;
        color: #eef2ff;
        min-width: 1200px;
    }
    .grid-view-cinema th,
    .grid-view-cinema td {
        padding: 0.8rem 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        vertical-align: middle;
    }
    .grid-view-cinema th {
        background: rgba(229,9,20,0.2);
        font-weight: 600;
        color: #e50914;
        white-space: nowrap;
    }
    .grid-view-cinema tr:hover {
        background: rgba(255,255,255,0.05);
    }
    .grid-view-cinema a {
        color: #e50914;
        text-decoration: none;
    }
    .grid-view-cinema a:hover {
        text-decoration: underline;
    }
    .grid-view-cinema input,
    .grid-view-cinema select {
        background: rgba(10,12,18,0.7);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 0.8rem;
        padding: 0.4rem 0.8rem;
        color: #fff;
        width: 100%;
    }
    .grid-view-cinema input:focus,
    .grid-view-cinema select:focus {
        border-color: #e50914;
        outline: none;
    }
    .pagination {
        margin-top: 1rem;
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    .pagination li {
        list-style: none;
    }
    .pagination a,
    .pagination span {
        background: rgba(255,255,255,0.1);
        padding: 0.4rem 0.8rem;
        border-radius: 0.5rem;
        color: #fff;
        text-decoration: none;
    }
    .pagination .active span {
        background: #e50914;
    }
    .rating-high {
        color: #10b981;
        font-weight: bold;
    }
    .rating-mid {
        color: #f59e0b;
        font-weight: bold;
    }
    @media (max-width: 768px) {
        .admin-movies-cinema {
            padding: 1rem;
        }
    }
</style>