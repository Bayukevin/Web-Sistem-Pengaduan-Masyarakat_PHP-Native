<?php
# @Copyright: (c) Pemrograman Web 04-09
# @Author: Bayu Kevin Farindra <1204200035>
# @Author: Hugo Rayhan Firmansyah <1204200114>
# @Author: Nabila Syifa Rachmadini <1204202050>
# @Author: Nathania Fadlilah <1204200073>
# @Date:   8 February, 2023
?>
<?php
session_start();
// file untuk generate captcha
//mengashilkan bilangan acak 5 digit
$bilangan = rand(10000, 99999);

//mendaftarkan variabel di dalam sesion
$_SESSION["bilangan"] = $bilangan;


//membuat gambar captcha
$gambar = imagecreatetruecolor(65,30);
$background = imagecolorallocate ($gambar, 244,67,54);
$foreground = imagecolorallocate ($gambar, 255,255,255);
imagefill ($gambar, 0,0,$background);
imagestring ($gambar,10,10,6,$bilangan, $foreground);

//menentukan header
header("cache-control: no-cache, must-revalidate");
header ("content-type: image/png");
imagepng($gambar);
imagedestroy ($gambar);
?>
