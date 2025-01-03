<!-- 最新文章區 -->
<style>
.detail {
    display: none;
}
</style>

<fieldset>
    <legend>目前位置：首頁 > 最新文章區 </legend>
    <!-- table>(tr>th*3)+(tr>td*3) -->
    <table style="width: 100%;">
        <tr>
            <th width="25%">標題</th>
            <th width="65%">內容</th>
            <th></th>
        </tr>
        <?php
        $total = $NEWS->count();
        $div = 5;
        // 分幾頁
        $pages = ceil($total/$div);
        // 現在的頁數 默認1
        $now = $_GET['p']??1;
        // 當頁第一筆的編號
        $start=($now-1)*$div;
        $rows = $NEWS->all(['sh'=>1]," LIMIT $start, $div");
        foreach ($rows as $row):
        ?>
        <tr>
            <td class="clo row-title"><?=$row['title'];?></td>
            <td>
                <span class='title'><?=mb_substr($row['news'],0,25);?>...</span>
                <span class='detail'><?=nl2br($row['news']);?></span>
            </td>
            <!-- 有登入就可以點讚 -->
            <td class="ct">
                <?php
            // 在下面做更改讚的判定
                if(isset($_SESSION['user'])){
                    // 要先確認好資料庫是否有點過讚
                    $chk = $LOG->count(['news'=>$row['id'],'user'=>$_SESSION['user']]);
                    $like = ($chk>0)?"收回讚":"讚";
                    echo "<a href='#' data-id='{$row['id']}' class='like'> $like </a>";
                }

            ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <div>
        <?php
            if(($now-1)>0){
                // <
                echo "<a href='?do=news&p=". ($now-1) ."'> &lt;</a>";
            }

            for($i=1;$i<=$pages;$i++){ 
                $size = ($i==$now)?"24px":"16px";
                echo "<a href='?do=news&p=$i' style='font-size: $size'>$i</a>";
            }

            if (($now+1)<=$pages){
                // >
                echo "<a href='?do=news&p=". ($now+1) ."'>&gt;</a>";
            }
            ?>
    </div>

</fieldset>

<script>
$(".like").on('click', function() {
    let id = $(this).data('id');
    let like = $(this).text();
    $.post("./api/like.php", {id}, ()=>{

        // 如果是讚
        switch (like) {
            case "讚":
                $(this).text("收回讚");
                break;
            case "收回讚":
                $(this).text("讚");
                break;
        }
        location.reload();
    })
})

$(".row-title").on("click",function(){
    $(this).next().children(".title,.detail").toggle();
})
</script>