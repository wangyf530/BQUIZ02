<!-- 拿新聞標題 -->
<?php include_once "db.php";

$id = $_POST['id'];
$row = $NEWS->find($id);
echo "<h3>{$row['title']}</h3>";
// new line to break line
echo nl2br($row['news']);