<!-- 投票 -->
 <?php
 $subject = $QUE->find($_GET['id']);
 $options = $QUE->all(['main_id'=>$_GET['id']]);
 ?>
<fieldset>
    <legend>目前位置：首頁 > 問卷調查 > <?=$subject['text'];?></legend>
    
    <h3> <?=$subject['text'];?> </h3>

    <form action="./api/vote.php" method="post">
    <?php
    foreach ($options as $option) {
        echo "<p>";
        echo "<input type='radio' name='opt' id='{$option['id']}' value='{$option['id']}'>";
        echo "<label for='{$option['id']}'> {$option['text']}</label>";
        echo "</p>";
    }
    ?>
    <div class="ct">
        <button type="submit">我要投票</button>
    </div>
    </form>
</fieldset>