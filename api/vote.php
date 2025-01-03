<?php
include_once "db.php";

$opt_id = $_POST['opt'];
$option = $QUE->find($opt_id);
$subject = $QUE->find($option['main_id']);
// 選項投票數+1
$option['vote']++;
// 題目投票數量也要+1
$subject['vote']++;
$QUE->save($option);
$QUE->save($subject);

to("../index.php?do=result&id={$option['main_id']}");