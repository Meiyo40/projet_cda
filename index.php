<?php
require_once 'vendor/autoload.php';

$router = new AltoRouter();
//$router->setBasePath("/");

$UserController = new \App\controller\UserController();
$TopicController = new \App\controller\TopicController();
$PostController = new \App\controller\PostController();
$CategoryController = new \App\controller\CategoryController();

//ROUTING USER
$router->map("GET", "/user", function () use($UserController) {
    $UserController->getAllUsers();
}, "get_all_users");

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

//ROUTING TOPIC
$router->map("GET", "/topic", function () use($TopicController) {
    $TopicController->getAllTopic();
}, "get_all_topics");

$router->map("GET", "/topic/[i:id]", function ($id) use($TopicController) {
    $TopicController->getTopic($id);
}, "get_topic");

$router->map("PUT", "/topic/[i:id]", function ($id) use ($TopicController) {
    $TopicController->putTopic($id);
}, "update_topic");

$router->map("DELETE", "/topic/[i:id]", function ($id) use ($TopicController) {
    $TopicController->deleteTopic($id);
}, "delete_topic");

$router->map("POST", "/topic", function () use ($TopicController) {
    $TopicController->postTopic();
}, "create_topic");


//ROUTING POST
$router->map("GET", "/post", function () use($PostController) {
    $PostController->getAllPosts();
}, "get_all_post");

$router->map("GET", "/post/[i:id]", function ($id) use($PostController) {
    $PostController->getPost($id);
}, "get_post");

$router->map("PUT", "/post/[i:id]", function ($id) use ($PostController) {
    $PostController->putPost($id);
}, "update_post");

$router->map("DELETE", "/post/[i:id]", function ($id) use ($PostController) {
    $PostController->deletePost($id);
}, "delete_post");

$router->map("POST", "/post", function () use ($PostController) {
    $PostController->createPost();
}, "create_post");

//ROUTING CATEGORY
$router->map("GET", "/category", function () use($CategoryController) {
    $CategoryController->getAllCategory();
}, "get_all_category");

$router->map("GET", "/category/[i:id]", function ($id) use($CategoryController) {
    $CategoryController->getCategory($id);
}, "get_category");

$router->map("PUT", "/category/[i:id]", function ($id) use ($CategoryController) {
    $CategoryController->updateCategory($id);
}, "update_category");

$router->map("DELETE", "/category/[i:id]", function ($id) use ($CategoryController) {
    $CategoryController->deleteCategory($id);
}, "delete_category");

$router->map("POST", "/category", function () use ($CategoryController) {
    $CategoryController->createCategory();
}, "create_category");

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