<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap5\BootstrapAsset;
$this->registerCssFile('@web/css/content-card.css');
$this->registerJsFile('@web/js/content-card.js');
?>

<div class="search-cinema">
        <h1 class="search-header"><i class="fas fa-search me-2"></i> Поиск</h1>

        <?php $form = ActiveForm::begin([
            'method' => 'get',
            'action' => ['search/index'],
            'options' => ['class' => 'mb-5']
        ]); ?>

        <!-- Строка поиска + кнопка в одну строку -->
        <div class="row g-3 mb-4">
            <div class="col-md-10">
                <?= Html::textInput('q', Yii::$app->request->get('q'), [
                    'class' => 'form-control-cinema',
                    'placeholder' => 'Название фильма или сериала...'
                ]) ?>
            </div>
            <div class="col-md-2">
                <?= Html::submitButton('<i class="fas fa-search me-1"></i> Найти', [
                    'class' => 'btn-cinema-primary w-100'
                ]) ?>
            </div>
        </div>

        <!-- Блок фильтров + кнопка сброса в одну строку -->
        <div class="cinema-card-glass">
            <div class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label class="filter-label">Год</label>
                    <?= Html::dropDownList('year', Yii::$app->request->get('year'), [
                        '2026' => '2026', '2025' => '2025', '2024' => '2024', '2023' => '2023', '2022' => '2022',
                        '2021' => '2021', '2016-2020' => '2016–2020', '2011-2015' => '2011–2015',
                        '2006-2010' => '2006–2010', '2000-2005' => '2000–2005', '1990-1999' => '1990–1999',
                    ], [
                        'prompt' => 'Любой',
                        'class' => 'form-control-cinema'
                    ]) ?>
                </div>
                <div class="col-md-2">
                    <label class="filter-label">Страна</label>
                    <?= Html::dropDownList('country', Yii::$app->request->get('country'), $countries, [
                        'prompt' => 'Любая',
                        'class' => 'form-control-cinema'
                    ]) ?>
                </div>
                <div class="col-md-2">
                    <label class="filter-label">Жанр</label>
                    <?= Html::dropDownList('genre', Yii::$app->request->get('genre'), $genres, [
                        'prompt' => 'Любой',
                        'class' => 'form-control-cinema'
                    ]) ?>
                </div>
                <div class="col-md-2">
                    <label class="filter-label">Тип</label>
                    <?= Html::dropDownList('type', Yii::$app->request->get('type'), [
                        1 => 'Фильм', 2 => 'Сериал'
                    ], [
                        'prompt' => 'Любой',
                        'class' => 'form-control-cinema'
                    ]) ?>
                </div>
                <div class="col-md-2">
                    <label class="filter-label">Рейтинг (от)</label>
                    <?= Html::dropDownList('rating', Yii::$app->request->get('rating'), [
                        1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10
                    ], [
                        'prompt' => 'Любой',
                        'class' => 'form-control-cinema'
                    ]) ?>
                </div>
                <div class="col-md-2">
                    <?= Html::a('Сбросить', ['search/index'], [
                        'class' => 'btn-cinema-secondary w-100 d-inline-block text-center'
                    ]) ?>
                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

        <!-- Результаты -->
        <div class="content-grid">
            <?php if ($movies): ?>
                <?php foreach ($movies as $movie): ?>
                    <?= $this->render('//common/_content_card', [
                        'item' => $movie,
                        'type' => (!empty($movie->movieTypes) && $movie->movieTypes[0]->type_id == 2) ? 'serie' : 'movie'
                    ]) ?>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center text-white-50 py-5">
                    <i class="fas fa-film fa-3x mb-3 opacity-50"></i>
                    <p>Ничего не найдено. Попробуйте изменить параметры поиска.</p>
                </div>
            <?php endif; ?>
        </div>
</div>

<style>
    .search-cinema .search-header {
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
    .cinema-card-glass {
        background: rgba(18, 22, 32, 0.75);
        backdrop-filter: blur(16px);
        border-radius: 1.8rem;
        border: 1px solid rgba(255,255,255,0.1);
        padding: 1.8rem;
        transition: all 0.3s;
    }
    .cinema-card-glass:hover {
        border-color: rgba(229,9,20,0.4);
        box-shadow: 0 20px 35px -12px rgba(0,0,0,0.5);
    }
    .form-control-cinema {
        background: rgba(10, 12, 18, 0.7);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 1.2rem;
        padding: 0.7rem 1rem;
        color: #f0f3fa;
        transition: all 0.2s;
        width: 100%;
    }
    .form-control-cinema:focus {
        background: rgba(20, 24, 36, 0.9);
        border-color: #e50914;
        box-shadow: 0 0 0 3px rgba(229,9,20,0.2);
        color: white;
    }
    select.form-control-cinema {
        cursor: pointer;
    }
    .btn-cinema-primary {
        background: #e50914;
        border: none;
        padding: 0.7rem 1.5rem;
        border-radius: 2rem;
        font-weight: 600;
        color: white;
        transition: 0.2s;
    }
    .btn-cinema-primary:hover {
        background: #f6121d;
        transform: translateY(-2px);
    }
    .btn-cinema-secondary {
        text-decoration: none;
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        padding: 0.7rem 1.5rem;
        border-radius: 2rem;
        font-weight: 600;
        color: #f0f3fa;
        transition: 0.2s;
    }
    .btn-cinema-secondary:hover {
        background: rgba(255,255,255,0.2);
        transform: translateY(-2px);
    }
    .filter-label {
        font-size: 0.8rem;
        margin-bottom: 0.3rem;
        color: #9aa4bf;
        display: block;
    }
    @media (max-width: 768px) {
        .search-cinema {
            padding: 1rem;
        }
    }
</style>