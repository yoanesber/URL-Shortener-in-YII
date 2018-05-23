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
 * User controller
 */
class UserController extends Controller
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
    }

    public function actionView($id = null){
    }

    public function actionLogout(){
        $session = Yii::$app->session;
        $session->destroy();
        
        $this->redirect("../site");
    }

    public function actionLogin(){
        $last_result = [
            'error' => true
        ];

        $request = (Yii::$app->request)?Yii::$app->request:null;
        if($request !== null){
            $user = new User();
            $user->username = ($request->getBodyParam('username'))?$request->getBodyParam('username'):null;
            $user->auth_key = ($request->getBodyParam('auth_key'))?$request->getBodyParam('auth_key'):null;
            
            if($user->username !== null && $user->auth_key !== null){
                $sql = "SELECT * FROM user WHERE username = :username and auth_key = :auth_key";
                $result = User::findBySql($sql, [':username' => $user->username, ':auth_key' => $user->auth_key])->all();

                $usr = array();
                foreach($result as $data){
                    $registered_at = strtotime($data->registered_at);
                    $registered_at = date("Y-m-d H:i:s", $registered_at);

                    $last_login = null;
                    if($data->last_login !== null){
                        $last_login = strtotime($data->last_login);
                        $last_login = date("Y-m-d H:i:s", $last_login);
                    }

                    $usr = [
                        'id' => $data->id,
                        'username' => $data->username,
                        'auth_key' => $data->auth_key,
                        'status' => $data->status,
                        'registered_at' => $registered_at,
                        'last_login' => $last_login
                    ];
                }

                if($usr && $usr !== null && sizeof($usr) > 0){
                    $session = Yii::$app->session;
                    $session['user_id'] = $usr['id'];
                    $session['username'] = $usr['username'];
                    $session['registered_at'] = $usr['registered_at'];
                    $session['last_login'] = $usr['last_login'];

                    $last_result['error'] = false;
                    return json_encode($last_result);
                    // $this->redirect("../urlconversion");
                }
                else return json_encode($last_result);
            }
            else return json_encode($last_result);
        }
        else return json_encode($last_result);
    }

    public function actionCreate(){
        $last_result = [
            'error' => true
        ];
        $request = (Yii::$app->request)?Yii::$app->request:null;
        if($request !== null){
            $user = new User();
            $user->username = ($request->getBodyParam('username'))?$request->getBodyParam('username'):null;
            $user->auth_key = ($request->getBodyParam('auth_key'))?$request->getBodyParam('auth_key'):null;
            $user->status = 1;
            $user->registered_at = date('Y-m-d H:i:s');
            $user->last_login = null;
            if($user->insert() !== false){
                $last_result = [
                    'error' => false
                ];
            }
        }

        return json_encode($last_result);
    }

    public function actionDelete($id = null){
        
    }
}
