<?php


namespace micro\controllers;

use yii\rest\ActiveController;
use micro\models\User;
use Yii;

class UserController extends ActiveController
{
    public $modelClass = 'micro\models\User';

    /**
     * Remove rateLimiter which requires an authenticated user to work
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['rateLimiter']);
        return $behaviors;
    }

    /**
     * This method is used to login the user by calling the end point like POST /users/login
     * @return string
     */
    public function actionLogin()
    {
        $name = Yii::$app->request->post('name');
        $password = Yii::$app->request->post('password');

        $user = User::findOne(['name' => $name, 'password' => $password]);

        if (isset($user)) {
            return User::getToken();
        }

        Yii::$app->response->statusCode = 401;
        return 'Username or password is invalid';
    }


    /**
     * This method is used to register a user by calling endpoint like POST users/register
     * Required parameters are name, email and password
     * @return array|mixed
     */
    public function actionRegister()
    {
        $model = new User();
        $model->scenario = User::SCENARIO_REGISTER;

        $model->name = Yii::$app->request->post('name');
        $model->email = Yii::$app->request->post('email');
        $model->password = Yii::$app->request->post('password');

        $model->register();

        if($model->hasErrors()) {
            Yii::$app->response->statusCode = 401;
            return $model->errors;
        } else {
            Yii::$app->response->statusCode = 201;
            return $model->token;
        }
    }

    /**
     * This method is used to get the authorized user
     * Required parameter is token
     *
     * @return User|string|null
     */
    public function actionAuthorized()
    {
        $token = Yii::$app->request->get('token');
        $user = User::findOne(['token' => $token]);

        if (isset($user) && $user->isAccessTokenValid()) {
            $user->password = '';
            return $user;
        }

        return 'Token ' . $token . ' not found ';
    }
}