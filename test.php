<?php
/**
 * Created by PhpStorm.
 * User: tangdoumac1
 * Date: 17/7/28
 * Time: 下午4:26
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'slim/vendor/autoload.php';
require 'student_manage.php';

$app = new Slim\App();

$app->get('/score/{id}', function(Request $request, Response $response, $args){

    StudentManage::getStudent($request, $response, $args);
});

$app->put('/score/{id}', function(Request $request, Response $response, $args) {
    StudentManage::updateStudent($request, $response, $args);
});


$app->delete('/score/{id}', function (Request $request, Response $response, $args) {
    StudentManage::deleteStudent($request, $response, $args);
});

$app->post('/score', function(Request $request, Response $response, $args) {
    printf("hello");

   StudentManage::addStudent($request, $response, $args);
});

$app->run();