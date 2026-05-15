<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = $model->username;
?>

<div class="user-view-cinema">
    <div class="user-header">
        <h1><i class="fas fa-user-circle"></i> <?= Html::encode($this->title) ?></h1>
        <div style="display: flex; gap: 10px;">
            <?= Html::a('<i class="fas fa-arrow-left"></i> Назад', ['index'], ['class' => 'btn-cinema', 'style' => 'background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.2); color:#f0f3fa;']) ?>
            <?= Html::a('<i class="fas fa-edit"></i> Редактировать', ['update', 'id' => $model->id], ['class' => 'btn-cinema btn-cinema-primary']) ?>
            <?= Html::a('<i class="fas fa-trash-alt"></i> Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn-cinema btn-cinema-danger',
                'data' => [
                    'confirm' => 'Вы уверены, что хотите удалить этого пользователя?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <div class="user-card">
        <div class="user-info-grid">
            <div class="user-avatar">
                <?php
                $avatarUrl = $model->avatar
                    ? Yii::getAlias('@web/uploads/avatar/') . $model->avatar
                    : Yii::getAlias('@web/uploads/avatar/default-avatar.png');
                echo Html::img($avatarUrl, ['alt' => $model->username]);
                ?>
            </div>
            <div class="user-details">
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-id-badge"></i> ID:</span>
                    <span class="detail-value"><?= $model->id ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-user"></i> Логин:</span>
                    <span class="detail-value"><?= Html::encode($model->username) ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-envelope"></i> Email:</span>
                    <span class="detail-value"><?= Html::encode($model->email) ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-user-tag"></i> Имя:</span>
                    <span class="detail-value"><?= Html::encode($model->name) ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-user-friends"></i> Фамилия:</span>
                    <span class="detail-value"><?= Html::encode($model->first_name) ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-user-friends"></i> Отчество:</span>
                    <span class="detail-value"><?= Html::encode($model->last_name) ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-cake-candles"></i> Дата рождения:</span>
                    <span class="detail-value"><?= $model->birth_date ? date('d.m.Y', strtotime($model->birth_date)) : '-' ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-star"></i> Подписка:</span>
                    <span class="detail-value">
                        <span class="badge <?= $model->subscription_type == 1 ? 'badge-danger' : 'badge-secondary' ?>">
                            <?= $model->subscription_type == 1 ? 'Активна' : 'Неактивна' ?>
                        </span>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-calendar-times"></i> Окончание подписки:</span>
                    <span class="detail-value"><?= $model->subscription_expires_at ? date('d.m.Y', strtotime($model->subscription_expires_at)) : '-' ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-check-circle"></i> Активен:</span>
                    <span class="detail-value">
                        <span class="badge <?= $model->is_active ? 'badge-success' : 'badge-secondary' ?>">
                            <?= $model->is_active ? 'Да' : 'Нет' ?>
                        </span>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-shield-alt"></i> Роль:</span>
                    <span class="detail-value">
                        <span class="badge <?= $model->role == 1 ? 'badge-warning' : 'badge-secondary' ?>">
                            <?= $model->role == 1 ? 'Администратор' : 'Пользователь' ?>
                        </span>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-calendar-plus"></i> Дата регистрации:</span>
                    <span class="detail-value"><?= date('d.m.Y H:i', strtotime($model->created_at)) ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-calendar-edit"></i> Последнее обновление:</span>
                    <span class="detail-value"><?= date('d.m.Y H:i', strtotime($model->updated_at)) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .user-view-cinema {
        font-family: 'Inter', sans-serif;
        margin: 0 auto;
        padding: 1rem;
    }
    .user-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 2rem;
    }
    .user-header h1 {
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
    .user-card {
        background: rgba(18, 22, 32, 0.75);
        backdrop-filter: blur(16px);
        border-radius: 2rem;
        border: 1px solid rgba(255,255,255,0.1);
        padding: 2rem;
        margin-bottom: 2rem;
    }
    .user-info-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
    }
    .user-avatar {
        flex: 0 0 150px;
        text-align: center;
    }
    .user-avatar img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #e50914;
        box-shadow: 0 15px 30px rgba(0,0,0,0.5);
    }
    .user-details {
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
        min-width: 160px;
        display: inline-block;
    }
    .detail-value {
        color: #eef2ff;
    }
    .badge {
        display: inline-block;
        padding: 0.2rem 0.8rem;
        border-radius: 2rem;
        font-size: 0.8rem;
        font-weight: 600;
    }
    .badge-success {
        background: #10b981;
        color: white;
    }
    .badge-danger {
        background: #e50914;
        color: white;
    }
    .badge-warning {
        background: #f59e0b;
        color: white;
    }
    .badge-secondary {
        background: #6b7280;
        color: white;
    }
    @media (max-width: 768px) {
        .user-info-grid {
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