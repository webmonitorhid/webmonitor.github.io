<?php
$konek = mysqli_connect("localhost", "root", "", "sensor");

$sql = mysqli_query($konek, "select * from ddht22 order by id desc");

$data = mysqli_fetch_array($sql);
$kelembaban = $data['kelembaban'];
if ($kelembaban == "") $kelembaban = 0;
echo $kelembaban;
