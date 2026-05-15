<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "review".
 *
 * @property int $id
 * @property int $user_id
 * @property int $movie_id
 * @property string|null $text
 * @property string|null $created_at
 */
class Review extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'review';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text', 'created_at'], 'default', 'value' => null],
            [['user_id', 'movie_id'], 'required'],
            [['user_id', 'movie_id'], 'integer'],
            [['text'], 'string'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'movie_id' => 'Movie ID',
            'text' => 'Text',
            'created_at' => 'Created At',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(\app\models\User::class, ['id' => 'user_id']);
    }

    public function getRating()
    {
        return $this->hasOne(Rating::class, ['movie_id' => 'movie_id'])
            ->onCondition(['rating.user_id' => $this->user_id]);
    }
}
