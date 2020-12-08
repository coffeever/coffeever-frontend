<?php
defined('INDEX') or die();
global $routes;

$routes = [
    [
        "route" => '^home[\/]?$',
        "file" => "home.php",
        "onBeforeAction" => function () {
            setConfigParam('siteTitle', 'Adawall Home');
            setConfigParam('metaDescription', 'Adawall Home meta description');
        }
    ],
    [
        "route" => "^giris-yap[\/]?$",
        "file" => "components/login.php",

        "printHeader" => false,
        "printFooter" => true,
        "onBeforeAction" => function () {
            if(isLoggedIn()){
                header('Location: ' . getSafeUrl('/hesap/kullanici-paneli'));
                exit();
            }
            setConfigParam('siteTitle', 'Giriş Yap');
        }
    ],
    [
        "route" => "^kayit-ol[\/]?$",
        "file" => "components/register.php",

        "printHeader" => false,
        "printFooter" => true,
        "onBeforeAction" => function () {
            if(isLoggedIn()){
                header('Location: ' . getSafeUrl('/hesap/kullanici-paneli'));
                exit();
            }
            setConfigParam('siteTitle', 'Kayıt Ol');
        }
    ],
    [
        "route" => "^parolami-unuttum/([a-zA-Z0-9-]+)[\/]?$",
        "file" => "components/reset-password.php",
        "onBeforeAction" => function ($params) {
            if (!empty($params) && isset($params['title'])) {
                setConfigParam('siteTitle', 'Parolamı Unuttum');
            }
        },
        "data" => function ($params) {
            $alias = $params[1];
            $data = makeRequest("get", ["tokens" => $alias], ["collection" => "subscribers"]);
            $data['token'] = $alias;
            return $data;
        }
    ],
    [
        "route" => "^logout[\/]?$",
        "stopProcessing" => true,
        "onBeforeAction" => function () {
            unsetAuthParams();
            header('Location: ' . '/');
        }
    ],
    [
        "isAlias" => true,
        "route" => "^".$postsUrlStructure."[\/]?$",
        "file" => "components/news.php",

        "onBeforeAction" => function () {
            setConfigParam('siteTitle', 'Blog');
        }
    ],
    [
        "route" => "^yazilar/".$postDetailUrlStructure."[\/]?$",
        "file" => "components/news-detail.php",

        "stopExecution" => false,
        "onBeforeAction" => function ($params) {
            if (!empty($params) && isset($params['title'])) {
                setConfigParam('siteTitle', $params['title']);
            }
        },
        "data" => function ($params) {
            $alias = $params[1];
            $data = makeRequest("get", ["alias" => $alias], ["collection" => "posts"]);
            if (!empty($data)) {
                if (!empty($data['metaTitle'])) {
                    setConfigParam('siteTitle', $data['metaTitle']);
                }
                if (!empty($data['metaKeywords'])) {
                    setConfigParam('metaKeywords', $data['metaKeywords']);
                }
                if (!empty($data['metaDescription'])) {
                    setConfigParam('metaDescription', $data['metaDescription']);
                }
                if (!empty($data['image'])) {
                    setConfigParam('ogImage', getPictureWithLink($data['image']));
                }
            }
            return $data;
        }
    ],
    [
        "route" => "^hesap/kullanici-paneli[\/]?$",
        "file" => "dashboard/user-panel.php",

        "isPublic" => true,
        "printHeader" => true,
        "printFooter" => true,
        "onBeforeAction" => function () {
            if(!isLoggedIn()){
                header('Location: ' . getSafeUrl('/giris-yap'));
                exit();
            }
            setConfigParam('siteTitle', 'Kullanıcı Paneli');
        }
    ],
    [
        "route" => "^hesap/adreslerim[\/]?$",
        "file" => "dashboard/adresses.php",

        "isPublic" => true,
        "printHeader" => true,
        "printFooter" => true,
        "onBeforeAction" => function () {
            setConfigParam('siteTitle', 'Adreslerim');
        }
    ],
    [
        "route" => "^sepet[\/]?$",
        "file" => "payment/cart.php",

        "onBeforeAction" => function () {
            setConfigParam('siteTitle', 'Satın Al');
        }
    ],
    [
        "route" => "^iletisim[\/]?$",
        "file" => "components/contact.php",

        "onBeforeAction" => function () {
            setConfigParam('siteTitle', 'İletişim');
            setConfigParam("bodyClass","template-collection header-has-overlap");
        }
    ],
    [
        "route" => "^sikca-sorulan-sorular[\/]?$",
        "file" => "components/faq.php",
        "onBeforeAction" => function () {
            setConfigParam('siteTitle', 'Sıkça Sorulan Sorular');
            setConfigParam("bodyClass","template-collection header-has-overlap");
        },
        "data" => function ($params) {
            $data = makeRequest("getList", [], ["collection" => "faqs"]);
            return $data;
        }
    ],
    [
        "route" => "^siparis-onay[\/]?$",
        "file" => "payment/checkout.php",

        "onBeforeAction" => function () {
            if (!isLoggedIn()) {
                $_SESSION['referenceUrl'] = 'siparis-onay';
                header('Location: /giris-yap');
                exit();
            }
            $_SESSION['referenceUrl'] = '';
            setConfigParam('siteTitle', 'Satın Al');
        }
    ],
    [
        "route" => "^odeme/([a-zA-Z0-9-]+)[\/]?$",
        "file" => "payment/payment.php",
        "stopExecution" => false,
        "onBeforeAction" => function ($params) {
            if (!empty($params) && isset($params['title'])) {
                setConfigParam('siteTitle', $params['title']);
            }
        },
        "data" => function ($params) {
            $alias = $params[1];
            $data = makeRequest("get", ["_id" => $alias], ["collection" => "orders"]);
            if (!empty($data)) {
                if (!empty($data['metaTitle'])) {
                    setConfigParam('siteTitle', $data['metaTitle']);
                }
                if (!empty($data['metaKeywords'])) {
                    setConfigParam('metaKeywords', $data['metaKeywords']);
                }
                if (!empty($data['metaDescription'])) {
                    setConfigParam('metaDescription', $data['metaDescription']);
                }
                if (!empty($data['image'])) {
                    setConfigParam('ogImage', getPictureWithLink($data['image']));
                }
            }
            return $data;
        }
    ],
    [
        "route" => "^ara[\/]?$",
        "file" => "components/search.php",
        "onBeforeAction" => function () {
            $keywords = isset($_GET['q']) ? urldecode(trim($_GET['q'])) : "";
            if (isset($_GET['t'])) {
                if ($_GET['t'] == "products") {
                    $searchFor = "Ürün";
                }
                if ($_GET['t'] == "posts") {
                    $searchFor = "Yazı";
                }
            }
            setConfigParam('siteTitle', $searchFor . ' arama sonuçları: ' . $keywords);
        }
    ],
    [
        "route" => "^paytr-callback[\/]?$",
        "stopExecution" => true,
        "onBeforeAction" => function () {
            exit();
        }
    ],
    [
        "route" => "^([a-zA-Z0-9-]+)[\/]?$",
        "file" => "components/single-page.php",
        "stopExecution" => false,
        "onBeforeAction" => function ($params) {
            if (!empty($params) && isset($params['title'])) {
                setConfigParam('siteTitle', $params['title']);
            }
        },
        "data" => function ($params) {
            $alias = $params[1];
            $data = makeRequest("get", ["alias" => $alias], ["collection" => "pages"]);
            if (!empty($data)) {
                if (!empty($data['metaTitle'])) {
                    setConfigParam('siteTitle', $data['metaTitle']);
                }
                if (!empty($data['metaKeywords'])) {
                    setConfigParam('metaKeywords', $data['metaKeywords']);
                }
                if (!empty($data['metaDescription'])) {
                    setConfigParam('metaDescription', $data['metaDescription']);
                }
                if (!empty($data['image'])) {
                    setConfigParam('ogImage', getPictureWithLink($data['image']));
                }
            }
            return $data;
        }
    ],
];
global $currentTemplate;
$currentTemplate = 'coffeever';
$router = new Router($currentTemplate);
$router->currentPage = $page;
foreach ($routes as $route) {
	if (!isset($route['route'])) continue;
	$_route = new Route();
	$_route->route = $route['route'];
	if (isset($route['file'])) $_route->file = $route['file'];
	if (isset($route['template'])) $_route->template = $route['template'];
	if (isset($route['stopProcessing'])) $_route->stopProcessing = $route['stopProcessing'];
	if (isset($route['stopExecution'])) $_route->stopExecution = $route['stopExecution'];
	if (isset($route['onBeforeAction'])) $_route->onBeforeAction = $route['onBeforeAction'];
	if (isset($route['onAfterAction'])) $_route->onAfterAction = $route['onAfterAction'];
	if (isset($route['isPublic'])) $_route->isPublic = $route['isPublic'];
	if (isset($route['printHeader'])) $_route->printHeader = $route['printHeader'];
	if (isset($route['printFooter'])) $_route->printFooter = $route['printFooter'];
	if (isset($route['data'])) $_route->data = $route['data'];
	$router->addRoute($_route);
}
$router->processRoutes();
die();