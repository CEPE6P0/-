<?php
use yii\helpers\Html;
$this->registerCssFile('@web/css/content-card.css');
$this->registerJsFile('@web/js/content-card.js');
?>

    <div class="cinema-profile-wrapper">

        <!-- Hero с обложкой и аватаром (полностью переработан) -->
        <div class="profile-hero">
            <div class="profile-cover"></div>
            <div class="avatar-section">
                <div class="profile-avatar">
                    <img src="../uploads/avatar/<?= $user->avatar ? $user->avatar : 'default-avatar.png' ?>" alt="Аватар">
                    <div class="avatar-edit-badge" onclick="alert('Загрузить новый аватар')">
                        <i class="fas fa-camera"></i>
                    </div>
                </div>
                <div class="profile-headline">
                    <h1><?= Html::encode($user->name . ' ' . $user->last_name) ?></h1>
                    <div class="profile-username">
                        <i class="fas fa-user-circle"></i> @<?= Html::encode($user->username) ?>
                    </div>
                </div>
                <div class="profile-action-buttons">
                    <?= Html::a('<i class="fas fa-user-edit"></i> Редактировать', ['profile/edit'], ['class' => 'btn-cinema btn-cinema-primary']) ?>
                    <?= Html::a('<i class="fas fa-key"></i> Сменить пароль', 'change-password', ['class' => 'btn-cinema btn-cinema-outline']) ?>
                </div>
            </div>
        </div>

        <!-- Статистика (динамическая, на основе понравившихся фильмов) -->
        <div class="profile-stats-grid">
            <div class="stat-card">
                <div class="stat-label">В ИЗБРАННОМ</div>
                <div class="stat-value"><?= count($likedMovies) ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">ПОДПИСКА</div>
                <div class="stat-value" style="font-size: 1.2rem;"><?= Html::encode($user->subscriptionTypeLabel) ?></div>
                <div style="font-size:0.7rem; margin-top:6px;">
                    <?php if ($user->subscription_expires_at): ?>
                        <i class="fas fa-calendar-alt"></i> до <?= Yii::$app->formatter->asDate($user->subscription_expires_at, 'dd.MM.Y') ?>
                    <?php else: ?>
                        <i class="fas fa-clock"></i> Неактивна
                    <?php endif; ?>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-label">РЕГИСТРАЦИЯ</div>
                <div class="stat-value" style="font-size: 1.1rem;"><?= date('d.m.Y', strtotime($user->created_at)) ?></div>
            </div>
        </div>

        <!-- Детальная информация пользователя -->
        <div class="user-details-panel">
            <div class="details-title">
                <i class="fas fa-id-card"></i> Личные данные
            </div>
            <div class="info-grid">
                <div class="info-item"><span class="info-label"><i class="fas fa-user"></i> Имя:</span><span class="info-value"><?= Html::encode($user->name) ?></span></div>
                <div class="info-item"><span class="info-label"><i class="fas fa-user-tag"></i> Фамилия:</span><span class="info-value"><?= Html::encode($user->last_name) ?></span></div>
                <div class="info-item"><span class="info-label"><i class="fas fa-user-friends"></i> Отчество:</span><span class="info-value"><?= Html::encode($user->first_name) ?></span></div>
                <div class="info-item"><span class="info-label"><i class="fas fa-cake-candles"></i> Дата рождения:</span><span class="info-value"><?= date('d.m.Y', strtotime($user->birth_date)) ?></span></div>
                <div class="info-item"><span class="info-label"><i class="fas fa-envelope"></i> Email:</span><span class="info-value"><?= Html::encode($user->email) ?></span></div>
                <div class="info-item">
    <span class="info-label">
        <i class="fas fa-crown"></i>
        Подписка до:
    </span>

                    <span class="info-value">

        <?= $user->subscription_expires_at
            ? Yii::$app->formatter->asDate(
                $user->subscription_expires_at,
                'dd.MM.yyyy'
            )
            : '—'
        ?>

    </span>
                </div>            </div>
            <?php if ($user->subscription_expires_at && strtotime($user->subscription_expires_at) < strtotime('+7 days')): ?>
                <div style="margin-top: 1.2rem; background:#86131c20; border-radius: 80px; padding: 0.5rem 1rem; font-size:0.8rem;">
                    <i class="fas fa-exclamation-triangle" style="color:#f5b042;"></i> Подписка истекает скоро — продлите, чтобы не потерять доступ
                </div>
            <?php endif; ?>
        </div>

        <!-- ============================================= -->
        <!-- БЛОК ПОНРАВИВШИЕСЯ ФИЛЬМЫ (НЕ ТРОГАТЬ)         -->
        <!-- ============================================= -->
        <div class="liked-movies-section">
            <h2>Понравившиеся фильмы</h2>
            <div class="slider">
                <button class="slider-arrow left">‹</button>
                <div class="slider-track">
                    <?php foreach ($likedMovies as $item): ?>
                        <?= $this->render('//common/_content_card', [
                            'item' => $item['model'],
                            'type' => ($item['typeId'] == 2 ? 'serie' : 'movie')
                        ]) ?>
                    <?php endforeach; ?>
                </div>
                <button class="slider-arrow right">›</button>
            </div>
        </div>
        <!-- ============================================= -->
        <!-- КОНЕЦ БЛОКА (ПОЛНОСТЬЮ СОХРАНЁН)              -->
        <!-- ============================================= -->
    </div>
<style>
    /* Контейнер основной */
    .cinema-profile-wrapper {
        max-width: 1400px;
    }

    /* Hero секция с обложкой и аватаром */
    .profile-hero {
        position: relative;
        margin-bottom: 2.5rem;
        border-radius: 2rem;
        overflow: hidden;
        background: linear-gradient(135deg, #1a1f2e, #0f1119);
        box-shadow: 0 20px 35px -12px rgba(0,0,0,0.5);
    }

    .profile-cover {
        height: 220px;
        background: linear-gradient(90deg, #2a2f3f, #1b1e2a);
        position: relative;
        background-image: url('https://images.unsplash.com/photo-1536440136628-849c177e76a1?q=80&w=1925&auto=format');
        background-size: cover;
        background-position: center 30%;
    }

    .profile-cover::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(0deg, rgba(15,17,25,0.9) 0%, rgba(15,17,25,0.4) 100%);
    }

    .avatar-section {
        position: relative;
        display: flex;
        align-items: flex-end;
        padding: 0 2rem 1.5rem 2rem;
        margin-top: -70px;
        gap: 1.8rem;
        flex-wrap: wrap;
        z-index: 2;
    }

    .profile-avatar {
        position: relative;
    }

    .profile-avatar img {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #2e3a4e;
        box-shadow: 0 12px 25px rgba(0,0,0,0.4);
        background: #1e2434;
        transition: transform 0.2s ease, border-color 0.2s;
    }

    .profile-avatar img:hover {
        transform: scale(1.02);
        border-color: #e50914;
    }

    .avatar-edit-badge {
        position: absolute;
        bottom: 6px;
        right: 6px;
        background: #e50914;
        border-radius: 50%;
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #0f1119;
        cursor: pointer;
        transition: background 0.2s;
    }

    .avatar-edit-badge i {
        font-size: 16px;
        color: white;
    }

    .avatar-edit-badge:hover {
        background: #b20710;
    }

    .profile-headline {
        flex: 1;
        margin-bottom: 0.5rem;
    }

    .profile-headline h1 {
        font-size: 2rem;
        font-weight: 700;
        letter-spacing: -0.3px;
        background: linear-gradient(135deg, #ffffff, #bfc9ff);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        margin-bottom: 0.25rem;
    }

    .profile-username {
        color: #9aa4bf;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 4px;
    }

    .profile-username i {
        font-size: 14px;
        color: #6c7a9e;
    }

    /* Кнопки действий */
    .profile-action-buttons {
        display: flex;
        gap: 1rem;
        align-items: center;
        margin-left: auto;
        flex-wrap: wrap;
    }

    .btn-cinema {
        padding: 0.65rem 1.6rem;
        border-radius: 40px;
        font-weight: 600;
        font-size: 0.9rem;
        border: none;
        transition: all 0.2s ease;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(8px);
        color: #f0f3fa;
        border: 1px solid rgba(255,255,255,0.2);
    }

    .btn-cinema-primary {
        background: #e50914;
        border: none;
        color: white;
        box-shadow: 0 8px 18px rgba(229,9,20,0.25);
    }

    .btn-cinema-primary:hover {
        background: #f6121d;
        transform: translateY(-2px);
        color: white;
    }

    .btn-cinema-outline:hover {
        background: rgba(255,255,255,0.2);
        transform: translateY(-2px);
        color: white;
    }

    /* Информационные карточки */
    .profile-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.2rem;
        margin: 2rem 0 2rem 0;
    }

    .stat-card {
        background: rgba(20, 24, 36, 0.65);
        backdrop-filter: blur(12px);
        border-radius: 1.5rem;
        padding: 1.2rem 1.5rem;
        border: 1px solid rgba(255,255,255,0.08);
        transition: all 0.25s;
    }

    .stat-card:hover {
        border-color: rgba(229,9,20,0.3);
        background: rgba(30, 35, 48, 0.8);
    }

    .stat-label {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 500;
        color: #8f9bb3;
        margin-bottom: 0.5rem;
    }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 800;
        line-height: 1.2;
        color: white;
    }

    .subscription-badge {
        background: linear-gradient(105deg, #2b2f44, #1b1f2c);
        border-radius: 40px;
        padding: 0.2rem 1rem;
        font-size: 0.75rem;
        font-weight: 600;
        color: #f5c542;
        border: 1px solid rgba(245,197,66,0.3);
        display: inline-block;
    }

    /* Детали пользователя в две колонки */
    .user-details-panel {
        background: rgba(12, 15, 24, 0.7);
        backdrop-filter: blur(12px);
        border-radius: 1.8rem;
        padding: 1.8rem;
        margin-bottom: 2.5rem;
        border: 1px solid rgba(255,255,255,0.05);
    }

    .details-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 10px;
        border-left: 3px solid #e50914;
        padding-left: 1rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1rem 1.8rem;
    }

    .info-item {
        display: flex;
        align-items: baseline;
        gap: 12px;
        flex-wrap: wrap;
        border-bottom: 1px dashed rgba(255,255,255,0.1);
        padding-bottom: 0.6rem;
    }

    .info-label {
        font-weight: 500;
        min-width: 110px;
        color: #9aa4bf;
        font-size: 0.85rem;
    }

    .info-value {
        font-weight: 500;
        color: #f0f3fa;
    }

    .subscription-expiry {
        background: rgba(0,0,0,0.3);
        border-radius: 80px;
        padding: 0.2rem 1rem;
        font-size: 0.8rem;
        display: inline-block;
    }

    /* Блок понравившиеся фильмы — оригинальный код не трогаем, только визуальные отступы */
    .liked-movies-section {
        margin-top: 2.5rem;
        margin-bottom: 2rem;
    }

    .liked-movies-section h2 {
        font-size: 1.7rem;
        font-weight: 600;
        margin-bottom: 1.3rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .liked-movies-section h2:before {
        content: '❤️';
        font-size: 1.4rem;
    }
</style>