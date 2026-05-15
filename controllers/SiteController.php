<?php

namespace app\controllers;

use app\models\Genre;
use app\models\Movie;
use app\models\RegisterForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\NotFoundHttpException;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $topMovies = Movie::find()
            ->joinWith('movieTypes mt')
            ->where(['mt.type_id' => 1])
            ->andWhere(['between', 'rating_avg', 7, 8, 9])
            ->orderBy(['rating_avg' => SORT_DESC])
            ->limit(10)
            ->all();

        $foreignMovies = Movie::find()
            ->joinWith(['countries c', 'movieTypes mt'])

            ->where(['mt.type_id' => 1])

            ->andWhere(['!=', 'c.name', 'Россия'])

            // исключить фильмы с жанром Мультфильмы
            ->andWhere([
                'not in',
                'movie.id',
                \app\models\MovieGenre::find()
                    ->select('movie_id')
                    ->joinWith('genre')
                    ->where(['genre.name' => 'Мультфильмы'])
            ])

            // исключить рейтинг 8-10
            ->andWhere(['not between', 'rating_avg', 7, 10])

            ->distinct()
            ->all();

        $russianMovies = Movie::find()
            ->joinWith(['countries c', 'movieTypes mt'])

            ->where([
                'mt.type_id' => 1,
                'c.name' => 'Россия'
            ])

            // исключить рейтинг 7-10
            ->andWhere(['not between', 'rating_avg', 7, 10])

            ->distinct()
            ->all();


        $series = Movie::find()
            ->joinWith('movieTypes mt')
            ->where(['mt.type_id' => 2])
            ->orderBy(['rating_avg' => SORT_DESC])
            ->limit(10)
            ->all();

        $newMovies = Movie::find()
            ->where(['year' => 2026])
            ->orderBy(['release_date' => SORT_DESC])
            ->limit(10)
            ->all();

        $cartoons = Movie::find()
            ->joinWith('genres g')
            ->where(['g.name' => 'Мультфильмы'])
            ->distinct()
            ->all();

        $genres = \app\models\Genre::find()
            ->all();

        return $this->render('index', [
            'topMovies' => $topMovies,
            'foreignMovies' => $foreignMovies,
            'russianMovies' => $russianMovies,
            'series' => $series,
            'newMovies' => $newMovies,
            'cartoons' => $cartoons,
            'genres' => $genres,
        ]);
    }

    public function actionGenre($id)
    {
        $genre = Genre::findOne($id);

        if (!$genre) {
            throw new NotFoundHttpException('Жанр не найден');
        }

        $movies = Movie::find()
            ->joinWith('genres')
            ->where(['genre.id' => $id])
            ->distinct()
            ->all();

        return $this->render('genre', [
            'genre' => $genre,
            'movies' => $movies,
            'title' => 'Жанр: ' . $genre->name,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */

    public function actionSubscription()
    {
        return $this->render('subscription');
    }

    public function actionBuySubscription()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $user = Yii::$app->user->identity;

        $user->subscription_type = 'active';

        $user->subscription_expires_at = date(
            'Y-m-d H:i:s',
            strtotime('+30 days')
        );

        $user->save(false);

        Yii::$app->session->setFlash(
            'success',
            'Подписка оформлена!'
        );

        return $this->goBack();
    }

    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            return $this->redirect('login');
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
