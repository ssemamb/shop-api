<?php
require_once 'router/router.php';
require_once 'middleware/rolepermisson.php';
$router->group('/users', function ($router) use ($UsersController) {

    $router->add('POST', '', [$UsersController, 'store']);
    $router->add('GET', '', [$UsersController, 'show']);
    $router->add('PUT', '/{user_id}', function ($params) use ($UsersController) {
        $user_id = $params[0];
        $UsersController->put($user_id);
    });
    $router->add('DELETE', '/{user_id}', function ($params) use ($UsersController) {
        $user_id = $params[0];
        $UsersController->destroy($user_id);
    });
    $router->add('GET', '/search', function ($params, $query) use ($UsersController) {
        $UsersController->search($query);
    });
});


$router->group('/stock_items', function ($router) use ($StockItemsController) {

    $router->add('POST', '', [$StockItemsController, 'store']);
    $router->add('GET', '', [$StockItemsController, 'show']);
    $router->add('PUT', '/{stock_items_id}', function ($params) use ($StockItemsController) {
        $stock_items_id = $params[0];
        $StockItemsController->put($stock_items_id);
    });
    $router->add('DELETE', '/{stock_items_id}', function ($params) use ($StockItemsController) {
        $stock_items_id = $params[0];
        $StockItemsController->destroy($stock_items_id);
    });
    $router->add('GET', '/search', function ($params, $query) use ($StockItemsController) {
        $StockItemsController->search($query);
    });
});


$router->group('/stock', function ($router) use ($StockController) {
    $router->add('POST', '', [$StockController, 'store']);
    $router->add('GET', '', [$StockController, 'show']);
    $router->add('PUT', '/{stock_id}', function ($params) use ($StockController) {
        $stock_id = $params[0];
        $StockController->put($stock_id);
    });
    $router->add('DELETE', '/{stock_id}', function ($params) use ($StockController) {
        $stock_id = $params[0];
        $StockController->destroy($stock_id);
    });
    $router->add('GET', '/search', function ($params, $query) use ($StockController) {
        $StockController->search($query);
    });
});



$router->group('/sales', function ($router) use ($SalesController) {
    $router->add('POST', '', [$SalesController, 'store']);
    $router->add('GET', '', [$SalesController, 'show']);
    $router->add('PUT', '/{sales_id}', function ($params) use ($SalesController) {
        $sales_id = $params[0];
        $SalesController->put($sales_id);
    });
    $router->add('DELETE', '/{sales_id}', function ($params) use ($SalesController) {
        $sales_id = $params[0];
        $SalesController->destroy($sales_id);
    });
});




$router->group('/auth', function ($router) use ($AuthController) {

    $router->add('POST', '/login', [$AuthController, 'login']);
    $router->add('POST', '/logout', [$AuthController, 'logout']);
    $router->add('POST', '/security_question', [$AuthController, 'securityquestion']);
    $router->add('POST', '/forgot_password', [$AuthController, 'forgotpassword']);
});


$router->group('/dashboard', function ($router) use ($DashboardController) {
    $router->add('GET', '', [$DashboardController, 'DashboardMetrics']);
});


$router->add('GET', '/admin', function () {
    $middleware = new RolesPermission('/admin');
    if ($middleware->handle()) {

        return true;
    }
});


$router->add('GET', '/super_admin', function () {

    $middleware = new RolesPermission('/super_admin');
    if ($middleware->handle()) {
        return true;
    }
});
