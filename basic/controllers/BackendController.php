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
use app\models\Comment;
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
        return $this->redirect('/backend/posts');
    }

    public function actionPosts()
    {

        $model = new PostList();
        $model->load(\Yii::$app->request->post());

        if (\Yii::$app->user->can('viewAllPosts')) {
            $posts = Post::find()
                ->orWhere(['LIKE', 'posts.text', $model->search])
                ->orWhere(['LIKE', 'posts.header', $model->search]);
        } else {
            $posts = Post::find()->where(['user_id' => Yii::$app->user->identity->id]);
        }

        $user = User::findIdentity(Yii::$app->user->identity->id);
        $posts_count = $user->posts;

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $posts->count(),
        ]);

        if (\Yii::$app->user->can('viewAllPosts')) {
            $posts = Post::find()
                ->innerJoinWith('user')
                ->innerJoinWith('category')
                ->orWhere(['LIKE', 'posts.text', $model->search])
                ->orWhere(['LIKE', 'posts.header', $model->search])
                ->andWhere(['LIKE', 'posts.category_id', $model->category_id])
                ->andWhere(['LIKE', 'posts.user_id', $model->user_id])
                ->orderBy($model->order_by)
                ->offset($pagination->offset)
                ->limit($pagination->limit)
                ->asArray()
                ->all();

        } else {
            $posts = Post::find()
                ->innerJoinWith('user')
                ->innerJoinWith('category')
                ->orderBy($model->order_by)
                ->offset($pagination->offset)
                ->where(['user_id' => Yii::$app->user->identity->id])
                ->limit($pagination->limit)
                ->asArray()
                ->all();
        }

        $categories_list = Category::find()->select(['name', 'id'])->indexBy('id')->column();
        array_unshift($categories_list, "All");

        $users_list = User::find()->select(['username', 'id'])->indexBy('id')->column();
        array_unshift($users_list, "All");

        return $this->render('posts', compact('model', 'posts', 'pagination', 'categories_list', 'users_list', 'posts_count'));
    }

    public function actionComments()
    {
        if (\Yii::$app->user->can('editComment')) {
            $comments = Comment::find();

            $pagination = new Pagination([
                'defaultPageSize' => 10,
                'totalCount' => $comments->count(),
            ]);

            $comments = Comment::find()
                ->innerJoinWith('user')
                ->innerJoinWith('post')
                ->orderBy('date DESC')
                ->offset($pagination->offset)
                ->limit($pagination->limit)
                ->asArray()
                ->all();

            return $this->render('comments', compact('comments','pagination'));
        }
        return $this->redirect('posts');
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

        $cat_count = count($categories);

        for ($i=0; $i<$cat_count; $i++){
            $cat_id = $categories[$i]['id'];
            $posts = Post::find()
                ->asArray()
                ->where(['category_id' => $cat_id])
                ->all();
            $categories[$i]['posts'] = count($posts);
        }

        return $this->render('categories', compact('categories', 'model'));
    }

    public function actionCategory_delete()
    {
        $category = Category::findOne($_GET['id']);
        $category->delete();

        Post::deleteAll('category_id = :category_id ', [':category_id' => $_GET['id']]);

        return $this->redirect('categories');
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
        $current_role = $user->role;

        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $user->username = $model->username;
            $user->email = $model->email;
            $user->role =  $model->role;
            $user->save();

            $auth = Yii::$app->authManager;
            $new_role = $auth->getRole($model->role);
            $current_role = $auth->getRole($current_role);
            $auth->revoke($current_role, $user->id);
            $auth->assign($new_role, $user->id);

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
        Comment::deleteAll('post_id = :post_id ', [':post_id' => $_GET['id']]);

        $post = Post::findOne($_GET['id']);
        $post->delete();

        $user = User::findIdentity($post['user_id']);
        $user->posts--;
        $user->save();

        return $this->redirect('posts');
    }

    public function actionComment_delete()
    {
        $comment = Comment::findOne($_GET['id']);
        $comment->delete();
        return $this->redirect('comments');
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