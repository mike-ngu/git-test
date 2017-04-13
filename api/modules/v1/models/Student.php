<?php
namespace api\modules\v1\models;
use \yii\db\ActiveRecord;
Use Yii;
/**
 * Student Model
 *
 * @author Michael Maverick <mb2010y@gmail.com>
 */
class Student extends ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'student';
	}

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['id'];
    }

    /**
     * Define rules for validation
     */
    public function rules()
    {
        return [
            // [['first_name', 'last_name', 'email', 'image_url'], 'required']
            [['fullname'], 'required']
        ];
    }

    public function fields()
    {
        return [
            // field name is the same as the attribute name
            'id',
            'fullname',
            'first_name',
            'last_name',
            'avatar_url' => 'image_url'
            // field name is "email", the corresponding attribute name is "email_address"
            //'email-address' => 'email',
            // field name is "name", its value is defined by a PHP callback
            //'full-name' => function ($model) {
            //    return $model->first_name . ' ' . $model->last_name;
            //},

        ];
    }


}
