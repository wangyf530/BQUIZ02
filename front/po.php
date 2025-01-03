<!-- 分類網誌 -->
<style>
.type,
.list-item {
    display: block;
    margin: 10px 0px;
}
</style>
<div style="margin-bottom:20px">
    目前位置：首頁 > 分類網誌 >
    <span id="type">健康新知</span>
</div>

<fieldset style="width:15%; display:inline-block;vertical-align:top;">
    <legend>分類網誌</legend>

    <a href="#" class="type" data-type='1'>健康新知 </a>
    <a href="#" class="type" data-type='2'>菸害防治</a>
    <a href="#" class="type" data-type='3'>癌症防治</a>
    <a href="#" class="type" data-type='4'>慢性病防治</a>
</fieldset>

<fieldset style="width:75%;display:inline-block;">
    <legend>文章列表</legend>
    <!-- 標題 -->
    <div id="postList"></div>
</fieldset>

<script>
getList(1)

$(".type").on('click', function() {
    // console.log($(this).text())
    $('#type').text($(this).text())

    let type = $(this).data('type')
    getList(type)

})
// 回呼要包含事件本身 ()的話要這麼寫
/*    $(".type").on('click',(e)=>{
        // console.log($(e.target).text())
        $('#type').text($(e.target).text())
    }) */

$(".list-item").on('click', function() {
    console.log('title', $(this).data('type'))
})

function getList(type) {
    /**
     * 1. 有參數時，等同使用 $.post
     * 2. 無參數時，等同使用 $.get
     */
    $("#postList").load("./api/get_list.php",{type})
    /*
    $.get("./api/get_list.php",{type},(list)=>{
        $("#postList").html(list)
    })
    */
}

function getPost(id){
    $("#postList").load("./api/get_post.php",{id})
}
</script>