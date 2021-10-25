<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
$this->registerCss(<<<CSS
    .skin-green .main-header .navbar{
        background-color: #CEDE00;
    }
    .skin-green .main-header .logo{
         background-color: #CEDE00;
         color: #092F87
    }
    .skin-green .main-header .navbar .nav>li>a{
        color: #092F87
    }
    .skin-green .main-header .navbar .sidebar-toggle{
        color: #092F87
    }
    .box.box-solid.box-primary>.box-header{
        background: #092f87;
        background-color: #092f87;
    }
    .texto-azul {
      color: #092f87;
    }
    .skin-green .wrapper, .skin-green .main-sidebar, .skin-green .left-side{
        background-color:  #252525
    }
    .skin-green .sidebar a{
        color: white
    }
CSS

);

if (Yii::$app->controller->action->id === 'login') { 
/**
 * Do not use this code in your template. Remove it. 
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {

    if (class_exists('backend\assets\AppAsset')) {
        backend\assets\AppAsset::register($this);
    } else {
        app\assets\AppAsset::register($this);
    }

    dmstr\web\AdminLteAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="hold-transition skin-green sidebar-mini">
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render(
            'header.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>

        <?= $this->render(
            'left.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>

        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>

    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
