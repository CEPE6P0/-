<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = $model->isNewRecord ? 'Создать пользователя' : 'Редактировать пользователя';
?>

<div class="admin-user-form">
    <div class="form-cinema-card">
        <div class="form-header">
            <h1><i class="fas fa-user-plus me-2"></i> <?= Html::encode($this->title) ?></h1>
        </div>

        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
        ]); ?>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'example@mail.com'])->label('<i class="fas fa-envelope"></i> Email') ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'placeholder' => 'Логин'])->label('<i class="fas fa-user-circle"></i> Логин') ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Имя'])->label('<i class="fas fa-user"></i> Имя') ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'first_name')->textInput(['maxlength' => true, 'placeholder' => 'Фамилия'])->label('<i class="fas fa-user-tag"></i> Фамилия') ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'last_name')->textInput(['maxlength' => true, 'placeholder' => 'Отчество'])->label('<i class="fas fa-user-friends"></i> Отчество') ?>
            </div>
        </div>

        <!-- БЛОК ПАРОЛЯ (для создания и опционально для редактирования) -->


        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'birth_date')->input('date', ['class' => 'form-control'])->label('<i class="fas fa-cake-candles"></i> Дата рождения') ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'avatar')->fileInput()->label('<i class="fas fa-image"></i> Аватар (jpg, png)') ?>
                <?php if ($model->avatar): ?>
                    <div class="mt-2">
                        <img src="<?= Yii::getAlias('@web/uploads/') . $model->avatar ?>" width="60" style="border-radius: 50%;">
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div>
            <?= $form->field($model, 'plainPassword')->passwordInput(['maxlength' => true, 'placeholder' => 'Введите пароль'])->label('<i class="fas fa-lock"></i> Пароль') ?>
        </div>

        <div class="btn-group">
            <?= Html::submitButton('<i class="fas fa-save"></i> Сохранить', ['class' => 'btn-save']) ?>
            <?= Html::a('<i class="fas fa-arrow-left"></i> Назад', ['index'], ['class' => 'btn-back']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<style>
    /* Стили такие же, как были, только добавим небольшую поддержку */
    .admin-user-form {
        font-family: 'Inter', sans-serif;
        min-height: 100vh;
    }
    .form-cinema-card {
        max-width: 800px;
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
        margin-bottom: 0.5rem;
        display: inline-block;
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
    input[type='file'] {
        padding: 0.5rem;
        background: rgba(10,12,18,0.6);
        border: 1px dashed rgba(255,255,255,0.3);
    }
    input[type='file']::file-selector-button {
        background: #e50914;
        border: none;
        padding: 0.3rem 1rem;
        border-radius: 2rem;
        color: white;
        margin-right: 1rem;
        cursor: pointer;
    }
    .help-block {
        color: #f97316;
        font-size: 0.7rem;
        margin-top: 0.3rem;
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
        .admin-user-form {
            padding: 1rem;
        }
        .form-cinema-card {
            padding: 1.5rem;
        }
        .btn-group {
            flex-direction: column;
        }
    }
</style>