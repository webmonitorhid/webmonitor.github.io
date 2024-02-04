<?php
$konek = mysqli_connect("localhost", "root", "", "sensor");

$stat = $_GET['stat'];
if ($stat == "ON") {
	mysqli_query($konek, "UPDATE kontrol SET pompa=1");
	echo "ON";
} else {
	mysqli_query($konek, "UPDATE kontrol SET pompa=0");
	echo "OFF";
}
