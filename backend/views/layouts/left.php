<?php
use yii\helpers\Url;
use mdm\admin\components\MenuHelper;
use yii\bootstrap\Nav;
use yii\widgets\Menu;
use yii\helpers\ArrayHelper;

$menu = MenuHelper::getAssignedMenu(Yii::$app->user->id);
//print_r($menu);die();

?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= Url::to('@web/assets/logo.png', true)  ?>"  style="width: 100px;height: 35px;" class="" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->username ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <?= 
        Menu::widget([
            'options'         => ['class' => 'sidebar-menu','data-widget'=> "tree"], 
            //'firstItemCssClass' => 'treeview',
            //'itemOptions'     => ['class' => 'treeview'],
            'activateParents' => true,
            'encodeLabels'    => false,
            'linkTemplate'    => '<a href="{url}" class="treeview"><span>{label}</span></a>',
            'submenuTemplate' => '<ul class="treeview-menu">{items}</ul>',
            'items'           => $menu
        ]);
        ?>
    </section>

</aside>
