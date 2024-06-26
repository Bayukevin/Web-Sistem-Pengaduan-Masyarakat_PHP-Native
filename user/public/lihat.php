<?php
# @Copyright: (c) Pemrograman Web 04-09
# @Author: Bayu Kevin Farindra <1204200035>
# @Author: Hugo Rayhan Firmansyah <1204200114>
# @Author: Nabila Syifa Rachmadini <1204202050>
# @Author: Nathania Fadlilah <1204200073>
# @Date:   8 February, 2023
?>
<?php
require_once("database.php");
$nomorError = "";
global $found, $foundreply;
// jalankan jika tombol cari ditekan
if(isset($_POST['submit'])) {
    $nomor = $_POST['nomor'];
    $is_valid = true;
    // validasi nomor laporan yang di inputankan user
    if (!preg_match("/^[0-9]*$/",$nomor)) { // cek nomor hanya boleh angka
        $nomorError = "Input Hanya Boleh Angka";
        $is_valid = false;
    } else {
        $nomorError = "";
    }
    // jika inpuan valid jalankan
    if ($is_valid) {
        $statement = $db->query("SELECT * FROM laporan LEFT JOIN divisi ON laporan.tujuan = divisi.id_divisi WHERE laporan.id = $nomor");
        // jika laporan tidak ditemukan tampilkan pesan
        if ($statement->rowCount() < 1) {
            $notFound= "Nomor Pengaduan Tidak Ditemukan !";
        }
        // jika  laporan ditemukan
        else {
            // ada laporan ada tangggapan
            $stat = $db->query("SELECT * FROM `tanggapan` WHERE id_laporan = $nomor");
            if ($stat->rowCount() > 0) {
                $foundreply = true;
            }
            // pengaduan ditemukan
            $nomorError = "";
            $found = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Lihat Pengaduan</title>
    <link rel="shortcut icon" href="images/icon sby.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css\styles.css">
    <!-- font Awesome CSS -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Main Styles CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="js/bootstrap.js"></script>
</head>

<body style="width:100%; margin: 0;">
    <!--Success Modal Saved-->
    <div class="modal fade" id="failedmodal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm " role="document">
            <div class="modal-content bg-2">
                <div class="modal-header ">
                    <h4 class="modal-title text-center text-danger">Gagal</h4>
                </div>
                <div class="modal-body">
                    <p class="text-center">Nomor Pengaduan Tidak Ditemukan</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="location.href='lihat';" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    // alert pengaduan tidak ditemukan
    if(isset($notFound)) {
        ?>
        <script type="text/javascript">
        $("#failedmodal").modal();
        </script>
        <?php
    }
    ?>

    <div class="shadow">
        <nav class="navbar navbar-fixed navbar-inverse form-shadow" style="width:100%; margin: 0;">
            <div class="container-fluid" style="padding: 0;">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="background-color: #25316D; width: 100%;">
                    <ul class="nav navbar-nav">
                        <li><a href="home" style="color: #FEDB39; font-weight: bold; font-size: 17px;">HOME</a></li>
                        <li><a href="lapor" style="color: #FEDB39; font-weight: bold; font-size: 17px;">LAPOR</a></li>
                        <li class="active"><a href="lihat" style="color: #FEDB39; font-weight: bold; font-size: 17px;">LIHAT PENGADUAN</a></li>
                        <li><a href="cara" style="color: #FEDB39; font-weight: bold; font-size: 17px;">CARA</a></li>
                        <li><a href="bantuan" style="color: #FEDB39; font-weight: bold; font-size: 17px;">BANTUAN</a></li>
                        <li><a href="kontak" style="color: #FEDB39; font-weight: bold; font-size: 17px;">KONTAK</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav><!-- /.nav -->

        <!-- content -->
        <div class="main-content">
            <h3><strong>Lihat Pengaduan</strong></h3>
            <hr/>
            <div class="row">
                <div class="col-md-6 card-shadow-2 form-custom">
                    <form class="form-horizontal" role="form" method="post">
                        <div class="form-group">
                            <label for="nomor" class="col-sm-4 control-label">Nomor Pengaduan</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="glyphicon glyphicon-exclamation-sign"></span></div>
                                    <input type="text" class="form-control" id="nomor" name="nomor" placeholder="Masukkan Nomor Pengaduan" required>
                                </div>
                                <p class="error"><?= @$nomorError ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-4">
                                <input id="submit" name="submit" type="submit" value="Lihat Pengaduan" class="btn btn-primary-custom form-shadow">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6"></div>
            </div>

            <br>
            <?php
            // dijalankan ketika $found bernilai true // laporan ditemukan
            if ($found){
                foreach ($statement as $key) {
                    $mysqldate = $key['tanggal'];
                    $phpdate = strtotime($mysqldate);
                    $tanggal = date( 'd F Y, H:i:s', $phpdate);
                    ?>
                    <h3>Hasil Pencarian</h3>

                    <div class="row">
                        <div class="col-md-8">

                            <div class="panel-body-lihat card-shadow-2">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h3 class="h3-laporan custom">Laporan</h3>
                                    </div>
                                    <div class="col-md-8">
                                        <h4 class="text-muted text-right"><?php echo $key['nama_divisi']; ?></h4>
                                    </div>
                                </div>
                                <hr class="hr-laporan">
                                <a class="media-left" href="#"><img class="img-circle card-shadow-2 img-sm" src="images/avatar/avatar1.png"></a>
                                <div class="media-body">
                                    <div>
                                        <h4 class="text-green profil-name" style="font-family: helvetica;"><?php echo $key['nama']; ?></h4>
                                        <p class="text-muted text-sm"><i class="fa fa-th fa-fw"></i>  -  <?php echo $tanggal; ?></p>
                                    </div>
                                    <hr class="hr-nama">
                                    <div class="isi-laporan">
                                        <p class="text-justify">
                                            <?php echo $key['isi']; ?>
                                        </p>
                                    </div>
                                    <hr class="hr-laporan">

                                    <div>
                                        <h3 class="custom">Tindak Lanjut Laporan</h3>
                                        <hr class="hr-laporan">
                                        <?php
                                        // dijalankan ketika $foundreply bernilai true // tanggapan ditemukan
                                        if ($foundreply){
                                            foreach ($stat as $key) {
                                                $mysqldatea = $key['tanggal_tanggapan'];
                                                $phpdatea = strtotime($mysqldatea);
                                                $tanggal_tanggapan = date( 'd F Y, H:i:s', $phpdatea);
                                                ?>

                                                <div class="media-block comment">
                                                    <a class="media-left" href="#"><img class="img-circle card-shadow-2 img-sm" src="images/avatar/avatar2.png"></a>
                                                    <div class="media-body">
                                                        <div>
                                                            <h4 class="text-primary profil-name" style="font-family: helvetica;"><?php echo $key['admin']; ?></h4>
                                                            <p class="text-muted text-sm"><i class="fa fa-th fa-fw"></i>  -  <?php echo $tanggal_tanggapan; ?></p>
                                                        </div>
                                                        <hr class="hr-nama-admin">
                                                        <p class="text-justify">
                                                            <?php echo $key['isi_tanggapan']; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    // dijalankan ketika $cari bernilai false // tanggapan tidak ditemukan
                                    else {
                                        echo "<h5 class=\"text-muted text-lg\"><i class=\"fa fa-exclamation-circle fa-fw\"></i>  Belum Ada Tanggapan</h5>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <div class="col-md-4">
                </div>
            </div>

            <!-- link to top -->
            <a id="top" href="#" onclick="topFunction()">
                <i class="fa fa-arrow-circle-up"></i>
            </a>
            <script>
            // When the user scrolls down 100px from the top of the document, show the button
            window.onscroll = function() {scrollFunction()};
            function scrollFunction() {
                if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
                    document.getElementById("top").style.display = "block";
                } else {
                    document.getElementById("top").style.display = "none";
                }
            }

            // When the user clicks on the button, scroll to the top of the document
            function topFunction() {
                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0;
            }
            </script>
            <!-- link to top -->

            <!-- /.main content -->
        </div>


        <hr>

        <!-- Footer -->
        <div class="footer footer-bottom text-center" style="background-color: #002B5B;">
            <div class="row">
                <div class="col-md-4 mb-5 mb-lg-0">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <i class="fa fa-top fa-map-marker"></i>
                        </li>
                        <li class="list-inline-item">
                            <h4 class="text-uppercase mb-4">Kantor</h4>
                        </li>
                    </ul>
                    <p class="mb-0">
                    Jl. Tunjungan No.1-3, Genteng, Kec. Genteng
                        <br>Surabaya, Jawa Timur
                    </p>
                </div>
                <div class="col-md-4 mb-5 mb-lg-0">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <i class="fa fa-top fa-rss"></i>
                        </li>
                        <li class="list-inline-item">
                            <h4 class="text-uppercase mb-4">Sosial Media</h4>
                        </li>
                    </ul>
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <a class="btn btn-outline-light btn-social text-center rounded-circle" href="https://www.facebook.com/HumasPemkotSurabaya/" target="_blank">
                                <i class="fa fa-fw fa-facebook"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a class="btn btn-outline-light btn-social text-center rounded-circle" href="https://twitter.com/dispendukcapils" target="_blank">
                                <i class="fa fa-fw fa-twitter"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <i class="fa fa-top fa-envelope-o"></i>
                        </li>
                        <li class="list-inline-item">
                            <h4 class="text-uppercase mb-4">Kontak</h4>
                        </li>
                    </ul>
                    <p class="mb-0">
                        0812-3456-7890 <br>
                        example@gmail.com
                    </p>
                </div>
            </div>
        </div>
        <!-- /footer -->

        <div class="copyright py-4 text-center text-white" style="background-color: #25316D;">
            <div class="container">
                <small>V-3.0 | Copyright &copy; Pemrograman Web IS-03-04</small>
            </div>
        </div>


        <!-- shadow -->
    </div>

    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="js/bootstrap.js"></script>

</body>

</html>
