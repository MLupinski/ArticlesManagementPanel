<?php

require_once('vendor/autoload.php');

$router = new Src\Core\Router();

$router->get('/', 'Home@index');
$router->get('/articles', 'Article@index');
$router->get('/authors', 'Author@index');

/**
 * API ARTICLE ROUTE *****************************************
 */
$router->get('/api/articles', 'Article@getAll');
$router->get('/api/add/article', 'Article@add');
$router->get("/api/update/article", 'Article@update');
$router->get('/api/delete/article', 'Article@delete');
/**
 * ***************************************************
 */

 /**
 * API AUTHOR ROUTE *****************************************
 */
$router->get('/api/authors', 'Author@getAll');
$router->get("/api/update/author", 'Author@update');
$router->get("/api/add/author", 'Author@add');
$router->get('/api/delete/author', 'Author@delete');
 /**
 * ***************************************************
 */
$router->dispatch();