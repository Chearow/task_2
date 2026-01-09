<?php

namespace frontend\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\Post;
use yii\data\ActiveDataProvider;

class PostController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Post::find()->with(['category', 'tags'])->orderBy(['id' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionView($id)
    {
        $post = Post::find()
            ->where(['id' => $id])
            ->with(['category', 'tags', 'comments'])
            ->one();

        if (!$post) {
            throw new NotFoundHttpException('Пост не найден');
        }

        return $this->render('view', ['post' => $post]);
    }
}
