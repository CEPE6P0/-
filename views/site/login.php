<?php
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Авторизация';
?>
<div class="site-login">
    <div class="cinema-auth-card">
        <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
        <hr>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'form-label'],
                'inputOptions' => ['class' => 'form-control'],
                'errorOptions' => ['class' => 'invalid-feedback'],
            ],
        ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Логин или email']) ?>
        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Пароль']) ?>
        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"form-check\">{input} {label}</div>\n<div>{error}</div>",
            'class' => 'form-check-input',
            'labelOptions' => ['class' => 'form-check-label']
        ]) ?>

        <div class="form-group mt-3">
            <?= Html::submitButton('Авторизоваться', ['class' => 'btn btn-cinema-primary']) ?>
            <hr class="my-3">
            <div class="d-flex justify-content-center gap-2">
                <span class="text-white-50">У вас ещё нет аккаунта?</span>
                <?= Html::a('Регистрация', 'register', ['class' => 'text-primary text-decoration-none']) ?>
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
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .cinema-auth-card {
        background: rgba(18, 22, 32, 0.85);
        backdrop-filter: blur(16px);
        border-radius: 2rem;
        border: 1px solid rgba(255,255,255,0.1);
        padding: 2rem;
        transition: all 0.3s;
        width: 100%;
        max-width: 460px;
    }

    .cinema-auth-card:hover {
        border-color: rgba(229,9,20,0.4);
        box-shadow: 0 20px 35px -12px rgba(0,0,0,0.5);
    }

    .cinema-auth-card h1 {
        font-size: 1.9rem;
        font-weight: 700;
        background: linear-gradient(135deg, #fff, #bfc9ff);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        margin-bottom: 0.5rem;
    }

    .cinema-auth-card hr {
        border-color: rgba(255,255,255,0.1);
        margin: 1rem 0;
    }

    .cinema-auth-card .form-label {
        font-weight: 500;
        color: #e0e4f0;
        letter-spacing: 0.3px;
        margin-bottom: 0.5rem;
    }

    .cinema-auth-card .form-control {
        background: rgba(10, 12, 18, 0.7);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 1.2rem;
        padding: 0.7rem 1rem;
        color: #f0f3fa;
        transition: all 0.2s;
    }

    .cinema-auth-card .form-control:focus {
        background: rgba(20, 24, 36, 0.9);
        border-color: #e50914;
        box-shadow: 0 0 0 3px rgba(229,9,20,0.2);
        color: white;
    }

    .cinema-auth-card .form-check-input {
        background-color: rgba(10,12,18,0.7);
        border-color: rgba(255,255,255,0.3);
    }
    .cinema-auth-card .form-check-input:checked {
        background-color: #e50914;
        border-color: #e50914;
    }
    .cinema-auth-card .form-check-label {
        color: #cfd4e6;
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

    .cinema-auth-card .text-primary {
        color: #e50914 !important;
        text-decoration: none;
        font-weight: 500;
    }
    .cinema-auth-card .text-primary:hover {
        text-decoration: underline;
    }

    .invalid-feedback {
        color: #f97316;
        font-size: 0.75rem;
    }
</style>