<?php

namespace app\models;

use Yii;
use yii\base\Model;

class RegisterForm extends Model
{
    public $username;
    public $name;
    public $first_name;
    public $last_name;
    public $birth_date;
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['username', 'name', 'first_name', 'last_name', 'birth_date', 'email', 'password'], 'required'],

            ['username', 'unique', 'targetClass' => User::class, 'message' => 'Этот логин уже занят'],
            ['username', 'match', 'pattern' => '/^[a-zA-Z0-9]+$/u', 'message' => 'Допустимы только латиница!'],


            [['name', 'first_name', 'last_name'], 'string', 'max' => 15],
            [['name', 'first_name', 'last_name'], 'match', 'pattern' => '/^[а-яА-ЯёЁ]+$/u', 'message' => 'Допустимы только кириллица!'],

            ['birth_date', 'date', 'format' => 'php:Y-m-d'],

            ['email', 'email'],

            ['password', 'string', 'min' => 6],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'name' => 'Имя',
            'last_name' => 'Фамилия',
            'first_name' => 'Отчество',
            'birth_date' => 'Дата рождения',
            'email' => 'Почта',
            'password' => 'Пароль',
        ];
    }

    public function register()
    {
        if (!$this->validate()) {
            return false;
        }
        $user = new User();
        $user->username = $this->username;
        $user->name = $this->name;
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->email = $this->email;
        $user->birth_date = $this->birth_date;
        $user->password = Yii::$app->security->generatePasswordHash($this->password);
        return $user->save() ? $user : false;
    }
}