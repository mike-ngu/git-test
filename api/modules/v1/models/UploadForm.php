<?php
/**
 * Student Model
 *
 * @author Michael <mb2010y@gmail.com>
 */

namespace api\modules\v1\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;


class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [
                ['imageFile'],
                'file',
                'skipOnEmpty' => false,
                'extensions' => 'png, jpg, jpeg',
                'maxSize' => (1024*1024)*4
            ],
        ];
    }

    /*
     *
     * */
    public function upload()
    {
        $result = array('status' => 0);
        if ($this->validate()) {
            // on success
            $dir = Yii::getAlias('@api')."/files/";
            $filePath = $dir . $this->imageFile->baseName . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs($filePath);
            $result['status'] = 1;
            $result['imageFile'] = $filePath;
        } else {
            // on failure
            $errors = $this->errors;
            $result['status'] = 0;
            $result['errors'] = $errors['imageFile'];
        }

        return $result;
    }
}