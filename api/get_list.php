<!-- 拿新聞標題 -->
<?php include_once "db.php";

$type = $_POST['type'];
$rows = $NEWS->all(['type'=>$type]);

foreach ($rows as $row) {
    echo "<a href='javascript:getPost({$row['id']})' class='list-item'>{$row['title']}</a>";
    // echo "<br>";
}