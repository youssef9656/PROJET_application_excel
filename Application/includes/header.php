
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../includes/jquery.sheetjs.css">
<!--    <script src="../../includes/jquery.sheetjs.js"></script>-->
    <link rel="stylesheet" href="../../includes/css/bootstrap.css">
<!--    <script src="../../includes/js/bootstrap.js"></script>-->

<!--    <title>Catalogue de Temps</title>-->

    <style>

        .navbar{
            position: fixed !important;
            top: 0;
            left: 0;
            width: 100%;
            color: #e7e8ea;
            z-index: 1000;


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
        .logout{

        }





        /* From Uiverse.io by kennyotsu-monochromia */
        .Btn {
            --black: #ff0000;
            --ch-black: #ff1111;
            --eer-black: #ff7373;
            --night-rider: #ff6767;
            --white: #ffffff;
            --af-white: #f3f3f3;
            --ch-white: #e1e1e1;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            width: 45px;
            height: 45px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition-duration: .3s;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.199);
            background-color: var(--night-rider);
        }

        /* plus sign */
        .sign {
            width: 100%;
            transition-duration: .3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sign svg {
            width: 17px;
        }

        .sign svg path {
            fill: var(--af-white);
        }
        /* text */
        .text {
            position: absolute;
            right: 0%;
            width: 0%;
            opacity: 0;
            color: var(--af-white);
            font-size: 1.2em;
            font-weight: 600;
            transition-duration: .3s;
        }
        /* hover effect on button width */
        .Btn:hover {
            width: 125px;
            border-radius: 5px;
            transition-duration: .3s;
        }

        .Btn:hover .sign {
            width: 30%;
            transition-duration: .3s;
            padding-left: 20px;
        }
        /* hover effect button's text */
        .Btn:hover .text {
            opacity: 1;
            width: 70%;
            transition-duration: .3s;
            padding-right: 10px;
        }
        /* button click effect*/
        .Btn:active {
            transform: translate(2px ,2px);
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light" style="padding-left: 20px">
        <a class="navbar-brand" style="color: #4fff41;font-size: 25px;font-weight: bold" href="#"><?= $pageName ?></a>
<!--        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">-->
<!--            <span class="navbar-toggler-icon"></span>-->
<!--        </button>-->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item item-hover">
                    <a class="nav-link" href="../reclamation/reclamation.php">Acceil</a>
                </li>
                <li class="nav-item item-hover">
                    <a class="nav-link" href="../operations_01/option_Ent_Sor.php">Journal entrées et sorties</a>
                </li>
                <li class="nav-item item-hover">
                    <a class="nav-link" href="../eata_stock/etat_de_stocks.php">Etat des stocks</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Bon commandes</a>
                    <ul class="dropdown-menu ">
                        <li><a class="dropdown-item text-center fs-5 fw-bold  " href="../bonomonde/bonCOMOND.php">Bon Commande</a></li>

                        <li><a class="dropdown-item text-center fs-5 fw-bold " href="../bon_reception_entree/bon_reception_entree.php">Bon Réception des entrées</a></li>
                        <li><a class="dropdown-item text-center fs-5 fw-bold  " href="../bon_reception_sortie/bon_reception_sortie.php">Bon Réception des sorties</a></li>
                    </ul>
                </li>
                <li class="nav-item item-hover">
                    <a class="nav-link" href="../addarticle_souslot/article_sous_lot.php"> </a>
                </li>
                <li class="nav-item item-hover">
                    <a class="nav-link" href="../"></a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">les données Articles</a>
                    <ul class="dropdown-menu ">
                        <li><a class="dropdown-item text-center fs-5 fw-bold " href="../fournisseurs/fournisseurs.php">Fournisseurs</a></li>
                        <li><a class="dropdown-item text-center fs-5 fw-bold  " href="../lot_et_souslot/lot_souslot.php">Lot / Sous lot</a></li>
                        <li><a class="dropdown-item text-center fs-5 fw-bold " href="../pageArticle/article.php">Article</a></li>
                        <li><hr class="dropdown-divider text-center fs-5 fw-bold "></li>
                        <li><a class="dropdown-item text-center  fw-bold " href="../addarticle_souslot/article_sous_lot.php">BASE DE DONNÉES ARTICLES </a></li>
                    </ul>
                </li>
                <?php


                if($_SESSION['role'] == "admin"){
                    echo '
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Statistiques</a>
                    <ul class="dropdown-menu ">
                         <li><a class="dropdown-item text-center fs-5 fw-bold  " href="../graphic/HHH.php">Statistiques des entree</a></li>
                        <li><a class="dropdown-item text-center fs-5 fw-bold " href="../graphic2_sour/HHH.php">Statistiques des sorties</a></li>
                         <li><a class="dropdown-item text-center fs-5 fw-bold " href="../garaphic3/garaphic3_DeponsEntre.php">Statistiques Dépenses Entrées</a></li>
                          <li><a class="dropdown-item text-center fs-5 fw-bold " href="../garaphic3/garaphic3_DeponSourt.php">Statistiques Dépenses Sorties</a></li>

                    </ul>
                </li>
                
                <li class="nav-item"> <a class="nav-link" href="../../View2/upload_exl/pload_exl.php">Importer les données</a>  </li>
                
                <li class="nav-item item-hover">
                    <a class="nav-link" href="../../View2/password/password.php">Admin page</a>
                </li>
                ';



                }



                ?>

                <li class="nav-item">
                    <a  href="../../Config/logout.php"><button class="Btn">

                            <div class="sign"><svg viewBox="0 0 512 512"><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path></svg></div>

                            <div class="text">Logout</div>
                        </button></a>

                </li>

            </ul>
        </div>
    </nav>
    <div class="div1"></div>