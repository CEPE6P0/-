<?php
use yii\helpers\Html;

$this->title = 'Админ-панель';
?>

<div class="admin-cinema">
    <div class="admin-header">
        <h1><i class="fas fa-tachometer-alt me-2"></i> Админ-панель</h1>
    </div>

    <div class="admin-grid">

        <div class="admin-card">
            <i class="fas fa-users"></i>
            <h3>Пользователи</h3>
            <p>Управление учетными записями, ролями и правами</p>
            <?= Html::a('Перейти', ['/admin/user'], ['class' => 'admin-btn']) ?>
        </div>

        <div class="admin-card">
            <i class="fas fa-film"></i>
            <h3>Фильмы</h3>
            <p>Добавление, редактирование, удаление фильмов и сериалов</p>
            <?= Html::a('Перейти', ['/admin/movie'], ['class' => 'admin-btn']) ?>
        </div>

    </div>
</div>

<style>
    .admin-cinema {
        font-family: 'Inter', sans-serif;
        min-height: 100vh;

    }
    .admin-header {
        margin-bottom: 2rem;
    }
    .admin-header h1 {
        font-size: 2rem;
        font-weight: 700;
        background: linear-gradient(135deg, #fff, #bfc9ff);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        display: inline-block;
        border-left: 4px solid #e50914;
        padding-left: 1rem;
    }
    .admin-grid {
        display: flex;
        gap: 1.8rem;
        flex-wrap: wrap;
    }
    .admin-card {
        background: rgba(18, 22, 32, 0.75);
        backdrop-filter: blur(16px);
        border-radius: 1.8rem;
        border: 1px solid rgba(255,255,255,0.1);
        padding: 1.8rem;
        width: 280px;
        transition: all 0.3s;
    }
    .admin-card:hover {
        transform: translateY(-6px);
        border-color: rgba(229,9,20,0.4);
        box-shadow: 0 20px 35px -12px rgba(0,0,0,0.5);
    }
    .admin-card i {
        font-size: 2.5rem;
        color: #e50914;
        margin-bottom: 1rem;
    }
    .admin-card h3 {
        font-size: 1.4rem;
        font-weight: 600;
        color: #f0f3fa;
        margin-bottom: 0.5rem;
    }
    .admin-card p {
        color: #9aa4bf;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }
    .admin-btn {
        display: inline-block;
        background: #e50914;
        color: white;
        padding: 0.5rem 1.2rem;
        border-radius: 2rem;
        text-decoration: none;
        font-weight: 600;
        transition: 0.2s;
        text-align: center;
    }
    .admin-btn:hover {
        background: #f6121d;
        transform: translateY(-2px);
        color: white;
    }
    @media (max-width: 640px) {
        .admin-cinema {
            padding: 1rem;
        }
        .admin-card {
            width: 100%;
        }
    }
</style>