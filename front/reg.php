<style>
.text-grey {
    background: #eee;
}
</style>

<fieldset style="width:50%; margin:auto">
    <legend>會員註冊</legend>
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
                <input type="button" value="註冊" onclick='reg()'>
                <input type="button" value="清除" onclick='resetForm()'>
            </td>
        </tr>
    </table>
</fieldset>

<script>
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
                    console.log("reg => ",res);
                    if (parseInt(res) == 1) {
                        alert("Register succeeded!")
                    }
                })
            }
        })
    }
}


function resetForm(){

    $("#acc").val(""),
    $("#pw").val(""),
    $("#pw2").val(""),
    $("#email").val("")
}
</script>