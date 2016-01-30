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
    if ('plus' == $(this).attr('id')) {
        var input = $(this).prev('input');
        var currentNum = parseInt(input.val());
        input.val(currentNum + 1)
    } else if ('minus' == $(this).attr('id')) {
        var input = $(this).next('input');
        var currentNum = parseInt(input.val());
        if (currentNum > 1) {
            input.val(currentNum - 1)
        }
    }
    number = parseInt($('#number').val());
    if (1 == $('#fromCart').val()) {
        $.post('ajax.php', {alterCart: 1, d_id: d_id, number: number});
    }
    //alert(number);
});
$(document).on('change', '#number', function () {
    number = $(this).val();
});

//立刻购买按钮
$(document).on('click', '.buy-now', function () {
    window.location.href = 'controller.php?settleAccounts=1&from=buy_now&d_id=' + d_id + '&number=' + number + '&rand=' + antCacheRand();
})
$(document).on('click', '.add-cart', function () {
    $.post('ajax.php', {addToCart: 1, g_id: g_id, d_id: d_id, number: number}, function (data) {
        showToast('加入购物车成功');
    })

});
//配件立刻购买按钮
$(document).on('click', '.part-buy-now', function () {
    window.location.href = 'controller.php?settleAccounts=1&from=buy_now&d_id=' + d_id + '&number=0&rand=' + antCacheRand();
})
//配件加入购物车
$(document).on('click', '.part-add-cart', function () {
    $.post('ajax.php', {addToCart: 1, g_id: g_id, d_id: d_id, number: 0}, function (data) {
        showToast('加入购物车成功');
    })

});
$(document).on('click', '#fav', function () {
    $.post('ajax.php', {addToFav: 1, g_id: g_id}, function (data) {
        showToast('收藏成功');
    });
});
$(document).on('click', '#getGoodsInf', function () {
    $('#goodsInf').empty();
    $.post('ajax.php', {getGoodsInf: 1, g_id: g_id}, function (data) {
        $('#goodsInf').append(data)
    });
    $('#goodsInf').fadeToggle('slow');
});

//配件栏
$(document).on('click', '.check-box', function () {
    var id = $(this).attr('id').slice(4);
    var selected = $(this).hasClass('checked')
    if (selected) {
        $(this).removeClass('checked');
        $('#num' + id).val(0)
    } else {
        $(this).addClass('checked');
        $('#num' + id).val(1)
    }
    $.post('ajax.php', {changePart: 1, g_id: g_id, part_id: id, mode: selected, number: 1}, function (data) {

    });
});
$(document).on('click', '.partCountButton', function () {

    var temp = $(this).siblings('input')
    var id = temp.attr('id').slice(3);
    var number = temp.val();
    $('#part' + id).addClass('checked');
    $.post('ajax.php', {changePart: 1, g_id: g_id, part_id: id, mode: false, number: number}, function (data) {

    });

})
$(document).on('change', '.partCountInput', function () {
    alert($(this).val());
});
$(document).on('click', '.more-review', function () {
    alert('ok');
    window.location.href='controller.php?getMoreReview=1&g_id='+g_id;
});
/**
 * 商品信息-参数栏切换
 */
$(document).on('click', '.nav', function () {
    var index = $(this).attr('id').slice(3);
    detailSwiper.slideTo(index);

})


//});