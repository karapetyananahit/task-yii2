<?php
namespace app\models;

use Yii;
use yii\web\UploadedFile;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int|null $category_id
 * @property int|null $status
 * @property string|null $image
 *
 * @property Category $category
 */
class Product extends ActiveRecord
{
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'category_id', 'image'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['name'], 'required'],
            [['category_id'], 'required', 'message' => 'Please select a category.'],
            [['description'], 'string'],
            [['category_id', 'status'], 'integer'],
            [['name', 'image'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg', 'skipOnEmpty' => true, 'maxSize' => 1024 * 1024 * 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'category_id' => 'Category',
            'status' => 'Status',
            'image' => 'Image',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Upload the image to the server.
     *
     * @return bool
     */
    public function upload()
    {
        if ($this->imageFile) {
            if ($this->validate()) {
                if ($this->image && file_exists($this->image)) {
                    @unlink($this->image);
                }
                $path = 'uploads/' . uniqid() . '.' . $this->imageFile->extension;

                if ($this->imageFile->saveAs($path)) {
                    $this->image = $path;
                }
            } else {
                return false;
            }
        }
        return $this->save(false);
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            if ($this->image) {
                $path = Yii::getAlias('@webroot') . '/' . $this->image;
                if (file_exists($path)) {
                    @unlink($path);
                }
            }
            return true;
        }
        return false;
    }


}
