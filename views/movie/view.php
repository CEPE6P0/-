<?php
use yii\helpers\Html;

$userId = Yii::$app->user->id ?? null;

$userRating = null;

if ($userId) {
    $userRating = \app\models\Rating::find()
        ->where([
            'user_id' => $userId,
            'movie_id' => $movie->id,
        ])
        ->one();
}

use yii\helpers\Url;

$likeUrl = Url::to(['movie/toggle-like']);
$rateUrl = Url::to(['movie/rate']);
$removeUrl = Url::to(['movie/remove-rating']);
$reviewUrl = Url::to(['movie/add-review']);

$this->registerJsFile('@web/js/movie.js', [
    'depends' => [\yii\web\JqueryAsset::class],
    'position' => \yii\web\View::POS_END
]);
?>

<div class="movie-page">

    <h1><?= Html::encode($movie->title) ?></h1>

    <div class="movie-top">
        <img src="../uploads/movies/<?= $movie->poster ?>" width="250" alt="Постер">

        <div class="movie-info">
            <p><b><i class="fas fa-calendar-alt"></i>  Год:</b> <?= $movie->year ?></p>
            <p><b><i class="fas fa-film"></i>  Жанр:</b> <?= implode(', ', array_column($movie->genres, 'name')) ?></p>
            <p><b><i class="fas fa-globe"></i>  Страна:</b> <?= implode(', ', array_column($movie->countries, 'name')) ?></p>
            <p><b><i class="fas fa-video"></i>  Трейлер:</b> <?= $movie->trailer_url ? Html::a($movie->trailer_url, $movie->trailer_url, ['target' => '_blank']) : '—' ?></p>

            <p><b><i class="fas fa-hourglass-half"></i>  Длительность:</b>
                <?php
                $typeId = \app\models\MovieType::find()
                    ->where(['movie_id' => $movie->id])
                    ->select('type_id')
                    ->scalar();
                ?>

                <?php if ($typeId == 2): // сериал ?>
                    <?= $movie->duration . ' ' . ['сезон', 'сезона', 'сезонов'][
                    ($movie->duration % 10 == 1 && $movie->duration % 100 != 11) ? 0 :
                        (in_array($movie->duration % 10, [2,3,4]) && !in_array($movie->duration % 100, [12,13,14]) ? 1 : 2)
                    ] ?>
                <?php else: // фильм ?>
                    <?php
                    $h = floor($movie->duration / 60);
                    $m = $movie->duration % 60;
                    echo ($h ? $h . ' ч ' : '') . ($m ? $m . ' мин' : '');
                    ?>
                <?php endif; ?>
            </p>

            <p><b><i class="fas fa-eye"></i> Просмотров:</b> <?= $movie->views ?></p>

            <div class="movie-actions">
                <!-- ЛАЙК -->
                <button id="like-btn" data-id="<?= $movie->id ?>">
                    <?= $movie->isLikedByUser($userId) ? '❤️' : '🤍' ?>
                    <span id="like-count" style="font-size:0.9rem;"><?= $movie->likes ?></span>
                </button>

                <!-- РЕЙТИНГ -->
                <?php
                $stars = $userRating ? round($userRating->rating / 2) : 0;
                ?>
                <div class="rating-block">
                    <b><i class="fas fa-star"></i> Ваша оценка:</b>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <span class="star <?= ($i <= $stars) ? 'active' : '' ?>"
                              data-value="<?= $i ?>"
                              data-id="<?= $movie->id ?>">
                            ★
                        </span>
                    <?php endfor; ?>
                    <button id="remove-rating" data-id="<?= $movie->id ?>">
                        ✖ Убрать
                    </button>
                </div>

                <p>
                    <b><i class="fas fa-chart-line"></i> Средний рейтинг:</b>
                    <span id="avg-rating"><?= round($movie->rating_avg, 1) ?></span>
                    (<?= 'Всего оценок ' . $movie->rating_count ?>)
                </p>
            </div>
        </div>
    </div>

    <hr>

    <h3><i class="fas fa-align-left"></i> Описание</h3>
    <p><?= Html::encode($movie->description) ?></p>
    <hr>

    <button class="btn btn-danger"
            data-bs-toggle="modal"
            data-bs-target="#videoModal">
        ▶ Смотреть
    </button>

    <div class="modal fade" id="videoModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content bg-black border-0">
                <div class="modal-header border-0">
                    <h5 class="text-white">
                        🎬 <?= $movie->title ?>
                    </h5>
                    <button type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="ratio ratio-16x9">
                        <iframe id="videoFrame"
                                src=""
                                allowfullscreen
                                allow="autoplay">
                        </iframe>
                    </div>
                    <div class="p-3">
                        <?php if ($hasSubscription): ?>
                            <button id="toggleVideoBtn"
                                    class="btn btn-success w-100"
                                    onclick="toggleVideo()">
                                ▶ Смотреть фильм
                            </button>
                        <?php else: ?>
                            <?php if (Yii::$app->user->isGuest): ?>
                                <a href="<?= \yii\helpers\Url::to(['site/login']) ?>"
                                   class="btn btn-warning w-100">
                                    🔐 Войдите для оформления подписки
                                </a>
                            <?php else: ?>
                                <button class="btn btn-warning w-100"
                                        data-bs-toggle="modal"
                                        data-bs-target="#subscriptionModal">
                                    💎 Оформить подписку
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h3><i class="fas fa-comment-dots"></i> Оставить отзыв</h3>
    <textarea id="review-text" rows="4" placeholder="Напишите отзыв..."></textarea>
    <button id="send-review" data-id="<?= $movie->id ?>">
        <i class="fas fa-paper-plane"></i> Отправить отзыв
    </button>

    <hr>

    <h3><i class="fas fa-users"></i> Отзывы</h3>
    <div id="reviews-list">
        <?php foreach ($movie->reviews as $review): ?>
            <?php
            $rating = \app\models\Rating::find()
                ->where([
                    'user_id' => $review->user_id,
                    'movie_id' => $movie->id,
                ])
                ->one();
            ?>
            <div class="review-item">
                <img class="review-avatar"
                     src="../uploads/avatar/<?= $review->user->avatar ? $review->user->avatar : 'default-avatar.png' ?>"
                     alt="Аватар">
                <div class="review-body">
                    <div class="review-header">
                        <b><?= Html::encode($review->user->username) ?></b>
                        <span class="review-date">
                            <i class="far fa-clock"></i> <?= date('d.m.Y H:i', strtotime($review->created_at)) ?>
                        </span>
                        <?php if ($rating): ?>
                            <span class="review-rating">⭐<?= (int)$rating->rating ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="review-text">
                        <?= Html::encode($review->text) ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    let movieId = <?= $movie->id ?>;

    const trailerId = "<?= $movie->trailer_url ?>";
    const movieVideoId = "<?= $movie->video_url ?>";

    const modal = document.getElementById('videoModal');
    const frame = document.getElementById('videoFrame');
    const btn   = document.getElementById('toggleVideoBtn');

    let isMovie = false;
    let saveInterval = null;

    // --------------------
    // ТРЕЙЛЕР
    // --------------------
    function loadTrailer() {
        frame.src = "https://rutube.ru/play/embed/" + trailerId + "?autoplay=1";

        btn.textContent = "▶ Смотреть фильм";
        btn.className = "btn btn-success w-100";

        isMovie = false;
    }

    // --------------------
    // ФИЛЬМ
    // --------------------
    function loadMovie() {
        frame.src = "https://rutube.ru/play/embed/" + movieVideoId + "?autoplay=1";

        btn.textContent = "🎬 Смотреть трейлер";
        btn.className = "btn btn-warning w-100";

        isMovie = true;
    }

    // --------------------
    // ПЕРЕКЛЮЧЕНИЕ
    // --------------------
    function toggleVideo() {
        if (!isMovie) {
            loadMovie();

            saveProgress(5, 30);

            startAutoSave();
        } else {
            loadTrailer();

            stopAutoSave();
        }
    }

    // --------------------
    // АВТОСОХРАНЕНИЕ
    // --------------------
    function startAutoSave() {
        stopAutoSave();

        saveInterval = setInterval(() => {
            if (isMovie) {
                let fakeTime = Math.floor(Date.now() / 1000) % 500;
                let fakeProgress = Math.min(95, fakeTime / 5);

                saveProgress(fakeProgress, fakeTime);
            }
        }, 5000);
    }

    function stopAutoSave() {
        if (saveInterval) {
            clearInterval(saveInterval);
            saveInterval = null;
        }
    }

    // --------------------
    // МОДАЛКА
    // --------------------
    modal.addEventListener('show.bs.modal', function () {
        loadTrailer();
    });

    modal.addEventListener('hidden.bs.modal', function () {
        frame.src = "";
        stopAutoSave();
    });

    // --------------------
    // КНОПКА
    // --------------------
    window.toggleVideo = toggleVideo;
</script>

<script>
    window.likeUrl = "<?= $likeUrl ?>";
    window.rateUrl = "<?= $rateUrl ?>";
    window.removeUrl = "<?= $removeUrl ?>";
    window.reviewUrl = "<?= $reviewUrl ?>";
</script>

<style>
    .modal-content{
        background:#000;
        border-radius:14px;
        overflow:hidden;
    }

    .btn-danger{
        background:#e50914;
        border:none;
    }

    .btn-danger:hover{
        background:#b20710;
    }


    /* Стили только для страницы фильма */
    .movie-page {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
        font-family: 'Inter', sans-serif;
        color: #eef2ff;
        background: transparent;
        border-radius: 1rem;
    }

    .movie-page h1 {
        font-size: 2.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, #fff, #bfc9ff);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        margin-bottom: 1.5rem;
    }

    .movie-page h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 2rem 0 1rem;
        color: #fff;
        border-left: 4px solid #e50914;
        padding-left: 1rem;
    }

    .movie-top {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
        background: rgba(18, 22, 32, 0.6);
        backdrop-filter: blur(8px);
        border-radius: 1.8rem;
        padding: 1.8rem;
        border: 1px solid rgba(255,255,255,0.1);
    }

    .movie-top img {
        border-radius: 1.2rem;
        width: 260px;
        object-fit: cover;
        box-shadow: 0 15px 30px rgba(0,0,0,0.5);
        transition: transform 0.2s;
    }

    .movie-top img:hover {
        transform: scale(1.02);
    }

    .movie-info {
        flex: 1;
    }

    .movie-info p {
        margin-bottom: 0.75rem;
        font-size: 1rem;
        color: #cfd8ec;
    }

    .movie-info b {
        color: #e50914;
        margin-right: 0.5rem;
    }

    .movie-actions {
        margin-top: 1.5rem;
        background: rgba(10,12,18,0.5);
        border-radius: 1.2rem;
        padding: 1rem;
    }

    /* Кнопка лайка */
    #like-btn {
        background: rgba(30,35,50,0.8);
        border: none;
        font-size: 1.8rem;
        padding: 0.5rem 1rem;
        border-radius: 3rem;
        cursor: pointer;
        transition: 0.2s;
        color: white;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    #like-btn:hover {
        transform: scale(1.07);
        background: #e50914;
    }
    #like-btn.liked {
        background: #e50914;
        color: white;
    }

    /* Звёзды рейтинга */
    .rating-block {
        margin: 1rem 0;
    }
    .star {
        font-size: 2rem;
        cursor: pointer;
        color: #4a4f62;
        transition: 0.2s;
        display: inline-block;
        margin-right: 0.2rem;
    }
    .star.active,
    .star.hovered {
        color: #ffcc00;
        text-shadow: 0 0 6px #ffbb00;
        transform: scale(1.1);
    }
    .star:hover {
        transform: scale(1.25);
        color: #ffdd55;
    }
    #remove-rating {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        padding: 0.4rem 1rem;
        border-radius: 2rem;
        color: #ff9f9f;
        font-weight: 500;
        margin-left: 1rem;
        transition: 0.2s;
    }
    #remove-rating:hover {
        background: #e50914;
        color: white;
        border-color: #e50914;
    }

    /* Отзывы */
    #review-text {
        background: rgba(10,12,18,0.7);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 1.2rem;
        padding: 1rem;
        color: #f0f3fa;
        font-family: 'Inter', sans-serif;
        margin-bottom: 1rem;
    }
    #review-text:focus {
        outline: none;
        border-color: #e50914;
    }
    #send-review {
        background: #e50914;
        border: none;
        padding: 0.7rem 1.5rem;
        border-radius: 2rem;
        font-weight: 700;
        color: white;
        transition: 0.2s;
        margin-bottom: 1rem;
    }
    #send-review:hover {
        background: #f6121d;
        transform: translateY(-2px);
    }

    .review-item {
        display: flex;
        gap: 1rem;
        background: rgba(25, 30, 45, 0.7);
        backdrop-filter: blur(4px);
        border-radius: 1.2rem;
        padding: 1rem;
        margin-bottom: 1rem;
        border: 1px solid rgba(255,255,255,0.08);
    }
    .review-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e50914;
    }
    .review-body {
        flex: 1;
    }
    .review-header {
        display: flex;
        flex-wrap: wrap;
        align-items: baseline;
        gap: 0.8rem;
        margin-bottom: 0.4rem;
    }
    .review-header b {
        color: #e50914;
        font-size: 1rem;
    }
    .review-date {
        font-size: 0.7rem;
        color: #9aa4bf;
    }
    .review-rating {
        background: #ffffff;
        color: #1e1f2c;
        padding: 0.1rem 0.5rem;
        border-radius: 2rem;
        font-size: 0.8rem;
        font-weight: bold;
    }

    /* Поле отзыва на всю ширину */
    #review-text {
        width: 100%;
        background: rgba(10,12,18,0.7);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 1.2rem;
        padding: 1rem;
        color: #f0f3fa;
        font-family: 'Inter', sans-serif;
        margin-bottom: 1rem;
        resize: vertical;
        box-sizing: border-box;
    }
    #review-text:focus {
        outline: none;
        border-color: #e50914;
    }

    /* Кнопка отправки — блочная, на всю ширину */
    #send-review {
        display: block;
        width: 100%;
        background: #e50914;
        border: none;
        padding: 0.8rem;
        border-radius: 2rem;
        font-weight: 700;
        font-size: 1rem;
        color: white;
        transition: 0.2s;
        margin-bottom: 1rem;
        text-align: center;
        cursor: pointer;
    }
    #send-review:hover {
        background: #f6121d;
        transform: translateY(-2px);
    }

    hr {
        border-color: rgba(255,255,255,0.1);
        margin: 1rem 0;
    }

    @media (max-width: 768px) {
        .movie-page {
            padding: 1rem;
        }
        .movie-top {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .movie-top img {
            width: 200px;
        }
        .star {
            font-size: 1.6rem;
        }
    }
</style>