<?php
include("../conf.php");
include("../includes/DB.class.php");
include("../includes/Produk.class.php");
$produk = new Produk($db_host, $db_user, $db_password, $db_name);
$produk->open();

if (isset($_POST['kode'])) {
   $produk->updateStokProduk($_POST['kode'], $_POST['tstok']);
   echo json_encode(['success' => 'Sukses']);
}

?>