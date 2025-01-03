<!-- 問卷區 -->
<fieldset>
    <legend>目前位置：首頁 > 問卷調查</legend>
    <!-- table>(tr>th*5)+(tr>td*5) -->
    <table style="width:90%">
        <tr>
            <th>編號</th>
            <th width="60%">問卷題目</th>
            <th>投票總數</th>
            <th>結果</th>
            <th>狀態</th>
        </tr>

        <?php
            $rows = $QUE->all(['main_id'=>0]);
            foreach($rows as $key => $row):
        ?>
        <tr>
            <!-- 編號 -->
            <td  class="ct"><?=$key+1;?>.</td>
            <!-- 問卷題目 -->
            <td><?=$row['text'];?></td>
            <!-- 投票總數 -->
            <td class="ct"><?=$row['vote'];?></td>
            <!-- 結果 -->
            <td class="ct">
                <a href="?do=result&id=<?=$row['id'];?>">結果</a>
            </td>
            <!-- 狀態 -->
            <td class="ct">
                <?php
                    if(!isset($_SESSION['user'])){
                        echo "請先登入";
                    } else {
                        echo "<a href='?do=vote&id={$row['id']}'>參與投票</a>";
                    }
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</fieldset>