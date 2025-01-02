<?php  include_once "db.php";

if(isset($_POST['ids'])){
    foreach ($_POST['ids'] as $id) {
        // 如果有刪除
        if(isset($_POST['del']) && in_array($id, $_POST['del'])){
            $NEWS->del($id);
        } else {
            $row = $NEWS->find($id);
            $row['sh']=(isset($_POST['sh']) && in_array($id, $_POST['sh']))?1:0;
            $NEWS->save($row);
        }
    }
}