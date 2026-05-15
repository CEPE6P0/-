<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string|null $username
 * @property string|null $name
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $birth_date
 * @property string|null $avatar
 * @property string|null $subscription_type
 * @property string|null $subscription_expires_at
 * @property int|null $is_active
 * @property string|null $role
 * @property string|null $created_at
 * @property string|null $updated_at
 */

class User extends ActiveRecord implements IdentityInterface
{
    public $plainPassword;
    const SUBSCRIPTION_TYPE_ACTIVE = 'active';
    const SUBSCRIPTION_TYPE_INACTIVE = 'inactive';
    const ROLE_USER = 'user';
    const ROLE_ADMIN = 'admin';
    public $avatarFile;
    public $new_password;
    public $confirm_password;

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->plainPassword) {
                // Записываем хеш в поле БД 'password'
                $this->password = Yii::$app->security->generatePasswordHash($this->plainPassword);
            } elseif ($insert && empty($this->password)) {
                $this->addError('plainPassword', 'Пароль не может быть пустым');
                return false;
            }
            return true;
        }
        return false;
    }

    public function hasSubscription()
    {
        return $this->subscription_type === 'active'
            && strtotime($this->subscription_expires_at) > time();
    }

    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            [['email'], 'email'],
            [['avatarFile'], 'file', 'extensions' => 'png, jpg, jpeg', 'skipOnEmpty' => true],
            [['avatar'], 'string', 'max' => 255],

            [['plainPassword'], 'required', 'on' => 'create'],
            [['plainPassword'], 'string', 'min' => 6],
            [['plainPassword'], 'safe'],

            [['new_password', 'confirm_password'], 'required', 'on' => 'changePassword'],
            ['confirm_password', 'compare', 'compareAttribute' => 'new_password'],

            ['username', 'unique', 'targetClass' => User::class, 'message' => 'Этот логин уже занят'],
            ['username', 'match', 'pattern' => '/^[a-zA-Z0-9]+$/u', 'message' => 'Допустимы только латиница!'],


            [['name', 'first_name', 'last_name'], 'string', 'max' => 15],
            [['name', 'first_name', 'last_name'], 'match', 'pattern' => '/^[а-яА-ЯёЁ]+$/u', 'message' => 'Допустимы только кириллица!'],

            ['birth_date', 'date', 'format' => 'php:Y-m-d'],

            ['email', 'email'],

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
            'avatar' => 'Аватар',
            'subscription_type' => 'Подписка',
            'avatarFile' => 'Аватар',
            'confirm_password' => 'Подведите пароль',
            'new_password' => 'Новый пароль',
        ];
    }
    public function getSubscriptionTypeLabel()
    {
        return [
            'active' => 'Активен',
            'inactive' => 'Неактивен',
        ][$this->subscription_type] ?? 'Неизвестно';
    }

    public static function tableName()
    {
        return 'user';
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return null;
    }

    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password);
    }
}
