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
require 'model/Recommend.php';
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
            echo $e;
        }

        return $response;
    }

    // 精选产品
    static function getFeatured(Request $request, Response $response, $args){
        $arr = array();

        for($x=0; $x< 3; $x++){
            $item = new Recommend();
            $item->id = $x;
            $item->name = '产品' + strval($x);
            $item->img = 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1524639198196&di=09c80077946ed508bb1c2ac6b253525c&imgtype=jpg&src=http%3A%2F%2Fimg4.imgtn.bdimg.com%2Fit%2Fu%3D2776839664%2C347860258%26fm%3D214%26gp%3D0.jpg';
            $item->des = '好好好';
            array_push($arr, $item);
        }

        $response = $response->withStatus(200)->withHeader('content-type', 'application/json;charset=utf-8');
        $response->getBody()->write(json_encode(
            [
                'status' => 200,
                'error' => '',
                'datas' => $arr
            ]
        ));

    return $response;
    }

    // 最近新品
    static function getNewest(Request $request, Response $response, $args){
        $arr = array();
        for($x=0; $x<10; $x++){
            $item = new Newest();
            $item->id = $x;
            $item->name = '新品' + strval($x);
            if($x % 2 == 0){
                $item->img = 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1524636521405&di=3e6bb7ce60234f970b3ceb1f0810767c&imgtype=0&src=http%3A%2F%2Fzp1.douguo.net%2Fupload%2Fdish%2F9%2F3%2F2%2F600_93112c1379981ccdb756d537ec86f6c2.jpg';
            }else{
                $item->img = 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1524636521404&di=71075b644556f604d9195594edb558b4&imgtype=0&src=http%3A%2F%2Fi5.xiachufang.com%2Fimage%2F600%2F0a22ddbae11911e4b0bce0db5512b208.jpg';
            }
            $item->price = $x;
            $item->des = "描述";
            array_push($arr, $item);
        }
        $response = $response->withStatus(200)->withHeader('content-type', 'application/json;charset=utf-8');
        $response->getBody()->write(json_encode(
            [
                'status' => 200,
                'error' => '',
                'datas' => $arr
            ]
        ));

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
            echo $e;
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
            echo $e;
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
            echo $e;
        }

        return $response;
    }
}