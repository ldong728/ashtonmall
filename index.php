<?php

//$mypath = $_SERVER['DOCUMENT_ROOT'] . '/mmzrb';   //用于直接部署
//include_once $mypath . '/includes/magicquotes.inc.php';
//include_once $mypath . '/includes/db.inc.php';
//include_once $mypath . '/includes/helpers.inc.php';
//include_once $mypath . '/view/layout.php';
session_start();

if (isset($_GET['country'])) {
    $sql_country = $_GET['country'];
    $sql = 'SELECT g_inf_tbl.id as id,g_inf_tbl.name,g_inf_tbl.made_in,g_inf_tbl.inf,g_price_tbl.sell,g_image_tbl.url
    FROM g_inf_tbl INNER JOIN g_price_tbl ON g_inf_tbl.id = g_price_tbl.id LEFT JOIN g_image_tbl ON g_image_tbl.g_id = g_inf_tbl.id
    WHERE g_inf_tbl.made_in ="'.$sql_country.'" AND url IS NOT null';
    $query = $pdo->query($sql);
    include 'view/index.html.php';
    exit;
	
}
if(isset($_GET['login'])){
   include 'view/login.html.php';
    exit;

}

if(isset($_POST['signin'])){




}

/*SELECT g_inf_tbl.id as id,g_inf_tbl.name,g_inf_tbl.inf,g_price_tbl.sell,g_image_tbl.url
FROM g_inf_tbl INNER JOIN g_price_tbl ON g_inf_tbl.id = g_price_tbl.id LEFT JOIN g_image_tbl ON g_image_tbl.g_id = g_inf_tbl.id

*/
if(isset($_GET['detel'])){
    $g_name = "";
    $sql = 'SELECT g_inf_tbl.id as id,g_inf_tbl.name,g_inf_tbl.inf,g_price_tbl.sell,g_image_tbl.url
    FROM g_inf_tbl INNER JOIN g_price_tbl ON g_inf_tbl.id = g_price_tbl.id LEFT JOIN g_image_tbl ON g_image_tbl.g_id = g_inf_tbl.id
    WHERE g_inf_tbl.id ="'.$_GET['g_id'].'" AND url IS NOT null';
    $query = $pdo->query($sql);
    foreach ($query as $row) {
        $img[]=$row['url'];
        if($g_name!=$row['name']){
            $g_name=$row['name'];
            $g_inf=$row['inf'];
            $g_price=$row['sell'];

        }else{
            continue;
        }
    }
    include 'view/goodsInf.html.php';
    exit;

}
echo 'nothing';

//include 'view/temp.html.php';
?>
