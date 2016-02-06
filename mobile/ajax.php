<?php
/**
 * Created by PhpStorm.
 * User: godlee
 * Date: 2015/10/26
 * Time: 13:09
 */
include_once '../includePackage.php';;
session_start();

if(isset($_SESSION['customerId'])){
    if(isset($_POST['alterCart'])){
        pdoUpdate('cart_tbl',array('number'=>$_POST['number']),array('c_id'=>$_SESSION['customerId'],'id'=>$_POST['cart_id']));
        echo 'ok';
        exit;
    }
    if(isset($_POST['alterPartCart'])){
        pdoUpdate('part_cart_tbl',array('part_number'=>$_POST['number']),array('part_id'=>$_POST['g_id'],'cart_id'=>$_POST['cart_id']));
        echo 'ok';
        exit;
    }
    if(isset($_POST['deleteCart'])){
        pdoDelete('cart_tbl',array('c_id'=>$_SESSION['customerId'],'id'=>$_POST['cart_id']));
        pdoDelete('part_cart_tbl',array('cart_id'=>$_POST['cart_id']));
        echo 'ok';
        exit;
    }
    if(isset($_POST['altAddr'])){
        $addrquery=pdoQuery('address_tbl',null,array('id'=>$_POST['id']),' limit 1');
        $addr=$addrquery->fetch();
        echo json_encode($addr);
        exit;

    }
    if(isset($_POST['deleteAddr'])){
        pdoDelete('address_tbl',array('id'=>$_POST['id']));
        echo 'ok';
        exit;
    }
    if(isset($_POST['addrNumRequest'])){
        $query=pdoQuery('address_tbl',array('count(*) as num'),array('c_id'=>$_SESSION['customerId']),'');
        $num=$query->fetch();
        echo $num['num'];
    };
    if(isset($_POST['setDefaultAdress'])){
      pdoUpdate('address_tbl',array('dft_a'=>0),array('c_id'=>$_SESSION['customerId']));
        pdoUpdate('address_tbl',array('dft_a'=>1),array('id'=>$_POST['id']));
        echo 'ok';
        exit;
    };
    if(isset($_GET['getOrderList'])){
        $where=array('c_id'=>$_SESSION['customerId']);
        foreach ($_POST as $k=>$v) {
            if($v==1){
                $where[$k]=array(1,9);
            }else{
                $where[$k]=$v;
            }
        }

        $query=pdoQuery('order_tbl',null,$where,'');
        $list=array();
        foreach ($query as $row) {
            $list[]=array(
                'id'=>$row['id'],
                'stu'=>getOrderStu($row['stu'])
            );
        }
        echo json_encode($list);

    }
    if(isset($_POST['addToFav'])){
        pdoInsert('favorite_tbl',array('c_id'=>$_SESSION['customerId'],'g_id'=>$_POST['g_id']),'ignore');
        echo('ok');
        exit;
    }
    if(isset($_POST['deletFav'])){
        pdoDelete('favorite_tbl',array('g_id'=>$_POST['g_id'],'c_id'=>$_SESSION['customerId']));
        echo 'ok';
        exit;
    }
    if(isset($_POST['changePart'])){
        if($_POST['mode']=='true'){
            unset($_SESSION['buyNow']['partsList'][$_POST['part_id']]);
        }else{
            $_SESSION['buyNow']['partsList'][$_POST['part_id']]=$_POST['number'];
        }
        mylog(getArrayInf($_SESSION['buyNow']['partsList']));
        echo 'ok';
        exit;
    }
    if(isset($_POST['buyNow'])){
//        pdoQuery('g_inf_tbl',null,array('sc_id'=>'5','id'=>array('4','5')),null);
//        pdoQuery('g_inf_tbl',null,array('sc_id'=>5,'id'=>array(4,5)),null);
//        pdoQuery('g_inf_tbl',null,array('sc_id'=>'5','id'=>array(4,5)),null);
        exit;
    }
    if(isset($_POST['userRemark'])){
        $_SESSION['customer_remark']=html(trim($_POST['remark']));
        echo 'ok';
        exit;

    }
    if(isset($_POST['submitReview'])){
        $insert=array(
            'c_id'=>$_SESSION['customerId'],
            'order_id'=>$_POST['order_id'],
            'g_id'=>$_POST['g_id'],
            'd_id'=>$_POST['d_id'],
            'score'=>$_POST['score'],
        );
        if(isset($_POST['review'])&&$_POST['review']!=''){
            $insert['review']=html(trim($_POST['review']));
        }
        $id=pdoInsert('review_tbl',$insert,'ignore');
        $v1q=pdoQuery('review_tbl',array('count(*) as num'),array('order_id'=>$_POST['order_id']),null);
        $reviewed=$v1q->fetch();
        $v2q=pdoQuery('user_input_review_view',array('count(*) as num'),array('order_id'=>$_POST['order_id']),null);
        $unreview=$v2q->fetch();
        if($reviewed['num']==$unreview['num']){
            pdoUpdate('order_tbl',array('stu'=>'3'),array('id'=>$_POST['order_id']));
            echo'done';
            exit;
        }
        echo $id;
        exit;
    }
    if(isset($_POST['linkKf'])){
        include_once $GLOBALS['mypath'] . '/wechat/serveManager.php';
        $response=linkKf($_SESSION['customerId']);
        echo $response;
        exit;
    }

}

//未登录
if(isset($_POST['getdetailprice'])){
    $query=pdoQuery('user_detail_view',null,array('d_id'=>$_POST['d_id']),' limit 1');
    $row=$query->fetch();
//    $price=(null==$row['price']? -1:$row['price']);
    $inf=array(
      'price'=>$row['price'],
        'sale'=>$row['sale']
    );
    $data=json_encode($inf);
    echo $data;

}
if(isset($_POST['getProduceList'])){
    $query=pdoQuery('user_list_view',null,array('sc_id'=>$_POST['sc_id'],'situation'=>'1'),' group by g_id');
    $data=array();
    foreach ($query as $row) {
        $data[]=$row;
    }
    echo json_encode($data);
    exit;
}
if(isset($_POST['getGoodsInf'])){
    $query=pdoQuery('g_inf_tbl',array('inf'),array('id'=>$_POST['g_id']),' limit 1');
    $row=$query->fetch();
    echo $row['inf'];
    exit;
}
if(isset($_POST['addToCart'])){
    if(isset($_SESSION['customerId'])){
//            mylog(('insert'));
           $cartId= pdoInsert('cart_tbl',array('c_id'=>$_SESSION['customerId'],'g_id'=>$_POST['g_id'],'d_id'=>$_POST['d_id'],'number'=>$_POST['number']),
                'update');
            $value=array();
            foreach ($_SESSION['buyNow']['partsList'] as $k=>$v) {
                $value[]=array('cart_id'=>$cartId,'part_id'=>$k,'part_number'=>$_POST['number']);
            }
            pdoBatchInsert('part_cart_tbl',$value);

        if(isset($_SESSION['tempCart'])){

        }
        if(!isset($_SESSION['customerLogin'])){
            pdoInsert('custom_login_tbl',array('id'=>$_SESSION['customerId']),' ignore');
            $_SESSION['customerLogin']=true;
        }
    }else{
        $_SESSION['tempCart'][]=array('g_id'=>$_POST['g_id'],'d_id'=>$_POST['d_id'],'number'=>$_POST['number']);
    }
}

if(isset($_POST['adFilter'])){
    $adQuery=pdoQuery('(select * from user_ad_filt_view order by sale asc) p',null,array('mc_id'=>$_POST['mc_id']),' group by g_id limit 10');
    $inf=array();
    foreach ($adQuery as $row) {
        $inf[]=$row;
    }
    echo json_encode($inf);
    exit;
}