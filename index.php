<?php

/******************************************
PRAKTIKUM RPL
 ******************************************/

include("conf.php");
include("includes/Template.class.php");
include("includes/DB.class.php");
include("includes/Produk.class.php");

// Membuat objek dari kelas task
$produk = new Produk($db_host, $db_user, $db_password, $db_name);
$produk->open();

// add data
if (isset($_POST['add'])) {
	$kode = $_POST['tkode'];
	$nama = $_POST['tname'];
	$stok = $_POST['tstok'];
	$harga = $_POST['tharga'];
	$expired = $_POST['texpired'];
	$kategori = $_POST['tkategori'];
	$deskripsi = $_POST['tdesc'];
	$produk->addProduk($kode, $nama, $stok, $harga, $expired, $kategori, $deskripsi);
}

// delete data
if (isset($_GET['id_hapus'])) {
	$produk->deleteProduk($_GET['id_hapus']);
	unset($_GET['id_hapus']);
	header("Location:index.php");
}

// Set data stok
if (isset($_GET['id_status'])) {
	$produk->updateStokProduk($_GET['id_status']);
}

$produk->getProduk();

// Proses mengisi tabel dengan data
$data = null;
$no = 1;

while (list($id, $kode, $tnama, $tstok, $tharga, $texpired, $tkategori, $tdeskripsi, $tstatus) = $produk->getResult()) {
	$tstatus = $tstatus ? 'Available' : 'Empty';
	// Tampilan jika kategori Produk nya sudah dikerjakan
	if ($tstatus !== 'Available') {
		$data .= "<tr>
		<td>" . $no . "</td>
		<td>" . $kode . "</td>
		<td>" . $tnama . "</td>	
		<td>" . $texpired . "</td>
		<td>" . $tstok . "</td>
		<td>" . $tkategori . "</td>
		<td> Rp" . $tharga . "</td>
		<td><div class='bg-danger font-weight-bold p-1 text-white rounded' style='font-size: .7em;'>" . $tstatus . "</td>
		<td>" . $tdeskripsi . "</td>
		<td>
		<button class='btn btn-danger btn-sm mb-3 col-md-12'><a href='index.php?id_hapus=" . $kode . "' style='color: white; font-weight: bold;'>Delete</a></button>
		<button class='btn btn-info btn-sm col-md-12' data-toggle='modal' data-target='#modalStock' id='" . $id . "' style='color: white; font-weight: bold;'>Set Stock</button>
		</td>
		</tr>";
		$no++;
	}

	// Tampilan jika kategori Produk nya tidak ada stok
	else {
		$data .= "<tr>
		<td>" . $no . "</td>
		<td>" . $kode . "</td>
		<td>" . $tnama . "</td>
		<td>" . $texpired . "</td>
		<td>" . $tstok . "</td>
		<td>" . $tkategori . "</td>
		<td> Rp" . $tharga . "</td>
		<td><div class='bg-success font-weight-bold p-1 text-white rounded' style='font-size: .7em;'>" . $tstatus . "</div></td>
		<td>" . $tdeskripsi . "</td>
		<td>
		<button class='btn btn-sm btn-danger mb-3 col-md-12'><a href='index.php?id_hapus=" . $kode . "' style='color: white; font-weight: bold;'>Delete</a></button>
		<button class='btn btn-sm btn-warning mb-3 col-md-12' ><a href='index.php?id_status=" . $kode .  "' style='color: white; font-weight: bold;'>Out of Stock</a></button>
		<button class='btn btn-info btn-sm col-md-12' data-toggle='modal' data-target='#modalStock' id='". $id ."' style='color: white; font-weight: bold;'>Set Stock</button>
		
		</td>
		</tr>";
		$no++;
	}
}
$data .= '<!-- Modal -->
  <div class="modal fade" id="modalStock" tabindex="-1" aria-labelledby="modalStockLabel" aria-hidden="true">

    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalStockLabel">
            Set Stock
          </h5>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">
              ×
            </span>
          </button>
        </div>

        <div class="modal-body">
          <!-- Data passed is displayed in this part of the modal body -->
          <div id="modal_body">
            <form method="POST" id="form-data">
              <div class="form-group">
                <label for="tstok">Stock</label>
                <input class="form-control" type="number" name="tstok" id="tstok">
					 <input type="hidden" name="kode" id="kode">
              </div>
              <button type="button" data-toggle="modal" data-target="#modalStock" class="btn btn-success btn-sm" id="update">
                Update
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>';

// Menutup koneksi database
$produk->close();

// Membaca template skin.html
$tpl = new Template("templates/skin.html");

// Mengganti kode Data_Tabel dengan data yang sudah diproses
$tpl->replace("DATA_TABEL", $data);

// Menampilkan ke layar
$tpl->write();
