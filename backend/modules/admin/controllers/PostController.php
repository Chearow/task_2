<?php

namespace backend\modules\admin\controllers;

use common\models\Category;
use common\models\ImageUpload;
use common\models\Post;
use common\models\PostSearch;
use common\models\Tag;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Post::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCreate()
    {
        $model = new Post();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->tagIds = ArrayHelper::getColumn($model->tags, 'id');

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionSetImage($id)
    {
        $model = new ImageUpload();

        if (Yii::$app->request->isPost) {
            $post = $this->findModel($id);
            $file = UploadedFile::getInstance($model, 'image');

            if ($post->saveImage($model->uploadFile($file, $post->image))) {
                return $this->redirect(['view', 'id' => $post->id]);
            }
        }

        return $this->render('image', ['model' => $model]);
    }

    public function actionSetCategory($id)
    {
        $post = $this->findModel($id);
        $selectedCategory = $post->category->id ?? null;
        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'name');

        if (Yii::$app->request->isPost) {
            $categoryId = Yii::$app->request->post('category');

            if ($categoryId) {
                $post->category_id = $categoryId;
                $post->save(false);
            }
            return $this->redirect(['view', 'id' => $post->id]);
        }


        return $this->render('category', [
            'model' => $post,
            'selectedCategory' => $selectedCategory,
            'categories' => $categories
        ]);
    }

    public function actionSetTags($id)
    {
        $post = $this->findModel($id);
        $selectedTags = $post->getSelectedTags();
        $tags = ArrayHelper::map(Tag::find()->all(), 'id', 'title');

        if (Yii::$app->request->isPost) {
            $tags = Yii::$app->request->post('tags');
            $post->saveTags($tags);
            return $this->redirect(['view', 'id' => $post->id]);
        }

        return $this->render('tags', [
            'selectedTags' => $selectedTags,
            'tags' => $tags
        ]);
    }

}
