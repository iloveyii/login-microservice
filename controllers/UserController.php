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
            $user->token = $user->generateAccessToken();
            $user->save(false);
            $data = [
                'token' =>  $user->token
            ];

            return $data;
        }

        Yii::$app->response->statusCode = 401;
        $data = [
            'error' =>  'Username or password is invalid'
        ];

        return $data;
    }


    /**
     * This method is used to register a user by calling endpoint like POST users/register
     * Required parameters are name, email and password
     * @return array|mixed
     */
    public function actionRegister()
    {
        $model = new User(['scenario' => User::SCENARIO_REGISTER]);

        if($model->load(Yii::$app->request->post()) && $model->register()) {
            Yii::$app->response->statusCode = 201;
            $data = [
                'token' =>  $model->token
            ];
            return $data;
        }

        // Model has errors
        Yii::$app->response->statusCode = 401;
        return $model->errors;
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

        Yii::$app->response->statusCode = 404;

        $data = [
            'error' =>  'Token ' . $token . ' not found '
        ];

        return $data;
    }
}
