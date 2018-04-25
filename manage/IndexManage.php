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

class IndexManage{

    // 首页banner
    static function getBanner(Request $request, Response $response, $args){
        $arr = array();

        for ($x=0; $x<=13; $x++) {
            $item = new Banner();
            $item -> id = 1;
            $item -> img = 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1524499232938&di=01e23a94a081802e354967070ffe187f&imgtype=0&src=http%3A%2F%2Fpic31.photophoto.cn%2F20140620%2F0042040381727046_b.jpg';
            $item -> des = "美食";

            array_push($arr, $item);
        }


        $response = $response->withStatus(200)->withHeader('Content-type', 'application/json;charset=utf-8');
        $response->getBody()->write(json_encode(
            [
                'status' => 200,
                'error' => '',
                'datas' =>  $arr
            ]
        ));
        return $response;
    }

    // 精选产品
    static function getFeatured(Request $request, Response $response, $args){
        $arr = array();

        for($x=0; $x< 3; $x++){
            $item = new Recommend();
            $item->id = $x;
            $item->name = '产品' + strval($x);
            $item->img = 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1524499232938&di=01e23a94a081802e354967070ffe187f&imgtype=0&src=http%3A%2F%2Fpic31.photophoto.cn%2F20140620%2F0042040381727046_b.jpg';
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

}