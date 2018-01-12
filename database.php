<?php
/**
 * Created by PhpStorm.
 * User: tangdoumac1
 * Date: 17/7/31
 * Time: 上午10:34
 */

function getDB()
{
    $dbhost = "localhost:3306";
    $dbuser = "root";
    $dbpass = "123456";
    $dbname = "douban";

    $mysql_conn_string = "mysql:host=$dbhost;dbname=$dbname";
    $pdo = new PDO($mysql_conn_string, $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->query("SET NAMES utf8");
    return $pdo;
}