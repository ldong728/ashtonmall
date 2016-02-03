<head>
    <?php include 'templates/header.php' ?>
</head>

<body>
<div class="wrap">
    <div class="category-name">
        <?php echo $cateName['sub_name']?>
    </div>
    <div class="h-slash"> </div>
    <div class="goods-list-container">
        <?php foreach($list as $row):?>
        <div class="goods-list-box">
            <img src="../<?php echo $row['url']?>"/>
            <div class="name">
                <?php echo $row['name']?>
            </div>
            <div class="intro">
                <?php echo $row['intro']?>
            </div>
            <a class="buy">

            </a>
        </div>
        <?php endforeach?>

    </div>
    <div class="parts-list-container">

    </div>

<?php include_once 'templates/foot.php'?>


</div>



<script>
    var id=<?php echo $_GET['fc_id']?>;
    var defaultv=<?php echo $default['id']?>;
    $('#main'+id).addClass('selected');
    $(document).on('click', '.cate-ul', function () {

        var id = $(this).attr('id');
        getProduceList(id);
    })
</script>
<script>
    getProduceList(defaultv);


    function getProduceList(sc_id){
        var cateName='';

        $('.main-right').fadeOut('fast',function(){
            $('.main-right').empty();
            $.post('ajax.php',{getProduceList:1,sc_id:sc_id},function(data){
                var value=eval('('+data+')');
                $.each(value,function(k,v){
                    cateName= v.sc_name;
                    var price= v.price? v.price: v.sale;
                    var content='<div class="produce-intro">'+
                        '<div class="produce-img"><img src="../'+ v.url+'"/></div>'+
                        '<div class="produce-inf name"><h3>'+ v.name+'</h3></div>'+
                        '<div class="produce-inf discrib"><p>'+ v.intro+'</p></div>'+
                        '<div class="produce-inf price"><h3>RMB '+price+'</h3></div>'+
                        '<a href="controller.php?goodsdetail=1&g_id='+ v.g_id+'" class="produce-inf buy-button"></a>' +
                        '</div>'+
                        '<div class="h-border"></div>';
                    $('.main-right').append(content);

                });
                $('.main-right').fadeIn('slow');
                $('.cate-name').text(cateName);
            });
        });

    }
</script>
</body>

