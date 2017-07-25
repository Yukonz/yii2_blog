<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\AddCategoryForm;
use app\models\Category;
use app\models\AddPostForm;
use app\models\PostList;
use app\models\Post;
use app\models\User;
use app\models\EditUserForm;
use yii\data\Pagination;

class BackendController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('posts');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */



    public function actionPosts()
    {

        $model = new PostList();

        if (\Yii::$app->user->can('viewAllPosts')) {
            $posts = Post::find();
        } else {
            $posts = Post::find()->where(['user_id' => Yii::$app->user->identity->id]);;
        }

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $posts->count(),
        ]);

        if (\Yii::$app->user->can('viewAllPosts')) {
            $posts = Post::find()
                ->asArray()
                ->orderBy($model->order_by)
                ->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();

        } else {
            $posts = Post::find()
                ->asArray()
                ->orderBy($model->order_by)
                ->offset($pagination->offset)
                ->where(['user_id' => Yii::$app->user->identity->id])
                ->limit($pagination->limit)
                ->all();
        }

        return $this->render('posts', compact('model', 'posts', 'pagination'));
    }

    public function actionCategories()
    {
        $model = new AddCategoryForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $category = new Category();
            $category->name = $model->name;
            $category->save();
        }

        $categories = Category::find()
            ->asArray()
            ->all();

        return $this->render('categories', compact('categories', 'model'));
    }

    public function actionUsers()
    {
        $users = User::find()
            ->asArray()
            ->all();

        return $this->render('users', compact('users'));
    }

    public function actionUser_edit()
    {
        $model = new EditUserForm();
        $user = User::findOne($_GET['id']);

        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $user->username = $model->username;
            $user->email = $model->email;
            $user->role =  $model->role;
            $user->save();

            return $this->redirect('users');
        }
        $model->username = $user->username;
        $model->email = $user->email;
        $model->role =  $user->role;
        return $this->render('edit_user', compact('model'));
    }

    public function actionUser_delete()
    {
        $user = User::findOne($_GET['id']);
        $user->delete();
        return $this->redirect('users');
    }

    public function actionPost_edit()
    {
        $model = new AddPostForm();
        $post = Post::findOne($_GET['id']);

        $model->header = $post->header;
        $model->text = $post->text;
        $model->category_id = $post->category_id;

        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $post = new Post();
            $post->header = $model->header;
            $post->text = $model->text;
            $post->category_id = $model->category_id;
            $post->user_id = Yii::$app->user->identity->id;
            $post->date = date("Y-m-d H:i:s");
            $post->save();

            return $this->redirect('posts');
        }

        return $this->render('edit_post', compact('model'));
    }

    public function actionPost_delete()
    {
        $post = Post::findOne($_GET['id']);
        $post->delete();
        return $this->redirect('posts');
    }

    public function actionPost_add()
    {
        $model = new AddPostForm();

        if($model->load(\Yii::$app->request->post())&& $model->validate()){

            $user = User::findIdentity(Yii::$app->user->identity->id);
            $user->posts++;
            $user->save();

            $post = new Post();
            $post->header = $model->header;
            $post->text = $model->text;
            $post->category_id = $model->category_id;
            $post->user_id = Yii::$app->user->identity->id;
            $post->date = date("Y-m-d H:i:s");
            $post->save();

            return $this->redirect('posts');
        } else {
            return $this->render('new_post', compact('model'));
        }
    }
}