<head>
    <?php include 'templates/header.php' ?>
    <link rel="stylesheet" href="stylesheet/sdp.css?v=<?php echo rand(1000, 9999) ?>"/>
    <meta content="YES" name="apple-touch-fullscreen">
    <meta content="yes" name="apple-mobile-web-app-capable">
</head>
<body>
<div class="wrap">
    <?php foreach ($list as $row): ?>
        <div class="list-content">
            <div class="list-block">
                <img class="list-img" src="../<?php echo $row['url']?>"/>
                <div class="price-box">
                    <div class="discount-box">
                        <p>进货价</p><p>￥<?php echo number_format($row['wholesale'],2,'.','')?></p>
                    </div>
                    <div class="setting-box">
                        <div class="min">
                            最低￥<span id="min<?php echo $row['g_id']?>"><?php echo number_format($row['min_sell'],2,'.','')?></span>
                        </div>

                        <div class="min">
                            最高￥<span id="max<?php echo $row['g_id']?>"><?php echo number_format($row['max_sell'],2,'.','')?></span>
                        </div>

                    </div>
                    <input type="tel" class="priceinput"id="<?php echo $row['g_id']?>"value="<?php echo isset($row['price'])?number_format($row['price'],2,'.',''):number_format($row['sale'],2,'.','')?>"/>
                </div>
                <div class="title-box"style="clear: left">
                    <div class="list-main-title">
                        <?php echo $row['made_in']?>
                    </div>
                    <div class="list-sub-title"id="pid<?php echo $row['g_id']?>">
                        <?php echo $row['produce_id']?>
                    </div>
                </div>
<!--                <a class="inner-button gsbutton" href="controller.php?sdp=1&gainshare=1&g_id=--><?php //echo $row['g_id']?><!--&p_id=--><?php //echo $row['produce_id']?><!--">-->
<!--                    佣金设置-->
<!--                </a>-->
                <a class="inner-button gsbutton"id="getgs<?php echo $row['g_id']?>" >
                    佣金设置
                </a>
            </div>

        </div>
    <?php endforeach ?>
    <div class="hidden-layer">
        <div class="hidden-container">
                <div class="category-name">
                    佣金设置
                </div>
                <div class="h-slash">
                </div>
            <div class="dyn-content">
                    <div class="gslist-block"id="block">
                        <div class="gs-rank">
                            等级<?php echo $k+1 ?>
                        </div>
                        <div class="gs-input-box">
                            佣金：<input class="number gs-value"id="gs" value=""/>元
                        </div>
                    </div>
            </div>

                <div class="gslist-block">
                    <input type="hidden"class="g_id"value=""/>
                    <button class="button altGainshare">更改设置</button>
                </div>
            <div class="gslist-block">
                <button class="button close"style="background-color: #f13031">关闭</button>
            </div>
                <div class="toast"?></div>

        </div>

    </div>

    <div class="toast"></div>

</div>

<script>
    $('.gsbutton').click(function(){
        var g_id=$(this).attr('id').slice(5);
        var name=$('#pid'+g_id).text();
        $.post('ajax.php',{sdp:1,getGainshare:1,g_id:g_id},function(data){
            var gslist=eval('('+data+')');
            $('.category-name').text(name+'佣金设置');
            $('.g_id').val(g_id);
            $('.dyn-content').empty();
            $.each(gslist,function(id,v){
                var content='<div class="gslist-block"id="block'+id+'">'+
                    '<div class="gs-rank">'+
                '等级'+(id+1)+
                '</div>'+
                '<div class="gs-input-box">'+
                '佣金：<input class="number gs-value"id="gs'+id+'" value="'+ v.value+'"/>元'+
                '</div></div>'
                $('.dyn-content').append(content);
            });
            $('.hidden-layer').fadeToggle('fast');
        });

    });
    $('.close').click(function(){
        $('.dyn-content').empty();
        $('.g_id').val('');
        $('.hidden-layer').fadeOut('fast');
    })
    $('.altGainshare').click(function(){
        var values=new Array();
        $('.gs-value').each(function(){
            var rank=$(this).attr('id').slice(2);
            var value=$(this).val();
            values.push({rank:rank,value:value});
        })
        $.post('ajax.php',{sdp:1,altGainshare:1,data:values,g_id:$('.g_id').val()},function(data){
            if(data='ok'){
                showToast('更改成功');
            }
        })
    });
    $('.priceinput').change(function(){
       var g_id=$(this).attr('id');
        var price=parseFloat($(this).val());
        var min=parseFloat($('#min'+g_id).text());
        var max=parseFloat($('#max'+g_id).text());
        if(price>max||price<min){
            alert('超出限定价格！')
        }else{
            $.post('ajax.php',{sdp:1,alterSdpPrice:1,g_id:g_id,price:price},function(data){
               if(data=='ok'){
                   showToast('价格修改成功');
               } else{
                   alert('超出限定价格！');
               }
            });
        }


    });

</script>
</body>