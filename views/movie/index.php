<?php
use yii\helpers\Html;
?>



<h1 class="mb-4">🎬 Все фильмы</h1>

<div class="movies-grid">
    <?php foreach ($movies as $movie): ?>
        <div class="movie-card">
            <a href="movie/view?id=<?= $movie->id ?>" class="movie-link">
                <div class="movie-poster-wrapper">
                    <img src="uploads/movies/<?= $movie->poster ?>" alt="<?= Html::encode($movie->title) ?>" width="180" class="movie-poster">
                    <div class="movie-overlay">
                        <div class="overlay-content">
                            <div class="overlay-top">
                                <div class="duration">
                                    ⏱
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
                                </div>
                                <div class="top-right">
                                    <div class="year">🎬 <?= $movie->year ?></div>
                                    <div class="rating">⭐ <?= $movie->rating_avg ?></div>
                                </div>
                            </div>
                            <div class="overlay-bottom">
                                <div class="movie-genres">
                                    <?php foreach ($movie->genres as $genre): ?>
                                        <span class="badge"><?= Html::encode($genre->name) ?></span>
                                    <?php endforeach; ?>
                                </div>
                                <div class="movie-countries">
                                    <?php foreach ($movie->countries as $country): ?>
                                        <span class="badge"><?= Html::encode($country->name) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
</div>

<style>
    /* ===== Сетка фильмов ===== */
    .movies-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 25px;
        justify-items: center;
        margin-top: 20px;
    }

    /* Карточка фильма */
    .movie-card {
        width: 300px;
        transition: transform 0.2s ease;
    }

    .movie-card:hover {
        transform: scale(1.02);
    }

    /* Обёртка для постера и оверлея */
    .movie-poster-wrapper {
        position: relative;
        width: 100%;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    /* Постер */
    .movie-poster {
        width: 100%;
        height: auto;
        display: block;
    }

    /* Оверлей – тёмный фон, появляется при наведении */
    .movie-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.75); /* слабый тёмный фон */
        color: white;
        opacity: 0;
        transition: opacity 0.3s ease;
        backdrop-filter: blur(2px);
        border-radius: 12px;
    }

    .movie-poster-wrapper:hover .movie-overlay {
        opacity: 1;
    }

    /* Содержимое оверлея – занимает всю высоту */
    .overlay-content {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
        padding: 12px;
        box-sizing: border-box;
    }

    /* Верхняя строка: длительность слева, год+рейтинг справа */
    .overlay-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        width: 100%;
        font-size: 0.9rem;
        font-weight: bold;
    }

    .duration {
        background: rgba(0,0,0,0.5);
        padding: 4px 8px;
        border-radius: 20px;
        backdrop-filter: blur(4px);
    }

    .top-right {
        text-align: right;
    }

    .year, .rating {
        background: rgba(0,0,0,0.5);
        padding: 4px 8px;
        border-radius: 20px;
        margin-bottom: 4px;
        backdrop-filter: blur(4px);
    }

    /* Нижний блок: жанры и страны */
    .overlay-bottom {
        text-align: left;
        width: 100%;
    }

    .movie-genres .badge,
    .movie-countries .badge {
        background-color: rgba(255,255,255,0.2) !important;
        color: white !important;
        font-size: 0.7rem;
        padding: 4px 8px;
        margin: 2px;
        border-radius: 12px;
        backdrop-filter: blur(4px);
    }

    .movie-countries {
        margin-top: 6px;
    }

    /* Адаптация для маленьких экранов */
    @media (max-width: 576px) {
        .movies-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
        }
        .movie-card {
            width: 150px;
        }
        .overlay-content {
            padding: 8px;
        }
        .duration, .year, .rating {
            font-size: 0.7rem;
            padding: 2px 6px;
        }
        .movie-genres .badge,
        .movie-countries .badge {
            font-size: 0.6rem;
            padding: 2px 6px;
        }
    }
</style>