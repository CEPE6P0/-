<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\Genre;
use app\models\Movie;

class GenreController extends Controller
{
    // Страница со всеми жанрами
    public function actionIndex()
    {
        $genres = Genre::find()
            ->orderBy(['name' => SORT_ASC])
            ->all();

        return $this->render('index', [
            'genres' => $genres
        ]);
    }

    // Страница с фильмами конкретного жанра
    public function actionView($id)
    {
        // Находим жанр
        $genre = Genre::findOne($id);

        if (!$genre) {
            throw new NotFoundHttpException('Жанр не найден');
        }

        // Получаем все фильмы этого жанра
        $movies = $genre->getMovies()->all();

        return $this->render('view', [
            'genre' => $genre,
            'movies' => $movies
        ]);
    }
}