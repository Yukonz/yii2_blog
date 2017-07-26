<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\RegisterForm;
use app\models\ProfileForm;
use app\models\AddCommentForm;
use app\models\User;
use app\models\PostList;
use app\models\Post;
use app\models\Comment;
use yii\data\Pagination;


class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
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

        $model = new PostList();
        $posts = Post::find();
        $post_count = $posts->count();
        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $post_count,
        ]);

        $posts = Post::find()
            ->offset($pagination->offset)
            ->innerJoinWith('category')
            ->innerJoinWith('user')
            ->limit($pagination->limit)
            ->orderBy('Date DESC')
            ->asArray()
            ->all();

        return $this->render('index', compact('model', 'posts', 'pagination'));
    }

    public function actionSingle_post()
    {

        $model = new AddCommentForm();
        $post = Post::find()
            ->innerJoinWith('user')
            ->innerJoinWith('category')
            ->where(['posts.id' => $_GET['id']])
            ->one();

        $comments = Comment::find()
            ->orderBy('date DESC')
            ->innerJoinWith('user')
            ->where(['post_id' => $post->id])
            ->asArray()
            ->all();

        if($model->load(\Yii::$app->request->post())&& $model->validate()){
            $comment = new Comment();
            $comment->text = $model->text;
            $comment->user_id = Yii::$app->user->identity->id;
            $comment->post_id = $post->id;
            $comment->date = date("Y-m-d H:i:s");
            $comment->save();
            return $this->redirect('single_post?id=' . $post->id);
        }

        return $this->render('single_post', compact('post', 'comments', 'model'));
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionBackend()
    {
        return $this->render('backend');
    }

    public function actionProfile()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new ProfileForm();
        $model->username = Yii::$app->user->identity->username;
        $model->role = Yii::$app->user->identity->role;
        $model->posts = Yii::$app->user->identity->posts;

        if($model->load(\Yii::$app->request->post())&& $model->validate()){
            $user = User::findIdentity(Yii::$app->user->identity->id);
            $user->username = $model->username;
            $user->email = $model->email;
            $user->role = $model->role;
            $user->posts = $model->posts;
            $user->password = \Yii::$app->security->generatePasswordHash($model->password);
            $user->save();
        } else {
            $model->email = Yii::$app->user->identity->email;
        }

        return $this->render('profile', compact('model'));
    }

    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegisterForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $user = new User();
            $user->username = $model->username;
            $user->email = $model->email;
            $user->role = $model->role;
            $user->password = \Yii::$app->security->generatePasswordHash($model->password);
            $user->register_date = date("Y-m-d H:i:s");
            $user->posts = $model->posts;

            if($user->save()){
                return $this->goHome();
            }
        }

        return $this->render('register', compact('model'));
    }
}
