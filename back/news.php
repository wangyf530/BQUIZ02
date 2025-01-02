<!-- <?php include_once "./api/db.php";?> -->


<fieldset style="width:85%; margin:auto">
    <legend>最新文章管理</legend>
    <!-- table.ct>(tr>th*4)+(tr>td)*4 -->
    <table class="ct" style="width:100%;height:200px">
        <tr style="height:40px">
            <th>編號</th>
            <th style="width:50%">標題</th>
            <th>顯示</th>
            <th>刪除</th>
        </tr>
        <?php
        $total = $NEWS->count();
        $div = 3;
        // 分幾頁
        $pages = ceil($total/$div);
        // 現在的頁數 默認1
        $now = $_GET['p']??1;
        // 當頁第一筆的編號
        $start=($now-1)*$div;

        $rows = $NEWS->all(" LIMIT $start, $div");
        foreach ($rows as $idx=>$row):
        ?>
        <tr>
            <!-- 編號 -->
            <td>
                <?=$start+$idx+1;?>.
            </td>
            <!-- 標題 -->
            <td><?=$row['title'];?></td>
            <!-- 顯示 -->
            <td>
                <input type="checkbox" name="sh[]" value="<?=$row['id'];?>" <?=($row['sh']==1)?"checked":"";?>>
            </td>
            <!-- 刪除 -->
            <td>
                <input type="checkbox" name="del[]" value="<?=$row['id'];?>">
            </td>
        </tr>
        <input type="hidden" name="id[]" value="<?=$row['id'];?>">
        <?php endforeach; ?>
    </table>
    <div class="ct">
        <?php
            if(($now-1)>0){
                // <
                echo "<a href='?do=news&p=". ($now-1) ."'>&lt;</a>";
            }

            for ($i=1; $i <= $pages; $i++) { 
                $size = ($i==$now)?"24px":"16px";
                echo "<a href='?do=news&p=$i' style='font-size: $size'>$i</a>";
            }

            if (($now+1)<=$pages){
                // >
                echo "<a href='?do=news&p=". ($now+1) ."'>&gt;</a>";
            }
            ?>


        <button onclick="edit()">確定修改</button>
    </div>
</fieldset>

<script>
function edit() {
    let ids = $("input[name='id[]']")
        .map((idx, item) => {
            return $(item).val()
        }).get();
    console.log(ids);

    // 大擴號只有一return的話可以簡寫
    /* let ids = $("input[name='id[]']")
        .map((idx, item) => $(item).val()).get();
    console.log(ids);
    */
    let sh = $("input[name='sh[]']:checked")
        .map((idx, item) => {
            return $(item).val()
        }).get();
    console.log('sh',sh);

    let del = $("input[name='del[]']:checked")
        .map((idx, item) => {
            return $(item).val()
        }).get();
    console.log('del',del);

    $.post("./api/edit_news.php",{ids,sh,del},(res)=>{
        // console.log(res);
        location.reload();
    })
}
</script>