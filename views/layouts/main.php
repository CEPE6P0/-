<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
$this->registerCssFile(Yii::getAlias('@web/fonts/css/all.min.css'));
?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <?php
        $this->registerCssFile('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');

        $this->registerJsFile(
            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
            ['position' => \yii\web\View::POS_END]
        );
        ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php
        // Регистрируем preconnect и preload ДО вызова $this->head()
        $this->registerLinkTag(['rel' => 'preconnect', 'href' => 'https://cdnjs.cloudflare.com']);
        $this->registerLinkTag(['rel' => 'preconnect', 'href' => 'https://fonts.googleapis.com']);
        $this->registerLinkTag([
            'rel' => 'preload',
            'as' => 'style',
            'href' => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css'
        ]);
        ?>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>

    <header>
        <?php
        NavBar::begin([
            'brandLabel' => '<i class="fas fa-film"></i> ' . Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => ['class' => 'navbar navbar-expand-md navbar-cinema fixed-top'],
            'brandOptions' => ['class' => 'navbar-brand'],
            'innerContainerOptions' => ['class' => 'container'], // обязательно
        ]);
        $currentRoute = Yii::$app->controller->getRoute();
        $menuItems = [];

        // Общие пункты
        $menuItems[] = [
            'label' => '<i class="fas fa-home"></i> Главная',
            'url' => ['/site/index'],
            'encode' => false,
            'active' => ($currentRoute == 'site/index')
        ];
        $menuItems[] = [
            'label' => '<i class="fas fa-film"></i> Фильмы',
            'url' => ['/movie/movies'],
            'encode' => false,
            'active' => ($currentRoute == 'movie/movies')
        ];
        $menuItems[] = [
            'label' => '<i class="fas fa-tv"></i> Сериалы',
            'url' => ['/movie/series'],
            'encode' => false,
            'active' => ($currentRoute == 'movie/series')
        ];
        $menuItems[] = [
            'label' => '<i class="fas fa-search"></i> Поиск',
            'url' => ['/search/index'],
            'encode' => false,
            'active' => ($currentRoute == 'search/index')
        ];

        if (
            Yii::$app->user->isGuest ||
            !Yii::$app->user->identity->hasSubscription()
        ) {

            $menuItems[] = [
                'label' => '<i class="fas fa-crown"></i> Подписка',
                'url' => '#',
                'encode' => false,
                'linkOptions' => [
                    'data-bs-toggle' => 'modal',
                    'data-bs-target' => '#subscriptionModal',
                ],
            ];
        }

        // Профиль – только авторизованным
        if (!Yii::$app->user->isGuest) {
            $menuItems[] = [
                'label' => '<i class="fas fa-user"></i> Профиль',
                'url' => ['/profile/index'],
                'encode' => false,
                'active' => ($currentRoute == 'profile/index')
            ];
        }

        // Админ-панель – только администраторам (поле role = 1)
        if (!Yii::$app->user->isGuest && isset(Yii::$app->user->identity->role) && Yii::$app->user->identity->role == 'admin') {
            $menuItems[] = [
                'label' => '<i class="fas fa-crown"></i> Админ-панель',
                'url' => ['/admin/default/index'],
                'encode' => false,
                'active' => (strpos($currentRoute, 'admin/') === 0)
            ];
        }

        // Вход / Выход
        if (Yii::$app->user->isGuest) {
            $menuItems[] = [
                'label' => '<i class="fas fa-sign-in-alt"></i> Войти',
                'url' => ['/site/login'],
                'encode' => false,
                'active' => ($currentRoute == 'site/login')
            ];
        } else {
            $menuItems[] = '<li class="nav-item">'
                . Html::beginForm(['/site/logout'])
                . Html::submitButton(
                    '<i class="fas fa-sign-out-alt"></i> Выйти (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'nav-link btn btn-link']
                )
                . Html::endForm()
                . '</li>';
        }

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav ms-auto'],
            'activateItems' => true,
            'items' => $menuItems,
        ]);

        NavBar::end();
        ?>
    </header>

    <main>
        <div class="container mt-5 pt-3">
            <?php if (!empty($this->params['breadcrumbs'])): ?>
                <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs'], 'options' => ['class' => 'breadcrumb bg-transparent p-0']]) ?>
            <?php endif ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <footer class="footer-cinema d-flex justify-content-center align-items-center">
        <?= date('Y') ?> <?= Yii::$app->name ?> — все права защищены
    </footer>
    <div class="modal fade" id="subscriptionModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">

            <div class="modal-content subscription-modal">

                <div class="modal-header border-0">
                    <h5 class="modal-title">
                        👑 Премиум подписка
                    </h5>

                    <button type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="price-block">
                        <div class="price">499 ₽</div>
                        <div class="period">/ месяц</div>
                    </div>

                    <p class="subtitle">
                        Оформи подписку и получи полный доступ к контенту
                    </p>

                    <div class="features">
                        <div>✔ Без рекламы</div>
                        <div>✔ Все фильмы и сериалы</div>
                        <div>✔ Full HD и выше</div>
                        <div>✔ Эксклюзивные премьеры</div>
                        <div>✔ Доступ с любых устройств</div>
                    </div>

                </div>

                <div class="modal-footer border-0">

                    <a href="<?= \yii\helpers\Url::to(['/site/buy-subscription']) ?>"
                       class="btn btn-danger w-100 btn-lg">

                        Оформить подписку

                    </a>

                </div>

            </div>

        </div>
    </div>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>

<style>
    .subscription-modal{
        background:#0f1117;
        border-radius:18px;
        color:#fff;
        border:1px solid rgba(229,9,20,0.3);
        box-shadow:0 20px 60px rgba(0,0,0,0.6);
    }

    .subscription-modal .modal-title{
        font-weight:700;
        font-size:20px;
    }

    .price-block{
        text-align:center;
        margin:10px 0 20px;
    }

    .price{
        font-size:48px;
        font-weight:800;
        color:#e50914;
    }

    .period{
        font-size:14px;
        color:#9aa4bf;
    }

    .subtitle{
        text-align:center;
        margin-bottom:20px;
        color:#cbd5e1;
    }

    .features{
        display:grid;
        gap:10px;
        font-size:15px;
        padding:10px 20px;
        background:#151925;
        border-radius:12px;
    }

    .features div{
        padding:6px 0;
        border-bottom:1px solid rgba(255,255,255,0.05);
    }

    .features div:last-child{
        border-bottom:none;
    }

    .btn-danger{
        background:#e50914;
        border:none;
        font-weight:600;
    }

    .btn-danger:hover{
        background:#b20710;
    }


    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html, body {
        height: 100%;
    }

    body {
        font-family: 'Inter', sans-serif;
        background: #0a0c10;
        display: flex;
        flex-direction: column;
    }

    /* Стилизованная шапка (стеклянная, тёмная) */
    .navbar-cinema {
        background: rgba(10, 12, 18, 0.85) !important;
        backdrop-filter: blur(16px);
        border-bottom: 1px solid rgba(229, 9, 20, 0.3);
        box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    }
    .navbar-cinema .navbar-brand {
        font-weight: 700;
        font-size: 1.5rem;
        background: linear-gradient(135deg, #fff, #e50914);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        letter-spacing: -0.5px;
    }
    .navbar-cinema .navbar-nav .nav-link {
        color: #eef2ff !important;
        font-weight: 500;
        transition: 0.2s;
        margin: 0 0.2rem;
        border-radius: 2rem;
    }
    .navbar-cinema .navbar-nav .nav-link:hover {
        color: #e50914 !important;
        background: rgba(229,9,20,0.15);
    }
    .navbar-cinema .btn-link {
        color: #eef2ff !important;
        text-decoration: none;
    }
    .navbar-cinema .btn-link:hover {
        color: #e50914 !important;
    }
    .navbar-toggler {
        border-color: rgba(255,255,255,0.3);
    }

    /* Основной контент растягивается */
    main {
        flex: 1 0 auto;
        padding: 1.5rem 0;
    }

    /* Футер в стиле кинотеатра */
    .footer-cinema {
        background: rgba(10, 12, 18, 0.9);
        backdrop-filter: blur(12px);
        border-top: 1px solid rgba(229, 9, 20, 0.3);
        padding: 1.5rem 0;
        margin-top: auto;
        font-size: 0.9rem;
    }
    .footer-cinema .container {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        align-items: center;
    }
    .footer-cinema .copyright {
        color: #9aa4bf;
    }
    .footer-cinema .copyright i {
        color: #e50914;
        margin-right: 4px;
    }
    .footer-cinema .powered {
        color: #6c7a9e;
    }
    .footer-cinema a {
        color: #e50914;
        text-decoration: none;
    }
    .footer-cinema a:hover {
        text-decoration: underline;
    }
    @media (max-width: 768px) {
        .footer-cinema .container {
            flex-direction: column;
            text-align: center;
        }
    }
    .navbar-cinema .navbar-nav .nav-link.active,
    .navbar-cinema .navbar-nav .nav-link:active {
        color: #e50914 !important;
        background: rgba(229,9,20,0.2);
        border-radius: 2rem;
    }
</style>
