<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Movie $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="admin-movie-form">
    <div class="form-cinema-card">
        <div class="form-header">
            <h1><i class="fas fa-video me-2"></i> <?= Html::encode($this->title) ?></h1>
        </div>

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Введите название'])->label('<i class="fas fa-heading"></i> Название') ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 5, 'placeholder' => 'Описание...'])->label('<i class="fas fa-align-left"></i> Описание') ?>

        <?= $form->field($model, 'poster')->textInput(['placeholder' => 'Название файла постера (например, poster.jpg)'])->label('<i class="fas fa-image"></i> Постер') ?>

        <?= $form->field($model, 'trailer_url')->textInput(['placeholder' => 'https://youtube.com/...'])->label('<i class="fab fa-youtube"></i> Ссылка на трейлер') ?>

        <div class="form-row">
            <?= $form->field($model, 'year')->input('number', ['min' => 1900, 'max' => date('Y')+5, 'placeholder' => 'Год'])->label('<i class="fas fa-calendar-alt"></i> Год') ?>
            <?= $form->field($model, 'release_date')->input('date')->label('<i class="fas fa-calendar-day"></i> Дата релиза') ?>
            <?= $form->field($model, 'duration')->input('number', ['placeholder' => 'Длительность (мин или сезоны)'])->label('<i class="fas fa-hourglass-half"></i> Длительность') ?>
        </div>

        <?= $form->field($model, 'type_id')->dropDownList(
            \yii\helpers\ArrayHelper::map($types, 'id', 'name'),
            ['prompt' => 'Выберите тип', 'class' => 'form-control']
        )->label('<i class="fas fa-tag"></i> Тип') ?>

        <?= $form->field($model, 'genre_ids')->checkboxList(
            \yii\helpers\ArrayHelper::map($genres, 'id', 'name'),
            [
                'itemOptions' => ['class' => 'form-check-input'],
                'class' => 'checkbox-list-grid',
            ]
        )->label('<i class="fas fa-mask"></i> Жанры') ?>

        <?= $form->field($model, 'country_ids')->checkboxList(
            \yii\helpers\ArrayHelper::map($countries, 'id', 'name'),
            [
                'itemOptions' => ['class' => 'form-check-input'],
                'class' => 'checkbox-list-grid',
            ]
        )->label('<i class="fas fa-globe"></i> Страны') ?>

        <div class="btn-group">
            <?= Html::submitButton('<i class="fas fa-save"></i> Сохранить', ['class' => 'btn-save']) ?>
            <?= Html::a('<i class="fas fa-arrow-left"></i> Назад', ['index'], ['class' => 'btn-back']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<style>
    .admin-movie-form {
        font-family: 'Inter', sans-serif;
    }
    .form-cinema-card {
        max-width: 900px;
        margin: 0 auto;
        background: rgba(18, 22, 32, 0.75);
        backdrop-filter: blur(16px);
        border-radius: 2rem;
        border: 1px solid rgba(255,255,255,0.1);
        padding: 2rem;
        transition: all 0.3s;
    }
    .form-cinema-card:hover {
        border-color: rgba(229,9,20,0.4);
        box-shadow: 0 20px 35px -12px rgba(0,0,0,0.5);
    }
    .form-header h1 {
        font-size: 1.8rem;
        font-weight: 700;
        background: linear-gradient(135deg, #fff, #bfc9ff);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        margin-bottom: 1.5rem;
        border-left: 4px solid #e50914;
        padding-left: 1rem;
    }
    .form-group {
        margin-bottom: 1.3rem;
    }
    .control-label {
        display: block;
        margin-bottom: 0.4rem;
        font-weight: 500;
        color: #e0e4f0;
        font-size: 0.9rem;
    }
    .control-label i {
        margin-right: 8px;
        color: #e50914;
        width: 20px;
    }
    .form-control {
        width: 100%;
        padding: 0.7rem 1rem;
        background: rgba(10,12,18,0.7);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 1.2rem;
        color: #f0f3fa;
        font-size: 0.95rem;
        transition: 0.2s;
    }
    .form-control:focus {
        color: white;
        border-color: #e50914;
        outline: none;
        box-shadow: 0 0 0 3px rgba(229,9,20,0.2);
        background: rgba(20,24,36,0.9);
    }
    textarea.form-control {
        resize: vertical;
    }
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 1rem;
    }
    .checkbox-list-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 0.5rem;
        background: rgba(10,12,18,0.5);
        padding: 1rem;
        border-radius: 1rem;
        margin-top: 0.5rem;
    }
    .checkbox-list-grid .form-check {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .checkbox-list-grid .form-check-input {
        width: 18px;
        height: 18px;
        background-color: rgba(10,12,18,0.7);
        border: 1px solid rgba(255,255,255,0.3);
        border-radius: 0.3rem;
        cursor: pointer;
    }
    .checkbox-list-grid .form-check-input:checked {
        background-color: #e50914;
        border-color: #e50914;
    }
    .checkbox-list-grid .form-check-label {
        color: #cfd4e6;
    }
    .btn-group {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }
    .btn-save {
        background: #e50914;
        border: none;
        padding: 0.7rem 1.8rem;
        border-radius: 2rem;
        font-weight: 600;
        color: white;
        transition: 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }
    .btn-save:hover {
        background: #f6121d;
        transform: translateY(-2px);
    }
    .btn-back {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        padding: 0.7rem 1.8rem;
        border-radius: 2rem;
        font-weight: 600;
        color: #f0f3fa;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: 0.2s;
    }
    .btn-back:hover {
        background: rgba(255,255,255,0.2);
        transform: translateY(-2px);
    }
    @media (max-width: 640px) {
        .admin-movie-form {
            padding: 1rem;
        }
        .form-cinema-card {
            padding: 1.5rem;
        }
        .form-row {
            grid-template-columns: 1fr;
        }
        .btn-group {
            flex-direction: column;
        }
        .checkbox-list-grid {
            grid-template-columns: 1fr;
        }
    }
</style>