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
    public $imageFile; // This is the temporary field for image upload

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
            [['description'], 'string'],
            [['category_id', 'status'], 'integer'],
            [['name', 'image'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxSize' => 1024 * 1024 * 2], // max 2MB file
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
            'category_id' => 'Category ID',
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
        if ($this->validate() && $this->imageFile) {
            $path = 'uploads/' . uniqid() . '.' . $this->imageFile->extension;
            if ($this->imageFile->saveAs($path)) {
                $this->image = $path;
                return $this->save(false);
            }
        }
        return false;
    }

}
