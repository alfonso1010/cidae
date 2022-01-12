<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\helpers\ArrayHelper;
use common\helpers\UtilidadesHelper;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
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
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
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
         $roles_usuario = \Yii::$app->authManager->getRolesByUser(
            Yii::$app->user->getId()
        );
        $roles_usuario =  reset($roles_usuario);
        $rol = ArrayHelper::getValue($roles_usuario, 'name', '');
        switch ($rol) {
            case 'admin':
                return $this->render('index');
                break;
            case 'profesor':
                return $this->redirect(["profesores/principal"]);
                break;
            case 'alumno':
                return $this->redirect(["alumnos/principal"]);
                break;
            default:
                Yii::$app->user->logout();
                return $this->goHome();
                break;
        }
        
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $roles_usuario = \Yii::$app->authManager->getRolesByUser(
                Yii::$app->user->getId()
            );
            $roles_usuario =  reset($roles_usuario);
            $rol = ArrayHelper::getValue($roles_usuario, 'name', '');
            switch ($rol) {
                case 'admin':
                    return $this->goHome(); 
                    break;
                case 'profesor':
                    return $this->redirect(["profesores/principal"]);
                    break;
                case 'alumno':
                    return $this->redirect(["alumnos/principal"]);
                    break;
                default:
                    Yii::$app->user->logout();
                    return $this->goHome();
                    break;
            }
            
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
