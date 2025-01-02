<?php 
include_once "db.php";

$chk = $USER->count($_POST);
if ($chk) {
    echo $chk;
    $_SESSION['user'] = $_POST['acc'];
} else {
    echo 0;
}

?>