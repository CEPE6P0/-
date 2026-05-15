<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "movie".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string|null $poster
 * @property string|null $trailer_url
 * @property string|null $video_url
 * @property int|null $year
 * @property string|null $release_date
 * @property int|null $duration
 * @property float|null $rating_avg
 * @property int|null $rating_count
 * @property int|null $views
 * @property int|null $likes
 * @property string|null $created_at
 *
 * @property Comment[] $comments
 * @property Country[] $countries
 * @property Favorite[] $favorites
 * @property Genre[] $genres
 * @property MovieCountry[] $movieCountries
 * @property MovieGenre[] $movieGenres
 * @property MovieType[] $movieTypes
 * @property Rating[] $ratings
 */
class Movie extends \yii\db\ActiveRecord
{
    public $genre_ids = [];
    public $country_ids = [];
    public $type_id;

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $db = \Yii::$app->db;

        // ======================
        // GENRES
        // ======================
        $db->createCommand()->delete('movie_genre', [
            'movie_id' => $this->id
        ])->execute();

        foreach ((array)$this->genre_ids as $id) {
            $db->createCommand()->insert('movie_genre', [
                'movie_id' => $this->id,
                'genre_id' => $id
            ])->execute();
        }

        // ======================
        // COUNTRIES
        // ======================
        $db->createCommand()->delete('movie_country', [
            'movie_id' => $this->id
        ])->execute();

        foreach ((array)$this->country_ids as $id) {
            $db->createCommand()->insert('movie_country', [
                'movie_id' => $this->id,
                'country_id' => $id
            ])->execute();
        }



        // ======================
        // TYPE
        // ======================
        $db->createCommand()->delete('movie_type', [
            'movie_id' => $this->id
        ])->execute();

        if (!empty($this->type_id)) {
            $db->createCommand()->insert('movie_type', [
                'movie_id' => $this->id,
                'type_id' => $this->type_id
            ])->execute();
        }
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->genre_ids = $this->getGenres()->select('id')->column();
        $this->country_ids = $this->getCountries()->select('id')->column();
        $this->type_id = $this->getTypes()->select('id')->scalar();
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'movie';
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        \Yii::$app->db->createCommand()->delete('movie_genre', [
            'movie_id' => $this->id
        ])->execute();

        \Yii::$app->db->createCommand()->delete('movie_country', [
            'movie_id' => $this->id
        ])->execute();

        \Yii::$app->db->createCommand()->delete('movie_type', [
            'movie_id' => $this->id
        ])->execute();

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'poster', 'trailer_url', 'year', 'release_date', 'duration'], 'default', 'value' => null],
            [['likes'], 'default', 'value' => 0],
            [['title'], 'required'],
            [['genre_ids', 'country_ids', 'type_id'], 'safe'],
            [['description', 'video_url'], 'string'],
            [['year', 'duration', 'rating_count', 'views', 'likes'], 'integer'],
            [['release_date', 'created_at'], 'safe'],
            [['rating_avg'], 'number'],
            [['title', 'poster', 'trailer_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'description' => 'Описание',
            'poster' => 'Постер',
            'trailer_url' => 'Ссылка на трейлер',
            'year' => 'Год',
            'release_date' => 'Дата релиза',
            'duration' => 'Длительность',

            'rating_avg' => 'Средний рейтинг',
            'rating_count' => 'Количество оценок',

            'views' => 'Просмотры',
            'likes' => 'Лайки',

            'created_at' => 'Дата создания',

            'type_id' => 'Тип',
            'genre_ids' => 'Жанры',
            'country_ids' => 'Страны',
        ];
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['movie_id' => 'id']);
    }

    /**
     * Gets query for [[Countries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCountries()
    {
        return $this->hasMany(Country::class, ['id' => 'country_id'])
            ->viaTable('movie_country', ['movie_id' => 'id']);
    }

    /**
     * Gets query for [[Favorites]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavorites()
    {
        return $this->hasMany(Favorite::class, ['movie_id' => 'id']);
    }

    /**
     * Gets query for [[Genres]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenres()
    {
        return $this->hasMany(Genre::class, ['id' => 'genre_id'])->viaTable('movie_genre', ['movie_id' => 'id']);
    }

    /**
     * Gets query for [[MovieCountries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMovieCountries()
    {
        return $this->hasMany(MovieCountry::class, ['movie_id' => 'id']);
    }

    /**
     * Gets query for [[MovieGenres]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMovieGenres()
    {
        return $this->hasMany(MovieGenre::class, ['movie_id' => 'id']);
    }

    /**
     * Gets query for [[MovieTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMovieTypes()
    {
        return $this->hasMany(MovieType::class, ['movie_id' => 'id']);
    }

    /**
     * Gets query for [[Ratings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRatings()
    {
        return $this->hasMany(Rating::class, ['movie_id' => 'id']);
    }

    public function getTypes()
    {
        return $this->hasMany(Type::class, ['id' => 'type_id'])
            ->viaTable('movie_type', ['movie_id' => 'id']);
    }

    public function getMainType()
    {
        return $this->hasOne(Type::class, ['id' => 'type_id'])
            ->viaTable('movie_type', ['movie_id' => 'id']);
    }

    public function isLikedByUser($userId)
    {
        if (!$userId) return false;

        return \app\models\Like::find()
            ->where([
                'user_id' => $userId,
                'movie_id' => $this->id
            ])
            ->exists();
    }

    public function getReviews()
    {
        return $this->hasMany(Review::class, ['movie_id' => 'id'])
            ->orderBy(['created_at' => SORT_DESC]);
    }

    public function getLikes()
    {
        return $this->hasMany(Like::class, ['movie_id' => 'id']);
    }
}
