if (g_id != -1) {
    $("#sc_id").val(sc_id);
    $("#made_in").val(mi);
    $.post('ajax_request.php', {newGoods: g_id}, function (data) {
        var inf = eval('(' + data + ')');
        $('#g_name').append('<option value = "' + inf.id + '">' + inf.name + '</option>');
    });
    getGInf();
}
$("#g_name").change(function () {
    g_id = $("#g_name option:selected").val();
    getGInf();
});
$("#sc_id").change(function () {
    //alert('change');
    $("#g_name").load("ajax_request.php", {
        categoryCheck: $("#sc_id option:selected").val(),
        country_id: $(".country option:selected").val()
    }, $("#g_name").empty())
});
$('#changeSc').change(function(){
    $.post('ajax_request.php',{alterCategory: $("#changeSc option:selected").val(),g_id:g_id},function(data){

    });
});
$(document).on('change', '.category', function () {
    $.post('ajax_request.php', {changeCategory: 1, d_id: $(this).attr('id'), value: $(this).val()});

})
$(document).on('change', '.sale', function () {
    $.post('ajax_request.php', {changeSale: 1, d_id: $(this).attr("id"), value: $(this).val()});
});
$(document).on('change', '.wholesale', function () {
    $.post('ajax_request.php', {changeWholesale: 1, d_id: $(this).attr("id"), value: $(this).val()});
});
$(document).on('click', '#add_category', function () {
    $.post('ajax_request.php', {addNewCategory: 1, g_id: g_id}, function (data) {
        $('#goods_detail').append(data);
    });
});
$(document).on('click', '.is_cover', function () {
    $.post('ajax_request.php', {set_cover_id: $(this).val(), g_id: g_id});
});
$(document).on('click','.img-upload',function(){
    $('#g-img-up').click();
});
$(document).on('change','#g-img-up',function(){
    $.ajaxFileUpload({
        url:'upload.php?g_id='+g_id,
        secureuri: false,
        fileElementId: $(this).attr('id'), //文件上传域的ID
        dataType: 'json', //返回值类型 一般设置为json
        success: function (v, status){
            var isCheck = (1 == v.front_cover ? 'checked = true' : '');
            var content = '<div class="demo-box"><input type="radio" name="is_cover"class="is_cover"value="' + v.id + '"' + isCheck + '/>'
                + '<a href="delete.php?delimg=' + v.urlInDb + '&g_id=' + g_id + '"><img class="demo" src= "' + v.url + '" alt = "error" /></a></div>';

            $('.img-upload').before(content);

        }  //服务器成功响应处理函数
    });
});
/**
 * 获取货品信息
 */

function getGInf() {
    $('#g_id_img').val(g_id);
    $('#hidden_g_id').val(g_id);
    $('#goods_detail').empty();
    $('#goods_image').empty();
    $('#intro').empty();
    $('#changeSituation').empty();
    $('.parm-set').empty();
    $('#changeCategory').css('display','none');

    $.post("ajax_request.php", {g_id: g_id}, function (data) {
        var inf = eval('(' + data + ')');
        if(0==inf.goodsInf.situation){
            var stub='<a href="consle.php?goodsSituation=1&g_id='+g_id+'">上架</a>'
        }else{
            var stub='<a href="consle.php?goodsSituation=0&g_id='+g_id+'">下架</a>'
        }
        $('#intro').append(inf.goodsInf.intro);
        $('#changeSituation').append(stub);
        $('#name').val(inf.goodsInf.name);
        if(null!=inf.goodsInf.inf) {
            um.setContent(inf.goodsInf.inf);
        }else{
            um.setContent('');
        }

        if(null!=inf.detail) {
            $.each(inf.detail, function (k, v) {
                var content = '<p>规格：<input type="text" class="category" id="' + v.id + '"value="' + v.category + '"/>' +
                    '售价：<input type="text" class="sale" id="' + v.id + '"value="' + v.sale + '"/>' +
                    '批发价：<input type="text" class="wholesale" id="' + v.id + '"value="' + v.wholesale + '"/>' +
                    '<a href="consle.php?del_detail_id=' + v.id + '&g_id=' + g_id + '">删除此规格</a>' +
                    '</p>';
                $('#goods_detail').append(content);
            });
        }
        if (null != inf.img) {
            $.each(inf.img, function (k, v) {
                var isCheck = (1 == v.front_cover ? 'checked = true' : '');
                var content = '<div class="demo-box"><input type="radio" name="is_cover"class="is_cover"value="' + v.id + '"' + isCheck + '/>设为主图'
                    + '<a href="delete.php?delimg=' + v.url + '&g_id=' + g_id + '"><img class="demo" src= "../' + v.url + '" alt = "error" /></a></div>'

                $('#goods_image').append(content);
            });

        }
        $('#goods_image').append('<a class="img-upload"></a><input type="file"id="g-img-up"name="g-img-up"style="display: none">');
        var precon='<form id="updateParm"action="consle.php?updateParm=1&g_id='+g_id+'"method="post">';
        $.each(inf.parm,function(k,v){
            var cateName=k;
            var con='<table class="parmInput"><tr>'+cateName+'</tr>'
            $.each(v,function(subk,subv){
                var scon='<tr><td>'+subv.name+'</td><td><input type="text" name="'+subv.col+'"value="'+subv.value+'"/></td></tr>'
                con+=scon;
            });
            con+='</table>'
            precon+=con
            //$('.parm-set').append(con);
        });
        $('.parm-set').append(precon+'<input type="submit"value="修改参数"/></form>');


        $('#g_inf').slideDown('fast');
        $('#changeCategory').css('display','block');
    });
}