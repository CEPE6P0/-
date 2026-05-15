<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "movie_genre".
 *
 * @property int $movie_id
 * @property int $genre_id
 *
 * @property Genre $genre
 * @property Movie $movie
 */
class MovieGenre extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'movie_genre';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['movie_id', 'genre_id'], 'required'],
            [['movie_id', 'genre_id'], 'integer'],
            [['movie_id', 'genre_id'], 'unique', 'targetAttribute' => ['movie_id', 'genre_id']],
            [['movie_id'], 'exist', 'skipOnError' => true, 'targetClass' => Movie::class, 'targetAttribute' => ['movie_id' => 'id']],
            [['genre_id'], 'exist', 'skipOnError' => true, 'targetClass' => Genre::class, 'targetAttribute' => ['genre_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'movie_id' => 'Movie ID',
            'genre_id' => 'Genre ID',
        ];
    }

    /**
     * Gets query for [[Genre]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenre()
    {
        return $this->hasOne(Genre::class, ['id' => 'genre_id']);
    }

    /**
     * Gets query for [[Movie]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMovie()
    {
        return $this->hasOne(Movie::class, ['id' => 'movie_id']);
    }

}
