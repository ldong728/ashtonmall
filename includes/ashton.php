<?php
/**
 * Created by PhpStorm.
 * User: godlee
 * Date: 2015/11/3
 * Time: 23:20
 */
define('SDP_KEY','329qkd98ekjd9aqkrmr87t');

function printView($addr,$title='abc'){
    $mypath= $GLOBALS['mypath'];
    include $mypath.'/admin/templates/header.html.php';
    include $mypath.'/'.$addr;
    include $mypath.'/admin/templates/footer.html.php';
}
function init()
{
    $smq=array();
    $mq=array();
    $sub_cg = pdoQuery('category_overview_view', null, null, '');
    foreach ($sub_cg as $sl) {
        $smq[] = array(
            'id' => $sl['id'],
            'name' => $sl['father_name'] . '--' . $sl['sub_name']
        );
    }
    $father_cg = pdoQuery('category_tbl', null, null, '');
    foreach ($father_cg as $l) {
        $mq[] = array(
            'id' => $l['id'],
            'name' => $l['name']
        );
    }
    $_SESSION['mq'] = $mq;
    $_SESSION['smq'] = $smq;
}
function getOrderStu($index){
    $list=array('待付款','已付款','已发货','已完成','异常','退款中','退货中','已取消','已过期','处理中');
    return $list[$index];
}
function getProvince($pro){
    $datafile = 'config/province.inc.php';
    if(file_exists($datafile)){
        $config = include($datafile);
        return $config[$pro];
    }
}
function printViewMobile($addr,$title='abc',$hasInput=false){

    $mypath= $GLOBALS['mypath'];
    if($hasInput){
        include $mypath.'/mobile/templates/headerJs.html.php';

    }else{
        include $mypath.'/mobile/templates/header.html.php';
    }
//    echo 'header OK';

    include $mypath.'/'.$addr;
    include $mypath.'/mobile/templates/footer.html.php';
}
function getCity($pro,$city){
    $datafile = 'config/city.inc.php';
    if(file_exists($datafile)){
        $config = include($datafile);
        $province_id=$pro;
        if($province_id != ''){
            $citylist = array();
            if(is_array($config[$province_id]) && !empty($config[$province_id])){
                $citys = $config[$province_id];
                return $citys[$city];
            }
        }
    }
}
function getArea($pro,$city,$area){
    $datafile = 'config/area.inc.php';
    if(file_exists($datafile)){
        $config = include($datafile);
        $province_id = $pro;
        $city_id = $city;
        if($province_id != '' && $city_id != ''){
            $arealist = array();
            if(isset($config[$province_id][$city_id]) && is_array($config[$province_id][$city_id]) && !empty($config[$province_id][$city_id])){
                $areas = $config[$province_id][$city_id];
                return $areas[$area];
            }
        }
    }
}
function getReview($g_id,$index=0,$limit=3){
    $query=pdoQuery('user_output_review_view',null,array('g_id'=>$g_id,'father_v_id'=>'-1'),
        ' and (c_id="'.$_SESSION['customerId'].'" or public=1) order by priority asc,review_time desc limit '.$index.','.$limit*5);
    $numquery=pdoQuery('review_tbl',array('count(*) as num'),array('g_id'=>$g_id,'father_v_id'=>'-1'),' and (public=1 or c_id="'.$_SESSION['customerId'].'")');
    $count=$numquery->fetch();
    $reviewcount=0;
    foreach ($query as $row) {
        if(!isset($review[$row['id']])){
            $review[$row['id']]=$row;
            $reviewcount++;
            if($reviewcount>$limit-1)break;
        }
        $review[$row['id']]['img'][]=$row['url'];
    }
    if(!isset($review))$review=array();
    if(!isset($count['num']))$count['num']=0;
    $back['num']=$count['num'];
    $back['inf']=$review;
    return $back;

}

function getGoodsPar($g_id,$sc_id){
    $back=array();
    $parmKeyQuery=pdoQuery('par_col_tbl',null,array('sc_id'=>$sc_id),' limit 25');
    $parmQuery=pdoQuery('parameter_tbl',null,array('g_id'=>$g_id),' limit 1');
    if($parm=$parmQuery->fetch()){
        foreach($parmKeyQuery as $parRow){
            $back[$parRow['par_category']][]=array('col'=>$parRow['col_name'],'name'=>$parRow['name'],'value'=>$parm[$parRow['col_name']]);
        }
    }else{
        foreach($parmKeyQuery as $parRow){
            $back[$parRow['par_category']][]=array('col'=>$parRow['col_name'],'name'=>$parRow['name'],'value'=>$parRow['dft_value']);
        }
    }
    if(!isset($back))$back['']=array();
    return $back;
}
function getWechatMode($customerId){
    $query=pdoQuery('wechat_mode_tbl',null,array('c_id'=>$customerId),' limit 1');
    if($row=$query->fetch()){
        $mode=$row['mode'];
    }else{
        $mode='normal';
        pdoInsert('wechat_mode_tbl',array('c_id'=>$customerId,'mode'=>$mode),'ignore');
    }
    return $mode;
}
function updateWechatMode($customerId,$mode){
    pdoUpdate('wechat_mode_tbl',array('mode'=>$mode),array('c_id'=>$customerId));
}
function getConfig($path){
    $data=file_get_contents($path);
    return json_decode($data,true);
}
function saveConfig($path,array $config){
    $data=json_encode($config);
    file_put_contents($path,$data);
}

function sdpPrice(array $list){
    if(isset($_SESSION['sdp']['manage'])&&$_SESSION['sdp']['manage']['switch']=='on'){
            $list['price']=$list['sale']*$_SESSION['sdp']['manage']['discount'];
    }else{
        if(isset($_SESSION['sdp']['price'][$list['g_id']])) $list['price']=$_SESSION['sdp']['price'][$list['g_id']];//分销商自定义价格
    }
    return $list;
}
function getSdpPrice($g_id){
    $query=pdoQuery('g_detail_view',array('sale'),array('g_id'=>$g_id),' limit 1');
    $inf=$query->fetch();
    if(isset($_SESSION['sdp']['manage'])&&$_SESSION['sdp']['manage']['switch']=='on'){
        $price=$inf['sale']*$_SESSION['sdp']['manage']['discount'];
    }else{
        $price=isset($_SESSION['sdp']['price'][$g_id])?$_SESSION['sdp']['price'][$g_id]:$inf['sale'];
    }
    return $price;
}

function createSdp($phone){
    $sdp_id=md5($_SESSION['customerId'].$phone.SDP_KEY);
    pdoInsert('sdp_user_tbl',array('sdp_id'=>$sdp_id,'open_id'=>$_SESSION['customerId'],'phone'=>$phone),'update');
    pdoInsert('sdp_user_level_tbl',array('sdp_id'=>$sdp_id,'level'=>'1'),'update');
    $f_id=isset($_SESSION['sdp']['sdp_id'])?$_SESSION['sdp']['sdp_id'] : 'root';
    pdoInsert('sdp_relation_tbl',array('sdp_id'=>$sdp_id,'f_id'=>$f_id,'root'=>$_SESSION['sdp']['root']),'update');
    pdoInsert('sdp_account_tbl',array('sdp_id'=>$sdp_id,'total_balence'=>'0'),'update');
    pdoDelete('sdp_subscribe_tbl',array('open_id'=>$_SESSION['customerId']));
}


/**
 * 佣金分配函数
 * @param $order_id 订单号
 */
function gainshare($order_id){
//    mylog('gainshare');
//    $orderQuery=pdoQuery('order_tbl',null,array('id'=>$order_id,'stu'=>'1'),' limit 1');//获取订单信息
    $orderQuery=pdoQuery('order_tbl',null,array('id'=>$order_id),' limit 1');//获取订单信息测试用代码
    
    if($order=$orderQuery->fetch()){
        
        if($order['remark']!=''){//订单包含分销商/微商信息
            
            $totalShared=0;
            $sdp_id=$order['remark'];
            $sdpQuery=pdoQuery('sdp_gainshare_view',null,array('sdp_id'=>$order['remark']),' limit 1');//获取分销商
            $sdpInf=$sdpQuery->fetch();
            if($sdpInf['level']==1){//分享者为微商
                
                $glist=array();
                $root=$sdpInf['root'];
                $gainQuery=pdoQuery('sdp_gainshare_tbl',null,array('root'=>$root),' order by rank asc');//获取微商所属分销商的佣金分配设置
                foreach ($gainQuery as $row) {//获取微商佣金比例，存入数组
                    $glist[]=array(
                      'rank'=>$row['rank'],
                        'value'=>$row['value']
                    );
                }
                if(count($glist)<1){//若分销商未设置佣金比例，则使用默认值
                    $gainQuery=pdoQuery('sdp_gainshare_tbl',null,array('root'=>'root'),' order by rank asc');
                    foreach ($gainQuery as $row) {//获取微商佣金比例，存入数组
                        $glist[]=array(
                            'rank'=>$row['rank'],
                            'value'=>$row['value']
                        );
                    }
                }
                foreach ($glist as $row) {//便利佣金分配数组，获取对应微商sdp_id
                    $relationQuery=pdoQuery('sdp_relation_tbl',null,array('sdp_id'=>$sdp_id),' limit 1');
                    $rel=$relationQuery->fetch();
                    $gainshareList[]=array(
                      'sdp_id'=>$rel['sdp_id'],
                        'rank'=>$row['rank'],
                        'value'=>$row['value'],
                        'total_fee'=>$order['total_fee']
                    );
                    $sdp_id=$rel['f_id'];
                    if($rel['f_id']==$rel['root']){
                        break;
                    }
                }
//                mylog(getArrayInf($gainshareList));
                $totalShared=gainshareAccount($gainshareList,$order['id']);//将佣金按比例存入微商账户
            }else{//分享者为分销商
                $root=$order['remark'];
            }
//            $root=$sdpInf['level']==0?$sdpInf['root'] :$order['remark'];
            if($root!='root'){//分销商提成
                $query=pdoQuery('sdp_user_tbl',null,array('open_id'=>$order['c_id']),' limit 1');
                if($temp=$query->fetch()){
                    if($temp['sdp_id']==$root){//分销商自己购买
                        return;
                    }
                }
                $discountQuery=pdoQuery('sdp_level_view',null,array('sdp_id'=>$root),' limit 1');
                $rootinf=$discountQuery->fetch();
                $costQuery=pdoQuery('sdp_prime_cost_tbl',null,array('o_id'=>$order_id),' limit 1');
                $cost=$costQuery->fetch();
                $rootEarn=$cost['sale']*(1-$rootinf['discount'])-$totalShared;
                alterSdpAccount($order_id,$root,$rootEarn);
            }
        }else{
            return;
        }

    }else{
        
        return;
    }
}
function gainshareAccount(array $gainshareList,$order_id){
    $totalPrice=0;
    foreach ($gainshareList as $row) {
        $price=$row['total_fee']*$row['value'];
        alterSdpAccount($order_id,$row['sdp_id'],$price);
        $totalPrice+=$price;
    }
    return $totalPrice;
}

function alterSdpAccount($order_id,$sdp_id,$price,$type='in'){
    $balenceQuery=pdoQuery('sdp_account_tbl',null,array('sdp_id'=>$sdp_id),' limit 1');
    $balence=$balenceQuery->fetch();
    if($type=='out')$price=-$price;
    $totalBalence=$balence['total_balence']+$price;
    $verify=md5($order_id.$price.$totalBalence.SDP_KEY);//每一笔记录都进行签名
    pdoInsert('sdp_record_tbl',array('order_id'=>$order_id,'sdp_id'=>$sdp_id,'fee'=>$price,'type'=>$type),'ignore');
    pdoUpdate('sdp_account_tbl',array('total_balence'=>$totalBalence,'verify'=>$verify),array('sdp_id'=>$sdp_id));
}

/**账户验证函数
 * @param $sdp_id
 */
function verifyAccount($sdp_id){
    $recordQuery=pdoQuery('sdp_record_tbl',null,array('sdp_id'=>$sdp_id),' order by creat_time desc limit 1');
    $record=$recordQuery->fetch();
    $accountQuery=pdoQuery('sdp_account_tbl',null,array('sdp_id'=>$sdp_id),' limit 1');
    $account=$accountQuery->fetch();
    if($record['type']=='out')$record['fee']=-$record['fee'];
    $verify=md5($record['order_id'].$record['fee'].$account['total_balence'].SDP_KEY);
    if($verify==$account['verify']){
        return true;
    }else{
        return false;
    }
}
