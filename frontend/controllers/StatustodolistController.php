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
class StatustodolistController extends Controller
{
    public function actions(){
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex(){
        $sql = 'SELECT * FROM todolist_status';
        $todolist_status = TodolistStatus::findBySql($sql)->all();
        $last_result = [
            'error' => true,
            'data' => null
        ];
        $array_status = array();
        foreach($todolist_status as $data){
            $status = [
                'id' => $data->id,
                'status_name' => $data->status_name,
                'status_desc' => $data->status_desc
            ];

            $array_status[] = $status;
        }

        if(sizeof($array_status) > 0){
            $last_result = [
                'error' => false,
                'data' => $array_status
            ];
        }

        return json_encode($last_result);
    }

    public function actionView($id = null){
        if($id === null )
            $sql = 'SELECT * FROM todolist_status ';
        else $sql = 'SELECT * FROM todolist_status WHERE id=:id';
        
        $todolist_status = TodolistStatus::findBySql($sql, [':id' => $id])->all();
        
        $last_result = [
            'error' => true,
            'data' => null
        ];
        $array_status = array();
        foreach($todolist_status as $data){
            $status = [
                'id' => $data->id,
                'status_name' => $data->status_name,
                'status_desc' => $data->status_desc
            ];

            $array_status[] = $status;
        }

        if(sizeof($array_status) > 0){
            $last_result = [
                'error' => false,
                'data' => $array_status
            ];
        }

        return json_encode($last_result);
    }
}
