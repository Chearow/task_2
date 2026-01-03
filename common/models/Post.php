<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $author_id
 * @property int $category_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Category $category
 * @property Comment[] $comments
 * @property User $user
 */
class Post extends \yii\db\ActiveRecord
{
    public $tagIds = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['content'], 'string'],
            [['author_id', 'category_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['author_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            ['tagIds', 'each', 'rule' => ['integer']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'author_id' => 'Author ID',
            'category_id' => 'Category ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function saveImage($filename): bool
    {
        $this->image = $filename;
        return $this->save(false);
    }

    public function getImage()
    {
        if (!empty($this->image)) {
            return Yii::getAlias('@frontendUrl') . '/uploads/' . $this->image;
        }
        return Yii::getAlias('@frontendUrl') . '/placeholders/no-image.png';
    }

    public function deleteImage()
    {
        $imageUploadModel = new ImageUpload();
        $imageUploadModel->deleteCurrentImage($this->image);
    }

    public function beforeDelete()
    {
        $this->deleteImage();
        return parent::beforeDelete();
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function saveCategory($category_id)
    {
        $category = Category::findOne($category_id);
        if ($category != null)
        {
            $this->link('category', $category);
            return true;
        }
        return false;
    }

    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::class,
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }

    public function getPostTags()
    {
        return $this->hasMany(PostTag::class, ['post_id' => 'id']);
    }

    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])
            ->via('postTags');
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        PostTag::deleteAll(['post_id' => $this->id]);

        if (is_array($this->tagIds))
        {
            foreach ($this->tagIds as $tagId)
            {
                $pt = new PostTag();
                $pt->post_id = $this->id;
                $pt->tag_id = $tagId;
                $pt->save();
            }
        }
    }

    public function getSelectedTags()
    {
        $selectedIds = $this->getTags()->select('id')->asArray()->all();
        return ArrayHelper::getColumn($selectedIds, 'id');
    }

    public function saveTags($tags)
    {
        if (is_array($tags))
        {
            $this->clearCurrentTags();

            foreach ($tags as $tag_id)
            {
                $tag = Tag::findOne($tag_id);
                $this->link('tags', $tag);
            }
        }
    }

    public function clearCurrentTags()
    {
        PostTag::deleteAll(['post_id' => $this->id]);
    }

}
