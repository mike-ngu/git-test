<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use api\modules\v1\models\Student;

/**
 * Upload Controller API
 *
 * @author Michael Maverick <mb2010y@gmail.com>
 */
class UploadController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Student';


    public function actionImageUpload()
    {
        //var_dump($_FILES);
        //var_dump(Yii::getAlias('@api'));
        //var_dump(Yii::$app->request->bodyParams);
        //die;

        $target_dir = Yii::getAlias('@api')."/files/";
        $target_file = $target_dir . basename($_FILES["image_url"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

        // Check if image file is a actual image or fake image
        /*
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["image_url"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }
        */

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["image_url"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["image_url"]["tmp_name"], $target_file)) {
                echo "The file ". basename( $_FILES["image_url"]["name"]). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

}


