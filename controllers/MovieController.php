<?php
namespace app\controllers;

use app\models\Like;
use app\models\Rating;
use app\models\UserWatchProgress;
use Yii;
use yii\web\Controller;
use app\models\Movie;
use app\models\MovieType; // добавьте эту модель

class MovieController extends Controller
{
    // 🎬 список ВСЕХ (фильмы и сериалы вместе)
    public function actionIndex()
    {
        $movies = Movie::find()->orderBy(['id' => SORT_DESC])->all();

        return $this->render('index', [
            'movies' => $movies
        ]);
    }

    // 🎥 страница одного фильма/сериала
    public function actionView($id)
    {
        $movie = Movie::findOne($id);

        if (!$movie) {
            throw new \yii\web\NotFoundHttpException('Фильм не найден');
        }

        $hasSubscription = false;

        // Если пользователь авторизован
        if (!Yii::$app->user->isGuest) {

            $user = Yii::$app->user->identity;

            $hasSubscription = $user->hasSubscription();
        }

        return $this->render('view', [
            'movie' => $movie,
            'hasSubscription' => $hasSubscription,
        ]);
    }


    // 🎬 ТОЛЬКО фильмы
    public function actionMovies()
    {
        $movies = Movie::find()
            ->select('movie.*, mt.type_id')
            ->leftJoin('movie_type mt', 'mt.movie_id = movie.id')
            ->where(['mt.type_id' => 1]) // 1 - ID фильма
            ->orderBy(['movie.id' => SORT_DESC])
            ->all();

        return $this->render('movies', [
            'movies' => $movies
        ]);
    }

    // 📺 ТОЛЬКО сериалы
    public function actionSeries()
    {
        $series = Movie::find()
            ->select('movie.*, mt.type_id')
            ->leftJoin('movie_type mt', 'mt.movie_id = movie.id')
            ->where(['mt.type_id' => 2]) // 2 - ID сериала
            ->orderBy(['movie.id' => SORT_DESC])
            ->all();

        return $this->render('series', [
            'series' => $series
        ]);
    }

    public function actionToggleLike()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $userId = Yii::$app->user->id;
        $movieId = Yii::$app->request->post('id');

        $like = Like::findOne([
            'user_id' => $userId,
            'movie_id' => $movieId
        ]);

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            $like = new Like();
            $like->user_id = $userId;
            $like->movie_id = $movieId;
            $like->save();
            $liked = true;
        }

        $count = Like::find()->where(['movie_id' => $movieId])->count();

        Movie::updateAll(['likes' => $count], ['id' => $movieId]);

        return ['liked' => $liked, 'likes' => $count];
    }

    public function actionRate()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $userId = Yii::$app->user->id;
        $movieId = Yii::$app->request->post('id');
        $ratingValue = Yii::$app->request->post('rating');

        $rating = Rating::findOne([
            'user_id' => $userId,
            'movie_id' => $movieId
        ]);

        if (!$rating) {
            $rating = new Rating();
            $rating->user_id = $userId;
            $rating->movie_id = $movieId;
            $rating->created_at = date('Y-m-d H:i:s');
        }

        $rating->rating = $ratingValue;
        $rating->save();

        return $this->calcRating($movieId);
    }

    public function actionRemoveRating()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $userId = Yii::$app->user->id;
        $movieId = Yii::$app->request->post('id');

        Rating::deleteAll([
            'user_id' => $userId,
            'movie_id' => $movieId
        ]);

        return $this->calcRating($movieId);
    }



    private function calcRating($movieId)
    {
        $stats = Rating::find()
            ->select([
                'avg' => 'AVG(rating)',
                'count' => 'COUNT(*)'
            ])
            ->where(['movie_id' => $movieId])
            ->asArray()
            ->one();

        $avg = round($stats['avg'] ?? 0, 1);
        $count = $stats['count'] ?? 0;

        Movie::updateAll([
            'rating_avg' => $avg,
            'rating_count' => $count
        ], ['id' => $movieId]);

        $rating = (int) Yii::$app->request->post('rating');
        $rating = max(2, min(10, $rating));
        return ['avg' => $avg];
    }

    public function actionAddReview()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (Yii::$app->user->isGuest) {
            return ['error' => true];
        }

        $userId = Yii::$app->user->id;
        $movieId = Yii::$app->request->post('id');
        $text = Yii::$app->request->post('text');
        $ratingValue = Yii::$app->request->post('rating');

        // REVIEW
        $review = \app\models\Review::findOne([
            'user_id' => $userId,
            'movie_id' => $movieId
        ]);

        if (!$review) {
            $review = new \app\models\Review();
            $review->user_id = $userId;
            $review->movie_id = $movieId;
            $review->created_at = date('Y-m-d H:i:s');
        }

        $review->text = $text;

        if (!$review->save()) {
            return [
                'error' => true,
                'msg' => $review->errors
            ];
        }

        // RATING
        $rating = \app\models\Rating::findOne([
            'user_id' => $userId,
            'movie_id' => $movieId
        ]);

        if (!$rating) {
            $rating = new \app\models\Rating();
            $rating->user_id = $userId;
            $rating->movie_id = $movieId;
            $rating->created_at = date('Y-m-d H:i:s');
        }

        $rating->rating = $ratingValue;

        if (!$rating->save()) {
            return [
                'error' => true,
                'msg' => $rating->errors
            ];
        }

        return [
            'success' => true,
            'username' => Yii::$app->user->identity->username,
            'avatar' => Yii::$app->user->identity->avatar ?: 'default-avatar.png',
            'created_at' => date('d.m.Y H:i'),
            'rating' => (int)$ratingValue
        ];
    }
}