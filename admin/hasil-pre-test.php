<?php

include('../config/db.php');
session_start();

if (!isset($_SESSION['name'])) {
    header('location: ../sign-in.php');
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
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
            <div class="body d-flex py-lg-2 py-md-2">
                <div class="container-fluid">
                    <h2>Hasil Pre Test</h2>
                    <div class="row clearfix g-3 mt-3">
                        <div class="col-lg-8 col-md-12 flex-column">
                            <div class="row row-deck g-3">
                                <div class="col-12 col-xl-12 col-lg-12">
                                    <div class="card mb-3 color-bg-200">
                                        <div class="card-body p-5">
                                            <div class=" row align-items-center">
                                                <table id="muridTable"
                                                    class="table table-bordered table-striped bg-white"
                                                    style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Murid</th>
                                                            <th>NIS/Login</th>
                                                            <th>Kelas</th>
                                                            <th>Hasil Pre Test</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- Row End -->
                </div>
            </div>

        </div>
    </div>

    <!-- Jquery Page Js -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="../js/template.js"></script>
    <script src="../js/page/elearn-index.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    var table;
    $(document).ready(function() {
        table = $('#muridTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "../data/murid.php?action=getHasilPretest",
                "dataType": "json",
                "type": "POST",
            },
            "columnDefs": [ //Set column definition initialisation properties.
                {
                    "targets": [0, 4, 5], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ],
            "columns": [{
                    data: "no",
                    name: "no"
                },
                {
                    data: "murid",
                    name: "murid"
                },
                {
                    data: "nis",
                    name: "nis",
                },
                {
                    data: "kelas",
                    name: "kelas",
                },
                {
                    data: "hasilPreTest",
                    name: "hasilPreTest",
                },
                {
                    data: "action",
                    name: "action"
                }
            ]
        });


        $('#formtambahMurid').submit(function() {
            $.ajax({
                url: "../data/murid.php?action=tambahMurid",
                method: "POST",
                data: $('#formtambahMurid').serialize(),
                success: function(data) {
                    Swal.fire(
                        '',
                        'Sukses Tambah Murid',
                        'success'
                    );
                    table.ajax.reload();
                    $('#modalTambahMurid').modal('hide');
                },
                error: function(e) {
                    console.log(e)
                }
            })
            return false;
        })

        $('#muridTable').on('click', '#btn-edit', function() {
            $.ajax({
                url: "../data/murid.php?action=getMuridById",
                method: "post",
                type: "ajax",
                data: {
                    id: $(this).attr('data'),
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $('#idMurid').val(data['id']);
                    $('#editNis').val(data['nis']);
                    $('#editNama').val(data['nama']);
                    $('#editAlamat').val(data['alamat']);
                    $('#edit_no_hp').val(data['no_hp']);
                    $('#editKelas').val(data['kelas']);
                },
                error: function(e) {
                    console.log(e);
                }
            })
            $('#modalEditMurid').modal('show');
        })

        $('#formEditMurid').submit(function() {
            $.ajax({
                url: '../data/murid.php?action=editMurid',
                method: "post",
                type: "ajax",
                data: $('#formEditMurid').serialize(),
                success: function(data) {
                    Swal.fire(
                        '',
                        'Update Murid Berhasil',
                        'success'
                    );
                    table.ajax.reload();
                    $('#modalEditMurid').modal('hide');
                },
                error: function(e) {
                    console.log(e);
                }
            });
            return false;
        })

        $('#muridTable').on('click', '#btn-delete', function() {

            Swal.fire({
                title: "Konfirmasi Hapus Murid?!",
                text: "Apakah anda yakin untuk manghapus data Murid ini?",
                icon: 'warning',
                showDenyButton: true,
                confirmButtonText: 'Ya!',
                denyButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '../data/murid.php?action=hapusMurid',
                        method: 'post',
                        type: 'ajax',
                        data: {
                            id: $(this).attr('data')
                        },
                        success: function(data) {
                            Swal.fire(
                                '',
                                'Hapus Murid Berhasil',
                                'success'
                            );
                            table.ajax.reload();
                            $('#modalEditMurid').modal('hide');
                        },
                        error: function(e) {
                            console.log(e);
                        }
                    })
                } else {
                    Swal.fire(
                        'Cancelled',
                        'Hapus Murid Dibatalkan',
                        'error'
                    );
                }
            })
        })

        $('#muridTable').on('click', '#btn-delete', function() {

            Swal.fire({
                title: "Konfirmasi Hapus Murid?!",
                text: "Apakah anda yakin untuk manghapus data Murid ini?",
                icon: 'warning',
                showDenyButton: true,
                confirmButtonText: 'Ya!',
                denyButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '../data/murid.php?action=hapusMurid',
                        method: 'post',
                        type: 'ajax',
                        data: {
                            id: $(this).attr('data')
                        },
                        success: function(data) {
                            Swal.fire(
                                '',
                                'Hapus Murid Berhasil',
                                'success'
                            );
                            table.ajax.reload();
                            $('#modalEditMurid').modal('hide');
                        },
                        error: function(e) {
                            console.log(e);
                        }
                    })
                } else {
                    Swal.fire(
                        'Cancelled',
                        'Hapus Murid Dibatalkan',
                        'error'
                    );
                }
            })
        })
    });
    </script>
</body>

</html>