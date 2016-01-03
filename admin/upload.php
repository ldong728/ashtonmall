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
        pdoInsert('inf_image_tbl',array('url'=>$inf['urlInDb'],'remark'=>$inf['md5']),'ignore');
        exit;
    }
    if(isset($_FILES['g-img-up'])){
        $file=$_FILES['g-img-up'];
        $uploader=new uploader('g-img-up');
        $uploader->upFile(time().rand(1000,9999));
        $inf=$uploader->getFileInfo();
        $jsonInf=json_encode($inf,JSON_UNESCAPED_UNICODE);
        echo $jsonInf;
        pdoInsert('g_image_tbl',array('g_id'=>$_GET['g_id'],'url'=>$inf['urlInDb'],'remark'=>$inf['md5']),'ignore');
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