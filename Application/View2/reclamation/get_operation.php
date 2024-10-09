<?php
include '../../config/connect_db.php';

if (isset($_POST['operation_id'])) {
    $operationId = intval($_POST['operation_id']);

    $query = "SELECT * FROM operation WHERE id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $operationId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $operation = $result->fetch_assoc();
            echo json_encode($operation); // Envoyer les données au format JSON
        }
        $stmt->close();
    }
}
?>
