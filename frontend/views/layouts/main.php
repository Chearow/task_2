<?php

/** @var \yii\web\View $this */

/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;

AppAsset::register($this);
?>
<?php
$this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php
        $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php
        $this->head() ?>
    </head>
    <body class="d-flex flex-column h-100">
    <?php
    $this->beginBody() ?>

    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
            <div class="container">
                <a class="navbar-brand fw-bold" href="<?= \yii\helpers\Url::to(['/site/index']) ?>">
                    Pixel Paradise
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#mainNavbar" aria-controls="mainNavbar"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="mainNavbar">

                    <ul class="navbar-nav mb-2 mb-lg-0 text-uppercase small">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= \yii\helpers\Url::to(['/site/index']) ?>">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= \yii\helpers\Url::to(['/post/index']) ?>">Posts</a>
                        </li>
                    </ul>

                    <ul class="navbar-nav mb-2 mb-lg-0 text-uppercase small">
                        <?php
                        if (Yii::$app->user->isGuest): ?>
                            <li class="nav-item"><a class="nav-link"
                                                    href="<?= \yii\helpers\Url::to(['/site/login']) ?>">Login</a></li>
                            <li class="nav-item"><a class="nav-link"
                                                    href="<?= \yii\helpers\Url::to(['/site/signup']) ?>">Register</a>
                            </li>
                        <?php
                        else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= \yii\helpers\Url::to(['/site/logout']) ?>"
                                   data-method="post">Logout (<?= Yii::$app->user->identity->username ?>)</a>
                            </li>
                        <?php
                        endif; ?>
                    </ul>

                </div>
            </div>
        </nav>
    </header>

    <main role="main" class="flex-shrink-0">
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <footer class="footer mt-auto py-3 text-muted">
        <div class="container">
            <p class="float-start">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
            <p class="float-end"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php
    $this->endBody() ?>
    </body>
    </html>
<?php
$this->endPage();
