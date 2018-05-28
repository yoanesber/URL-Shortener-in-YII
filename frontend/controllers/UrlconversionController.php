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

class GoogleUrlApi {
    var $apiKey = 'AIzaSyBJoSKBvJeIFAo5QFulDksofooOgGRv8RM';

    public function shorten($url) {
        $response = $this->send($url, 'shorten');
		return (isset($response)) ? $response:false;
    }

    public function expand($url) {
        $response = $this->send($url, 'expand');
		return (isset($response)) ? $response:false;
    }

    public function statistic($url) {
        $response = $this->send($url, 'statistic');
		return (isset($response)) ? $response:false;
    }
    
	function send($url, $type='shorten') {
        $postData = array('longUrl' => $url, 'key' => $this->apiKey);
        $jsonData = json_encode($postData);

        $curlObj = curl_init();

        if($type == 'shorten'){
            curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url?key='.$this->apiKey);
            curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curlObj, CURLOPT_HEADER, 0);
            curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
            curl_setopt($curlObj, CURLOPT_POST, 1);
            curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);
        }
        else if($type == 'expand'){
            curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url?key='.$this->apiKey.'&shortUrl='.$url);
            curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
        }
        else if($type == 'statistic'){
            curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url?key='.$this->apiKey.'&shortUrl='.$url.'&projection=FULL');
            curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
        }
        

        $response = curl_exec($curlObj);
        $json = json_decode($response);
        curl_close($curlObj);
        return $json;
	}		
}

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

    public function actionGetstatistic($id = null){
        $last_result = [
            'error' => true,
            'data' => null
        ];

        if($id !== null ){
            $sql = 'SELECT * FROM url_conversions WHERE id=:id';
            $urlconversion = UrlConversion::findBySql($sql, [':id' => $id])->one();
            
            if(isset($urlconversion->id)){
                $googleUrlApi = new GoogleUrlApi();
                $googleUrlApiResponse = $googleUrlApi->statistic($urlconversion->url_conversion);

                $last_result['error'] = false;
                $last_result['data'] = $googleUrlApiResponse;
            }
            else $last_result['error_message'] = "There's something problem when findBySql!";
        }
        else $last_result['error_message'] = "There's something problem! Parameter id is null!";

        return json_encode($last_result);
    }

    public function actionCreate(){
        $last_result = ['error' => true];
        $request = (Yii::$app->request)?Yii::$app->request:null;
        $session = Yii::$app->session;

        if($request !== null){
            $urlconversion = new Urlconversion();
            $urlconversion->url_original = ($request->post('url_original'))?$request->post('url_original'):null;
            $urlconversion->createdAt = date('Y-m-d H:i:s');
            $urlconversion->createdBy = $session['user_id'];
            if($urlconversion->url_original !== null && filter_var($urlconversion->url_original, FILTER_VALIDATE_URL)){
                $googleUrlApi = new GoogleUrlApi();
                $googleUrlApiResponse = $googleUrlApi->shorten($urlconversion->url_original);
                if($googleUrlApiResponse !== false){
                    $urlconversion->url_conversion = $googleUrlApiResponse->id;
                    if($urlconversion->insert() !== false)
                        $last_result['error'] = false;
                    else $last_result['error_message'] = "There's something problem when save URL!";
                }
                else $last_result['error_message'] = "There's something problem when get google URL API!";
            }
            else $last_result['error_message'] = "There's something problem. URL is not valid!";
        }
        else $last_result['error_message'] = "There's something problem. Request is null!";

        return json_encode($last_result);
    }
}