<?php
include '../../config/connect_db.php';

if (isset($_GET['operationId'])) {
    $operationId = mysqli_real_escape_string($conn, $_GET['operationId']);

    // Requête pour récupérer la réclamation
    $sql = "SELECT reclamation FROM operation WHERE id = '$operationId'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo $row['reclamation'];
    } else {
        // Aucune réclamation trouvée, renvoyer une chaîne vide
        echo "";
    }
}
?>