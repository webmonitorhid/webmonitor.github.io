<?php
$konek = mysqli_connect("localhost", "root", "", "sensor");

$sql = mysqli_query($konek, "select * from ddht22 order by id desc");

$data = mysqli_fetch_array($sql);
$suhu = $data['suhu'];
if ($suhu == "") $suhu = 0;
echo $suhu;
