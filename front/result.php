<!-- 結果 -->
<?php
 $subject = $QUE->find($_GET['id']);
 $options = $QUE->all(['main_id'=>$_GET['id']]);
 ?>

<style>
    .result{
        display:flex;
        width: 100%;
        align-items:center;
    }

    .result p{
        width: 30%;
    }

    .result div:nth-child(1){
        width: 50%;
    }
    .result div:nth-child(2){
        width: 15%;
    }
</style>

<fieldset>
    <legend>目前位置：首頁 > 問卷調查 > <?=$subject['text'];?></legend>
    
    <h3> <?=$subject['text'];?> </h3>

    <?php
    foreach ($options as $option) {
        if($subject['vote']==0){
            $rate =0;
        } else {
            $rate = $option['vote'] / $subject['vote'];
        }
        $rateStr = round($rate*100,2);
        $rateNum = $rate*45;
        echo "<div class='result'>";
        echo "<p style='width:30%;'> {$option['text']} </p>";
        echo "<div style='height:20px; width:{$rateNum}%; background-color:#999;'> &nbsp </div>";
        echo "<div> {$option['vote']}票($rateStr %) </div>";
        echo "</div>";
    }
    ?>
    <div class="ct">
        <button onclick="location.href='?do=que'">返回</button>
    </div>

</fieldset>