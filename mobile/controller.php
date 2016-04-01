<?php
/**
 * Created by PhpStorm.
 * User: godlee
 * Date: 2015/10/28
 * Time: 15:14
 */
include_once '../includePackage.php';
session_start();
if (isset($_SESSION['customerId'])) {
    if (isset($_GET['settleAccounts'])) {
        if (isset($_GET['from']) && 'buy_now' == $_GET['from']) {
            $from = 'buy_now';
            if (isset($_GET['d_id']) && isset($_GET['number'])) {
                $_SESSION['buyNow']['d_id'] = $_GET['d_id'];
                $_SESSION['buyNow']['number'] = $_GET['number'];
            }
//            mylog('sessionFull:'.getArrayInf($_SESSION));
//            mylog('buyNowsession:'.getArrayInf($_SESSION['buyNow']));
            $arr = getBuyNowDetail($_SESSION['buyNow']['d_id'], $_SESSION['buyNow']['number'], $_SESSION['buyNow']['partsList']);
        } else {
            $from = 'cart';
            $arr = getCartDetail($_SESSION['customerId']);
        }
        $totalPrice = $arr['totalPrice'];
        $totalSave = $arr['totalSave'];
        $goodsList = $arr['goodsList'];
        if (0 == count($goodsList)) {
            header('location:index.php');
        }
        if (isset($_GET['addressId'])) {
            $addrQuery = pdoQuery('address_tbl', null, array('id' => $_GET['addressId']), ' limit 1');
        } else {
            $addrQuery = pdoQuery('address_tbl', null, array('c_id' => $_SESSION['customerId'], 'dft_a' => 1), ' limit 1');
        }

        if ($addrrow = $addrQuery->fetch()) {
            $addr = $addrrow;
        } else {
            $addrrow = array('id' => -1, 'name' => '', 'phone' => '', 'address' => '点击设置收货地址', 'province' => ' ',
                'city' => ' ', 'area' => ' ');
            $addr = $addrrow;;
        }
        include 'view/order.html.php';
        exit;
    }
    //地址页面修改已存在地址
    if (isset($_GET['alterAddress'])) {

        $pro = getProvince($_POST['pro']);
        $city = getCity($_POST['pro'], $_POST['city']);
        $area = getArea($_POST['pro'], $_POST['city'], $_POST['area']);
        $value = array('pro_id' => $_POST['pro'], 'city_id' => $_POST['city'], 'area_id' => $_POST['area'],
            'area' => $_POST['area'], 'province' => $pro, 'city' => $city, 'area' => $area, 'address' => $_POST['address'], 'name' => $_POST['name'],
            'phone' => $_POST['phone']);
        if (-1 == $_POST['address_id']) {
            $value['c_id'] = $_SESSION['customerId'];
            $value['dft_a'] = 0;
            $addrId = pdoInsert('address_tbl', $value);
        } else {
            pdoUpdate('address_tbl', $value,
                array('id' => $_POST['address_id']));
        }
        $from = isset($_GET['from']) ? '&from=' . $_GET['from'] : '';
        header('location:controller.php?editAddress=1' . $from);
    }

    if (isset($_GET['editAddress'])) {
        $to = $_GET['from'];
        $addrQuery = pdoQuery('address_tbl', null, array('c_id' => $_SESSION['customerId']), ' limit 5');
        $addrlist = array();
        foreach ($addrQuery as $row) {
            $addrlist[] = $row;
        }
        include 'view/address.html.php';
        exit;
    }
    if (isset($_GET['orderConfirm'])) {
        $to = $_GET['from'];
        if (-1 != $_GET['addrId']) {

            $orderId = 'dy' . time() . rand(100, 999);  //订单号生成，低并发情况下适用
            if ('buy_now' == $to) {
                if(isset($_SESSION['buyNow'])){
                    $arr = getBuyNowDetail($_SESSION['buyNow']['d_id'], $_SESSION['buyNow']['number'], $_SESSION['buyNow']['partsList']);
                }else{
                    header('location:index.php');
                    exit;
                }

            } else {
                $arr = getCartDetail($_SESSION['customerId']);
            }

            $total_fee = 0;
//            mylog(getArrayInf($arr['goodsList']));
            foreach ($arr['goodsList'] as $row) {
                if (!isset($readyInsert[$row['d_id']])) {
                    $readyInsert[$row['d_id']] = array(
                        'o_id' => $orderId,
                        'c_id' => $_SESSION['customerId'],
                        'd_id' => $row['d_id'],
                        'number' => $row['number'],
                        'price' => $row['price'],
                        'total' => $row['price'] * $row['number']
                    );
                } else {
                    $readyInsert[$row['d_id']]['number'] += $row['number'];
                    $readyInsert[$row['d_id']]['total'] = $readyInsert[$row['d_id']]['number'] * $readyInsert[$row['d_id']]['price'];
                }
                $total_fee += $row['price'] * $row['number'];
                if (isset($row['parts'])) {
                    foreach ($row['parts'] as $prow) {
                        if (!isset($readyInsert[$prow['part_d_id']])) {
                            $readyInsert[$prow['part_d_id']] = array(
                                'o_id' => $orderId,
                                'c_id' => $_SESSION['customerId'],
                                'd_id' => $prow['part_d_id'],
                                'number' => $prow['part_number'],
                                'price' => $prow['part_sale'],
                                'total' => $prow['part_sale'] * $prow['part_number']
                            );
                        } else {
                            $readyInsert[$prow['part_d_id']]['number'] += $row['number'];
                            $readyInsert[$prow['part_d_id']]['total'] = $readyInsert[$prow['part_d_id']]['number'] * $prow['part_sale'];
                        }
                        $total_fee += $prow['part_sale'] * $prow['part_number'];
                    }
                }
                if(0==$readyInsert[$row['d_id']]['number']){
                    unset($readyInsert[$row['d_id']]);
                }
            }
            if ($readyInsert == null) {
                header('location:index.php');
                exit;
            }
            if($_GET['card']!='none'){
                $savefeeQuery=pdoQuery('card_record_tbl',null,array('card_code'=>$_GET['card'],'consumed'=>'0'),' limit 1');
                if($save=$savefeeQuery->fetch()){
                    include_once '../wechat/cardManager.php';
                    if(consumeCard($_GET['card'])!=false){
                        $total_fee-=$save['fee'];
                        pdoUpdate('card_record_tbl',array('order_id'=>$orderId,'consumed'=>'1'),array('card_code'=>$_GET['card']));
                    }
                }
            }

            pdoInsert('order_tbl', array('id' => $orderId, 'c_id' => $_SESSION['customerId'], 'a_id' => $_GET['addrId'], 'total_fee' => $total_fee,'customer_remark'=>$_SESSION['customer_remark']));
            pdoBatchInsert('order_detail_tbl', $readyInsert);
            if ('buy_now' == $to) {
                unset($_SESSION['buyNow']);
            } else {
                pdoDelete('cart_tbl', array('c_id' => $_SESSION['customerId']));
            }
            $orderStu = 0;
            include 'view/order_inf.html.php';
        } else {
            header('location:controller.php?editAddress=1&from=' . $to);
        }
        exit;
    }
    if(isset($_GET['pay_order'])){
        $orderId=$_GET['order_id'];
        $orderStu=$_GET['order_stu'];
        $total_fee=$_GET['total_fee'];
        include 'view/order_inf.html.php';
        exit;
    }
    if(isset($_GET['preOrderOK'])){
        if(isset($_SESSION['userKey']['package'])){
//            mylog($_SESSION['userKey']['package']);
            $preSign=array(
                'appId'=>APP_ID,
                'timeStamp'=>time(),
                'nonceStr'=>getRandStr(32),
                'package'=>$_SESSION['userKey']['package'],
                'signType'=>'MD5'
            );
            $sign=makeSign($preSign,KEY);
            $preSign['paySign']=$sign;
//            mylog('jsAPiPry:'.toXml($preSign));
            $orderId=
            include 'view/wxpay.html.php';
        }else{
            header('location:index.php');
        }
        exit;
    }
    if(isset($_GET['review'])){
//        mylog('haha');
        $reviewedQuery=pdoQuery('review_tbl',array('d_id'),array('order_id'=>$_GET['order_id']),null);
        foreach ($reviewedQuery as $row) {
            $reviewed[]=$row['d_id'];
        }
//        mylog('hh2');
        if(!isset($reviewed))$reviewed=array();

        $query=pdoQuery('user_input_review_view',null,array('order_id'=>$_GET['order_id']),null);
//        mylog('hh3');
        foreach ($query as $row) {
            if(in_array($row['d_id'],$reviewed)){
                continue;
            }
            $review[]=$row;
        }
        if(!isset($review)){
            pdoUpdate('order_tbl',array('stu'=>'3'),array('id'=>$_GET['order_id']));
            header('location:controller.php?customerInf=1');
            exit;
        }
        include 'view/review.html.php';
        exit;

    }
    if(isset($_GET['toalipay'])){
        $orderId=$_GET['orderId'];
        include 'view/alipay.html.php';
        exit;
    }
    if(isset($_GET['jumpToAlipay'])){
        $orderId=$_GET['orderId'];


    }
    if (isset($_GET['customerInf'])) {
        include 'view/customer_inf.html.php';
        exit;
    }

    if (isset($_GET['getOrderDetail'])) {
        $orderQuery = pdoQuery('order_view', null, array("id" => $_GET['id']), ' limit 1');
        $order_inf = $orderQuery->fetch();
        $ordeDetailQuery = pdoQuery('user_order_view', null, array('o_id' => $_GET['id']), ' order by price desc');
        include 'view/order_detail.html.php';
        exit;
    }
    if (isset($_GET['getFav'])) {
        $query = pdoQuery('user_fav_view', null, array('c_id' => $_SESSION['customerId']), ' group by g_id');
        include 'view/favorite.html.php';
        exit;
    }
    if (isset($_GET['linkKf'])) {
        include_once $GLOBALS['mypath'] . '/wechat/serveManager.php';
        $respon = sendKFMessage($_SESSION['customerId'], '您好' . $_SESSION['userInf']['nickname'] . '，有什么可以帮助你？');
        header('location:index.php?rand=' . $_SESSION['rand']);
        exit;
    }
}
//以下功能不需登录，不需判断$_SESSION['customerId']
if (isset($_GET['oauth'])) {
    include_once $GLOBALS['mypath'] . '/wechat/serveManager.php';
    if ($_GET['code']) {
        $userId = getOauthToken($_GET['code']);
        $_SESSION['customerId'] = $userId['openid'];
        $_SESSION['userInf'] = getUnionId($userId['openid']);


    } else {
        mylog('cannot get Code');
        echo "入口错误，请从公众号的“微商城”按钮进入本商城";
        exit;
    }
    if($_GET['state']!='root'){

    }
    $query=pdoQuery('sdp_relation_view',null,array('open_id'=>$_SESSION['customerId']),' limit 1');
    $sdp=$query->fetch();
    if($sdp){
        $_SESSION['sdp']=array(
            'sdp_id'=>$sdp['sdp_id'],
            'f_id'=>$sdp['f_id'],
            'root'=>$sdp['root']
        );
    }else{
        $query=pdoQuery('sdp_relation_tbl',null,array('f_id'=>$_GET['state']),' limit 1');
        $sdp=$query->fetch();
        if($sdp){
            $_SESSION['sdp']=array(
                'f_id'=>$sdp['f_id'],
                'root'=>$sdp['root']
            );
        }
    }
    if($_SESSION['sdp']['root']!='root'){
        $priceQuery=pdoQuery('sdp_price_tbl',null,array('sdp_id'=>$_SESSION['sdp']['root']),null);
        foreach ($priceQuery as $row) {
            $_SESSION['sdp']['price'][$row['g_id']]=$row['price'];
        }

        if($_SESSION['sdp']['sdp_id']==$_SESSION['sdp']=['root']){
            $manageQuery=pdoQuery('sdp_level_view',null,array('level_id'=>$sdp['root']),' limit 1');
            $manage=$manage->fetch();
            $_SESSION['sdp']['manage']=array(
                'switch'=>'on',
              'discount'=>$manage['discount'],
                'min_sell'=>$manage['min_sell'],
                'max_sell'=>$manage['max_sell'],
            );
        }
    }
    $rand = rand(1000, 9999);
    $_SESSION['rand'] = $rand;
    if(isset($_GET['share'])){
        if($_GET['part']==1){
            header('location:controller.php?goodsdetail=1&g_id='.$_GET['share']);
        }else{
            header('location:controller.php?partsdetail=1&g_id='.$_GET['share']);
        }
        exit;
    }
//    mylog('nickName:'.$_SESSION['userInf']['nickname']);
    header('location:index.php?rand=' . $rand);
    if (isset($_SESSION['userInf'])) {
        foreach ($_SESSION['userInf'] as $k => $v) {
            if ('subscribe_time' == $k) {
                $v = date('Y-m-d H:i:s', $v);
            }
            $data[$k] = addslashes($v);
        }
        $re = pdoInsert('custom_inf_tbl', $data, 'update');
    }
    exit;
}

//获取主分类
if (isset($_GET['getList'])) {
    $sc_id = $_GET['c_id'];
    $query=pdoQuery('user_tmp_list_view',null,array('sc_id'=>$sc_id,'situation'=>'1'),' group by g_id');
    foreach ($query as $row) {
//        if(isset($_SESSION['sdp']['price'][$row['g_id']])) $row['price']=$_SESSION['sdp']['price'][$row['g_id']];
        $row=sdpPrice($row);
        $list[]=$row;
    }
    if(!isset($list))$list=array();
    $cateName=pdoQuery('category_overview_view',null,array('id'=>$sc_id),' limit 1');
    $cateName=$cateName->fetch();
    $partQuery=pdoQuery('user_parts_view',null,array('sc_id'=>$sc_id),'group by g_id');
    foreach ($partQuery as $row) {
        $partList[]=$row;
    }
    if(!isset($partList))$partList=array();
    include 'view/goods_list.html.php';
    exit;
}
//获取搜索结果
if(isset($_GET['search'])){
    $cateName=array();
    $partList=array();
    $key='%'.$_GET['search'].'%';
//    $query=pdoQuery('user_g_inf_view',null,array('situation'=>'1'),' and (name like "'.$key.'" or intro like "'.$key.'")');
    $query=pdoQuery('user_tmp_list_view',null,array('situation'=>'1'),' and (name like "'.$key.'") group by g_id');

    foreach ($query as $row) {
        $list[]=$row;
    }
    if(!isset($list)){
        $list=array();
        $cateName=array('sub_name'=>'无符合条件的搜索结果');
    }
    include 'view/goods_list.html.php';
    exit;

}

//if (isset($_GET['getList'])) {
//    $end = ' group by g_id';
//    $where = null;
//    if (isset($_GET['father_id'])) $where['father_id'] = $_GET['father_id'];
//    if (isset($_GET['sc_id'])) $where['sc_id'] = $_GET['sc_id'];
//    if (isset($_GET['made_in'])) $where['made_in'] = $_GET['made_in'];
//    if (isset($_GET['name'])) {
//        $end = (null != $where ? ' and name like "%' . $_GET['name'] . '%"' : ' where name like "%' . $_GET['name'] . '%"') . $end;
//    }
//    $query = pdoQuery('(select * from user_list_view order by price asc) p', null, $where, $end);
//    include 'view/list.html.php';
//
//
//}
if (isset($_GET['goodsdetail'])) {
    unset($_SESSION['buyNow']);
    if ($_GET['g_id'] == null) {
        header('location:index.php');
        exit;
    }
    $query = pdoQuery('user_g_inf_view', null, array('g_id' => $_GET['g_id']), ' limit 1');
    $inf = $query->fetch();
    $imgQuery = pdoQuery('g_image_tbl', null, array('g_id' => $_GET['g_id']), 'order by id asc');
    if (isset($_GET['d_id'])) {
        if (isset($_GET['number'])) {
            $number = $_GET['number'];
            $fromCart = 1;
        } else {
            $number = 1;
            $fromCart = 0;
        }
        $detailQueryQ = pdoQuery('user_detail_view', null, array('g_id' => $_GET['g_id']), ' and d_id != ' . $_GET['d_id']);
        $query = pdoQuery('user_detail_view', null, array('d_id' => $_GET['d_id']), null);
        $default = $query->fetch();
    } else {
        $number = 1;
        $fromCart = 0;
        $detailQueryQ = pdoQuery('user_detail_view', null, array('g_id' => $_GET['g_id']), null);
        $default = $detailQueryQ->fetch();
    }
//    if(isset($_SESSION['sdp']['price'][$default['g_id']]))$default['price']=$_SESSION['sdp']['price'][$default['g_id']];
    $default=sdpPrice($default);
    foreach ($detailQueryQ as $row) {
//        if(isset($_SESSION['sdp']['price'][$row['g_id']])) $row['price']=$_SESSION['sdp']['price'][$row['g_id']];
        $row=sdpPrice($row);
            $detailQuery[]=$row;
    }


    $partQuery = pdoQuery('user_parts_view', null, array('host_id' => $_GET['g_id']), null);
    $parts = array();
    $_SESSION['buyNow']['partsList'] = array();
    foreach ($partQuery as $row) {
        if (1 == $row['dft_check'] || isset($_SESSION['buyNow']['partsList'][$row['g_id']])) {
            $row['dft'] = 'checked';
            $_SESSION['buyNow']['partsList'][$row['g_id']] = 1;
        } else {
            $row['dft'] = '';
        }
        $parts[] = $row;
    }
    if(count($parts)==0){
        $coopquery = pdoQuery('user_coop_view', null, array('host_id' => $_GET['g_id']), null);
        foreach ($coopquery as $cooprow) {
            $coop[$cooprow['g_id']]=$cooprow;
        }

    }
    $review=getReview($_GET['g_id']);
    $parm = getGoodsPar($_GET['g_id'], $inf['sc_id']);
    $paramvalue='';
    if(!isset($parm['技术参数'])){
        $parm['技术参数']=array();
    }
    if(isset($parm[''])){
        foreach ($parm[''] as $t) {
            if($t['name']=='功能'){
                $paramvalue=$t['value'];
            }
        }
    }else{
        $paramvalue='';
    }



    include 'view/goods_inf.html.php';
    exit;
}
if(isset($_GET['after_inf'])){
    $reQuery=pdoQuery('after_inf_tbl',null,array('g_id'=>$_GET['after_inf']),' limit 1');
    $remark=$reQuery->fetch();
    echo $remark['after_inf'];
    exit;
}

if (isset($_GET['partsdetail'])) {
    unset($_SESSION['buyNow']);
    if ($_GET['g_id'] == null) {
        header('location:index.php');
        exit;
    }
    $query = pdoQuery('user_parts_view', null, array('g_id' => $_GET['g_id']), ' limit 1');
    $inf = $query->fetch();
    $imgQuery[] = $inf;
    $_SESSION['buyNow']['partsList'] = array();
    $reQuery=pdoQuery('sub_category_tbl',null,array('id'=>$inf['sc_id']),' limit 1');
    $hostQuery=pdoQuery('part_tbl',array('g_id'),array('part_g_id'=>$inf['g_id']),' limit 10');
    foreach ($hostQuery as $row) {
        $host[]=$row['g_id'];
    }
    $hostlist=pdoQuery('user_g_inf_view',null,array('g_id'=>$host),null);

    $remark=$reQuery->fetch();
    $cate=$remark;
    $number=1;
    $review=getReview($_GET['g_id']);
    include 'view/part_inf.html.php';
    exit;
}


if (isset($_GET['getCart'])) {
    if (isset($_SESSION['customerId'])) {
        $list = getCartDetail($_SESSION['customerId']);
        $cartlist = $list['goodsList'];
        include 'view/cart.html.php';

    } else {
        //进入登录界面

    }
    exit;
}
if (isset($_GET['getSort'])) {

    $query = pdoQuery('category_view', null, null, ' order by father_id asc');
    foreach ($query as $row) {
        $catList[$row['father_id']][] = $row;
    }

//    $sub=pdoQuery('sub_category_tbl')
    include 'view/sort.html.php';
    exit;
}
if (isset($_GET['customerInf'])) {

}
if(isset($_GET['getMoreReview'])){
    $start=isset($_GET['start'])?$_GET['start']:0;
    $limit=isset($_GET['limit'])?$_GET['limit']:20;
    $reviews=getReview($_GET['g_id'],$start,$limit);
    $totalNumber=$reviews['num'];
    $reviews=$reviews['inf'];
    include'view/reviewdisplay.html.php';
//    $query=pdoQuery('user_review_view',null,array('g_id'=>$_GET['g_id'],''))
}
if(isset($_GET['paySuccess'])){
    $orderId=$_GET['orderId'];
    include 'view/pay_success.html.php';
}
function getCartDetail($customerId)
{
    $totalPrice = 0;
    $totalSave = 0;
    $goodsQuery = pdoQuery('user_cart_view', null, array('c_id' => $customerId), null);
    $goodsList = array();
    foreach ($goodsQuery as $row) {
        $row=sdpPrice($row);
        $part_price = $row['part_sale'];
        if (isset($goodsList[$row['cart_id']])) {
            $goodsList[$row['cart_id']]['total'] += $row['part_number'] * $part_price;
            $goodsList[$row['cart_id']]['full_price'] += $part_price;
        } else {
            if (isset($row['price'])) {
                $price = $row['price'];
                $totalSave += ($row['sale'] - $row['price']) * $row['number'];
            } else {
                $price = $row['sale'];
            }
            $thisPrice = $price * $row['number'];
            $totalPrice += $thisPrice;
            $goodsList[$row['cart_id']] = array(
                'cart_id' => $row['cart_id'],
                'g_id' => $row['g_id'],
                'd_id' => $row['d_id'],
                'name' => $row['name'],
                'made_in'=>$row['made_in'],
                'produce_id' => $row['produce_id'],
                'category' => $row['category'],
                'price' => $price,//不带配件 单价
                'full_price' => $price + $part_price,//单件+配件价格
                'number' => $row['number'],
                'total' => $row['number'] * $price + $row['part_number']*$part_price,//总价
                'url' => $row['url'],
            );
        }
        //配件信息
//        $partList=array();
        if (isset($row['part_d_id'])) {
//            mylog('part_d_id setted');
            $goodsList[$row['cart_id']]['parts'][] = array(
                'part_id' => $row['part_id'],
                'part_name' => $row['part_name'],
                'part_produce_id' => $row['part_produce_id'],
                'part_d_id' => $row['part_d_id'],
                'part_url' => $row['part_url'],
                'part_sale' => $row['part_sale'],
                'part_number'=>$row['part_number']
            );
            $totalPrice += $row['part_sale'] * $row['part_number'];
//            mylog(getArrayInf($goodsList[$row['cart_id']]['parts']));
        } else {
            $goodsList[$row['cart_id']]['parts']=array();
        }

    }

//    mylog(getArrayInf($goodsList));
    return array(
        'totalPrice' => $totalPrice,
        'totalSave' => $totalSave,
        'goodsList' => $goodsList
    );
}

function getBuyNowDetail($d_id, $number, array $partsList)
{
    $gInfQuery = pdoQuery('user_tmp_list_view', null, array('d_id' => $d_id), null);
    $row = $gInfQuery->fetch();
//    if(isset($_SESSION['sdp']['price'][$row['g_id']])) $row['price']=$_SESSION['sdp']['price'][$row['g_id']];
    $row=sdpPrice($row);
    $price = isset($row['price']) ? $row['price'] : $row['sale'];
    $goodsList[0] = array(
        'g_id' => $row['g_id'],
        'd_id' => $row['d_id'],
        'name' => $row['name'],
        'produce_id' => $row['produce_id'],
        'category' => $row['category'],
        'price' => $price,
        'number' => $number,
        'total' => $number * ($price),
        'url' => $row['url'],
    );
    foreach ($partsList as $k=>$v) {
        $partsId[]=$k;
    }
    if(!isset($partsId))$partsId=array();
    $pquery = pdoQuery('parts_view', null, array('g_id' => $partsId), null);
    foreach ($pquery as $prow) {
        $goodsList[0]['parts'][] = array(
            'part_id' => $prow['g_id'],
            'part_name' => $prow['name'],
            'part_produce_id' => $prow['produce_id'],
            'part_d_id' => $prow['d_id'],
            'part_url' => $prow['url'],
            'part_sale' => $prow['sale'],
//            'part_number'=>$partsList[$prow['g_id']]
            'part_number'=>$number
        );
        $goodsList[0]['total'] += $prow['sale'] * $number;
    }
    if(!isset($goodsList[0]['parts']))$goodsList[0]['parts']=array();
    return array(
        'totalPrice' => $goodsList[0]['total'],
        'totalSave' => 0,
        'goodsList' => $goodsList
    );

//    $totalPrice=$goodsList[0]['total'];
//    $totalSave=0;


}

