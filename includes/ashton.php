<?php
/**
 * Created by PhpStorm.
 * User: godlee
 * Date: 2015/11/3
 * Time: 23:20
 */
define('SDP_KEY','329qkd98ekjd9aqkrmr87t');
define('TIME_OUT',15);

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
function setOrderStu($orderId,$stu,$operator=-1,$paymode=0){
    pdoUpdate('order_tbl', array('stu' => $stu), array('id' => $orderId));
    pdoInsert('order_record_tbl',array('order_id'=>$orderId,'event'=>$stu,'pay_mode'=>$paymode,'operator_id'=>$operator));
}

/**将长期未评价和未付款的订单给出默认好评，或取消
 * @param int $time
 * @return bool
 */

function clearOrders($time=TIME_OUT){
    pdoUpdate('order_tbl',array('stu'=>'7'),array('stu'=>'0'),' and to_days(order_time)<to_days(now())-'.$time);
    $dealed=pdoQuery('user_order_view',null,array('stu'=>'2'),' and to_days(order_time)<to_days(now())-'.$time);
    foreach ($dealed as $row) {
        $values[]=array(
            'c_id'=>$row['c_id'],
            'order_id'=>$row['o_id'],
            'g_id'=>$row['g_id'],
            'd_id'=>$row['d_id'],
            'score'=>'5',
            'public'=>1
        );
    }
    pdoUpdate('order_tbl',array('stu'=>'3'),array('stu'=>'2'),' and to_days(order_time)<to_days(now())-'.$time);
    if(isset($values)){
        pdoBatchInsert('review_tbl',$values);
    }
    return true;
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

function sdpPrice(array $list){//将数组中的price字段对应价格替换为分销商设置价格
    if(isset($_SESSION['sdp']['manage'])&&$_SESSION['sdp']['manage']['switch']=='on'){//开启进货模式，价格为供货商管理员设置价格或分销商折扣率
        if(isset($_SESSION['sdp']['wholesale'][$list['g_id']])){
            $list['price']=$_SESSION['sdp']['wholesale'][$list['g_id']];
        }else{
            $list['price']=$list['sale']*$_SESSION['sdp']['manage']['discount'];
        }
    }else{
        if(isset($_SESSION['sdp']['price'][$list['g_id']])) $list['price']=$_SESSION['sdp']['price'][$list['g_id']];//分销商自定义价格
    }
    return $list;
}
function sdpPartPrice(array $list,$idColName='g_id',$priceColName='part_sale'){//将数组中的price字段对应价格替换为分销商设置价格
    if(isset($_SESSION['sdp']['manage'])&&$_SESSION['sdp']['manage']['switch']=='on'){//开启进货模式，价格为供货商管理员设置价格或分销商折扣率
        if(isset($_SESSION['sdp']['wholesale'][$list[$idColName]])){
            $list[$priceColName]=$_SESSION['sdp']['wholesale'][$list[$idColName]];
        }else{
            $list[$priceColName]=$list[$priceColName]*$_SESSION['sdp']['manage']['discount'];
        }
    }else{
        if(isset($_SESSION['sdp']['price'][$list[$idColName]])) $list[$priceColName]=$_SESSION['sdp']['price'][$list[$idColName]];//分销商自定义价格
    }
    return $list;
}

function getSdpPrice($g_id){
    $query=pdoQuery('g_detail_view',array('sale'),array('g_id'=>$g_id),' limit 1');
    $inf=$query->fetch();
    if(isset($_SESSION['sdp']['manage'])&&$_SESSION['sdp']['manage']['switch']=='on'){
        $price=isset($_SESSION['sdp']['wholesale'][$g_id])?$_SESSION['sdp']['wholesale'][$g_id]:$inf['sale']*$_SESSION['sdp']['manage']['discount'];
    }else{
        $price=isset($_SESSION['sdp']['price'][$g_id])?$_SESSION['sdp']['price'][$g_id]:$inf['sale'];
    }
    return $price;
}

function createSdp($phone,$name,$province,$city){
    $query=pdoQuery('sdp_user_tbl',null,array('open_id'=>$_SESSION['customerId']),'limit 1');
    if(!$query->fetch()){
        $sdp_id=md5($_SESSION['customerId'].$phone.SDP_KEY);
        pdoInsert('sdp_user_tbl',array('sdp_id'=>$sdp_id,'open_id'=>$_SESSION['customerId'],'phone'=>trim($phone),'name'=>trim($name),'province'=>trim($province),'city'=>trim($city)),'update');
        pdoInsert('sdp_user_level_tbl',array('sdp_id'=>$sdp_id,'level'=>'1'),'update');
        $f_id=isset($_SESSION['sdp']['sdp_id'])?$_SESSION['sdp']['sdp_id'] : 'root';
        pdoInsert('sdp_relation_tbl',array('sdp_id'=>$sdp_id,'f_id'=>$f_id,'root'=>$_SESSION['sdp']['root']),'update');
        pdoInsert('sdp_account_tbl',array('sdp_id'=>$sdp_id,'total_balence'=>'0'),'update');
        pdoDelete('sdp_subscribe_tbl',array('open_id'=>$_SESSION['customerId']));
        $_SESSION['sdp']['sdp_id']=$sdp_id;
        $_SESSION['sdp']['level']=1;
        return 'ok';
    }else{
        return false;
    }



//    include_once $GLOBALS['mypath'] . '/wechat/serveManager.php';
//    createQrcode($_SESSION['sdp']['sdp_id']);

}
function altSdpLevel($sdp_id,$level){
    if($sdp_id!='root'){
        pdoDelete('sdp_gainshare_tbl',array('root'=>$sdp_id));//清除用户自设的佣金比例
        pdoDelete('sdp_price_tbl',array('sdp_id'=>$sdp_id));//清除用户自设的商品价格
    }

    if(1==$level){
        $rootQuery=pdoQuery('sdp_relation_view',array('root','level'),array('sdp_id'=>$sdp_id),' limit 1');
        $r=$rootQuery->fetch();
        if($r['level']>1){
            $fullQuery=pdoQuery('sdp_relation_tbl',array('sdp_id','f_id'),array('root'=>$sdp_id),null);
            foreach ($fullQuery as $row) {
                $fullList[$row['f_id']]=$row['sdp_id'];
            }
            if(count($fullList)>0){
                $list=getSubSdp($fullList,array($sdp_id));
                pdoUpdate('sdp_relation_tbl',array('root'=>'root'),array('sdp_id'=>$list));
            }
            pdoInsert('sdp_relation_tbl',array('sdp_id'=>$sdp_id,'f_id'=>'root','root'=>'root'),'update');
            pdoUpdate('sdp_user_level_tbl',array('level'=>$level),array('sdp_id'=>$sdp_id));

        }
    }elseif($level>1){
        $rootQuery=pdoQuery('sdp_relation_view',array('root','level'),array('sdp_id=>$sdp_id'),' limit 1');
        $r=$rootQuery->fetch();
        if($r['level']==1){
            $root=$r['root'];
            $fullQuery=pdoQuery('sdp_relation_tbl',array('sdp_id','f_id'),array('root'=>$root),null);
            foreach ($fullQuery as $row) {
                $fullList[$row['f_id']]=$row['sdp_id'];
            }
            $list=getSubSdp($fullList,array($sdp_id));
            pdoUpdate('sdp_relation_tbl',array('root'=>$sdp_id),array('sdp_id'=>$list));
            pdoDelete('sdp_relation_tbl',array('sdp_id'=>$sdp_id));
        }
        pdoUpdate('sdp_user_level_tbl',array('level'=>$level),array('sdp_id'=>$sdp_id));

    }
    return 'ok';
}
function deleteSdp($sdp_id){
    $query=pdoQuery('sdp_relation_tbl',null,array('sdp_id'=>$sdp_id),' limit 1');
    $inf=$query->fetch();
    $f_id=$inf['f_id'];

    $sub=pdoQuery('sdp_relation_tbl',null,array('f_id'=>$sdp_id),null);
    foreach ($sub as $row) {
        $alt[]=$row['sdp_id'];
    }
    if(isset($alt)){
        $num=pdoUpdate('sdp_relation_tbl',array('f_id'=>$f_id),array('sdp_id'=>$alt));
    }
    pdoDelete('sdp_user_tbl',array('sdp_id'=>$sdp_id));
    pdoDelete('sdp_user_level_tbl',array('sdp_id'=>$sdp_id));
    pdoDelete('sdp_relation_tbl',array('sdp_id'=>$sdp_id));
    pdoDelete('sdp_account_tbl',array('sdp_id'=>$sdp_id));
    return;
}


/**
 * 佣金分配函数
 * @param $order_id 订单号
 */
function gainshare($order_id){
    $orderQuery=pdoQuery('order_tbl',null,array('id'=>$order_id,'stu'=>'1'),' limit 1');//获取订单信息
//    $orderQuery=pdoQuery('order_tbl',null,array('id'=>$order_id),' limit 1');//获取订单信息测试用代码
    if($order=$orderQuery->fetch()){
        if($order['remark']!=''){//订单包含分销商/微商信息
            $totalShared=0;
            $sdp_id=$order['remark'];
            $sdpQuery=pdoQuery('sdp_gainshare_view',null,array('sdp_id'=>$order['remark']),' limit 1');//获取分销商
            $sdpInf=$sdpQuery->fetch();
            
            $orderDtetailQuery=pdoQuery('sdp_order_view',null,array('o_id'=>$order_id),null);
            $orderDetail=$orderDtetailQuery->fetchAll();
            if($sdpInf['level']==1){//分享者为微商
                $usedglist=array();
                $root=$sdpInf['root'];
                $gainshareList=array(array('sdp_id'=>$sdp_id,'open_id'=>$sdpInf['open_id'],'fee'=>0,'level'=>$sdpInf['level']));
                foreach ($orderDetail as $detailRow) {
                    $g_id=$detailRow['g_id'];
                    $num=$detailRow['number'];
                    $price=$detailRow['price'];
                    $usedglist=getGainshareConfig($root,$g_id);//获取该商品的佣金分配数组
                    mylog(json_encode($usedglist));
                    foreach ($usedglist as $k=>$grow) {//遍历佣金分配数组，获取对应微商sdp_id
                        if($gainshareList[$k]=='root')break;//终止标记，表示此级已是分销商
                        $shared=$num*$grow['value'];//计算佣金
//                        $totalShared+=$shared;//总佣金支出累计，用于从分销商利润中扣除
                        if(!isset($gainshareList[$k])){//微商数组中对应级为空
                            $relationQuery=pdoQuery('sdp_relation_view',null,array('sdp_id'=>$gainshareList[$k-1]['sdp_id']),' limit 1');//获取上一级sdp
                            $rel=$relationQuery->fetch();
                            if($rel['f_id']==$rel['root']){
                                $gainshareList[$k]='root';
                                break;
                            }
                            $gainshareList[$k]=array('sdp_id'=>$rel['f_id'],'open_id'=>$rel['f_open_id'],'fee'=>$shared,'level'=>$rel['level']);

                        }else{
                            $gainshareList[$k]['fee']+=$shared;
                        }
                        $totalShared+=$shared;//总佣金支出累计，用于从分销商利润中扣除
                    }
                }
//                mylog(getArrayInf($gainshareList));
                foreach ($gainshareList as $gsrow) {
                    if($gsrow!='root')alterSdpAccount($order_id,$gsrow['sdp_id'],$gsrow['fee'],$gsrow['open_id'],'in');
                }
            }else{//分享者为分销商
                
                $root=$order['remark'];
            }
            
            if($root!='root'){//分销商提成
                $discountQuery=pdoQuery('sdp_level_view',null,array('sdp_id'=>$root),' limit 1');
                $rootinf=$discountQuery->fetch();//获取分销商折扣
                $rootLevel=$rootinf['level_id'];
                $totalCost=0;
                foreach ($orderDetail as $orow) {
                    $wholesale=pdoQuery('sdp_wholesale_tbl',null,array('level_id'=>$rootLevel,'g_id'=>$orow['g_id']), ' limit 1');
                    $wholesale=$wholesale->fetch();
                    $cost=$wholesale?$wholesale['price']*$orow['number']:$orow['total_sale']*$rootinf['discount'];
//                    mylog('wholesale='.$wholesale['price']);
//                    mylog('total_sale='.$orow['total_sale']);
//                    mylog('discount='.$rootinf['discount']);
//                    mylog($cost);
                    $totalCost+=$cost;

                }
                $totalCost+=$totalShared;
                    $rootEarn=$order['total_fee']-$totalCost;
                alterSdpAccount($order_id,$root,$rootEarn);
            }
        }else{
            
            return;
        }

    }else{
        

        return;
    }
}
function gainshareAccount(array $gainshareList,$order_id){//根据数组处理佣金
    $totalPrice=0;
    foreach ($gainshareList as $row) {
        $price=$row['total_fee']*$row['value'];
        alterSdpAccount($order_id,$row['sdp_id'],$price);
        $totalPrice+=$price;
    }
    return $totalPrice;
}

function alterSdpAccount($order_id,$sdp_id,$price,$openid=null,$type='in'){
    $balenceQuery=pdoQuery('sdp_account_tbl',null,array('sdp_id'=>$sdp_id),' limit 1');
    $balence=$balenceQuery->fetch();

    if($type=='out')$price=-$price;
    $totalBalence=$balence['total_balence']+$price;
    $price=number_format($price,2,'.','');
    $totalBalence=number_format($totalBalence,2,'.','');
    $verify=md5($order_id.$price.$totalBalence.SDP_KEY);//每一笔记录都进行签名
//    mylog($price);
//    mylog($totalBalence);
//    mylog($order_id.$price.$totalBalence.SDP_KEY);
    pdoInsert('sdp_record_tbl',array('order_id'=>$order_id,'sdp_id'=>$sdp_id,'fee'=>$price,'type'=>$type),'ignore');
    pdoUpdate('sdp_account_tbl',array('total_balence'=>$totalBalence,'verify'=>$verify),array('sdp_id'=>$sdp_id));
    if(isset($openid)&&$price>0) {
        if($type=='in') {
            $intro='您获得一笔新佣金！';
        }elseif($type=='out') {
            $intro='您的佣金帐户有一笔取现操作';
        }
        include_once $GLOBALS['mypath'].'/wechat/serveManager.php';
        $templateArray = array(
            'first' => array('value' => $intro),
            'keyword1' => array('value' => number_format($price,2,'.',''), 'color' => '#0000ff'),
            'keyword2' => array('value' => date('Y-m-d H:i:s', time()), 'color' => '#0000ff'),
            'remark' => array('value' => '祝您生意兴隆')
        );
//        mylog($openid);
//        mylog(getArrayInf($templateArray));
        $request = sendTemplateMsg($openid, $GLOBALS['template_key_gainshare'], '', $templateArray);
//        mylog($request);
    }
}
function getSdpInf($index,$size,$level=0,array $filter=null){
        $orderby=isset($filter['order']) ? $filter['order']:'create_time';
        $rule=isset($filter['rule']) ? $filter['rule']:'desc';

    if(0==$level){
        $levelQuery=pdoQuery('sdp_level_tbl',array('level_id'),null,' where level_id>1');
        foreach ($levelQuery as $row) {
            mylog();
            $levelList[]=$row['level_id'];
        }
        $where['level']=$levelList;
    }else{
        $where['level']=$level;
        $whereStr='';
    }
    if(isset($filter['where'])){
        foreach ($filter['where'] as $k=>$v) {
            $where[$k]=$v;
        }
    }

    $count=pdoQuery('sdp_user_full_inf_view',array('count(*) as total_num'),$where,$whereStr);
    $c=$count->fetch();
    $return['count']=$c['total_num'];
    if($level>1){
        $infQuery=pdoQuery('sdp_root_full_inf_view',null,$where,$whereStr."order by $orderby $rule limit $index,$size");
    }else{
        $infQuery=pdoQuery('sdp_user_full_inf_view',null,$where,$whereStr."order by $orderby $rule limit $index,$size");
    }
    foreach ($infQuery as $row) {
        $return['sdp'][]=$row;
    }
    if(!isset($return['sdp']))$return['sdp']=array();
    return $return;

}
function changeSdpLevel($sdpId,$level){

}
function getSubSdp(array $fullList,array $sdpList){
    $return=array();
    foreach ($fullList as $f => $s) {
        if(in_array($f,$sdpList)){
            $return[]=$s;
        }
    }
    if(count($return)>0){
        return array_merge($sdpList,getSubSdp($fullList,$return));
    }else{
        return $sdpList;
    }
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
//    mylog($record['fee']);
//    mylog($account['total_balence']);
//    mylog($record['order_id'].$record['fee'].$account['total_balence'].SDP_KEY);
//    mylog($verify);
//    mylog($account['verify']);
    if($verify==$account['verify']){
        return true;
    }else{
        return false;
    }
}

/**获取佣金设置
 * @param string $root 分销商id
 * @param int $g_id 商品ID
 * @return array 返回佣金设置列表
 */

function getGainshareConfig($root="root",$g_id=-1){
    $gainshareQuery=pdoQuery('sdp_gainshare_tbl',null,null,' where root in ("root","'.$root.'") and (g_id=-1 or g_id='.$g_id.')  order by rank asc');

    foreach ($gainshareQuery as $gainshareRow) {
        $glist[$gainshareRow['g_id']][$gainshareRow['root']][]=$gainshareRow;
    }
    if(isset($glist[$g_id][$root])){
        $pre=$glist[$g_id][$root];
    }elseif(isset($glist[$g_id]['root'])){
        $pre=$glist[$g_id]['root'];
    }elseif(isset($glist[-1][$root])){
        $pre=$glist[-1][$root];
    }else{
        $pre=$glist[-1]['root'];
    }
    foreach ($pre as $prrow){
        $usedglist[]=array(
            'rank'=>$prrow['rank'],
            'value'=>$prrow['value']
        );
    }
    if(!$usedglist)$usedglist=array();
    return $usedglist;
}
function getsdpWholesale($level){
    $levelInf=pdoQuery('sdp_level_tbl',null,array('level_id'=>$level),' limit 1');
    $levelInf=$levelInf->fetch();
    $wsQuery=pdoQuery('sdp_wholesale_tbl',null,array('level_id'=>$level),null);
    foreach ($wsQuery as $row) {
        $wslist[$row['g_id']]=$row;
    }
    $gList=pdoQuery('user_tmp_list_view',null,null,' group by g_id');
    foreach ($gList as $row) {
        if(isset($wslist[$row['g_id']])){
            $ws= $wslist[$row['g_id']]['price'];
            $min=isset($wslist[$row['g_id']]['min_sell'])?$wslist[$row['g_id']]['min_sell']:$levelInf['min_sell']*$row['sale'];
            $max=isset($wslist[$row['g_id']]['max_sell'])?$wslist[$row['g_id']]['max_sell']:$levelInf['max_sell']*$row['sale'];
        }else{
            $ws=$levelInf['discount']*$row['sale'];
            $min=$levelInf['min_sell']*$row['sale'];
            $max=$levelInf['max_sell']*$row['sale'];
        }
        $wholesale[]=array(
            'g_id'=>$row['g_id'],
            'made_in'=>$row['made_in'],
            'produce_id'=>$row['produce_id'],
            'url'=>$row['url'],
            'sale'=>$row['sale'],
            'wholesale'=>$ws,
            'min_sell'=>$min,
            'max_sell'=>$max
        );
    }
//    mylog(getArrayInf($wholesale));
    return $wholesale;
}

function twoBfilter($sdp_id,$g_id){
    $sale=pdoQuery('g_detail_tbl',array('sale'),array('g_id'=>$g_id),' limit 1');
    $sale=$sale->fetch();
    $wholeSale=pdoQuery('sdp_wholesale_tbl',null,array('level_id'=>$_SESSION['sdp']['level'],'g_id'=>$g_id),' limit 1');
    if($ws=$wholeSale->fetch()){
        $cost=$ws['price'];
    }else{
        $cost=$sale['sale']*$_SESSION['sdp']['manage']['discount'];
    }
    $priceQuery=pdoQuery('sdp_price_tbl',null,array('sdp_id'=>sdp_id,'g_id'=>g_id),' limit 1');
    if($p=$priceQuery->fetch()){
        $price=$p['price'];
    }else{
        $price=$sale['sale'];
    }
    $gainshareList=getGainshareConfig($sdp_id,$g_id);
    $totalGs=0;
    foreach ($gainshareList as $row) {
     $totalGs+=$row['value'];
    }
    $cCost=(1-$totalGs)*$price;
    if($cCost<$cost){
        pdoDelete('sdp_gainshare_tbl',array('root'=>$sdp_id,'g_id'=>$g_id));
        return false;
    }else{
        return true;
    }


}
