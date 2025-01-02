<?php 
include_once "db.php";
// 變數本身就是陣列
// $_POST['ids']

foreach ($_POST['ids'] as $id) {
    $USER->del($id);
}
