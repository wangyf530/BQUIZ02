<?php 
include_once "db.php";

$user = $USER->find(['email'=>$_GET['email']]);
// 如果不是空的 -> 有這個用戶
if (!empty($user)) {
    echo "您的密碼為:".$user['pw'];
} else {
    echo "查無此資料";
}

?>