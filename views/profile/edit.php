<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Редактирование профиля';
?>
<div class="edit-profile-wrapper">
    <div class="cinema-card">
        <div class="card-header">
            <i class="fas fa-user-edit"></i>
            <h2>Редактирование профиля</h2>
        </div>

        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data', 'id' => 'profile-form'],
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'control-label'],
                'errorOptions' => ['class' => 'help-block']
            ]
        ]); ?>

        <!-- Сетка на две колонки для основных полей -->
        <div class="form-grid">
            <?= $form->field($user, 'username')->textInput(['class' => 'form-control', 'placeholder' => 'Логин'])->label('<i class="fas fa-user-circle"></i> Логин') ?>
            <?= $form->field($user, 'email')->input('email', ['class' => 'form-control', 'placeholder' => 'example@mail.com'])->label('<i class="fas fa-envelope"></i> Email') ?>

            <?= $form->field($user, 'last_name')->textInput(['class' => 'form-control', 'placeholder' => 'Фамилия'])->label('<i class="fas fa-user-tag"></i> Фамилия') ?>
            <?= $form->field($user, 'name')->textInput(['class' => 'form-control', 'placeholder' => 'Имя'])->label('<i class="fas fa-user"></i> Имя') ?>

            <?= $form->field($user, 'first_name')->textInput(['class' => 'form-control', 'placeholder' => 'Отчество'])->label('<i class="fas fa-user-friends"></i> Отчество') ?>
            <?= $form->field($user, 'birth_date')->input('date', ['class' => 'form-control'])->label('<i class="fas fa-cake-candles"></i> Дата рождения') ?>
        </div>

        <!-- Поле аватара на всю ширину -->
        <?= $form->field($user, 'avatarFile')->fileInput()->label('<i class="fas fa-image"></i> Аватар (jpg, png)') ?>

        <div class="btn-group">
            <?= Html::submitButton('<i class="fas fa-save"></i> Сохранить', ['class' => 'btn-save']) ?>
            <?= Html::a('<i class="fas fa-arrow-left"></i> Назад', ['profile/index'], ['class' => 'btn-back']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#profile-form').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);
        let formData = new FormData(this);

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                if (response.success) {
                    alert('Профиль обновлён');
                    location.reload();
                } else {
                    console.log(response.errors);
                    alert('Ошибка при сохранении');
                }
            }
        });

        return false;
    });
</script>

<style>
    .edit-profile-wrapper {
        max-width: 900px;
        margin: 0 auto;
        padding: 1rem;
        box-sizing: border-box;
    }
    .edit-profile-wrapper * {
        box-sizing: border-box;
    }

    /* Основная карточка */
    .cinema-card {
        background: rgba(18, 22, 32, 0.75);
        backdrop-filter: blur(16px);
        border-radius: 2rem;
        border: 1px solid rgba(255,255,255,0.08);
        padding: 2rem;
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
        font-size: 2.5rem;
        color: #e50914;
        background: rgba(229,9,20,0.15);
        padding: 0.8rem;
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
    }

    /* Сетка для полей в две колонки */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem 1.5rem;
    }
    .form-grid .form-group {
        margin-bottom: 0;
    }
    .full-width {
        grid-column: span 2;
    }

    /* Стили полей формы */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .control-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #e0e4f0;
        font-size: 0.9rem;
        letter-spacing: 0.3px;
    }

    .control-label i {
        margin-right: 8px;
        color: #e50914;
        width: 20px;
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
        font-family: 'Inter', sans-serif;
    }

    .form-control:focus {
        outline: none;
        border-color: #e50914;
        background: rgba(20, 24, 36, 0.8);
        box-shadow: 0 0 0 3px rgba(229,9,20,0.2);
    }

    input[type='file'] {
        padding: 0.6rem;
        background: rgba(10, 12, 18, 0.6);
        border: 1px dashed rgba(255,255,255,0.3);
        border-radius: 1.2rem;
        color: #ccc;
    }

    input[type='file']::file-selector-button {
        background: #e50914;
        border: none;
        padding: 0.4rem 1rem;
        border-radius: 2rem;
        color: white;
        font-weight: 600;
        margin-right: 1rem;
        cursor: pointer;
        transition: 0.2s;
    }

    input[type='file']::file-selector-button:hover {
        background: #f6121d;
    }

    .help-block {
        color: #f97316;
        font-size: 0.75rem;
        margin-top: 0.4rem;
        margin-left: 0.5rem;
    }

    .btn-group {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
        flex-wrap: wrap;
    }

    .btn-save {
        background: #e50914;
        border: none;
        padding: 0.8rem 2rem;
        border-radius: 2rem;
        font-weight: 700;
        font-size: 1rem;
        color: white;
        cursor: pointer;
        transition: 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 8px 20px rgba(229,9,20,0.3);
    }

    .btn-save:hover {
        background: #f6121d;
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(229,9,20,0.4);
    }

    .btn-back {
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(4px);
        border: 1px solid rgba(255,255,255,0.2);
        padding: 0.8rem 2rem;
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
        color: white;
    }

    /* Адаптив */
    @media (max-width: 576px) {
        .edit-profile-wrapper {
            padding: 0.5rem;
        }
        .cinema-card {
            padding: 1.5rem;
        }
        .form-grid {
            grid-template-columns: 1fr;
            gap: 0.5rem;
        }
        .btn-group {
            flex-direction: column;
        }
        .btn-save, .btn-back {
            justify-content: center;
        }
    }
</style>