<?php
namespace app\models;
use yii\base\Model;

class AddCategoryForm extends Model{

    public $id;
    public $name;

    public function rules()
    {
        return [
            [['name'], 'required', 'message' => 'Category name is required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Category name',
        ];
    }
}