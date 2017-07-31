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
    $dbpass = "root";
    $dbname = "school";

    $mysql_conn_string = "mysql:host=$dbhost;dbname=$dbname";
    $dbConnection = new PDO($mysql_conn_string, $dbuser, $dbpass);
    $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbConnection;
}