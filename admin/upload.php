<?php
include_once '../includePackage.php';
include_once 'upload.class.php';
session_start();
if(isset($_SESSION['login'])) {
    $uploader= new uploader();
    if (isset($_POST['altAd'])) {

        if (isset($_FILES['adPic'])) {
            $file = $_FILES['adPic'];
            if (fileFilter($file, array('image/gif', 'image/jpeg', 'image/pjpeg','image/png'), 500000)) {
                $temp = move_uploaded_file($file['tmp_name'], $_POST['adImg']);
                if (false == $temp) mylog('fileerrer');
            }
        }
        if (isset($_POST['g_id'])) {
            pdoUpdate('ad_tbl', array('g_id' => $_POST['g_id']), array('id' => $_POST['altAd']));
        }
        header('location:index.php?ad=1');
        exit;
    }
    if (isset($_GET['infImgUpload'])){
        $file=$_FILES['upfile'];
        $uploader->upFile(time().rand(1000,9999));
        $inf=$uploader->getFileInfo();
        $jsonInf=json_encode($inf,JSON_UNESCAPED_UNICODE);
        echo $jsonInf;
        if('SUCCESS'==$inf['state']) {
            pdoInsert('inf_image_tbl', array('url' => $inf['url'], 'remark' => $inf['md5']), 'ignore');
        }
        exit;
    }
    if(isset($_FILES['g-img-up'])){
        $uploader=new uploader('g-img-up');
        $uploader->upFile($_GET['g_id'].'_'.time().rand(1000,9999));
        $inf=$uploader->getFileInfo();

        if('SUCCESS'==$inf['state']) {
            $query=pdoQuery('image_view',array('g_id'),array('g_id'=>$_GET['g_id']),null);
            $is_cover='0';
            if(!$query->fetch()){
                $is_cover='1';
                $inf['cover']=true;
            }
           $id= pdoInsert('g_image_tbl', array('g_id' => $_GET['g_id'], 'url' => $inf['url'], 'remark' => $inf['md5'],'front_cover'=>$is_cover), '');
            $inf['id']=$id;
        }
        $jsonInf=json_encode($inf,JSON_UNESCAPED_UNICODE);
        mylog($jsonInf);
        echo $jsonInf;
        exit;
    }
    if(isset($_FILES['front-img-up'])){
        $uploader=new uploader('front-img-up');
        $uploader->upFile('9999_'.time().rand(1000,9999));
        mylog('frontUp');
        $inf=$uploader->getFileInfo();
        if('SUCCESS'==$inf['state']) {
            $id= pdoInsert('ad_tbl', array('category'=>'banner', 'img_url' => $inf['url']), '');
            $inf['id']=$id;
        }
//        header('contentType:application/json');
        $jsonInf=json_encode($inf,JSON_UNESCAPED_UNICODE);
        mylog('imgUploaded:'.$jsonInf);
        echo $jsonInf;
        exit;
    }

    if(isset($_FILES['parts-img-up'])){
        $uploader=new uploader('parts-img-up');
        $uploader->upFile($_GET['g_id'].'_'.time().rand(1000,9999));
        $inf=$uploader->getFileInfo();
        $jsonInf=json_encode($inf,JSON_UNESCAPED_UNICODE);

        if('SUCCESS'==$inf['state']) {
            mylog('success');
            $temp=pdoQuery('g_image_tbl',null,array('g_id'=>$_GET['g_id']),'limit 1');
            if(!$row=$temp->fetch()){
                pdoInsert('g_image_tbl', array('g_id' => $_GET['g_id'], 'url' => $inf['url'], 'remark' => $inf['md5']), 'ignore');
                mylog("create record");
            }else{
                pdoUpdate('g_image_tbl',array('remark'=>$inf['md5'],'url'=>$inf['url']),array('g_id'=>$_GET['g_id']));
                $query=pdoQuery('image_view',null,array('remark'=>$row['remark']), ' limit 1');
                if(!$t=$query->fetch()){
                    unlink('../'.$row['url']);
                    mylog('unlink"../'.$row['url']);
                }else{
                    mylog('not unlink');
                }

            }

        }
        mylog($jsonInf);
        echo $jsonInf;
        exit;
    }
//    if (isset($_GET['g_id'])){
//
//    }

//    if (isset($_POST['g_id']) && $_POST['g_id'] != '-1') {
//        $file = $_FILES['spic'];
//        $inf = '';
//        for ($i = 0; $i < count($file['name']); $i++) {
//            if ((($file["type"][$i] == "image/png")
//                    || ($file["type"][$i] == "image/jpeg")
//                    || ($file["type"][$i] == "image/pjpeg"))
//                && ($file["size"][$i] < 500000)
//            ) {
//                if ($file["error"][$i] > 0) {
//                    $inf = "Return Code: " . $file["error"][$i] . "<br />";
//                    echo $inf;
//                    exit;
//                } else {
//                    $img_name = $_POST['g_id'] . '_' . md5($file["name"][$i]) . '.jpg';
//                    $img_md5=md5_file($file["tmp_name"][$i]);
//                    if ($uploader->checkFileMd5($img_md5)) {
//                        $url=$uploader->getUrl();
//                    } else {
//                        $url="g_img/" . $img_name;
//                        move_uploaded_file($file["tmp_name"][$i],
//                           '../'. $url);
//                    }
//                    $row=array('g_id'=>$_POST['g_id'],'url'=>$url,'remark'=>md5_file("../g_img/" . $img_name));
//                    $insertArray[]=$row;
//
//                }
//            }
//
//        }
//        header("Content-Type:text/html;charset=utf-8");
//        pdoBatchInsert('g_image_tbl',$insertArray);
//    }
    $g_id = $_POST['g_id'];
    header('location:index.php?goods-config=1&g_id=' . $g_id);
    exit;
}
function fileFilter($file, array $type, $size)
{
    if (in_array($file['type'], $type) && $file['size'] < $size) {
        if ($file['error'] > 0) {
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}
?>