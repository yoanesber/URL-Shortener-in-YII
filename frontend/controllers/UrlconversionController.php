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
use app\models\UrlConversion;

/**
 * Site controller
 */
class UrlconversionController extends Controller
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

    public function actionBaseconvert() {
        $last_result = [
            'error' => true,
            'url_conversion' => null
        ];

        $url = null;
        $request = (Yii::$app->request)?Yii::$app->request:null;
        if($request !== null)
            $url = $request->getBodyParam('url');

        if($url !== null){
            $str = trim($url); 
            // $frombase = 10;
            // $tobase = 36;
            // if (intval($frombase) != 10) { 
            //     $len = strlen($str); 
            //     $q = 0; 
            //     for ($i=0; $i<$len; $i++) { 
            //         $r = base_convert($str[$i], $frombase, 10); 
            //         $q = bcadd(bcmul($q, $frombase), $r); 
            //     } 
            // } 
            // else $q = $str; 
        
            // $s = ''; 
            // if (intval($tobase) != 10) { 
            //     while (bccomp($q, '0', 0) > 0) { 
            //         $r = intval(bcmod($q, $tobase)); 
            //         $s = base_convert($r, 10, $tobase) . $s; 
            //         $q = bcdiv($q, $tobase, 0); 
            //     } 
            // } 
            // else $s = $q; 

            $s = base64_encode($str);
            // $s = base64_decode($s);

            $last_result['error'] = false;
            $last_result['url_conversion'] = $s;

            return json_encode($last_result);
        }
        else return json_encode($last_result);
    } 

    public function actionIndex($action = NULL){
        $sql = 'SELECT * FROM url_conversions';
        $urlconversion = UrlConversion::findBySql($sql)->all();
        $array_urlconversion = array();
        if(sizeof($urlconversion) > 0){
            foreach ($urlconversion as $data) {
                $uc = [
                    'id' => $data->id,
                    'url_original' => $data->url_original,
                    'url_conversion' => $data->url_conversion,
                    'createdAt' => $data->createdAt,
                    'createdBy' => $data->createdBy
                ];
    
                $array_urlconversion[] = $uc;
            }
        }

        return $this->render('list', [
            'urlconversion' => $array_urlconversion
        ]);
    }

    public function actionView($id = null){
        if($id === null )
            $sql = 'SELECT * FROM todolist ';
        else $sql = 'SELECT * FROM todolist WHERE id=:id';
        
        $todolist = Todolist::findBySql($sql, [':id' => $id])->all();
        
        $last_result = [
            'error' => true,
            'data' => null
        ];
        $array_todolist = array();
        foreach($todolist as $data){
            $task_start_date = strtotime($data->task_start_date);
            $task_start_date = date("Y-m-d H:i:s", $task_start_date);
            $task_end_date = strtotime($data->task_end_date);
            $task_end_date = date("Y-m-d H:i:s", $task_end_date);

            $tl = [
                'id' => $data->id,
                'task_name' => $data->task_name,
                'task_desc' => $data->task_desc,
                'task_start_date' => $task_start_date,
                'task_end_date' => $task_end_date,
                'task_place' => $data->task_place,
                'status_id' => $data->status_id,
                'createdAt' => $data->createdAt,
                'createdBy' => $data->createdBy,
                'updatedAt' => $data->updatedAt,
                'updatedBy' => $data->updatedBy
            ];

            $array_todolist[] = $tl;
        }

        if(sizeof($array_todolist) > 0){
            $last_result = [
                'error' => false,
                'data' => $array_todolist
            ];
        }

        return json_encode($last_result);
    }

    public function actionCreate(){
        $last_result = [
            'error' => true
        ];
        $request = (Yii::$app->request)?Yii::$app->request:null;
        $session = Yii::$app->session;
        if($request !== null){
            $urlconversion = new Urlconversion();
            $urlconversion->url_original = $request->getBodyParam('url_original');
            $urlconversion->url_conversion = $request->getBodyParam('url_conversion');
            $urlconversion->createdAt = date('Y-m-d H:i:s');
            $urlconversion->createdBy = $session['user_id'];
            if($urlconversion->insert() !== false){
                $last_result = [
                    'error' => false
                ];
            }
        }

        return json_encode($last_result);
    }

    public function actionUpdate($id = null){
        $last_result = [
            'error' => true
        ];
        $request = (Yii::$app->request)?Yii::$app->request:null;
        if($id !== null and $request !== null){
            $todolist = Todolist::findOne($id);
            $todolist->task_name = $request->getBodyParam('task_name');
            $todolist->task_desc = $request->getBodyParam('task_desc');
            $todolist->task_start_date = $request->getBodyParam('task_start_date');
            $todolist->task_end_date = $request->getBodyParam('task_end_date');
            $todolist->task_place = $request->getBodyParam('task_place');
            $todolist->status_id = $request->getBodyParam('task_status');
            $todolist->updatedAt = date('Y-m-d H:i:s');
            $todolist->updatedBy = 1;
            $todolist->save();

            $last_result = [
                'error' => false
            ];
        }

        return json_encode($last_result);
    }

    public function actionDelete($id = null){
        $last_result = [
            'error' => true,
            'data' => null
        ];

        if($id !== null){
            $sql = 'SELECT * FROM todolist WHERE id=:id';
            $todolist = Todolist::findBySql($sql, [':id' => $id])->all();
            $array_todolist = array();
            foreach ($todolist as $data) {
                $task_start_date = strtotime($data->task_start_date);
                $task_start_date = date("Y-m-d H:i:s", $task_start_date);
                $task_end_date = strtotime($data->task_end_date);
                $task_end_date = date("Y-m-d H:i:s", $task_end_date);

                $tl = [
                    'id' => $data->id,
                    'task_name' => $data->task_name,
                    'task_desc' => $data->task_desc,
                    'task_start_date' => $task_start_date,
                    'task_end_date' => $task_end_date,
                    'task_place' => $data->task_place,
                    'status_id' => $data->status_id,
                    'createdAt' => $data->createdAt,
                    'createdBy' => $data->createdBy,
                    'updatedAt' => $data->updatedAt,
                    'updatedBy' => $data->updatedBy
                ];
    
                $array_todolist[] = $tl;
                $data->delete();
            }

            if(sizeof($array_todolist) > 0){
                $last_result = [
                    'error' => false,
                    'data' => $array_todolist
                ];
            }
        }
        
        return json_encode($last_result);
    }
}
