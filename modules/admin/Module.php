<?php

namespace app\modules\admin;

use Yii;
use yii\base\Action;
use yii\web\ForbiddenHttpException;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->user->loginRequired();
        }

        if (Yii::$app->user->identity->role !== 'admin') {
            throw new ForbiddenHttpException('Доступ запрещен!');
        }

        return parent::beforeAction($action);
    }
}
