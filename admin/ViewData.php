<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
</head>

<body>
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
</body>

</html>