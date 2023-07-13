<!-- # @Author: Wahid Ari <wahidari>
# @Date:   8 January 2018, 5:05
# @Copyright: (c) wahidari 2018 -->
<?php
require_once("database.php");
require_once("auth.php"); // Session
logged_admin ();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Export - Pengaduan Dispenduk Bangkalan</title>
  <!-- Bootstrap core CSS-->
  <!-- <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet"> -->
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link rel="stylesheet" href="css/export.css">
  <!-- Page level plugin CSS-->
  <link rel="stylesheet" type="text/css" href="vendor/datatables/extra/jquery.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="vendor/datatables/extra/buttons.dataTables.min.css">

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>

  <!-- export plugin JavaScript-->
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/extra/dataTables.buttons.min.js"></script>
  <script src="vendor/datatables/extra/buttons.print.min.js"></script>
  <script src="vendor/datatables/extra/jszip.min.js"></script>
  <script src="vendor/datatables/extra/pdfmake.min.js"></script>
  <script src="vendor/datatables/extra/vfs_fonts.js"></script>
  <script src="vendor/datatables/extra/buttons.html5.min.js"></script>
  <script type="text/javascript" class="init">
  $(document).ready(function() {
    $('#example').DataTable({
      dom: 'Bfrtip',
      buttons: [{
          extend: 'print',
          title: 'Data Pengaduan',
          customize: function(win) {
            $(win.document.body).find('table')
              .addClass('compact')
              .css('font-size', 'inherit');
            $(win.document.body)
              .css('font-size', '10pt')
              .prepend(
                '<img src="http://www.surabaya.bpk.go.id/wp-content/uploads/2015/07/logo-Bangkalan.png" style="opacity: 0.5; display:block;margin-left: auto; margin-top: auto; margin-right: auto; width: 100px;" />'
              );
          }
        },
        {
          extend: 'pdf',
          orientation: 'landscape',
          pageSize: 'LEGAL',
          title: 'Data Pengaduan'
        },
        {
          extend: 'excel',
          title: 'Data Pengaduan'
        }
      ]
    });
  });
  </script>

</head>

<body id="page-top">
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
    <section class="container-dataIsi">
      <div class="content-wrapper">
        <div class="container-fluid">
          <!-- DataTables Card-->
          <div class="card-cekat">
            <div class="card-header">
              <i class="fa fa-table"></i> Cetak Laporan Masuk
            </div>
            <table id="example" width="100%">
              <thead>
                <tr>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Telpon</th>
                  <th>Alamat</th>
                  <th>Tujuan</th>
                  <th>Isi Laporan</th>
                  <th>Tanggal</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
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
              </tbody>
            </table>
          </div>
        </div>
    </section>
  </main>

  <!-- Body -->

  <!-- /.container-fluid-->

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


  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="js/admin.js"></script>
  <!-- Custom scripts for this page-->
  <script src="js/admin-datatables.js"></script>

  </div>
  <!-- /.content-wrapper-->

</body>

</html>