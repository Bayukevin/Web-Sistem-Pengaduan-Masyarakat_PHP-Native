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
    global $nomor, $foundreply, $id_admin;
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
        // header("Location: tables");
    }
?>
<?php
// fungsi untuk merandom avatar profil
function RandomAvatar(){
    $photoAreas = array("avatar1.png", "avatar2.png", "avatar3.png", "avatar4.png", "avatar5.png", "avatar6.png", "avatar7.png", "avatar8.png", "avatar9.png", "avatar10.png", "avatar11.png");
    $randomNumber = array_rand($photoAreas);
    $randomImage = $photoAreas[$randomNumber];
    echo $randomImage;
}
?>

<!DOCTYPE html>
<html lang="id" style="scroll-behavior: smooth;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Pengaduan Masyarakat Surabaya</title>
    <link rel="shortcut icon" href="images/icon sby.png">
     <!-- Main Styles-2 CSS -->
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
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v2.11';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

    <!--Success Modal Saved-->
    <div class="modal fade" id="successmodalclear" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm " role="document">
            <div class="modal-content bg-2">
                <div class="modal-header ">
                    <h4 class="modal-title text-center text-green">Sukses</h4>
                </div>
                <div class="modal-body">
                    <p class="text-center">Pengaduan Berhasil Di Kirim</p>
                    <p class="text-center">Untuk Mengetahui Status Pengaduan</p>
                    <p class="text-center">Silahkan Buka Menu <a href="lihat">Lihat Pengaduan</a> </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn button-green" onclick="location.href='home';" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <?php
        if(isset($_GET['status'])) {
    ?>
    <script type="text/javascript">
        $("#successmodalclear").modal();
    </script>
    <?php
        }
    ?>
    <!-- body -->
    <div class="shadow">
        <!-- navbar -->
        <nav class="navbar navbar-inverse navbar-fixed form-shadow" style="width:100%; margin: 0;">
            <!-- container-fluid -->
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
                    <ul class="nav navbar-nav nav-link">
                        <li class="active"><a href="" style="color: #FEDB39; font-weight: bold; font-size: 17px;">HOME</a></li>
                        <li><a href="lapor" style="color: #FEDB39; font-weight: bold; font-size: 17px;">LAPOR</a></li>
                        <li><a href="lihat" style="color: #FEDB39; font-weight: bold; font-size: 17px;">LIHAT PENGADUAN</a></li>
                        <li><a href="cara" style="color: #FEDB39; font-weight: bold; font-size: 17px;">CARA</a></li>
                        <li><a href="bantuan" style="color: #FEDB39; font-weight: bold; font-size: 17px;">BANTUAN</a></li>
                        <li><a href="kontak" style="color: #FEDB39; font-weight: bold; font-size: 17px;">KONTAK</a></li>
                    </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <!-- end navbar -->

    <!-- start slider -->
    <div id="mainCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#mainCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#mainCarousel" data-slide-to="1"></li>
            <li data-target="#mainCarousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->

        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="images/home-1.jpg" alt="...">
                
            </div>
            <div class="item">
                <img src="images/home-2.png" alt="...">
                
            </div>
            <div class="item">
                <img src="images/home-3.png" alt="...">
            </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#mainCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#mainCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <!-- end Slider -->

    <!-- content -->
    <div class="main-content">
        <!-- section -->
        <div class="section">
            <div class="row">

                <!-- laporan Terbaru -->
                <div class="col-md-8">
                    <br>
                    <h3 class="text-center h3-custom"><strong>Pengaduan Terbaru</strong></h3>
                    <hr class="custom-line"/>
                    <hr>
                    <!-- scroll-laporan -->
                    <div class="scroll-laporan">
                        <?php
                        // Ambil semua record dari tabel laporan
                        $statement = $db->query("SELECT * FROM `laporan` ORDER BY id DESC");
                        foreach ($statement as $key ) {
                            $mysqldate = $key['tanggal'];
                            $phpdate = strtotime($mysqldate);
                            $tanggal = date( 'd F Y, H:i:s', $phpdate);
                            ?>   
                            <div class="panel-body card-shadow-2">
                                <a class="media-left" href="#"><img class="img-circle img-sm form-shadow" src="images/avatar/<?php RandomAvatar(); ?>"></a>
                                <div class="media-body">
                                    <div>
                                        <h4 class="text-green profil-name" style="font-family: helvetica;"><?php echo $key['nama']; ?></h4>
                                        <p class="text-muted text-sm"><i class="fa fa-th fa-fw"></i>  -  <?php echo $tanggal; ?></p>
                                    </div>
                                    <hr class="hr-nama">
                                    <p>
                                        <?php echo $key['isi']; ?>
                                    </p>
                                </div>
                                <!-- media body -->
                                <div class="form-inline">
                                    <button type="button" class="btn btn-primary btn-sm btn-custom card-shadow-2" data-toggle="modal" data-target="#ModalDetail<?php echo $key['id']; ?>" style="margin: 8px;">
                                        Lihat Detail
                                    </button>
								</div>
                            </div>
                            <!-- panel body -->
                            <?php
                        }
                        ?>
                    </div>
                    <!-- end scroll-laporan -->
                </div>
                <!-- End Laporan Terbaru -->

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
        <?php
            }
        ?>

                <!-- Social Media Feed -->
                <div class="col-md-4">
                    <br>
                    <!-- header text social-feed -->
                    <h3 class="text-center h3-custom"><strong>Social Feed</strong></h3>
                    <hr class="custom-line"/>
                    <!-- end header text social-feed -->
                    <!-- Twitter Feed -->
                    <div class="box">
                        <div class="box-icon shadow" style="background-color: #002B5B;">
                            <span class="fa fa-2x fa-twitter"></span>
                        </div>
                        <div class="info">
                            <h3 class="text-center">twitter</h3>
                            <a class="twitter-timeline" href="https://twitter.com/dispendukcapils" data-width="500" data-height="300">Tweets by disdukcapilsby</a>
                            <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                        </div>
                    </div>
                    <!-- End Twitter Feed -->
                    <hr>
                    <!-- Facebook Feed -->
                    <div class="box">
                        <div class="box-icon shadow" style="background-color: #002B5B;">
                            <span class="fa fa-2x fa-facebook"></span>
                        </div>
                        <div class="info">
                            <h3 class="text-center">facebook</h3>
                            <div class="fb-page" data-height="300" data-width="500" data-href="https://www.facebook.com/HumasPemkotSurabaya/" data-tabs="timeline" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                                <blockquote cite="https://www.facebook.com/HumasPemkotSurabaya/" class="fb-xfbml-parse-ignore">
                                    <a href="https://www.facebook.com/HumasPemkotSurabaya/">Pemerintahan Kota Surabaya</a>
                                </blockquote>
                            </div>
                        </div>
                    </div>
                    <!-- End Facebook Feed -->
                    <hr>
                    <!-- Facebook Feed -->
                    <div class="box">
                        <div class="box-icon shadow" style="background-color: #002B5B;">
                            <span class="fa fa-2x fa-rss"></span>
                        </div>
                        <div class="info">
                            <h3 class="text-center">link</h3>
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-success"><a href="#">Website Pemerintah Surabaya</a></li>
                                <li class="list-group-item list-group-item-info"><a href="#">Website Diskominfo Surabaya</a></li>
                                <li class="list-group-item list-group-item-warning"><a href="#">Website Dispendukcapil Surabaya</a></li>
                                <li class="list-group-item list-group-item-danger"><a href="#">Website Bappeda Surabaya</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- End Facebook Feed -->
                </div>
                <!-- End Social Media Feed -->               
            </div>
            <!-- end row -->
        </div>
        <!-- /.section -->

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

    </div>
    <!-- end main-content -->

    <!-- Footer -->
    <footer class="footer text-center" style="background-color: #002B5B;">
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
    </footer>
    <!-- /footer -->

    <div class="copyright py-4 text-center text-white" style="background-color: #25316D;">
        <!-- <div class="container"> -->
        <small>V-3.0 | Copyright &copy; Pemrograman Web IS-03-04</small>
        <!-- </div> -->
    </div>
    <!-- shadow -->
</div>

</body>
</html>
