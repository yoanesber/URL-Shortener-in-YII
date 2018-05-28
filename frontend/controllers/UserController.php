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
            'error' => true,
            'error_message' => null
        ];

        $request = (Yii::$app->request)?Yii::$app->request:null;
        if($request !== null){
            $param_username = ($request->post('username'))?$request->post('username'):null;
            $param_auth_key = ($request->post('auth_key'))?$request->post('auth_key'):null;
            
            if($param_username !== null && $param_auth_key !== null){
                $find_user = User::find()->where('username=:username', [':username' => $param_username])->one();
                if($find_user !== null && $find_user['username'] !== null){
                    if(password_verify($param_auth_key, $find_user['auth_key'])){
                        $user_id = $find_user->id;
                        $user_name = $find_user->username;
                        $registered_at = $find_user->registered_at;
                        $last_login = $find_user->last_login;

                        $find_user->last_login = date('Y-m-d H:i:s');
                        if($find_user->update() !== false){
                            $session = Yii::$app->session;
                            $session['user_id'] = $user_id;
                            $session['username'] = $user_name;
                            
                            $registered_at = strtotime($registered_at);
                            $registered_at = date("Y-m-d H:i:s", $registered_at);
                            $session['registered_at'] = $registered_at;
                            $session['last_login'] = 'You are the first time sign in';
                            
                            if($last_login !== null){
                                $last_login = strtotime($last_login);
                                $last_login = date("Y-m-d H:i:s", $last_login);
                                $session['last_login'] = $last_login;
                            }

                            $last_result['error'] = false;
                            return json_encode($last_result);
                        }
                        else $last_result['error_message'] = "There's something problem when update last login!";
                    }
                    else $last_result['error_message'] = "Please double check username and password!";
                }
                else $last_result['error_message'] = "Username isn't registered!";
            }
            else $last_result['error_message'] = "There's something problem. Parameter username or auth key is null!";
        }
        else $last_result['error_message'] = "There's something problem. Request is null!";

        return json_encode($last_result);
    }

    public function actionCreate(){
        $last_result = ['error' => true, 'error_message' => null];
        $request = (Yii::$app->request)?Yii::$app->request:null;
        if($request !== null){
            $user = new User();
            $user->username = ($request->post('username'))?$request->post('username'):null;
            $user->auth_key = ($request->post('auth_key'))?$request->post('auth_key'):null;
            $options = ['cost' => 10]; //Jika nilainya 10 maka proses hashing dilakukan sebanyak 2^10 atau 1024 kali.
            $user->auth_key = password_hash($user->auth_key, PASSWORD_DEFAULT, $options);
            $user->status = 1;
            $user->registered_at = date('Y-m-d H:i:s');
            $user->last_login = null;

            if($user->username !== null && $user->auth_key !== null){
                $find_user = User::find()->where('username=:username', [':username' => $user->username])->one();
                if($find_user['username'] === null){
                    if($user->insert() !== false)
                        $last_result['error'] = false;
                    else $last_result['error_message'] = "There's something problem when create user!";
                }
                else $last_result['error_message'] = "Username is already exists! Please use another username.";
            }
            else $last_result['error_message'] = "There's something problem. Username and password must not be empty!";
        }
        else $last_result['error_message'] = "There's something problem. Request is null !";

        return json_encode($last_result);
    }

    public function actionDelete($id = null){
        
    }
}
