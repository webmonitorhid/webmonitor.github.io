<?php
$konek = mysqli_connect("localhost", "root", "", "sensor");

$suhu = $_GET['suhu'];
$kelembaban = $_GET['kelembaban'];

mysqli_query($konek, "ALTER TABLE ddht22 AUTO_INCREMENT=1");

$simpan = mysqli_query($konek, "insert into ddht22(suhu,kelembaban)values('$suhu', '$kelembaban')");

if ($simpan)
	echo "Berhasil";
else
	echo "GGAGAl";
