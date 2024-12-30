<!-- 主頁頁籤 -->
<style>
.types{
    display:flex;
    flex-direction:row;
    /* justify-content:center; */
    margin-left:1px;
    /* margin-left:5px; */
}


.type {
    border: 1px solid #999;
    padding: 5px 10px;
    /* margin:0 1px; */
    margin-left:-1px;
}

.type:hover{
    cursor:pointer;
}

.texts{

}

.text{
    width: 95%;
    min-height:470px;
    border:1px solid #999;
    display:none;
}

.active{
    display:block;
}

</style>
<div class="types">
    <div class="type">健康新知</div>
    <div class="type">菸害防治</div>
    <div class="type">癌症防治</div>
    <div class="type">慢性病防治</div>
</div>
<div class="texts">
    <div class="text active">1</div>
    <div class="text">2</div>
    <div class="text">3</div>
    <div class="text">4</div>
</div>

<script>
    $(".type").on("click",function(){
        let idx = $(this).index();
        $(".text").removeClass('active');
        $('.text').eq(idx).addClass('active');
    })
</script>
