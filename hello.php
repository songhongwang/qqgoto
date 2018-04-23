<?php
/**
 * Created by PhpStorm.
 * User: tangdoumac1
 * Date: 17/7/31
 * Time: 下午4:49
 */

$str = '1234';
if (preg_match("[a-zA-Z0-9]{4,16}", $str)) {
    echo "验证成功";
} else {
    echo "验证失敗";
}

?>