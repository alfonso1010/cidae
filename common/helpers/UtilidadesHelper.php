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

    public static function calculaSemestreBloque($grupo){
        $fecha_inicio_grupo  = new \DateTime($grupo->fecha_inicio_clases);
        //$fecha_actual = new \DateTime(Yii::$app->formatter->asDate('now', 'php:Y-m-d'));
        $fecha_actual = new \DateTime(Yii::$app->formatter->asDate('now', 'php:Y-m-d'));
        $intvl = $fecha_inicio_grupo->diff($fecha_actual);
        $semestre = 0;
        $bloque = 0;
        //semstre 1
        if($intvl->y == 0 && $intvl->m <= 5){
            $semestre = 1;
            if($intvl->m >= 0 && $intvl->m <= 2){
                $bloque = 1;
            }else if($intvl->m > 2 && $intvl->m <= 5){
                $bloque = 2;
            }
        }else if( $intvl->y == 0 && $intvl->m > 5 && $intvl->m <= 11 ){
        //semestre 2
            $semestre = 2;
            if($intvl->m > 5 && $intvl->m <= 8){
                $bloque = 1;
            }else if($intvl->m > 8 && $intvl->m <= 11){
                $bloque = 2;
            }
        }else if( $intvl->y == 1  && $intvl->m <= 5 ){
        //semestre 3
            $semestre = 3;
            if($intvl->m >= 0 && $intvl->m <= 2){
                $bloque = 1;
            }else if($intvl->m > 2 && $intvl->m <= 5){
                $bloque = 2;
            }
        }else if( $intvl->y == 1 && $intvl->m > 5 && $intvl->m <= 11 ){
        //semestre 4
            $semestre = 4;
            if($intvl->m > 5 && $intvl->m <= 8){
                $bloque = 1;
            }else if($intvl->m > 8 && $intvl->m <= 11){
                $bloque = 2;
            }
        }else if( $intvl->y == 2  && $intvl->m <= 5 ){
        //semestre 5
            $semestre = 5;
            if($intvl->m >= 0 && $intvl->m <= 2){
                $bloque = 1;
            }else if($intvl->m > 2 && $intvl->m <= 5){
                $bloque = 2;
            }
        }else if( $intvl->y == 2 && $intvl->m > 5 && $intvl->m <= 11 ){
        //semestre 6
            $semestre = 6;
            if($intvl->m > 5 && $intvl->m <= 8){
                $bloque = 1;
            }else if($intvl->m > 8 && $intvl->m <= 11){
                $bloque = 2;
            }
        }
        if($semestre > 0 && $bloque > 0){
            return [
                'semestre' => $semestre,
                'bloque' => $bloque,
                'años' => $intvl->y,
                'meses' => $intvl->m,
                'dias' => $intvl->d
            ];
        }else{
            return null;
        }
    }
}

?>