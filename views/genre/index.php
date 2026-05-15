<?php
/* @var $this yii\web\View */
/* @var $genres app\models\Genre[] */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Каталог жанров';
?>

<div class="genre-catalog">
    <h1><i class="fas fa-film"></i> Каталог жанров</h1>

    <div class="genre-grid">
        <?php foreach ($genres as $genre):
            $movieCount = $genre->getMovies()->count();
            ?>
            <a href="<?= Url::to(['genre/view', 'id' => $genre->id]) ?>" class="genre-card">
                <div class="genre-image-wrapper">
                    <?= Html::img('@web/uploads/genre/' . $genre->photo, [
                        'class' => 'genre-image',
                        'alt' => Html::encode($genre->name),
                    ]) ?>
                </div>
                <div class="genre-info">
                    <h2 class="genre-name"><?= Html::encode($genre->name) ?></h2>
                    <div class="genre-meta">
                        <i class="fas fa-video"></i>
                        <span><?= $movieCount ?> <?= $movieCount % 10 == 1 && $movieCount % 100 != 11 ? 'фильм' : (in_array($movieCount % 10, [2,3,4]) && !in_array($movieCount % 100, [12,13,14]) ? 'фильма' : 'фильмов') ?></span>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<style>
    .genre-catalog {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem 1rem;
        font-family: 'Inter', sans-serif;
    }

    .genre-catalog h1 {
        font-size: 2rem;
        font-weight: 700;
        background: linear-gradient(135deg, #fff, #bfc9ff);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        margin-bottom: 2rem;
        display: inline-block;
        border-left: 4px solid #e50914;
        padding-left: 1rem;
    }

    .genre-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 1.8rem;
    }

    .genre-card {
        background: rgba(18, 22, 32, 0.75);
        backdrop-filter: blur(12px);
        border-radius: 1.8rem;
        border: 1px solid rgba(255,255,255,0.08);
        overflow: hidden;
        transition: all 0.3s ease;
        text-decoration: none;
        display: block;
    }

    .genre-card:hover {
        transform: translateY(-8px);
        border-color: rgba(229,9,20,0.5);
        box-shadow: 0 20px 30px -12px rgba(0,0,0,0.6);
    }

    .genre-image {
        width: 100%;
        aspect-ratio: 1 / 1;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .genre-card:hover .genre-image {
        transform: scale(1.05);
    }

    .genre-info {
        padding: 1.2rem;
        text-align: center;
        background: linear-gradient(0deg, rgba(10,12,18,0.9) 0%, rgba(18,22,32,0.7) 100%);
    }

    .genre-name {
        font-size: 1.4rem;
        font-weight: 700;
        color: #f0f3fa;
        margin: 0 0 0.5rem 0;
        letter-spacing: -0.3px;
    }

    .genre-meta {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        color: #bfc9ff;
    }

    .genre-meta i {
        color: #e50914;
    }

    @media (max-width: 768px) {
        .genre-grid {
            gap: 1rem;
        }
        .genre-name {
            font-size: 1.2rem;
        }
        .genre-catalog {
            padding: 1rem;
        }
    }
</style>