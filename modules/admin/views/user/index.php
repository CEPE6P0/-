<?php

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\modules\admin\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss("
    .admin-users-cinema {
        font-family: 'Inter', sans-serif;
    }
    .admin-users-cinema h1 {
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
    .btn-back {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        padding: 0.5rem 1.2rem;
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
    .btn-cinema-success {
        text-decoration: none;
        background: #10b981;
        border: none;
        padding: 0.5rem 1.2rem;
        border-radius: 2rem;
        font-weight: 600;
        color: white;
        transition: 0.2s;
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
        min-width: 800px;
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
    @media (max-width: 768px) {
        .admin-users-cinema {
            padding: 1rem;
        }
        .grid-view-cinema th,
        .grid-view-cinema td {
            padding: 0.5rem;
            font-size: 0.8rem;
        }
    }
");
?>

<div class="admin-users-cinema">
    <h1><i class="fas fa-users me-2"></i> <?= Html::encode($this->title) ?></h1>

    <div style="display: flex; gap: 10px; margin-bottom: 1rem;">
        <?= Html::a('<i class="fas fa-arrow-left"></i> Назад', ['/admin'], ['class' => 'btn-back']) ?>
        <?= Html::a('<i class="fas fa-plus"></i> Добавить пользователя', ['create'], ['class' => 'btn-cinema-success']) ?>
    </div>

    <?php Pjax::begin(); ?>

    <div class="grid-wrapper">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'grid-view-cinema'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'username:text:Логин',
                'email:email:Email',
                [
                    'attribute' => 'birth_date',
                    'label' => 'Дата рождения',
                    'value' => function ($model) {
                        return $model->birth_date ? date('d.m.Y', strtotime($model->birth_date)) : '-';
                    },
                ],
                [
                    'attribute' => 'subscription_type',
                    'label' => 'Подписка',
                    'value' => function ($model) {
                        return $model->subscription_type == 1 ? 'Активна' : 'Неактивна';
                    },
                    'filter' => [1 => 'Активна', 0 => 'Неактивна'],
                ],
                [
                    'attribute' => 'subscription_expires_at',
                    'label' => 'Окончание подписки',
                    'value' => function ($model) {
                        return $model->subscription_expires_at ? date('d.m.Y', strtotime($model->subscription_expires_at)) : '-';
                    },
                ],
                'is_active:boolean:Активен',

                [
                    'class' => ActionColumn::class,
                    'header' => 'Действия',
                    'urlCreator' => function ($action, User $model) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    },
                    'contentOptions' => ['style' => 'white-space: nowrap;'],
                ],
            ],
        ]); ?>
    </div>

    <?php Pjax::end(); ?>
</div>