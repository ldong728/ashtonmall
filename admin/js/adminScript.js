$('input').attr('onkeypress',"if(event.keyCode == 13) return false;");//屏蔽回车键
function showToast(str){
    $('.toast').empty();
    $('.toast').append(str)
    $('.toast').fadeIn('fast')
    var t = setTimeout('$(".toast").fadeOut("slow")', 800);
}