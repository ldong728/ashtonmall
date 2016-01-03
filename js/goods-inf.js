//$(document).ready(function () {

    $(document).on('click', '.selectBox', function () {
        d_id = $(this).attr('id').slice(3);
        $('.selectBox').removeClass('detail-selected');
        $(this).addClass('detail-selected')
        $.post('ajax.php', {getdetailprice: 1, d_id: d_id}, function (data) {
            var inf = eval('(' + data + ')');
            $('#price').empty();
            $('#sale').empty();
            if (inf.price == null) {
                realPrice = inf.sale;
            } else {
                realPrice = inf.price;
                $('#sale').append('¥' + inf.sale);
            }
            $('#price').append('¥' + realPrice);

        });

    });

    $(document).on('click', '.number-button', function () {
        var currentNum = parseInt($('#number').val());
        if ('plus' == $(this).attr('id')) {
            $('#number').val(currentNum + 1);
        } else {
            if (currentNum > 1) {
                $('#number').val(currentNum - 1);
            }
        }
        number = parseInt($('#number').val());
        if (1 == $('#fromCart').val()) {
            $.post('ajax.php', {alterCart: 1, d_id: d_id, number: number});
        }

    });
    $(document).on('change','#number',function(){
        number=$(this).val();
    });
    $(document).on('click', '.add-cart', function () {
        $.post('ajax.php', {addToCart: 1, g_id: g_id, d_id: d_id, number: number}, function (data) {
            //$('#add-cart-sucessful').fadeIn('fast')
            //var t = setTimeout('$("#add-cart-sucessful").fadeOut("slow")', 800);
            showToast('加入购物车成功');
        })

    });
    $(document).on('click','#fav',function(){
        $.post('ajax.php',{addToFav:1,g_id:g_id},function(data){
           showToast('收藏成功');
        });
    });
    $(document).on('click', '#getGoodsInf', function () {
        $('#goodsInf').empty();
        $.post('ajax.php',{getGoodsInf:1,g_id:g_id},function(data){
            $('#goodsInf').append(data)
        });
        $('#goodsInf').fadeToggle('slow');
    });
/**
 * 商品信息-参数栏切换
 */
    $(document).on('click','.nav',function(){
        //$('.nav').removeClass('nav-selected');
        //$(this).addClass('nav-selected');
        var index=$(this).attr('id').slice(3);
        detailSwiper.slideTo(index);

    })




//});