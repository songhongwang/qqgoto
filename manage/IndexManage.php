<?php
/**
 * Created by PhpStorm.
 * User: tangdoumac1
 * Date: 18/4/23
 * Time: 下午5:09
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


require 'model/Banner.php';
require 'model/Featured.php';
require 'model/Newest.php';
require_once 'db/Database.php';

class IndexManage{

    // 初始化表
    static function initTable(){
        try{
            $db = Database::getDB();

            // banner 表
            $sql = "create table if not EXISTS banner (id int(11) PRIMARY KEY AUTO_INCREMENT, name VARCHAR(100) CHARACTER SET 'utf8', img VARCHAR(200) CHARACTER SET 'utf8', price FLOAT, des VARCHAR(200) CHARACTER SET 'utf8')";
            $sth = $db->prepare($sql);
            $sth->execute();

            // featured 表
            $sql = "create table if not EXISTS featured (id int(11) PRIMARY KEY AUTO_INCREMENT, name VARCHAR(100) CHARACTER SET 'utf8', img VARCHAR(200) CHARACTER SET 'utf8', price FLOAT, des VARCHAR(200) CHARACTER SET 'utf8')";
            $sth = $db->prepare($sql);
            $sth->execute();

            // newest 表
            $sql = "create table if not EXISTS newest (id int(11) PRIMARY KEY AUTO_INCREMENT, name VARCHAR(100) CHARACTER SET 'utf8', img VARCHAR(200) CHARACTER SET 'utf8', price FLOAT, des VARCHAR(200) CHARACTER SET 'utf8')";
            $sth = $db->prepare($sql);
            $sth->execute();
        }catch(PDOException $e){
            echo $e;
        }
    }

    // 首页banner
    static function getBanner(Request $request, Response $response, $args){
        try{
            $db = Database::getDB();

            $sqlStr = "select * from banner";
            if($args['id'] > 0){
                $sqlStr = $sqlStr . " WHERE id = :id";
            }

            $sth = $db->prepare($sqlStr);


            if($args['id'] > 0){
                $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            }

            $sth->execute();
            $bannerList = $sth->fetchAll(PDO::FETCH_ASSOC);

            $arr = array();
            foreach ($bannerList as $item){
                $banner = new Banner();
                $banner->id = $item['id'];
                $banner->name = $item['name'];
                $banner->img = $item['img'];
                $banner->price = $item['price'];
                $banner->des = $item['des'];
                array_push($arr, $banner);
            }

            $response = $response->withStatus(200)->withHeader('Content-type', 'application/json;charset=utf-8');
            $response->getBody()->write(json_encode(
                [
                    'status' => 200,
                    'error' => '',
                    'datas' =>  $arr
                ]
            ));

        }catch (PDOException $e){
            echo "请重试，异常信息:";
            if(defined('Debug')){
                echo $e;
            }
            self::initTable();
        }

        return $response;
    }

    // 精选产品
    static function getFeatured(Request $request, Response $response, $args){

        try{
            $db = Database::getDB();

            $sqlStr = "select * from featured";
            if($args['id'] > 0){
                $sqlStr = $sqlStr . " WHERE id = :id";
            }

            $sth = $db->prepare($sqlStr);


            if($args['id'] > 0){
                $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            }

            $sth->execute();
            $featuredList = $sth->fetchAll(PDO::FETCH_ASSOC);

            $arr = array();
            foreach ($featuredList as $item){
                $featured = new Featured();
                $featured->id = $item['id'];
                $featuredList->name = $item['name'];
                $featured->img = $item['img'];
                $featured->price = $item['price'];
                $featured->des = $item['des'];
                array_push($arr, $featured);
            }

            $response = $response->withStatus(200)->withHeader('content-type', 'application/json;charset=utf-8');
            $response->getBody()->write(json_encode(
                [
                    'status' => 200,
                    'error' => '',
                    'datas' => $arr
                ]
            ));

        }catch (PDOException $e){
            echo "请重试，异常信息:";
            if(defined('Debug')){
                echo $e;
            }
            self::initTable();
        }

    return $response;
    }

    // 最近新品
    static function getNewest(Request $request, Response $response, $args){

        try{
            $db = Database::getDB();
            $sqlStr = "select * from newest";
            if($args['id'] > 0){
                $sqlStr = $sqlStr . " WHERE id = :id";
            }
            $sth = $db->prepare($sqlStr);

            if($args['id'] > 0){
                $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            }

            $sth->execute();
            $newestList = $sth->fetchAll(PDO::FETCH_ASSOC);
            $arr = array();
            foreach ($newestList as $item) {
                $newest = new Newest();
                $newest->id = $item['id'];
                $newest->name = $item['name'];
                $newest->img = $item['img'];
                $newest->price = $item['price'];
                $newest->des = $item['des'];
                array_push($arr, $newest);
            }

            $response = $response->withStatus(200)->withHeader('content-type', 'application/json;charset=utf-8');
            $response->getBody()->write(json_encode(
                [
                    'status' => 200,
                    'error' => '',
                    'datas' => $arr
                ]
            ));

        }catch (PDOException $e){
            echo "400 request forbidden";
            if(define("Debug")){
                echo $e;
            }
            self::initTable();
        }

        return $response;
    }

    public static function postBanner($request, $response, $args)
    {

        try{
            $postDatas = $request->getParsedBody();
            $db = Database::getDB();
            $sth = $db->prepare("INSERT INTO banner (name, img, price, des) VALUES (:name, :img, :price, :des)");
            $sth->bindParam(':name', $postDatas['name'], PDO::PARAM_STR);
            $sth->bindParam(':img', $postDatas['img'], PDO::PARAM_STR);
            $sth->bindParam(':price', $postDatas['price'], PDO::PARAM_STR);
            $sth->bindParam(':des', $postDatas['des'], PDO::PARAM_STR);
            $sth->execute();

            $response = $response->withStatus(200)->withHeader('content-type', 'application/json;charset=utf-8');
            $response->getBody()->write(json_encode(
                [
                    'status' => 200,
                    'error' => '',
                    'datas' => 'insert banner success'
                ]
            ));

        }catch(PDOException $e){
            echo "请重试，异常信息:";
            if(defined('Debug')){
                echo $e;
            }
            self::initTable();
        }

        return $response;

    }

    public static function postFeatured($request, $response, $args)
    {
        try{
            $postDatas = $request->getParsedBody();
            $db = Database::getDB();
            $sth = $db->prepare("INSERT INTO featured (name, img, price, des) VALUES (:name, :img, :price, :des)");
            $sth->bindParam(':name', $postDatas['name'], PDO::PARAM_STR);
            $sth->bindParam(':img', $postDatas['img'], PDO::PARAM_STR);
            $sth->bindParam(':price', $postDatas['price'], PDO::PARAM_STR);
            $sth->bindParam(':des', $postDatas['des'], PDO::PARAM_STR);
            $sth->execute();

            $response = $response->withStatus(200)->withHeader('content-type', 'application/json;charset=utf-8');
            $response->getBody()->write(json_encode(
                [
                    'status' => 200,
                    'error' => '',
                    'datas' => 'insert featured success'
                ]
            ));

        }catch(PDOException $e){
            echo "请重试，异常信息:";
            if(defined('Debug')){
                echo $e;
            }
            self::initTable();
        }

        return $response;
    }

    public static function postNewest($request, $response, $args)
    {
        try{
            $postDatas = $request->getParsedBody();
            $db = Database::getDB();
            $sth = $db->prepare("INSERT INTO newest (name, img, price, des) VALUES (:name, :img, :price, :des)");
            $sth->bindParam(':name', $postDatas['name'], PDO::PARAM_STR);
            $sth->bindParam(':img', $postDatas['img'], PDO::PARAM_STR);
            $sth->bindParam(':price', $postDatas['price'], PDO::PARAM_STR);
            $sth->bindParam(':des', $postDatas['des'], PDO::PARAM_STR);
            $sth->execute();

            $response = $response->withStatus(200)->withHeader('content-type', 'application/json;charset=utf-8');
            $response->getBody()->write(json_encode(
                [
                    'status' => 200,
                    'error' => '',
                    'datas' => 'insert newest success'
                ]
            ));

        }catch(PDOException $e){
            echo "请重试，异常信息:";
            if(defined('Debug')){
                echo $e;
            }
            self::initTable();
        }

        return $response;
    }
}