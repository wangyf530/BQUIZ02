<?php include_once "db.php";

// 計算acc=$acc的數量(1為有一個帳號與此重複)
/* $acc = $_GET['acc'];
echo $USER->count(['acc'==$acc]); */

echo $USER->count($_GET);

/* 
if($res>0){
    echo 1;
} else {
    echo 0;
} */

?>