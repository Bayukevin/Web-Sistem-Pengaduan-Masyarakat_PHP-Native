<?php
# @Copyright: (c) Pemrograman Web 04-09
# @Author: Bayu Kevin Farindra <1204200035>
# @Author: Hugo Rayhan Firmansyah <1204200114>
# @Author: Nabila Syifa Rachmadini <1204202050>
# @Author: Nathania Fadlilah <1204200073>
# @Date:   8 February, 2023
?>
<?php

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "kp";

try {
    //create PDO connection
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
} catch(PDOException $e) {
    //show error
    die("Terjadi masalah: " . $e->getMessage());
}
