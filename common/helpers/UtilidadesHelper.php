<?php

namespace common\helpers;

use Yii;
use yii\httpclient\Client;

class UtilidadesHelper {

    public static function behaviorRbac() {
        return [
            'allow' => true,
            'roles' => ['@'],
            'matchCallback' => function($rule, $action) {
                $module                 = Yii::$app->controller->module->id;
                $action                 = Yii::$app->controller->action->id;
                $controller             = Yii::$app->controller->id;
                $controladorAccion      = "/$controller/$action";
                $controladorCompleto    = "/$controller/*";
                $moduloControladorAccion   = "/$module/$controller/$action";
                $moduloControladorCompleto = "/$module/$controller/*";
                $moduloCompleto = "/$module/*";
                $post = Yii::$app->request->post();
                if (\Yii::$app->user->can($controladorAccion)
                    || \Yii::$app->user->can($controladorCompleto)
                    || \Yii::$app->user->can($moduloControladorCompleto)
                    || \Yii::$app->user->can($moduloCompleto)
                ){
                    return true;
                }
            }
        ];
    }

    public static function verificaRol($rol)
    {
        $roles = Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId());
        foreach ($roles as $key => $value) {
            $roles[] = $value->name;
        }
        if (in_array($rol, $roles)) {
            return 1;
        }
        return 0;
    }
}

?>