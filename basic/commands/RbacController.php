<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // добавляем разрешение "createPost"
        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create a post';
        $auth->add($createPost);

        $editPost = $auth->createPermission('editPost');
        $editPost->description = 'Edit a post';
        $auth->add($editPost);

        $editUser = $auth->createPermission('editUser');
        $editUser->description = 'Edit a user';
        $auth->add($editUser);

        $createCategory = $auth->createPermission('createCategory');
        $createCategory->description = 'Create a category';
        $auth->add($createCategory);

        $viewAllPosts = $auth->createPermission('viewAllPosts');
        $viewAllPosts->description = 'View all posts';
        $auth->add($viewAllPosts);

        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $editPost);
        $auth->addChild($user, $createPost);

        $editor = $auth->createRole('editor');
        $auth->add($editor);
        $auth->addChild($editor, $editPost);
        $auth->addChild($editor, $viewAllPosts);
        $auth->addChild($editor, $createCategory);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $createPost);
        $auth->addChild($admin, $editUser);
        $auth->addChild($admin, $editor);

        $auth->assign($editor, 3);
        $auth->assign($admin, 2);
        $auth->assign($user, 5);
    }
}