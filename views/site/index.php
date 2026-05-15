<?php

/** @var yii\web\View $this */

use yii\helpers\Url;

$this->title = 'Главная';
$this->registerCssFile('@web/css/content-card.css');
$this->registerJsFile('@web/js/content-card.js');

?>

<div class="site-index">
    <div class="hero-slider">
        <button class="hero-arrow left">‹</button>

        <div class="hero-track">

            <div class="hero-slide">
                <img src="<?= Url::to('@web/uploads/slider/slide1.jpg') ?>" alt="">
            </div>

            <div class="hero-slide">
                <img src="<?= Url::to('@web/uploads/slider/slide2.jpg') ?>" alt="">
            </div>

            <div class="hero-slide">
                <img src="<?= Url::to('@web/uploads/slider/slide3.jpg') ?>" alt="">
            </div>

            <div class="hero-slide">
                <img src="<?= Url::to('@web/uploads/slider/slide4.jpg') ?>" alt="">
            </div>

            <div class="hero-slide">
                <img src="<?= Url::to('@web/uploads/slider/slide5.jpg') ?>" alt="">
            </div>

        </div>

        <button class="hero-arrow right">›</button>
    </div>

    <h2><i class="fas fa-clock"></i> Новинки</h2>
    <div class="slider">
        <button class="slider-arrow left">‹</button>
        <div class="slider-track">
            <?php foreach ($newMovies as $item): ?>
                <?= $this->render('//common/_content_card', [
                    'item' => $item,
                    'type' => 'movie'
                ]) ?>
            <?php endforeach; ?>
        </div>
        <button class="slider-arrow right">›</button>
    </div>

    <h2><i class="fas fa-trophy"></i> Лучшие фильмы</h2>
    <div class="slider">
        <button class="slider-arrow left">‹</button>
        <div class="slider-track">
            <?php foreach ($topMovies as $item): ?>
                <?= $this->render('//common/_content_card', [
                    'item' => $item,
                    'type' => 'movie'
                ]) ?>
            <?php endforeach; ?>
        </div>
        <button class="slider-arrow right">›</button>
    </div>

    <h2><i class="fas fa-globe"></i> Зарубежные фильмы</h2>
    <div class="slider">
        <button class="slider-arrow left">‹</button>
        <div class="slider-track">
            <?php foreach ($foreignMovies as $item): ?>
                <?= $this->render('//common/_content_card', [
                    'item' => $item,
                    'type' => 'movie'
                ]) ?>
            <?php endforeach; ?>
        </div>
        <button class="slider-arrow right">›</button>
    </div>

    <h2><i class="fas fa-flag-checkered"></i> Русские фильмы</h2>
    <div class="slider">
        <button class="slider-arrow left">‹</button>
        <div class="slider-track">
            <?php foreach ($russianMovies as $item): ?>
                <?= $this->render('//common/_content_card', [
                    'item' => $item,
                    'type' => 'movie'
                ]) ?>
            <?php endforeach; ?>
        </div>
        <button class="slider-arrow right">›</button>
    </div>

    <h2><i class="fas fa-list"></i> Жанры</h2>

    <div class="slider">
        <button class="slider-arrow left">‹</button>

        <div class="slider-track">
            <?php foreach ($genres as $genre): ?>
                <div class="genre-card">
                    <a href="/KINO/web/site/genre?id=<?= $genre->id ?>">
                        <div class="genre-name">
                            <?= $genre->name ?>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <button class="slider-arrow right">›</button>
    </div>

    <h2><i class="fas fa-tv"></i> Сериалы</h2>
    <div class="slider">
        <button class="slider-arrow left">‹</button>
        <div class="slider-track">
            <?php foreach ($series as $item): ?>
                <?= $this->render('//common/_content_card', [
                    'item' => $item,
                    'type' => 'serie'
                ]) ?>
            <?php endforeach; ?>
        </div>
        <button class="slider-arrow right">›</button>
    </div>



    <h2><i class="fas fa-child"></i> Мультфильмы</h2>
    <div class="slider">
        <button class="slider-arrow left">‹</button>
        <div class="slider-track">
            <?php foreach ($cartoons as $item): ?>
                <?= $this->render('//common/_content_card', [
                    'item' => $item,
                    'type' => 'movie'
                ]) ?>
            <?php endforeach; ?>
        </div>
        <button class="slider-arrow right">›</button>
    </div>
</div>

<style>
    .hero-slider {
        position: relative;
        width: 100%;
        height: 700px;
        overflow: hidden;
        margin-bottom: 30px;
    }

    .hero-track {
        display: flex;
        transition: transform 0.5s ease;
        height: 100%;
    }

    .hero-slide {
        min-width: 100%;
        height: 100%;
    }

    .hero-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .hero-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        font-size: 40px;
        background: rgba(0,0,0,0.5);
        color: #fff;
        border: none;
        cursor: pointer;
        z-index: 2;
        padding: 10px 15px;
    }

    .hero-arrow.left { left: 10px; }
    .hero-arrow.right { right: 10px; }





    .genre-card {
        min-width: 150px;
        height: 100px;
        margin-right: 15px;
        background: #1e1e1e;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.3s;
    }

    .genre-card:hover {
        transform: scale(1.05);
        background: #333;
    }

    .genre-name {
        color: #fff;
        font-weight: bold;
        text-align: center;
        text-decoration: none;
    }
    a {
        text-decoration: none;

    }

    .site-index {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem 1rem;
        font-family: 'Inter', sans-serif;
    }

    .site-index h2 {
        font-size: 1.8rem;
        font-weight: 700;
        background: linear-gradient(135deg, #fff, #bfc9ff);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        margin: 2rem 0 1rem;
        display: inline-block;
        border-left: 4px solid #e50914;
        padding-left: 1rem;
    }

    .site-index h2:first-of-type {
        margin-top: 0;
    }

    /* Оформление слайдеров */


    @media (max-width: 768px) {
        .site-index {
            padding: 1rem;
        }
        .site-index h2 {
            font-size: 1.4rem;
        }
    }
</style>

<script>
    let index = 0;

    const track = document.querySelector('.hero-track');
    const slides = document.querySelectorAll('.hero-slide');

    document.querySelector('.hero-arrow.right').onclick = () => {
        index = (index + 1) % slides.length;
        track.style.transform = `translateX(-${index * 100}%)`;
    };

    document.querySelector('.hero-arrow.left').onclick = () => {
        index = (index - 1 + slides.length) % slides.length;
        track.style.transform = `translateX(-${index * 100}%)`;
    };
</script>