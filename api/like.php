<?php 
include_once "db.php";
// 後續可省略建立變數 直接使用
$id = $_POST['id'];
$user = $_SESSION['user'];

$news = $NEWS->find($id);
// 檢查是否已經在資料庫裡
$chk = $LOG->count(['news'=>$id,'user'=>$user]);
// 已存在 -> 有點過讚 -> 要取消讚
if($chk>0){
    $LOG->del(['news'=>$id,'user'=>$user]);
    $news['likes']--;
} else {
    $LOG->save(['news'=>$id,'user'=>$user]);
    $news['likes']++;
}

$NEWS->save($news);


