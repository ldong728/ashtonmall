<?php
/**
 * Created by PhpStorm.
 * User: godlee
 * Date: 2015/10/28
 * Time: 15:14
 */
include_once '../includePackage.php';
session_start();

if(isset($_SESSION['customerId'])){
    if(isset($_GET['settleAccounts'])){
        $arr=getCartDetail($_SESSION['customerId']);
        $totalPrice=$arr['totalPrice'];
        $totalSave=$arr['totalSave'];
        $goodsList=$arr['goodsList'];
        if(0==count($goodsList)){
            header('location:index.php');
        }
        if(isset($_GET['addressId'])){
            $addrQuery=pdoQuery('address_tbl',null,array('id'=>$_GET['addressId']),' limit 1');
        }else{
            $addrQuery=pdoQuery('address_tbl',null,array('c_id'=>$_SESSION['customerId'],'dft_a'=>1),' limit 1');
        }

        if($addrrow=$addrQuery->fetch()){
           $addr=$addrrow;
        }else{
            $addrrow=array('id'=>-1,'name'=>'','phone'=>'','address'=>'点击设置收货地址','province'=>' ',
            'city'=>' ','area'=>' ');
            $addr=$addrrow;
;        }
        include 'view/order.html.php';
        exit;
    }
    if(isset($_GET['alterAddress'])){
        $pro=getProvince($_POST['pro']);
        $city=getCity($_POST['pro'],$_POST['city']);
        $area=getArea($_POST['pro'],$_POST['city'],$_POST['area']);
        $value=array('pro_id'=>$_POST['pro'],'city_id'=>$_POST['city'],'area_id'=>$_POST['area'],
            'area'=>$_POST['area'],'province'=>$pro,'city'=>$city,'area'=>$area,'address'=>$_POST['address'],'name'=>$_POST['name'],
            'phone'=>$_POST['phone']);
        if(-1==$_POST['address_id']){
            $value['c_id']=$_SESSION['customerId'];
            $value['dft_a']=0;
            $addrId=pdoInsert('address_tbl',$value);
        }else{
            pdoUpdate('address_tbl',$value,
                array('id'=>$_POST['address_id']));
        }
        header('location:controller.php?editAddress=1');
    }
    if(isset($_GET['editAddress'])){
//        mylog('editAddress');
        $addrQuery=pdoQuery('address_tbl',null,array('c_id'=>$_SESSION['customerId']),' limit 5');
        $addrlist=array();
        foreach ($addrQuery as $row) {
            $addrlist[]=$row;
        }
//        mylog('editAddress2');
//        echo 'what\'s up man';
        include 'view/address.html.php';
        exit;
    }
    if(isset($_GET['orderConfirm'])){
//        include 'view/order_inf.html.php';
//        exit;
        if(-1!=$_GET['addrId']) {
            $orderId = 'dy' . time() . rand(100, 999);  //订单号生成，低并发情况下适用
            $arr = getCartDetail($_SESSION['customerId']);
            $total_fee=0;
            foreach ($arr['goodsList'] as $row) {
                $readyInsert[] = array(
                    'o_id' => $orderId,
                    'c_id' => $_SESSION['customerId'],
                    'd_id' => $row['d_id'],
                    'number' => $row['number'],
                    'price' => $row['price'],
                    'total' => $row['total']
                );
                $total_fee+=$row['total'];
            }
            if($readyInsert==null){
                header('location:index.php');
                exit;
            }

            pdoInsert('order_tbl', array('id' => $orderId, 'c_id' => $_SESSION['customerId'], 'a_id' => $_GET['addrId'],'total_fee'=>$total_fee));
            pdoBatchInsert('order_detail_tbl', $readyInsert);
            pdoDelete('cart_tbl', array('c_id' => $_SESSION['customerId']));

            $orderStu = 0;
            include 'view/order_inf.html.php';
        }else{
            header('location:controller.php?editAddress=1');
        }
        exit;
    }
    if(isset($_GET['customerInf'])){
        include 'view/customer_inf.html.php';
        exit;
    }
    if(isset($_GET['getOrderDetail'])){
        $orderQuery=pdoQuery('order_view',null,array("id"=>$_GET['id']),' limit 1');
        $order_inf=$orderQuery->fetch();
        $ordeDetailQuery=pdoQuery('user_order_view',null,array('o_id'=>$_GET['id']),'');
        include 'view/order_detail.html.php';
        exit;
    }
    if(isset($_GET['getFav'])){
        $query=pdoQuery('user_fav_view',null,array('c_id'=>$_SESSION['customerId']),' group by g_id');
        include 'view/favorite.html.php';
        exit;
    }
    if(isset($_GET['linkKf'])){
        include_once $GLOBALS['mypath'].'/wechat/serveManager.php';
        $respon=sendKFMessage($_SESSION['customerId'],'您好'.$_SESSION['userInf']['nickname'].'，有什么可以帮助你？');
        header('location:index.php?rand='.$_SESSION['rand']);
        exit;
    }
}


//以下功能不需登录，不需判断$_SESSION['customerId']
if(isset($_GET['oauth'])){
    include_once $GLOBALS['mypath'].'/wechat/serveManager.php';
    if($_GET['code']){
//        mylog('getCode');
        $userId=getOauthToken($_GET['code']);
//        mylog('getOpenId'.$userId['openid']);
        $_SESSION['customerId']=$userId['openid'];
        $_SESSION['userInf']=getUnionId($userId['openid']);

    }else{
        mylog('cannot get Code');
    }
    $rand=rand(1000,9999);
    $_SESSION['rand']=$rand;
    header('location:index.php?rand='.$rand);
    if(isset($_SESSION['userInf'])){
        foreach ($_SESSION['userInf'] as $k=>$v) {
            if('subscribe_time'==$k){
                $v=date('Y-m-d H:i:s', $v);
            }
            $date[$k]=addslashes($v);
        }
        $re=pdoInsert('custom_inf_tbl',$date,'update');
//        mylog($re);
    }


    exit;

}
if(isset($_GET['getFcList'])){
    $father_id=$_GET['fc_id'];
    $cate=pdoQuery('category_view',null,null,'');
    $maincate=array();
    $cateList=array();
    foreach ($cate as $caRow) {
        $maincate[$caRow['father_id']] = array('name' => $caRow['father_name'], 'id' => $caRow['father_id']);
        if ($father_id == $caRow['father_id']) {
            $cateList[] = $caRow;
        }
    }
    $produceQuery=pdoQuery('user_g_inf_view',null,array('father_id'=>$father_id),'');
    $produceList=array();
    foreach ($produceQuery as $row) {
        $produceList[$row['sc_id']][]=$row;
    }

    include 'view/goods_list.html.php';
    exit;
}
if(isset($_GET['getList'])){
    $end=' group by g_id';
    $where=null;
    if(isset($_GET['father_id']))$where['father_id']=$_GET['father_id'];
    if(isset($_GET['sc_id']))$where['sc_id']=$_GET['sc_id'];
    if(isset($_GET['made_in']))$where['made_in']=$_GET['made_in'];
    if(isset($_GET['name'])){
        $end=(null!=$where?' and name like "%'.$_GET['name'].'%"': ' where name like "%'.$_GET['name'].'%"').$end;
    }
    $query=pdoQuery('(select * from user_list_view order by price asc) p',null,$where,$end);
    include 'view/list.html.php';


}
if(isset($_GET['goodsdetail'])){
    if($_GET['g_id']==null){
        header('location:index.php');
        exit;
    }
    $query=pdoQuery('user_g_inf_view',null,array('g_id'=>$_GET['g_id']),' limit 1');
    $inf=$query->fetch();
    $imgQuery=pdoQuery('g_image_tbl',null,array('g_id'=>$_GET['g_id']),null);
    if(isset($_GET['d_id'])){
        if(isset($_GET['number'])){
            $number=$_GET['number'];
            $fromCart=1;
        }else{
            $number=1;
            $fromCart=0;
        }
        $detailQuery=pdoQuery('user_detail_view',null,array('g_id'=>$_GET['g_id']),' and d_id != '.$_GET['d_id']);
        $query=pdoQuery('user_detail_view',null,array('d_id'=>$_GET['d_id']),null);
        $default=$query->fetch();
    }else{
        $number=1;
        $fromCart=0;
        $detailQuery=pdoQuery('user_detail_view',null,array('g_id'=>$_GET['g_id']),null);
        $default=$detailQuery->fetch();
    }
    include 'view/goods_inf.html.php';
    exit;
}
if(isset($_GET['getCart'])){
    if(isset($_SESSION['customerId'])){
        $query=pdoQuery('user_cart_view',null,array('c_id'=>$_SESSION['customerId']),null);
        $cartlist=array();
        foreach ($query as $row) {
            $cartlist[]=$row;
        }

        include 'view/cart.html.php';

    }else{
        //进入登录界面

    }
    exit;
}
if(isset($_GET['getSort'])){

    $query=pdoQuery('category_view',null,null,' order by father_id asc');
    foreach ($query as $row) {
        $catList[$row['father_id']][]=$row;
    }

//    $sub=pdoQuery('sub_category_tbl')
    include 'view/sort.html.php';
    exit;
}
if(isset($_GET['customerInf'])){

}
function getCartDetail($customerId){
    $totalPrice=0;
    $totalSave=0;
    $goodsQuery=pdoQuery('user_cart_view',null,array('c_id'=>$customerId),null);
    $goodsList=array();
    foreach ($goodsQuery as $row) {

        if (isset($row['price'])) {
            $price = $row['price'];
            $totalSave += ($row['sale'] - $row['price']) * $row['number'];
        } else {
            $price = $row['sale'];
        }
        $thisPrice = $price * $row['number'];
        $totalPrice += $thisPrice;

        $goodsList[] = array(
            'g_id'=>$row['g_id'],
            'd_id'=>$row['d_id'],
            'name' => $row['name'],
            'category' => $row['category'],
            'price' => $price,
            'number' => $row['number'],
            'total' => $row['number'] * $price,
            'url' => $row['url']
        );
    }
    return array(
        'totalPrice'=>$totalPrice,
        'totalSave'=>$totalSave,
        'goodsList'=>$goodsList
    );
}

