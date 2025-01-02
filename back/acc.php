<?php include_once "./api/db.php" ?>
<style>
    .ct tr:nth-child(1){
        background:#ccc;
    }
</style>
<fieldset style="width:75%; margin:auto">
    <legend>帳號管理</legend>
    <table class="ct" style="width:75%; margin:auto">
        <tr>
            <td>帳號</td>
            <td>密碼</td>
            <td>刪除</td>
        </tr>
        <?php
        $rows = $USER->all();
        foreach ($rows as $row):
        ?>
        <tr>
            <td>
                <?=$row['acc'];?>
            </td>
            <td>
                <!-- <?=$row['pw'];?> -->
                 <?= str_repeat("*",strlen($row['pw']));?>
            </td>
            <td>
                <input type="checkbox" name="del[]" value="<?=$row['id'];?>">
            </td>
        </tr>
        <?php endforeach;?>
    </table>
    <div class="ct">
        <button onclick="del()">確定刪除</button>
        <button onclick="resetChk()">清空選取</button>
    </div>


    <h2>新增會員</h2>
    <div style="color:red;">
        * 請設定您要註冊的帳號及密碼（最長12個字元）
    </div>
    <table>
        <tr>
            <td class="text-grey">Step1:登入帳號</td>
            <td><input type="text" name="acc" id="acc"></td>
        </tr>
        <tr>
            <td class="text-grey">Step2:登入密碼</td>
            <td><input type="password" name="pw" id="pw"></td>
        </tr>
        <tr>
            <td class="text-grey">Step3:再次確認密碼</td>
            <td><input type="password" name="pw" id="pw2"></td>
        </tr>
        <tr>
            <td class="text-grey">Step4:信箱(忘記密碼時使用)</td>
            <td><input type="text" name="email" id="email"></td>
        </tr>
        <tr>
            <td>
                <input type="button" value="新增" onclick='reg()'>
                <input type="button" value="清除" onclick='resetForm()'>
            </td>
        </tr>
    </table>

</fieldset>
<script>
    function del(){
        let dels = $("input[name='del[]']:checked");
        let ids = new Array();
        dels.each((idx,item)=>{
            ids.push($(item).val())
        })
        // console.log(ids)

        $.post('./api/del_user.php',{ids},()=>{
            location.reload()
        })
    }


function reg() {
    let user = {
        acc: $("#acc").val(),
        pw: $("#pw").val(),
        pw2: $("#pw2").val(),
        email: $("#email").val()
    }

    // console.log(user);

    if (user.acc == "" || user.pw == "" || user.pw2 == "" || user.email == "") {
        alert("不可空白");
        // 分號可以不要
    } else if (user.pw != user.pw2) {
        alert("兩次密碼不一致");
    } else {
        // 檢查是否已有帳號
        $.get("./api/chk_acc.php", {acc: user.acc}, (res) => {
            console.log("chk_acc => ",res);
            // 1:資料庫已有該帳號 0:資料庫未有該帳號,可註冊
            if (parseInt(res) > 0) {
                alert("account already exists!")
            } else {
                $.post("./api/reg.php", user, (res) =>  {
                    location.reload();
                    resetForm();
                })
            }
        })
    }
    resetForm()
}


function resetForm(){

    $("#acc").val(""),
    $("#pw").val(""),
    $("#pw2").val(""),
    $("#email").val("")
}

function resetChk(){
    $("input[type='checkbox']:checked").prop('checked',false)
}
</script>