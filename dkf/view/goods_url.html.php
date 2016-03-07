<!DOCTYPE html>
<html lang="n">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <title>插件页</title>
    <script type="text/javascript" src="../js/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="stylesheet/style.css">
</head>

<body>
<div class="wrap">
<?php foreach($urls as $row):?>
    <div class="url-block">
        <div class="inf-block"id="but<?php echo $row['g_id']?>">
            <img src="<?php echo '../'.$row['img']?>"/>
            <p class="theUrl"id="url<?php echo $row['g_id']?>"><?php echo $row['produce_id']?></p>
        </div>
        <div class="url-content">
            <?php echo $row['url']?>
        </div>

    </div>


<?php endforeach;?>
</div>
<script>
//    $('.inf-block').click(function(){
//       var id=$(this).attr('id').slice(3);
//        window.external.PutMsg(
//    {
//            "msg":
//            {
//                "head": {"random": "123456"}
//                "body"： [{"type":0, "content":{"text":"你好客服001为您服务"}}]
//            }
//        }
//        )
//    });

</script>


</body>
</html>
