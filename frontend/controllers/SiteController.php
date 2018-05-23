<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
use app\models\User;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function actions(){
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionOffline(){
        echo 'We are offline';
    }

    public function actionIndex($action = NULL){
        $session = Yii::$app->session;
        if($session['username'] != "")
            $this->redirect("../urlconversion");
        else return $this->render('login');
    }
}
