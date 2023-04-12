<?php
require_once "core/init.php";

require_once "view/header.php";

$query = mysqli_query($link, "SELECT * FROM tb_barang");
$error = '';

if (isset($_POST['simpan'])){
    $id = $_POST['id'];
    $jumlah = $_POST['jumlah'];
    $user = $_SESSION['user'];
    $tgl = $_POST['tgl'];

    $sql = "INSERT INTO tb_transaksi_keluar (id_barang, jumlah, username, tgl) VALUES ('$id', '$jumlah', '$user', '$tgl')";

    if (mysqli_query($link, $sql)) {
        $stok = mysqli_query($link, "SELECT jumlah FROM tb_barang WHERE id='$id'");
        $peng = mysqli_fetch_assoc($stok);
        $stok_new = (int)$peng['jumlah'] - $jumlah;

        mysqli_query($link, "UPDATE tb_barang SET jumlah='$stok_new' WHERE id='$id'");
        header("location: brgkeluar.php"); 
    }else{
            echo "terjadi kesalahan";
        }
    }
    ?>

<div class="brg" align="center">
    <h2>Barang Keluar</h2>
<form action=""method="post" enctype="multipart/form-data">
    <label for="">Barang</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <select id="barang" name="id"><br><br>
    <?php
    $hasil = mysqli_query($link, "SELECT * FROM tb_barang");
    while($data = mysqli_fetch_assoc($hasil)){
        ?>
        <option value="<?= $data['id'] ?>"><?= $data['nama'] ?></option>
        <?php
    }
    ?>
    <br><br>
    <label for="">Tanggal</label>
    <input type="date" name="tgl"><br><br>
    <label for="">Jumlah</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="text" name="jumlah"><br><br>
    <div id="error">
        <?=$error ?>
    </div>
    <input type="submit" name="simpan" valua="submit">
    </form>
    </div>
<?php 
require_once "view/footer.php";
?>  