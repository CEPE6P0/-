<?php
/* @var $this yii\web\View */
/* @var $genre app\models\Genre */
/* @var $movies app\models\Movie[] */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $genre->name;
?>

    <div class="container mt-4">
        <!-- Кнопка назад -->
        <div class="mb-3">
            <a href="<?= Url::to(['genre/index']) ?>" class="btn btn-outline-secondary btn-sm">
                ← Назад к жанрам
            </a>
        </div>

        <!-- Заголовок жанра -->
        <h1 class="mb-4"><?= Html::encode($genre->name) ?></h1>

        <?php
        // Разделяем фильмы и сериалы по ID типа
        $moviesList = [];
        $seriesList = [];

        foreach ($movies as $movie) {
            // Проверяем тип через movieTypes -> type
            $isSerie = false;
            foreach ($movie->movieTypes as $movieType) {
                // Обращаемся к связанной модели Type
                if ($movieType->type && $movieType->type->id == 2) { // 2 - ID сериала
                    $isSerie = true;
                    break;
                }
            }

            if ($isSerie) {
                $seriesList[] = $movie;
            } else {
                $moviesList[] = $movie;
            }
        }
        ?>

        <!-- Фильмы -->
        <?php if (!empty($moviesList)): ?>
            <h2 class="mb-3">🎬 Фильмы</h2>
            <div class="content-grid mb-5">
                <?php foreach ($moviesList as $movie): ?>
                    <?= $this->render('//common/_content_card', [
                        'item' => $movie,
                        'type' => 'movie'
                    ]) ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Сериалы -->
        <?php if (!empty($seriesList)): ?>
            <h2 class="mb-3">📺 Сериалы</h2>
            <div class="content-grid">
                <?php foreach ($seriesList as $serie): ?>
                    <?= $this->render('//common/_content_card', [
                        'item' => $serie,
                        'type' => 'serie'
                    ]) ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Если ничего нет -->
        <?php if (empty($moviesList) && empty($seriesList)): ?>
            <div class="alert alert-info">
                В этом жанре пока нет фильмов или сериалов
            </div>
        <?php endif; ?>
    </div>

<?php
$this->registerCssFile('@web/css/content-card.css');
?>