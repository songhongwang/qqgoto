<?php
/**
 * Created by PhpStorm.
 * User: tangdoumac1
 * Date: 18/4/26
 * Time: 下午3:03
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'db/Database.php';
require 'model/Poem.php';

class PoemManage
{

    static function randPoem(Request $request, Response $response, $args){
        try{
            $db = Database::getDB();

            $sqlStr = "select * from poem WHERE id = :id";


            $sth = $db->prepare($sqlStr);
            $id = rand(1,320);

            if($id > 0){
                $sth->bindParam(':id', $id, PDO::PARAM_INT);
            }

            $sth->execute();
            $result = $sth->fetch(PDO::FETCH_ASSOC);

            $poem = new Poem();
            $poem->type = $result['type'];
            $poem->id = $result['id'];
            $poem->name = $result['name'];
            $poem->dynasty = $result['dynasty'];
            $poem->author = $result['author'];
            $poem->content = $result['content'];
            $poem->translation =str_replace("\<\/p\>", "", str_replace("\<p\>","",$result['translation']));

            $response = $response->withStatus(200)->withHeader('Content-type', 'application/json;charset=utf-8');
            $response->getBody()->write(json_encode(
                [
                    'status' => 200,
                    'error' => '',
                    'datas' =>  $poem
                ]
            ));

        }catch (PDOException $e){
            echo "请重试，异常信息: getBanner()";
            if(defined('Debug')){
                echo $e;
            }
        }

        return $response;


    }
}