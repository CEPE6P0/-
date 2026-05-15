<?php

namespace app\controllers;

use app\models\Country;
use app\models\Genre;
use app\models\Movie;
use Yii;
use yii\web\Controller;

class SearchController extends Controller
{
    public function actionIndex()
    {
        $query = Movie::find()->alias('m');

        $q = Yii::$app->request->get('q');
        $year = Yii::$app->request->get('year');
        $country = Yii::$app->request->get('country');
        $genre = Yii::$app->request->get('genre');
        $rating = Yii::$app->request->get('rating');
        $type = Yii::$app->request->get('type');

        if ($q) {
            $query->andWhere(['like', 'm.title', $q]);
        }

        if ($year) {
            $query->andWhere(['m.year' => $year]);
        }

        if ($country) {
            $query->joinWith('countries c')
                ->andWhere(['c.id' => $country]);
        }

        if ($rating) {
            $query->andWhere(['m.rating_avg' => $rating]);
        }

        if ($type) {
            $query->joinWith('movieTypes mt')
                ->andWhere(['mt.type_id' => $type]);
        }

        if ($genre) {
            $query->joinWith('genres g')
                ->andWhere(['g.id' => $genre]);
        }

        $movies = $query->all();

        return $this->render('index', [
            'movies' => $movies,
            'countries' => Country::find()->select(['name', 'id'])->indexBy('id')->column(),
            'genres' => Genre::find()->select(['name', 'id'])->indexBy('id')->column(),
        ]);
    }
}