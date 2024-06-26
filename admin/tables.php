<!-- # @Author: Wahid Ari <wahidari>
# @Date:   8 January 2018, 5:05
# @Copyright: (c) wahidari 2018 -->
<?php
    // database
    require_once("database.php");
    require_once("auth.php"); // Session
    logged_admin ();
    // global var
    global $nomor, $foundreply;
    // hapus Balasan laporan berdasarkan id Balasan laporan
    if (isset($_POST['HapusTanggapan'])) {
        $id_hapus_tanggapan = $_POST['id_tanggapan'];
        $id_hapus_tanggapan_laporan = $_POST['id_hapus_tanggapan_laporan'];
        // hapus tanggapan dari tabel tanggapan
        $statement = $db->query("DELETE FROM `tanggapan` WHERE `tanggapan`.`id_tanggapan` = $id_hapus_tanggapan");
        $statt = $db->query("SELECT * FROM `tanggapan` WHERE id_laporan = $id_hapus_tanggapan_laporan");
        $cek = $statt->fetch(PDO::FETCH_ASSOC);
        // jika user terdaftar
        if(!$cek){
            $update = $db->query("UPDATE `laporan` SET `status` = 'Menunggu' WHERE `laporan`.`id` = $id_hapus_tanggapan_laporan");
        }
    }

    // hapus laporan berdasarkan id laporan
    if (isset($_POST['Hapus'])) {
        $id_hapus = $_POST['id_laporan'];
        // hapus semua tanggapan dari laporan yang akan dihapus
        $statement = $db->query("DELETE FROM `tanggapan` WHERE `tanggapan`.`id_laporan` = $id_hapus");
        // hapus laporan
        $statement = $db->query("DELETE FROM `laporan` WHERE `laporan`.`id` = $id_hapus");
    }

    // tanggapi laporan
    if (isset($_POST['Balas'])) {
        // insert tabel tanggapan
        $id_laporan = $_POST['id_laporan'];
        $isi_tanggapan = $_POST['isi_tanggapan'];
        $admin = "Admin";
        $sql = "INSERT INTO `tanggapan` (`id_tanggapan`, `id_laporan`, `admin`, `isi_tanggapan`, `tanggal_tanggapan`) VALUES (NULL, :id_laporan, :admin, :isi_tanggapan, CURRENT_TIMESTAMP)";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id_laporan', $id_laporan);
        $stmt->bindValue(':admin', $admin);
        $stmt->bindValue(':isi_tanggapan', htmlspecialchars($isi_tanggapan));
        $stmt->execute();
        // jika ada tanggapan, update status laporan menjadi ditanggapi
        $statement = $db->query("UPDATE `laporan` SET `status` = 'Ditanggapi' WHERE `laporan`.`id` = $id_laporan");
        // kembali ke page tables
        header("Location: tables");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="images/favicon.ico">
  <title>Table - Pengaduan Dispenduk Bangkalan</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="table.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer" id="page-top">
  <!-- Navigation-->
  <header>
    <nav class="navbar" id="mainNav">
      <a class="judul" href="index">Pemkot Surabaya</a>
      </button>
      <a class="btn-sigOut" href="logout">
        <i class="fa fa-fw fa-sign-out"></i>Logout
      </a>
    </nav>
  </header>
  <main class="container-isi">
    <aside class="containerAside">
      <div class="profile-main">
        <img alt="image" src="images/avatar1.png" width="80">
        <div class="wrapper-nameAdmin">
          <p>Admin <span><?php echo $divisi; ?></span></p>
        </div>

      </div>
      <nav class="nav-admin">
        <ul>
          <li>
            <a href="index">
              <i class="fa fa-fw fa-dashboard"></i>
              <span class="nav-link-text">Dashboard</span>
            </a>
          </li>
          <li>
            <a href="tables">
              <i class="fa fa-fw fa-table"></i>
              <span class="nav-link-text">Tables</span>
            </a>
          </li>
          <li>
            <a href="export">
              <i class="fa fa-fw fa-print"></i>
              <span class="nav-link-text">Export</span>
            </a>
          </li>
        </ul>
      </nav>
    </aside>
    <section>
      <!-- Body -->
      <div class="content-wrapper">
        <div class="container-fluid">

          <!-- DataTables Card-->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-table"></i> Laporan Masuk
            </div>
            <table class="table " id="dataTable">
              <thead>
                <tr>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Telpon</th>
                  <th>Isi Laporan</th>
                  <th>Tanggal</th>
                  <th class="sorting_asc_disabled sorting_desc_disabled">Status</th>
                  <th class="th-no-border sorting_asc_disabled sorting_desc_disabled"></th>
                  <th class="th-no-border sorting_asc_disabled sorting_desc_disabled" style="text-align:right">Aksi
                  </th>
                  <th class="sorting_asc_disabled sorting_desc_disabled"></th>
                </tr>
              </thead>
              <tbody>

                <?php
// Ambil semua record dari tabel laporan

    if ($id_admin > 0) {
        $statement = $db->query("SELECT * FROM laporan, divisi WHERE laporan.tujuan = divisi.id_divisi AND laporan.tujuan = $id_admin ORDER BY laporan.id DESC");
    } else {
        $statement = $db->query("SELECT * FROM `laporan` ORDER BY id DESC");
    }
    foreach ($statement as $key ) {
        $mysqldate = $key['tanggal'];
        $phpdate = strtotime($mysqldate);
        $tanggal = date( 'd/m/Y', $phpdate);
        $status  = $key['status'];
        if($status == "Ditanggapi") {
            $style_status = "<p style=\"background-color:#009688;color:#fff;padding-left:2px;padding-right:2px;padding-bottom:2px;margin-top:16px;font-size:15px;font-style:italic;\">Ditanggapi</p>";
        } else {
            $style_status = "<p style=\"background-color:#FF9800;color:#fff;padding-left:2px;padding-right:2px;padding-bottom:2px;margin-top:16px;font-size:15px;font-style:italic;\">Menunggu</p>";
        }
?>
                <tr>
                  <td><?php echo $key['nama']; ?></td>
                  <td><?php echo $key['email']; ?></td>
                  <td><?php echo $key['telpon']; ?></td>
                  <td><?php echo $key['isi']; ?></td>
                  <td><?php echo $tanggal; ?></td>
                  <td><?php echo $style_status; ?></td>
                  <td class="td-no-border">
                    <button type="button" class="btn-detail" data-toggle="modal"
                      data-target="#ModalDetail<?php echo $key['id']; ?>">
                      Detail
                    </button>
                  </td>
                  <td class="td-no-border">
                    <button type="button" class="btn-balas" data-toggle="modal"
                      data-target="#ModalBalas<?php echo $key['id']; ?>">
                      Balas
                    </button>
                  </td>
                  <td class="td-no-border">
                    <button type="button" class="btn-hapus" data-toggle="modal"
                      data-target="#ModalHapus<?php echo $key['id']; ?>">
                      Hapus
                    </button>
                  </td>
                </tr>
                <?php
    }
?>
              </tbody>
            </table>
            <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
          </div>
        </div>
    </section>
  </main>


  <!-- /.container-fluid-->

  <!-- Isi masing2 modal, detail, balas dan hapus -->
  <?php
            if ($id_admin > 0) {
                $statement = $db->query("SELECT * FROM laporan, divisi WHERE laporan.tujuan = divisi.id_divisi AND laporan.tujuan = $id_admin ORDER BY laporan.id DESC");
            } else {
                $statement = $db->query("SELECT * FROM laporan, divisi WHERE laporan.tujuan = divisi.id_divisi ORDER BY laporan.id DESC");
            }

            foreach ($statement as $key ) {
                // cek apakah laporan sudah ditanggapi atau belum
                $nomor = $key['id'];
                $stat = $db->query("SELECT * FROM `tanggapan` WHERE id_laporan = $nomor");
                if ($stat->rowCount() > 0) {
                    // jika laporan sudah ditanggapi, maka tampilkan tanggapan di modal detail laporan
                    $foundreply = true;
                }
        ?>

  <!--Modal Detail-->
  <div class="modal fade" id="ModalDetail<?php echo $key['id']; ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg " role="document">
      <div class="modal-content">
        <div class="modal-header ">
          <h5 class="modal-title text-center">Detail Laporan</h5>
        </div>
        <div class="modal-body">
          <p class="custom"><b>Nama :</b></p>
          <p class="custom"><?php echo $key['nama']; ?></p>
          <hr class="custom">
          <p class="custom"><b>Email :</b></p>
          <p class="custom"><?php echo $key['email']; ?></p>
          <hr class="custom">
          <p class="custom"><b>Telpon :</b></p>
          <p class="custom"><?php echo $key['telpon']; ?></p>
          <hr class="custom">
          <p class="custom"><b>Alamat :</b></p>
          <p class="custom"><?php echo $key['alamat']; ?></p>
          <hr class="custom">
          <p class="custom"><b>Tujuan :</b></p>
          <p class="custom"><?php echo $key['nama_divisi']; ?></p>
          <hr class="custom">
          <p class="custom"><b>Isi Laporan :</b></p>
          <p class="custom"><?php echo $key['isi']; ?></p>
          <hr class="custom">
          <p class="custom"><b>Tanggal :</b></p>
          <p class="custom"><?php echo $key['tanggal']; ?></p>
          <?php
                            // tampilkan tanggapan jika sudah ada tanggapan
                            if($foundreply) {
                                foreach ($stat as $keyy) {
                                ?>
          <hr class="custom">
          <p class="custom"><b>Tanggapan :</b></p>
          <p class="custom"><?php echo $keyy['isi_tanggapan']; ?></p>
          <form method="post">
            <input type="hidden" name="id_hapus_tanggapan_laporan" value="<?php echo $keyy['id_laporan']; ?>">
            <input type="hidden" name="id_tanggapan" value="<?php echo $keyy['id_tanggapan']; ?>">
            <input type="submit" class="btn btn-danger btn-sm card-shadow-2" name="HapusTanggapan" value="Hapus">
          </form>
          <?php
                                }
                            }
                         ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-close btn-sm card-shadow-2" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
  <!--./Modal Detail-->

  <!-- Modal Balas -->
  <div class="modal fade" id="ModalBalas<?php echo $key['id']; ?>" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Balas Laporan</h5>
        </div>
        <div class="modal-body">
          <form method="post">
            <div class="form-group">
              <p><b>Nama Pelapor:</b></p>
              <?php echo $key['nama']; ?>
              <hr>
            </div>
            <div class="form-group">
              <p><b>Isi Laporan :</b></p>
              <p>"<?php echo $key['isi']; ?>"</p>
              <hr>
            </div>
            <div class="form-group">
              <p><b>Tanggapan :</b></p>
              <textarea class="form-control" name="isi_tanggapan" placeholder="Isi Tanggapan" required></textarea>
            </div>
            <div class="modal-footer">
              <input type="hidden" name="id_laporan" value="<?php echo $key['id']; ?>">
              <input type="submit" class="btn btn-primary-custom card-shadow-2 btn-sm" name="Balas" value="Balas">
              <button type="button" class="btn btn-close btn-sm card-shadow-2" data-dismiss="modal">Batal</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- ./Modal Balas -->

  <!--Modal Hapus-->
  <div class="modal fade" id="ModalHapus<?php echo $key['id']; ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm " role="document">
      <div class="modal-content">
        <div class="modal-header ">
          <h5 class="modal-title text-center">Hapus Laporan</h5>
        </div>
        <div class="modal-body">
          <p class="text-center">Hapus Pengaduan</p>
          <p class="text-center">Dari <b><?php echo $key['nama']; ?></b> ?</p>
        </div>
        <div class="modal-footer">
          <form method="post">
            <input type="hidden" name="id_laporan" value="<?php echo $key['id']; ?>">
            <input type="submit" class="btn btn-danger btn-sm card-shadow-2" name="Hapus" value="Hapus">
            <button type="button" class="btn btn-close btn-sm card-shadow-2" data-dismiss="modal">Batal</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- ./Modal Hapus-->
  <?php
            }
        ?>

  <footer class="sticky-footer">
    <div class="container">
      <div class="text-center">
        <small>Copyright © Dispenduk Bangkalan 2018</small>
      </div>
    </div>
  </footer>

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fa fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Yakin Ingin Keluar?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Pilih "Logout" jika anda ingin mengakhiri sesi.</div>
        <div class="modal-footer">
          <button class="btn btn-close card-shadow-2 btn-sm" type="button" data-dismiss="modal">Batal</button>
          <a class="btn btn-primary btn-sm card-shadow-2" href="logout">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- Page level plugin JavaScript-->
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="js/admin.js"></script>
  <!-- Custom scripts for this page-->
  <script src="js/admin-datatables.js"></script>

  </div>
  <!-- /.content-wrapper-->
</body>

</html>