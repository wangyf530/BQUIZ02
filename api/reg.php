<?php 
    include_once "db.php";
    // 不存資料庫 所以unset
    unset($_POST['pw2']);

    echo $USER->save($_POST);

?>