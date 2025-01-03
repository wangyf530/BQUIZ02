<!-- 人氣文章 -->
<style>
.detail {
    background: rgba(51, 51, 51, 0.8);
    color: #FFF;
    height: 300px;
    width: 400px;
    position: absolute;
    display: none;
    left: 10px;
    top: 10px;
    z-index: 9999;
    overflow: auto;
    
}
</style>

<!-- 把news.php 最新文章全部複製，改變部分文字及代碼 -->
<?php include_once "./api/db.php"; ?>
<fieldset>
    <legend>目前位置：首頁 > 人氣文章區 </legend>
    <!-- table>(tr>th*3)+(tr>td*3) -->
    <table style="width:100%">
        <tr>
            <th width="20%">標題</th>
            <th width="60%">內容</th>
            <!-- 增加文字 -->
            <th> 人氣</th>
        </tr>
        <?php
        $total = $NEWS->count();
        $div = 5;
        $pages = ceil($total/$div);
        $now = $_GET['p']??1;
        $start=($now-1)*$div;
        // 增加sql語法 order by 從讚數最多的開始排列
        $rows = $NEWS->all(['sh'=>1]," ORDER BY `likes` DESC LIMIT $start, $div");
        foreach ($rows as $row):
        ?>
        <tr>
            <td class="clo row-title"><?=$row['title'];?></td>
            <td style="position:relative;" class="row-content">
                <span class="title"><?=mb_substr($row['news'],0,25);?>...</span>
                <span class="detail">
                    <h2 style="color:skyblue"> <?=$NEWS::$type[$row['type']];?></h2>
                    <?=nl2br($row['news']);?>
                </span>
            </td>
            <!-- 從資料庫撈有多少人點讚 更改相關文字-->
            <td>
                <?=$row['likes'];?>個人說
                <img src="./icon/02B03.jpg" style="width:25px;">
                <?php 
                if(isset($_SESSION['user'])){
                    $chk=$LOG->count(['news'=>$row['id'],'user'=>$_SESSION['user']]);
                    $like=($chk>0)?"收回讚":"讚";
                    echo "<a href='#' data-id='{$row['id']}' class='like'>$like</a>";
                }

                ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div class="ct">
        <?php
        // do 要改成pop 要不然會跑到 news.php 的最新消息區
            if(($now-1)>0){
                // <
                echo "<a href='?do=pop&p=". ($now-1) ."'>&lt;</a>";
            }

            for ($i=1; $i <= $pages; $i++) { 
                $size = ($i==$now)?"24px":"16px";
                echo "<a href='?do=pop&p=$i' style='font-size: $size'>$i</a>";
            }

            if (($now+1)<=$pages){
                // >
                echo "<a href='?do=pop&p=". ($now+1) ."'>&gt;</a>";
            }
            ?>
    </div>

</fieldset>

<script>
$(".like").on("click", function(){
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

$(".row-title").hover(
    function() {
        $(this).next().children(".detail").show();
    },
    function() {
        $(this).next().children(".detail").hide();

    }
)


$(".row-content").hover (
    function() {
        $(this).children(".detail").show();
    },
    function() {
        $(this).children(".detail").hide();

    }
)
</script>