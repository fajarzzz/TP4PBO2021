<?php 

/******************************************
TUGAS PRAKTIKUM DPBO
******************************************/

class Produk extends DB{
	
	// Mengambil data
	function getProduk(){
		// Query mysql select data ke prduk
		$query = "SELECT * FROM produk";

		// Mengeksekusi query
		return $this->execute($query);
	}

	function getProdukById($id){
		$query = "SELECT * FROM produk WHERE id='$id';";

		return $this->execute($query);
	}
	
	function addProduk($kode, $name, $stok, $harga, $expired, $kategori, $deskripsi){
		$status = $stok !== 0 ? 1 : 0;
		$query = "INSERT INTO produk (kode_pd, nama_pd, stok_pd, harga_pd, expired_pd, kategori_pd, deskripsi_pd, status_pd) VALUES ('$kode','$name', '$stok', '$harga', '$expired', '$kategori', '$deskripsi', '$status');";
		return $this->execute($query);
	}

	function deleteProduk($kode){
		$query = "DELETE FROM produk WHERE kode_pd='$kode';";
		return $this->execute($query);
	}
	
	function updateStokProduk($kode, $jlh=0){
		$status = $jlh === 0 ? 0 : 1;
		$query = "UPDATE produk SET stok_pd=$jlh, status_pd=$status WHERE kode_pd='$kode';";
		return $this->execute($query);
	}

	function getProdukOrderByCol($col){
		$query = "SELECT * FROM produk ORDER BY $col ASC;";
		return $this->execute($query);
	}
}



?>
