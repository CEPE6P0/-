<?php
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Регистрация';
?>
<div class="site-login">
    <div class="cinema-reg-card">
        <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
        <hr>

        <?php $form = ActiveForm::begin([
            'id' => 'register-form',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'form-label'],
                'inputOptions' => ['class' => 'form-control'],
                'errorOptions' => ['class' => 'invalid-feedback'],
            ],
        ]); ?>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Придумайте логин']) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'email')->textInput(['placeholder' => 'example@mail.com']) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'last_name')->textInput(['placeholder' => 'Фамилия']) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'name')->textInput(['placeholder' => 'Имя']) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'first_name')->textInput(['placeholder' => 'Отчество (необязательно)']) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'birth_date')->input('date') ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Минимум 6 символов']) ?>
            </div>
        </div>

        <div class="form-group mt-3">
            <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-cinema-primary']) ?>
            <hr class="my-3">
            <div class="d-flex justify-content-center gap-2">
                <span class="text-white-50">У вас уже есть аккаунт?</span>
                <?= Html::a('Авторизация', 'login', ['class' => 'text-primary text-decoration-none']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<style>
    .site-login {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
    }

    .cinema-reg-card {
        background: rgba(18, 22, 32, 0.85);
        backdrop-filter: blur(16px);
        border-radius: 2rem;
        border: 1px solid rgba(255,255,255,0.1);
        padding: 2rem;
        transition: all 0.3s;
        width: 100%;
        max-width: 700px;
        margin: 0 auto;
    }

    .cinema-reg-card:hover {
        border-color: rgba(229,9,20,0.4);
        box-shadow: 0 20px 35px -12px rgba(0,0,0,0.5);
    }

    .cinema-reg-card h1 {
        font-size: 1.9rem;
        font-weight: 700;
        background: linear-gradient(135deg, #fff, #bfc9ff);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        margin-bottom: 0.5rem;
    }

    .cinema-reg-card hr {
        border-color: rgba(255,255,255,0.1);
        margin: 1rem 0;
    }

    .cinema-reg-card .form-label {
        font-weight: 500;
        color: #e0e4f0;
        letter-spacing: 0.3px;
        margin-bottom: 0.5rem;
    }

    .cinema-reg-card .form-control {
        background: rgba(10, 12, 18, 0.7);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 1.2rem;
        padding: 0.7rem 1rem;
        color: #f0f3fa;
        transition: all 0.2s;
    }

    .cinema-reg-card .form-control:focus {
        background: rgba(20, 24, 36, 0.9);
        border-color: #e50914;
        box-shadow: 0 0 0 3px rgba(229,9,20,0.2);
        color: white;
    }

    .cinema-reg-card input[type='date']::-webkit-calendar-picker-indicator {
        filter: invert(1);
        cursor: pointer;
    }

    .btn-cinema-primary {
        background: #e50914;
        border: none;
        padding: 0.7rem;
        border-radius: 2rem;
        font-weight: 700;
        font-size: 1rem;
        transition: 0.2s;
        width: 100%;
        color: white;
    }
    .btn-cinema-primary:hover {
        background: #f6121d;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(229,9,20,0.4);
    }

    .cinema-reg-card .text-primary {
        color: #e50914 !important;
        text-decoration: none;
        font-weight: 500;
    }
    .cinema-reg-card .text-primary:hover {
        text-decoration: underline;
    }

    .invalid-feedback {
        color: #f97316;
        font-size: 0.75rem;
    }

    @media (max-width: 576px) {
        .cinema-reg-card {
            padding: 1.5rem;
        }
    }
</style>