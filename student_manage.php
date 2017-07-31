<?php

/**
 * Created by PhpStorm.
 * User: tangdoumac1
 * Date: 17/7/31
 * Time: 下午3:49
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


require 'database.php';

class StudentManage
{
    static function getStudent(Request $request, Response $response, $args)
    {
        try {
            $db = getDB();
            $sqlStr = "SELECT * FROM students";
            if($args['id'] > 0){
                $sqlStr = $sqlStr . " WHERE student_id = :id";
            }

            $sth = $db->prepare($sqlStr);


            if($args['id'] > 0){
                $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            }

            $sth->execute();
            $student = $sth->fetchAll(PDO::FETCH_ASSOC);

            if ($student) {
                $arr = array();
                foreach ($student as $stu){
                    array_push($arr, $stu);
                }


                $response = $response->withStatus(200)->withHeader('Content-type', 'application/json');
                $response->getBody()->write(json_encode(
                    [
                        'status' => 200,
                        'error' => '',
                        'datas' => $arr
                    ]
                ));
            } else {
                $response = $response->withStatus(404)->withHeader('Content-type', 'application/json');
                $response->getBody()->write(json_encode(
                    [
                        'status' => 404,
                        'error' => 'student could not be found',
                        'datas' => $student
                    ]
                ));
            }
            return $response;
            $db = null;
        } catch (PDOException $e) {
            $response = $response->withStatus(500)->withHeader('Content-type', 'application/json');
            $response->getBody()->write(json_encode(
                [
                    'status' => 500,
                    'error' => $e->getMessage(),
                    'datas' => ''
                ]
            ));
            return $response;
            $db = null;
        }
    }

    static function updateStudent(Request $request, Response $response, $args)
    {
        try {
            $putDatas = $request->getParsedBody();
            $db = getDB();
            $sth = $db->prepare("UPDATE students SET score = :score WHERE student_id = :id");

            $sth->bindParam(':score', $putDatas['score'], PDO::PARAM_INT);
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $ret = $sth->execute();

            $response = $response->withStatus(200)->withHeader('Content-type', 'application/json');
            $response->getBody()->write(json_encode(
                    [
                        'status' => 200,
                        'error' => '',
                        'datas' => 'update successfully'
                    ]
                )
            );
            return $response;
            $db = null;
        } catch (PDOException $e) {
            $response = $response->withStatus(500)->withHeader('Content-type', 'application/json');
            $response->getBody()->write(json_encode(
                [
                    'status' => 500,
                    'error' => $e->getMessage(),
                    'datas' => ''
                ]
            ));
            return $response;
            $db = null;
        }
    }

    static function addStudent(Request $request, Response $response, $args)
    {
        $postDatas = $request->getParsedBody();
        try {
            $db = getDB();
            $sth = $db->prepare("INSERT INTO students (score, first_name, last_name) VALUES (:score, :firstName, :lastName)");
            $sth->bindParam(':score', $postDatas['score'], PDO::PARAM_INT);
            $sth->bindParam(':firstName', $postDatas['firstName'], PDO::PARAM_STR);
            $sth->bindParam(':lastName', $postDatas['lastName'], PDO::PARAM_STR);
            $sth->execute();

            $response = $response->withStatus(200)->withHeader('Content-type', 'application/json');
            $response->getBody()->write(json_encode(
                    [
                        'status' => 200,
                        'error' => '',
                        'datas' => 'insert successfully'
                    ]
                )
            );
            return $response;
            $db = null;

        } catch (PDOException $e) {
            $response = $response->withStatus(500)->withHeader('Content-type', 'application/json');
            $response->getBody()->write(json_encode(
                [
                    'status' => 500,
                    'error' => $e->getMessage(),
                    'datas' => ''
                ]
            ));
            return $response;
            $db = null;
        }
    }

    static function deleteStudent(Request $request, Response $response, $args)
    {
        try {
            $db = getDB();
            $sth = $db->prepare("DELETE FROM students WHERE student_id = :id");
            $sth->bindParam(':id', $args['id'], PDO::PARAM_INT);
            $sth->execute();

            $response = $response->withStatus(200)->withHeader('Content-type', 'application/json');
            $response->getBody()->write(json_encode(
                    [
                        'status' => 200,
                        'error' => '',
                        'datas' => 'delete successfully'
                    ]
                )
            );
            return $response;
            $db = null;

        } catch (PDOException $e) {
            $response = $response->withStatus(500)->withHeader('Content-type', 'application/json');
            $response->getBody()->write(json_encode(
                [
                    'status' => 500,
                    'error' => $e->getMessage(),
                    'datas' => ''
                ]
            ));
            return $response;
            $db = null;
        }
    }
}