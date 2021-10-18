<?php
require_once 'vendor/autoload.php';

$router = new AltoRouter();
//$router->setBasePath("/");

$UserController = new \App\controller\UserController();

$router->map("GET", "/user/[i:id]", function ($id) use($UserController) {
    $UserController->getUser($id);
}, "get_user");

$router->map("PUT", "/user/[i:id]", function ($id) use ($UserController) {
    $UserController->putUser($id);
}, "update_user");

$router->map("DELETE", "/user/[i:id]", function ($id) use ($UserController) {
    $UserController->deleteUser($id);
}, "delete_user");

$router->map("POST", "/user", function () use ($UserController) {
    $UserController->postUser();
}, "create_user");

$match = $router->match();

if( is_array($match) && is_callable( $match['target'] ) ) {
    call_user_func_array( $match['target'], $match['params'] );
} else {
    // no route was matched
    header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}

function test($id)
{
    echo "ok".$id;
}