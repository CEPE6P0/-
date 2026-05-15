<?php

namespace app\controllers;

use app\models\Movie;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\Response;

class ProfileController extends Controller
{
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $likes = \app\models\Like::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->all();

        $items = [];

        foreach ($likes as $like) {

            $movie = \app\models\Movie::findOne($like->movie_id);

            if (!$movie) {
                continue;
            }

            $typeId = \app\models\MovieType::find()
                ->where(['movie_id' => $movie->id])
                ->select('type_id')
                ->scalar();

            $items[] = [
                'model' => $movie,
                'typeId' => $typeId
            ];
        }

        return $this->render('index', [
            'user' => Yii::$app->user->identity,
            'likedMovies' => $items,
        ]);
    }

    public function actionEdit()
    {
        $user = Yii::$app->user->identity;

        if ($user->load(Yii::$app->request->post())) {

            $file = UploadedFile::getInstance($user, 'avatarFile');

            if ($file) {
                $dir = Yii::getAlias('@webroot/uploads/');
                if (!is_dir($dir)) mkdir($dir, 0777, true);

                $name = uniqid() . '.' . $file->extension;

                if ($file->saveAs($dir . $name)) {
                    if ($user->avatar) {
                        @unlink(Yii::getAlias('@webroot/uploads/') . $user->avatar);
                    }
                    $user->avatar = $name;
                }
            }

            $saved = $user->save(false);

            if ($saved) {
                Yii::$app->session->setFlash('success', 'Профиль успешно обновлён!');
            }

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ['success' => $saved, 'errors' => $user->errors];
            }

            return $saved
                ? $this->redirect(['profile/index'])
                : null;
        }

        return $this->render('edit', compact('user'));
    }

    public function actionChangePassword()
    {
        $user = Yii::$app->user->identity;
        $user->scenario = 'changePassword';

        if ($user->load(Yii::$app->request->post())) {

            if (!empty($user->new_password)) {

                $user->password = Yii::$app->security->generatePasswordHash($user->new_password);

                if ($user->save(false)) {
                    Yii::$app->session->setFlash('success', 'Пароль успешно изменён!');
                    return $this->redirect(['profile/index']);
                }
            } else {
                Yii::$app->session->setFlash('error', 'Введите новый пароль');
            }
        }

        return $this->render('change-password', [
            'user' => $user
        ]);
    }
}