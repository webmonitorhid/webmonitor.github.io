<?php
$konek = mysqli_connect("localhost", "root", "", "sensor");
$sql = mysqli_query($konek, "SELECT * FROM kontrol");
$data = mysqli_fetch_array($sql);

$pompa = $data['pompa'];
?>

<!DOCTYPE html>
<html lang="en">

<!-- PENGIRIM DATA SENSOR-->
<script type="text/javascript" src="jquery/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        setInterval(function() {
            $("#ceksuhu").load('ceksuhu.php');
            $("#cekkelembaban").load('cekkelembaban.php');
        }, 1000);
    });
</script>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- TAMPILAN SUHU CARD -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Suhu</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><span id="ceksuhu">0</span></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-thermometer-half fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- TAMPILAN KELEMBABAN CARD -->
            <div class="card mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Kelembaban</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><span id="cekkelembaban">0</span></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-tint fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- JAM -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Waktu</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="current-time">Loading...</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pompa -->
            <div class="card mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Pompa</div>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="switch" onchange="ubahstatus(this.checked)" <?php if ($pompa == 1) echo "checked"; ?>>
                                    <label class="custom-control-label" for="switch"> <span id="status"><?php if ($pompa == 1) echo "ON";
                                                                                                        else echo "OFF" ?></span></label>
                                </div>
                            </div>
                            <div cass="col-auto">
                                <i class="fas fa-faucet fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- StatusPompa -->
    <script type="text/javascript">
        function ubahstatus(value) {
            if (value == true) value = "ON";
            else value = "OFF";
            document.getElementById('status').innerHTML = value;

            var xmlhttp = new XMLHttpRequest();

            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById('status').innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "pompa.php?stat=" + value, true);
            xmlhttp.send();
        }
    </script>

    <script>
        function updateClock() {
            const currentTimeElement = document.getElementById("current-time");
            const now = new Date();
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const currentTime = `${hours}:${minutes}`;
            currentTimeElement.textContent = currentTime;
        }

        // Update the clock immediately and then every second
        updateClock();
        setInterval(updateClock, 1000);
    </script>

    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Suhu dan Kelembaban</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-md-12 mb-4">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between mb-4">
                    <h6 class="m-0 font-weight-bold text-primary">Input Set Point</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="row">
                </div>

                <!-- input set point suhu Card Example -->
                <div class="col-sm-4 col-md-12 mb-4">
                    <div class="card border-left-primary shadow h-100 py-3">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-s font-weight-bold text-primary mb-1">
                                        Suhu</div>
                                    <form>
                                        <div class="row">
                                            <div class="col">
                                                <input type="number" class="form-control" placeholder="B. Bawah">
                                            </div>
                                            <div class="col">
                                                <input type="number" class="form-control" placeholder="B. Atas">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-thermometer-half fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- input set point kelembaban Card Example -->
                <div class="col-sm-4 col-md-12 mb-4">
                    <div class="card border-left-success shadow h-100 py-3">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-s font-weight-bold text-success mb-1">
                                        Kelembaban</div>
                                    <form>
                                        <div class="row">
                                            <div class="col">
                                                <input type="number" class="form-control" placeholder="B. Bawah">
                                            </div>
                                            <div class="col">
                                                <input type="number" class="form-control" placeholder="B. Atas">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-tint fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End of Content Wrapper -->

</div>