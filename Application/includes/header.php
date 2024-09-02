
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../includes/jquery.sheetjs.css">
    <script src="../../includes/jquery.sheetjs.js"></script>
    <title>Catalogue de Temps</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .navbar-light {
            background-color: #000060 !important;
        }

        .navbar-light .navbar-brand, .navbar-light .nav-link {
            color: #e7e8ea !important;
        }

        .filter-inputs input {
            margin-bottom: 10px;
        }

        .table {
            width: 100%;
        }

        .table thead th {
            background-color: #0152AE !important;
            color: #e7e8ea !important;
        }

        .table-icons i {
            cursor: pointer;
            margin-right: 10px;
        }

        .table-icons i:last-child {
            margin-right: 0;
        }

        .modal-xl .modal-dialog {
            max-width: 90%;
        }

        .modal-body .form-group {
            margin-bottom: 1rem;
        }

        .modal-body .form-row {
            display: flex;
            flex-wrap: wrap;
        }

        .modal-body .form-row .col {
            flex: 1;
            min-width: 33%;
            padding-right: 15px;
        }

        .modal-body .form-row .col:last-child {
            padding-right: 0;
        }

        .btn-primary {
            background-color: #049d05;
            border-color: #049d05;
        }

        .btn-primary:hover {
            background-color: #037b04;
            border-color: #037b04;
        }

        .form-control:focus {
            border-color: #0152ae;
            box-shadow: 0 0 0 0.2rem rgba(1, 82, 174, 0.25);
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#"><?= $pageName ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="../catalogueTemps/catalogueTemps.php?produit">Catalogue du temps</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="../gamme/gamme.php">La gamme</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../polyvalence/polyvalence.php">La polyvalence</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../equilibrage/equilibrage.php">Équilibrage</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../operatrice/operatrice.php">Operatrice</a>
                </li>
            </ul>
        </div>
    </nav>