<!-- # @Author: Wahid Ari <wahidari>
# @Date:   8 January 2018, 5:05
# @Copyright: (c) wahidari 2018 -->
<?php
    require_once("database.php"); // koneksi DB
    require_once("auth.php"); // Session
    logged_admin ();
    global $total_laporan_masuk, $total_laporan_menunggu, $total_laporan_ditanggapi;
    if ($id_admin > 0) {
        foreach($db->query("SELECT COUNT(*) FROM laporan WHERE laporan.tujuan = $id_admin") as $row) {
            $total_laporan_masuk = $row['COUNT(*)'];
        }

        foreach($db->query("SELECT COUNT(*) FROM laporan WHERE status = \"Ditanggapi\" AND laporan.tujuan = $id_admin") as $row) {
            $total_laporan_ditanggapi = $row['COUNT(*)'];
        }

        foreach($db->query("SELECT COUNT(*) FROM laporan WHERE status = \"Menunggu\" AND laporan.tujuan = $id_admin") as $row) {
            $total_laporan_menunggu = $row['COUNT(*)'];
        }
    } else {
        foreach($db->query("SELECT COUNT(*) FROM laporan") as $row) {
            $total_laporan_masuk = $row['COUNT(*)'];
        }

        foreach($db->query("SELECT COUNT(*) FROM laporan WHERE status = \"Ditanggapi\"") as $row) {
            $total_laporan_ditanggapi = $row['COUNT(*)'];
        }

        foreach($db->query("SELECT COUNT(*) FROM laporan WHERE status = \"Menunggu\"") as $row) {
            $total_laporan_menunggu = $row['COUNT(*)'];
        }
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
  <title>Dashboard</title>
  <link rel="stylesheet" href="css/index.css">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>

<body id="page-top">
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
            <a class="nav-link" href="index">
              <i class="fa fa-fw fa-dashboard"></i>
              <span class="nav-link-text">Dashboard</span>
            </a>
          </li>
          <li>
            <a class="nav-link" href="tables">
              <i class="fa fa-fw fa-table"></i>
              <span class="nav-link-text">Tables</span>
            </a>
          </li>
          <li>
            <a class="nav-link" href="export">
              <i class="fa fa-fw fa-print"></i>
              <span class="nav-link-text">Export</span>
            </a>
          </li>
        </ul>
      </nav>
    </aside>
    <!-- container data -->
    <section>
      <article class="container-card">
        <div class="card">
          <div class="card-body">
            <div class="mr-5"><?php echo $total_laporan_masuk; ?> Laporan Masuk</div>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <div class="mr-5"><?php echo $total_laporan_menunggu; ?> Belum Ditanggapi</div>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <div class="mr-5"><?php echo $total_laporan_ditanggapi; ?> Sudah Ditanggapi</div>
          </div>
        </div>
      </article>
      <article class="container-dataTable">
        <div>
          <h2 class="judullaporan">Semua Laporan</h2>
          <div class=" container-table">
            <table id="dataTable" width="100%">
              <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Telpon</th>
                <th>Alamat</th>
                <th>Tujuan</th>
                <th>Isi Laporan</th>
                <th>Tanggal</th>
                <th class="sorting_asc_disabled sorting_desc_disabled">Status</th>
              </tr>
              <?php
                            // Ambil semua record dari tabel laporan
                            if ($id_admin > 0) {
                                $statement = $db->query("SELECT * FROM laporan, divisi WHERE laporan.tujuan = divisi.id_divisi AND laporan.tujuan = $id_admin ORDER BY laporan.id DESC");
                            } else {
                                $statement = $db->query("SELECT * FROM laporan, divisi WHERE laporan.tujuan = divisi.id_divisi ORDER BY laporan.id DESC");
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
                <td><?php echo $key['alamat']; ?></td>
                <td><?php echo $key['nama_divisi']; ?></td>
                <td><?php echo $key['isi']; ?></td>
                <td><?php echo $tanggal; ?></td>
                <td><?php echo $style_status; ?></td>
              </tr>
              <?php
                            }
                            ?>
            </table>
          </div>

        </div>
      </article>
    </section>
  </main>
  <footer class="sticky-footer">
    <p>Copyright © Dispenduk Bangkalan 2018</p>
  </footer>


  <!-- Custom scripts for this page-->
  <script src="js/admin-datatables.js"></script>

  </div>

</body>

</html>