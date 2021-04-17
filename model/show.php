<?php
include("../conf.php");
include("../includes/DB.class.php");
include("../includes/Produk.class.php");

$produk = new Produk($db_host, $db_user, $db_password, $db_name);
$produk->open();

if(isset($_POST['product_id'])){
   $produk->getProdukById($_POST['product_id']);
   $row =$produk->getResult();
   echo json_encode($row);
}

?>