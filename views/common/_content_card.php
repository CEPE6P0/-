<?php
/*
 * Универсальная карточка для фильмов и сериалов
 */

use yii\helpers\Html;
use yii\helpers\Url;

$mainType = $item->mainType;
$isSeries = $mainType && $mainType->name === 'Сериал';
?>

<div class="content-card">
    <a href="<?= Url::to(['movie/view', 'id' => $item->id]) ?>" class="content-link">
        <div class="poster-wrapper">

            <?= Html::img('@web/uploads/movies/' . $item->poster, [
                'class' => 'content-poster',
                'alt' => Html::encode($item->title),
                'onerror' => "this.src='" . Yii::getAlias('@web/uploads/movies/no-poster.jpg') . "'"
            ]) ?>
            <div class="content-overlay">
                <div class="overlay-content">
                    <div class="overlay-top">
                        <?php if ($isSeries): ?>

                            <div class="duration">
                                📺 <?= $item->duration ?>

                                <?php
                                $seasons = $item->duration;

                                if ($seasons % 10 == 1 && $seasons % 100 != 11) {
                                    echo ' сезон';
                                } elseif (
                                    $seasons % 10 >= 2 &&
                                    $seasons % 10 <= 4 &&
                                    ($seasons % 100 < 10 || $seasons % 100 >= 20)
                                ) {
                                    echo ' сезона';
                                } else {
                                    echo ' сезонов';
                                }
                                ?>
                            </div>

                        <?php else: ?>

                            <div class="duration">
                                ⏱
                                <?php
                                $h = floor($item->duration / 60);
                                $m = $item->duration % 60;

                                echo ($h ? $h . ' ч ' : '') . ($m ? $m . ' мин' : '0 мин');
                                ?>
                            </div>

                        <?php endif; ?>

                        <div class="top-right">
                            <div class="year">🎬 <?= Html::encode($item->year) ?></div>
                            <div class="rating">⭐ <?= Html::encode($item->rating_avg ?? '0') ?></div>
                        </div>
                    </div>
                    <div class="overlay-bottom">
                        <div class="item-genres">
                            <?php foreach ($item->genres as $genre): ?>
                                <span class="badge"><?= Html::encode($genre->name) ?></span>
                            <?php endforeach; ?>
                        </div>
                        <div class="item-countries">
                            <?php foreach ($item->countries as $country): ?>
                                <span class="badge"><?= Html::encode($country->name) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>