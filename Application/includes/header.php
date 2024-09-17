
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../includes/jquery.sheetjs.css">
<!--    <script src="../../includes/jquery.sheetjs.js"></script>-->
    <link rel="stylesheet" href="../../includes/css/bootstrap.css">
<!--    <script src="../../includes/js/bootstrap.js"></script>-->

    <title>Catalogue de Temps</title>

    <style>

        .navbar{
            position: fixed !important;
            top: 0;
            left: 0;
            width: 100%;

        }
        .div1{
            width: 100%;
            height: 100px;
        }
        .navbar-light {
            background-color: #08808c;
        }
        .dropdown-menu{

        }

        .navbar-light .navbar-brand, .navbar-light .nav-link {
            color: #e7e8ea;
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
    <nav class="navbar navbar-expand-lg navbar-light" style="padding-left: 20px">
        <a class="navbar-brand" style="color: #4fff41;font-size: 25px;font-weight: bold" href="#"><?= $pageName ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item item-hover">
                    <a class="nav-link" href="../operations_01/option_Ent_Sor.php">Journal entrées et sorties</a>
                </li>
                <li class="nav-item item-hover">
                    <a class="nav-link" href="../eata_stock/etat_de_stocks.php">Etat des stocks</a>
                </li>

                <li class="nav-item item-hover">
                    <a class="nav-link" href="#">Bon Réception et commande </a>
                </li>
                <li class="nav-item item-hover">
                    <a class="nav-link" href="../addarticle_souslot/article_sous_lot.php"> </a>
                </li>
                <li class="nav-item item-hover">
                    <a class="nav-link" href="../"></a>
                </li>

                <?php


                if($_SESSION['role'] == "admin"){
                    echo '<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">les données Articles</a>
                    <ul class="dropdown-menu ">
                        <li><a class="dropdown-item text-center fs-5 fw-bold " href="../fournisseurs/fournisseurs.php">Fournisseurs</a></li>
                        <li><a class="dropdown-item text-center fs-5 fw-bold  " href="../lot_et_souslot/lot_souslot.php">Lot / Sous lot</a></li>
                        <li><a class="dropdown-item text-center fs-5 fw-bold " href="../pageArticle/article.php">Article</a></li>
                        <li><hr class="dropdown-divider text-center fs-5 fw-bold "></li>
                        <li><a class="dropdown-item text-center  fw-bold " href="../addarticle_souslot/article_sous_lot.php">BASE DE DONNÉES ARTICLES </a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Statistiques</a>
                    <ul class="dropdown-menu ">
                        <li><a class="dropdown-item text-center fs-5 fw-bold " href="../graphic2_sour/HHH.php">Statistiques des sorties</a></li>
                        <li><a class="dropdown-item text-center fs-5 fw-bold  " href="../graphic/HHH.php">Statistiques des entree</a></li>

                    </ul>
                </li>';
                }

                ?>
                <li class="nav-item">
                    <a class="nav-link" href="../../Config/logout.php">logout</a>

                </li>

            </ul>
        </div>
    </nav>
    <div class="div1"></div>