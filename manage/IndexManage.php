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

class IndexManage{

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

    static function getRecommend(Request $request, Response $response, $args){
        $arr = array();

        for($x=0; $x< 10; $x++){
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


}