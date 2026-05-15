<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "like".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $movie_id
 */
class Like extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'likes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'movie_id'], 'default', 'value' => null],
            [['user_id', 'movie_id'], 'integer'],
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
        ];
    }

}
