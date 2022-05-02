<?php

include('../config/db.php');
session_start();

if (!isset($_SESSION['name'])) {
    header('location: ../sign-in.php');
}

if ($_SESSION['level_user'] == 3) {
    $survey = mysqli_query($conn, "SELECT * FROM pre_test_answer where student_id = '{$_SESSION['student_id']}'");
    $survey_row = mysqli_num_rows($survey);
    if ($survey_row == 1) {
        $_SESSION['survey_taken'] = true;
    } else {
        $_SESSION['survey_taken'] = false;
    }
}


?>

<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>:: e-Learn:: Education Dashboard </title>
    <link rel="icon" href="../favicon.ico" type="image/x-icon"> <!-- Favicon-->
    <!-- plugin css file  -->
    <link rel="stylesheet" href="../node_modules/owl.carousel2/dist/assets/owl.carousel.min.css" />
    <!-- project css file  -->
    <link rel="stylesheet" href="../assets/css/e-learn.style.min.css">
</head>

<body>

    <div id="elearn-layout" class="theme-purple">
        <!-- sidebar -->
        <?php include('../layout/sidebar.php'); ?>

        <!-- main body area -->
        <div class="main px-lg-4 px-md-4">

            <!-- Body: Header -->
            <?php include('../layout/header.php'); ?>

            <!-- Body: Body -->
            <div class="body d-flex py-lg-3 py-md-2">
                <div class="container-xxl">
                    <div class="row clearfix g-3">
                        <div class="col-lg-8 col-md-12 flex-column">
                            <div class="row row-deck g-3">
                                <div class="col-12 col-xl-12 col-lg-12">
                                    <div class="card mb-3 color-bg-200">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-12 col-lg-5 order-lg-2">
                                                    <div class="text-center p-4">
                                                        <img src="../assets/images/study.svg" alt="..."
                                                            class="img-fluid set-md-img">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-7 order-lg-1">
                                                    <h3 class=" mb-3">Welcome back, <span class="fw-bold">
                                                            <?php echo $_SESSION['name']; ?>
                                                        </span>
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if ($_SESSION['level_user'] == 3) { ?>


                            <div class="card mb-3 color-bg-200">
                                <div class="card-header py-3">
                                    <h6 class="mb-0 fw-bold ">Hasil Pre Test</h6>
                                </div>
                                <div class="card-body">
                                    <?php if ($_SESSION['survey_taken']) {

                                            $sql = "SELECT * FROM pre_test_result WHERE student_id = '{$_SESSION['student_id']}'";
                                            $query = mysqli_query($conn, $sql);
                                            $result = mysqli_fetch_array($query, MYSQLI_ASSOC);
                                            $level = $result['level'];
                                            if (mysqli_num_rows($query) > 0) { ?>
                                    <h6 class="mb-0 fw-bold">
                                        Level materi anda adalah Level
                                        <strong><?php echo $level ?></strong>
                                    </h6>

                                    <?php
                                            } else { ?>
                                    <h6 class="mb-0 fw-bold">
                                        Anda sudah mengambil Pre-Test, silahkan tunggu hasil pre-test yang masih
                                        diproses
                                    </h6>
                                    <?php }

                                            ?>
                                    <?php  } else { ?>
                                    <h6 class="mb-2 fw-bold">Anda belum mengambil Pre Test Level Belajar</h6>
                                    <p>Silahkan ambil Pre-test dengan klik tombol <a href="pre-test.php"
                                            class="btn btn-primary ">Pre-Test</a></p>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div><!-- Row End -->
                </div>
            </div>

        </div>

        <!-- Jquery Core Js -->
        <script src="../assets/bundles/libscripts.bundle.js"></script>

        <!-- Plugin Js-->
        <script src="../node_modules/owl.carousel2/dist/owl.carousel.min.js"></script>
        <script src="../assets/bundles/apexcharts.bundle.js"></script>

        <!-- Jquery Page Js -->
        <script src="../js/template.js"></script>
        <script src="../s/page/elearn-index.js"></script>
</body>

</html>