<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Смена пароля';
?>

<div class="change-password-container">
    <div class="cinema-card">
        <div class="card-header">
            <i class="fas fa-key"></i>
            <h2>Новый пароль</h2>
            <p>Придумайте надёжный пароль, который вы ещё не использовали</p>
        </div>

        <?php $form = ActiveForm::begin([
            'options' => ['class' => 'change-password-form'],
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'control-label'],
                'errorOptions' => ['class' => 'help-block']
            ]
        ]); ?>

        <div class="form-group">
            <?= $form->field($user, 'new_password')->passwordInput([
                'placeholder' => '••••••••',
                'class' => 'form-control'
            ])->label('<i class="fas fa-lock"></i> Новый пароль') ?>
        </div>

        <div class="form-group">
            <?= $form->field($user, 'confirm_password')->passwordInput([
                'placeholder' => '••••••••',
                'class' => 'form-control'
            ])->label('<i class="fas fa-check-circle"></i> Подтверждение пароля') ?>
        </div>

        <?= Html::submitButton('<i class="fas fa-save"></i> Сменить пароль', ['class' => 'btn-cinema-submit']) ?>

        <?php ActiveForm::end(); ?>

        <div class="back-link">
            <?= Html::a('<i class="fas fa-arrow-left"></i> Вернуться в профиль', ['profile/index']) ?>
        </div>
    </div>
</div>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }


    .change-password-container {
        max-width: 550px;
        width: 100%;
        margin: 100px auto;
    }

    .cinema-card {
        background: rgba(18, 22, 32, 0.75);
        backdrop-filter: blur(16px);
        border-radius: 2rem;
        border: 1px solid rgba(255,255,255,0.08);
        padding: 2rem 2rem 2.5rem;
        box-shadow: 0 25px 45px -12px rgba(0,0,0,0.5);
        transition: all 0.3s ease;
    }

    .cinema-card:hover {
        border-color: rgba(229,9,20,0.3);
    }

    .card-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .card-header i {
        font-size: 3rem;
        color: #e50914;
        background: rgba(229,9,20,0.15);
        padding: 1rem;
        border-radius: 50%;
        margin-bottom: 1rem;
    }

    .card-header h2 {
        font-size: 1.8rem;
        font-weight: 700;
        background: linear-gradient(135deg, #fff, #bfc9ff);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        margin-bottom: 0.5rem;
    }

    .card-header p {
        color: #9aa4bf;
        font-size: 0.9rem;
    }

    /* Стили полей формы */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #e0e4f0;
        font-size: 0.9rem;
        letter-spacing: 0.3px;
    }

    .form-group label i {
        margin-right: 8px;
        color: #e50914;
        font-size: 0.9rem;
    }

    .form-control {
        width: 100%;
        padding: 0.9rem 1.2rem;
        background: rgba(10, 12, 18, 0.6);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 1.2rem;
        font-size: 1rem;
        color: #f0f3fa;
        transition: all 0.2s;
        font-family: 'Inter', monospace;
    }

    .form-control:focus {
        color: white;
        outline: none;
        border-color: #e50914;
        background: rgba(20, 24, 36, 0.8);
        box-shadow: 0 0 0 3px rgba(229,9,20,0.2);
    }

    .help-block {
        color: #f97316;
        font-size: 0.75rem;
        margin-top: 0.4rem;
        margin-left: 0.5rem;
    }

    .btn-cinema-submit {
        width: 100%;
        padding: 0.9rem;
        background: #e50914;
        border: none;
        border-radius: 2rem;
        font-weight: 700;
        font-size: 1rem;
        color: white;
        cursor: pointer;
        transition: 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-top: 0.5rem;
        box-shadow: 0 8px 20px rgba(229,9,20,0.3);
    }

    .btn-cinema-submit:hover {
        background: #f6121d;
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(229,9,20,0.4);
    }

    .btn-cinema-submit:active {
        transform: translateY(1px);
    }

    .back-link {
        text-align: center;
        margin-top: 1.8rem;
    }

    .back-link a {
        color: #9aa4bf;
        text-decoration: none;
        font-size: 0.9rem;
        transition: 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .back-link a:hover {
        color: #e50914;
    }

    /* Убираем стандартные обводки Yii */
    .has-error .form-control {
        border-color: #f97316;
    }
</style>