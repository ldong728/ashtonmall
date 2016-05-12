<head>
    <?php include 'templates/header.php' ?>
    <link rel="stylesheet" href="stylesheet/sdp.css?v=<?php echo rand(1000,9999)?>"/>
    <meta content="YES" name="apple-touch-fullscreen">
    <meta content="yes" name="apple-mobile-web-app-capable">
</head>
<body>
    <div class="wrap">
        <div class="log-tel-box">
            <input type="text"class="inf-input"id="name"placeholder="请输入姓名">
        </div>
        <div class="log-tel-box">
            <input type="tel"class="inf-input"id="phone"placeholder="请输入手机号">
        </div><div class="log-tel-box">
            <input type="text"class="inf-input short"id="province"placeholder="请输入省名"<?php echo isset($_SESSION['userInf']['province'])?'value="'.$_SESSION['userInf']['province'].'"':''?>>
            <input type="text"class="inf-input short"id="city"placeholder="请输入城市"<?php echo isset($_SESSION['userInf']['city'])?'value="'.$_SESSION['userInf']['city'].'"':''?>>
        </div>



        <button class="create-sdp">成为微商</button>
    <div class="toast"></div>
    </div>

<script>
    $('.create-sdp').click(function(){
        var phone=$('#phone').val();
        var name=$('#name').val();
        var province=$('#province').val();
        var city=$('#city').val();
        if($.trim(name)!=''){
            $.post('ajax.php',{sdp:1,create_sdp:1,phone:phone,name:name,province:province,city:city},function(data){
                if(data=="ok"){
                    showToast('注册完成');
                    window.location.href ='index.php?rand=0';
                }else{
                    showToast("已注册或服务器错误");
                }

            })
        }else{
            showToast('请输入姓名');
        }

    });
</script>
</body>