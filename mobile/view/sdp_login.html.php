<head>
    <?php include 'templates/header.php' ?>
    <link rel="stylesheet" href="stylesheet/sdp.css?v=<?php echo rand(1000,9999)?>"/>
    <meta content="YES" name="apple-touch-fullscreen">
    <meta content="yes" name="apple-mobile-web-app-capable">
</head>
<body>
    <div class="wrap">
        <input type="tel"class="phone-input"id="phone"placeholder="请输入手机号">
        <button class="create-sdp">成为微商</button>

    </div>

<script>
    $('.create-sdp').click(function(){
        var phone=$('#phone').val()
        $.post('ajax.php',{sdp:1,create_sdp:1,phone:phone},function(data){
            alert(data);
        })
    });
</script>
</body>