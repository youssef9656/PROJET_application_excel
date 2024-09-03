<?php $pageName= 'lot / sous lot';include '../../config/connect_db.php';include '../../includes/header.php'; ?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="../../includes/jquery.sheetjs.js"></script>
    <title>Document</title>
</head>
<body>
<div class="ajouter_table1"></div>
<div class="table1">

</div>
<div class="ajouter_table2"></div>
<div class="table2">

</div>


<script>
    $(document).ready(function() {
        $.ajax({
            url: 'lot_table.php', // Assurez-vous que ce chemin est correct
            method: 'GET',
            success: function(response) {
                $('.table1').html(response);
            },
            error: function(xhr, status, error) {
                console.error('Une erreur s\'est produite:', status, error);
            }
        });
    });
</script>
</body>
</html>