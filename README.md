# [qqgoto.com](http://www.qqgoto.com)
php slim CRUD simple

## 使用composer 创建slim项目
  1. composer require slim/slim “^3.0”


## Apache 容器指定 路由文件 
  1. .htaccess文件中指定RewriteRule 字段的值为路由文件 xxx.php

## 数据库链接工具类database.php 使用的是pdo方式

## mysql pdo 中文乱码问题 
  1. 在获取到数据库链接的时候指定字符集:  $pdo->query("SET NAMES utf8");


