<?php
/**
 * Created by PhpStorm.
 * User: tangdoumac1
 * Date: 17/7/28
 * Time: 下午4:26
 */
// 文件保护
define('IN_SYS', true);

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once 'slim/vendor/autoload.php';

require 'slim/vendor/autoload.php';
require 'manage/IndexManage.php';
require 'manage/StudentManage.php';

$app = new Slim\App();

$app->get('/movie/{id}', function(Request $request, Response $response, $args){

    StudentManage::getStudent($request, $response, $args);
});

$app->get('/movie', function(Request $request, Response $response, $args){

    StudentManage::getAllStudent($request, $response, $args);
});

$app->get('/movie/', function(Request $request, Response $response, $args){

    StudentManage::getAllStudent($request, $response, $args);
});

$app->put('/movie/{id}', function(Request $request, Response $response, $args) {
    StudentManage::updateStudent($request, $response, $args);
});


$app->delete('/movie/{id}', function (Request $request, Response $response, $args) {
    StudentManage::deleteStudent($request, $response, $args);
});

$app->post('/movie', function(Request $request, Response $response, $args) {
   StudentManage::addStudent($request, $response, $args);
});

// 小程序api start
// 轮播图
$app->get('/banner', function (Request $request, Response $response, $args){
   IndexManage::getBanner($request, $response, $args);
});
$app->post('/banner', function (Request $request, Response $response, $args){
    IndexManage::postBanner($request, $response, $args);
//    IndexManage::initTable($request, $response, $args);
});
// 精选
$app->get('/featured', function (Request $request, Response $response, $args){
    IndexManage::getFeatured($request, $response, $args);
});
$app->post('/featured', function (Request $request, Response $response, $args){
    IndexManage::postFeatured($request, $response, $args);
});
// 最近新品
$app->get('/newest', function (Request $request, Response $response, $args){
    IndexManage::getNewest($request, $response, $args);
});
$app->post('/newest', function (Request $request, Response $response, $args){
    IndexManage::postNewest($request, $response, $args);
});

// 小程序api end


$app->run();