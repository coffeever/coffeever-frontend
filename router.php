<?php
defined('INDEX') or die();
global $routes;

$routes = [
    [
        "route" => '^home[\/]?$',
        "file" => "home.php",
        "onBeforeAction" => function () {
            setConfigParam('siteTitle', 'Coffever');
        }
    ],
    [
        "route" => "^login[\/]?$",
        "file" => "components/login.php",

        "printHeader" => false,
        "printFooter" => true,
        "onBeforeAction" => function () {
            if(isLoggedIn()){
                header('Location: ' . getSafeUrl('/hesap/kullanici-paneli'));
                exit();
            }
            setConfigParam('siteTitle', 'Login');
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
        "route" => "^account[\/]?$",
        "file" => "dashboard/user-panel.php",

        "isPublic" => true,
        "printHeader" => true,
        "printFooter" => true,
        "onBeforeAction" => function () {
            if(!isLoggedIn()){
                header('Location: ' . getSafeUrl('/login'));
                exit();
            }
            setConfigParam('siteTitle', 'Account');
        }
    ],
    [
        "route" => "^favorites[\/]?$",
        "file" => "dashboard/favorites.php",

        "isPublic" => true,
        "printHeader" => true,
        "printFooter" => true,
        "onBeforeAction" => function () {
            setConfigParam('siteTitle', 'Favorites');
        }
    ],
    [
        "route" => "^our-team[\/]?$",
        "file" => "components/our-team.php",

        "onBeforeAction" => function () {
            setConfigParam('siteTitle', 'Our Team');
        }
    ],
    [
        "route" => "^contact[\/]?$",
        "file" => "components/contact.php",

        "onBeforeAction" => function () {
            setConfigParam('siteTitle', 'Contact');
        }
    ],
    [
        "route" => "^search[\/]?$",
        "file" => "components/search.php",
        "onBeforeAction" => function () {
            setConfigParam('siteTitle', 'Search');
        }
    ],
    [
        "route" => "^results[\/]?$",
        "file" => "components/results.php",
        "onBeforeAction" => function () {
            setConfigParam('siteTitle', 'Search');
        }
    ],
    [
        "route" => "^coffees[\/]?$",
        "file" => "components/coffees.php",
        "onBeforeAction" => function () {
            setConfigParam('siteTitle', 'Search');
        }
    ],
    [
        "route" => "^coffee-detail/([a-zA-Z0-9-]+)[\/]?$",
        "file" => "components/coffee-detail.php",
        "stopExecution" => false,
        "onBeforeAction" => function ($params) {
            if (!empty($params) && isset($params['title'])) {
                setConfigParam('siteTitle', $params['title']);
            }
        },
        "data" => function ($params) {
            $alias = $params[1];
            $data = makeRequest("getSingleCoffee", ["slug" => $alias], "GET");
            if (!empty($data)) {
                if (!empty($data['metaTitle'])) {
                    setConfigParam('siteTitle', $data['name']);
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