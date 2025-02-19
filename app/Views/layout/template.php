<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema hostpot</title>
    <link href="<?= base_url('bootstrap-5.3.3-dist/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
    <link href="DataTables/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="DataTables/datatables.min.js"></script>
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container">
        <?php
        $session = session();

        // Verifica si el usuario está logueado
        if ($session->get('logged_in')) {
        ?>
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="<?= base_url('home') ?>"><img width="100" height="40" src="<?= base_url('images/LogoGlobal-n.png') ?>" alt=""></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item px-2">
                                <a class="nav-link active" aria-current="page" href="<?= base_url('home') ?>">Inicio</a>
                            </li>
                            <li class="nav-item px-2">
                                <a class="nav-link" href="<?= base_url('users') ?>">Admin</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-2" href="<?= base_url('logout') ?>">Cerrar sesión</a>
                            </li>
                            <!--
                        <li class="nav-item">
                            <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                        </li> -->
                        </ul>
                    </div>
                </div>
            </nav>

        <?php
        }
        ?>

        <?= $this->renderSection('content'); ?>
    </div>
    <script src="<?= base_url('bootstrap-5.3.3-dist/js/bootstrap.min.js'); ?>"></script>
</body>

</html>