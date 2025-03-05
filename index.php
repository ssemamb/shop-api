<?php
require_once 'config/connection.php';
require_once 'controllers/UsersController.php';
require_once 'controllers/StockItemsController.php';
require_once 'controllers/StockController.php';
require_once 'controllers/SalesController.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/DashboardController.php';
require_once 'middleware/rolepermisson.php';
require_once 'router/router.php';

$baseUrl = '/shop-api/v1';
$router = new Router($baseUrl);

$UsersModel = new UsersModel($pdo);
$UsersController = new UsersController($UsersModel);


$StockItemsModel = new StockItemsModel($pdo);
$StockItemsController = new StockItemsController($StockItemsModel);

$StockModel = new StockModel($pdo);
$StockController = new StockController($StockModel);


$SalesModel = new SalesModel($pdo);
$SalesController = new SalesController($SalesModel);


$UsersModel = new UsersModel($pdo);
$AuthService = new AuthService($UsersModel, $pdo);
$AuthController = new AuthController($AuthService);


$DashboardModel = new DashboardModel($pdo);
$DashboardController = new DashboardController($DashboardModel);

require_once 'router/routes.php';

//dispatch incoming requests

$method = $_SERVER['REQUEST_METHOD'];
$Url = str_replace('/index.php', '', $_SERVER['REQUEST_URI']);
$Url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->dispatch($method, $Url);
