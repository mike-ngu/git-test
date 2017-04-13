<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use api\modules\v1\models\Student;
use api\modules\v1\models\UploadForm;
use yii\web\UploadedFile;

/**
 * Student Controller API
 *
 * @author Michael Maverick <mb2010y@gmail.com>
 */
class StudentController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Student';

    public function actionView($id)
    {
        //return User::findOne($id);
        //return 'hello world';
        var_dump('hello world23');die;
    }

    public function actions()
    {
        $actions = parent::actions();
        // unset default 'create' action
        unset($actions['create']);
        unset($actions['update']);
        return $actions;
    }


    // custom 'create' action
    public function actionCreate()
    {
        //var_dump(Yii::$app->request->post());die;

        $arrStudentName = explode(" ", Yii::$app->request->post('fullname'));

        $model = new Student();

        $model->load(Yii::$app->request->post(), '');
        //$model->fullname   = 'my name dddd';
        $model->first_name = $arrStudentName[0];
        $model->last_name  = $arrStudentName[1];


        $model->save();
        /*
        $response = Yii::$app->getResponse();
        $response->setStatusCode(201);
        echo json_encode(array_filter($model->attributes),JSON_PRETTY_PRINT);
        exit;*/

        $this->setHeader(201);
        echo json_encode(array_filter($model->attributes),JSON_PRETTY_PRINT);
        exit;

        return $model;

    }

    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $arrStudentName = explode(" ", Yii::$app->request->post('fullname'));


        //$model = Student::findModel($id);
        //$model = Student::find($id);
        $model = Student::find()->where('id ='.$id)->one();
        $model->attributes = $request->bodyParams;

        //var_dump($request->bodyParams);
        //var_dump($model->attributes);die;


        $model->first_name = $arrStudentName[0];
        $model->last_name  = $arrStudentName[1];
        $model->save();
        return $model;

        //$model =
        var_dump(Yii::$app->request->bodyParams);
        var_dump($id);
        var_dump($model);die;




        if ($request->isPut || $request->isPatch){
            var_dump(Yii::$app->request->bodyParams);
        }else{
            var_dump('wrong method');
        }


        die;
    }

    /*
     *
     *
     *
     */
    public function actionImageUpload($id)
    {
        $intStudentId = intval($id);

        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstanceByName('imageFile');

            $arrResult = $model->upload();
            if ($arrResult['status']) {

                //var_dump($arrResult);die;
                // file is uploaded successfully
                $model = Student::find()->where('id ='.$intStudentId)->one();
                $model->image_url = $arrResult;
                $model->save();

                $this->setHeader(201);
                echo json_encode(array_filter($model->attributes),JSON_PRETTY_PRINT);
                exit;
            }else{
                $this->setHeader(422);
                echo json_encode(['errors' => $arrResult], JSON_PRETTY_PRINT);
                exit;

                //Yii::$app->response->statusCode = 422;
            }
        }else{
            var_dump(Yii::$app->response->statusCode);die;
            // 405 Method Not Allowed
        }
    }



    private function setHeader($status)
    {
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        $content_type="application/json; charset=utf-8";

        header($status_header);
        header('Content-type: ' . $content_type);
        //header('X-Powered-By: ' . "Nintriva <nintriva.com>");
    }
    private function _getStatusCodeMessage($status)
    {
        $codes = Array(
            200 => 'OK',
            201 => 'Created',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            422 => 'Data Validation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

}


