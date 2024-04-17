<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// include_once "autoload.php";

include_once "./router/Router.php";
include_once "./config/config.php";


$router = new Router();

$router->addRoute("GET", $_SERVER['REQUEST_URI'], "HomepageController@getHomepage");
$router->addRoute("POST", $url, "HomepageController@getFolder");
$router->addRoute("POST", $urlFilter, "HomepageController@setFilterController");
$router->addRoute("POST", $urlColor, "HomepageController@setColorController");
$router->addRoute("POST", $urlTag, "HomepageController@setTagController");
$router->addRoute("POST", $urlGetTag, "HomepageController@getTagController");
$router->addRoute("POST", $urlPreview, "HomepageController@getContentFile");
$router->addRoute("POST", $urlSearch, "HomepageController@glob_recursive_post");

$router->handleRequest($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
