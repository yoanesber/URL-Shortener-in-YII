<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\Pagination;
use app\models\Todolist;
use app\models\TodolistStatus;

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
        $sql = 'SELECT * FROM todolist';
        $todolist = Todolist::findBySql($sql)->all();
        $array_todolist = array();
        if(sizeof($todolist) > 0){
            foreach ($todolist as $data) {
                $sql = 'SELECT * FROM todolist_status where id=:id';
                $status = TodolistStatus::findBySql($sql, [':id' => $data->status_id])->all();
                
                $status_name = '';
                if($status and $status !== null && sizeof($status) > 0)
                    $status_name = $status[0]['status_name'];

                $tl = [
                    'id' => $data->id,
                    'task_name' => $data->task_name,
                    'task_desc' => $data->task_desc,
                    'task_start_date' => $data->task_start_date,
                    'task_end_date' => $data->task_end_date,
                    'task_place' => $data->task_place,
                    'status_id' => $data->status_id,
                    'status_name' => $status_name,
                    'createdAt' => $data->createdAt,
                    'createdBy' => $data->createdBy,
                    'updatedAt' => $data->updatedAt,
                    'updatedBy' => $data->updatedBy
                ];
    
                $array_todolist[] = $tl;
            }
        }

        return $this->render('index', [
            'todolist' => $array_todolist
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
        if($request !== null){
            $todolist = new Todolist();
            $todolist->task_name = $request->getBodyParam('task_name');
            $todolist->task_desc = $request->getBodyParam('task_desc');
            $todolist->task_start_date = $request->getBodyParam('task_start_date');
            $todolist->task_end_date = $request->getBodyParam('task_end_date');
            $todolist->task_place = $request->getBodyParam('task_place');
            // $todolist->status_id = $request->getBodyParam('task_status');
            $todolist->createdAt = date('Y-m-d H:i:s');
            $todolist->createdBy = 1;
            if($todolist->insert() !== false){
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
