<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "tugas_akhir";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$id_produsen        = "";
$nama               = "";
$kontak             = "";
$alamat             = "";
$barang             = "";

$sukses     = "";
$error      = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if ($op == 'delete') {
    $id   = $_GET['id']; // Corrected to use 'id' instead of '$id'
    $sql  = "delete from data_produsen where id_produsen = '$id'";
    $q    = mysqli_query($koneksi, $sql);
    if ($q) {
        echo "<script>alert('Data Berhasil Dihapus'); document.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Data Gagal Dihapus'); document.location.href='index.php';</script>";
    }
}

if ($op == 'edit') {
    $id    = $_GET['id']; // Corrected to use 'id' instead of '$id'
    $sql   = "select * from data_produsen where id_produsen = '$id'";
    $q     = mysqli_query($koneksi, $sql);
    $r     = mysqli_fetch_array($q);

    $id_produsen = $r['id_produsen'];
    $nama = $r['nama'];
    $kontak = $r['kontak'];
    $alamat = $r['alamat'];
    $barang = $r['barang'];
}

if (isset($_POST['simpan'])) {
    $id_produsen = isset($_POST['id_produsen']) ? $_POST['id_produsen'] : "";
    $nama          = $_POST['nama'];
    $kontak        = $_POST['kontak'];
    $alamat        = $_POST['alamat'];
    $barang        = $_POST['barang'];

    // Check if ID Supplier already exists for updating
    $check_sql = "SELECT * FROM data_produsen WHERE id_produsen = '$id_produsen'";
    $check_result = mysqli_query($koneksi, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // ID Supplier exists, proceed with the UPDATE
        $update_sql = "UPDATE data_produsen SET nama = '$nama', kontak = '$kontak', alamat = '$alamat', barang = '$barang' WHERE id_produsen = '$id_produsen'";
        $update_result = mysqli_query($koneksi, $update_sql);

        if ($update_result) {
            $sukses = "Data produsen Berhasil Diedit";
        } else {
            $error = "Data produsen Gagal Diedit";
        }
    } else {
        // ID Supplier doesn't exist, insert new data
        $insert_sql = "INSERT INTO data_produsen (id_produsen, nama, kontak, alamat, barang) VALUES ('$id_produsen', '$nama', '$kontak', '$alamat', '$barang')";
        $insert_result = mysqli_query($koneksi, $insert_sql);

        if ($insert_result) {
            $sukses = "Data produsen Berhasil Disimpan";
        } else {
            $error = "Data produsen Gagal Disimpan";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Supplier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 950px;
        }

        .card {
            margin-top: 20px;
            text-align: center;
        }

        .card-body {
            text-align: center;
        }

        .table {
            text-align: center;
            margin: auto;
        }
    </style>
</head>

<body>
    <!-- untuk memasukkan data -->
    <div class="card">
        <div class="card-header">
            Masukkan Data
        </div>
        <div class="card-body">
            <?php
            if ($error) {
            ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error ?>
                </div>
            <?php
                header("refresh:5;url=index.php"); //5 : detik
            }
            ?>
            <?php
            if ($sukses) {
            ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $sukses ?>
                </div>
            <?php
                header("refresh:5;url=index.php");
            }
            ?>
            <form action="index.php" method="POST">
                <div class="mb-3 row">
                    <label for="id_produsen" class="col-sm-2 col-form-label">ID Produsen</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="id_produsen" name="id_produsen" value="<?php echo $id_produsen ?>">

                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="nama" class="col-sm-2 col-form-label">Nama Produsen</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="kontak" class="col-sm-2 col-form-label">kontak</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="kontak" name="kontak" value="<?php echo $kontak ?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat ?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="barang" class="col-sm-2 col-form-label">Barang</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="barang" name="barang" value="<?php echo $barang ?>">
                    </div>
                </div>
                <div class="col-12">
                    <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                </div>
            </form>
        </div>
    </div>

    <!-- untuk mengeluarkan data -->
    <div class="card">
        <div class="card-header text-white bg-secondary">
            Output Data
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ID Produsen</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Kontak</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">barang</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql2   = "SELECT * FROM data_produsen ORDER BY id_produsen ASC"; // ASC untuk urutan ascending, DESC untuk descending
                    $q2     = mysqli_query($koneksi, $sql2);
                    $urut   = 1;
                    while ($r2 = mysqli_fetch_array($q2)) {
                        $id_produsen   = $r2['id_produsen'];
                        $nama          = $r2['nama'];
                        $kontak        = $r2['kontak'];
                        $alamat        = $r2['alamat'];
                        $barang        = $r2['barang'];

                    ?>
                        <tr>
                            <th scope="row"><?php echo $urut++ ?></th>
                            <td scope="row"><?php echo $id_produsen ?></td>
                            <td scope="row"><?php echo $nama ?></td>
                            <td scope="row"><?php echo $kontak ?></td>
                            <td scope="row"><?php echo $alamat ?></td>
                            <td scope="row"><?php echo $barang ?></td>
                            <td scope="row">
                                <a href="index.php?op=edit&id=<?php echo $id_produsen ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                <a href="index.php?op=delete&id=<?php echo $id_produsen ?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>

            </table>
        </div>
    </div>
    </div>
</body>

</html>