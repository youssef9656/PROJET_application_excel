<?php
// تضمين ملف الاتصال بقاعدة البيانات
include '../../Config/connect_db.php';

// جلب البيانات من جدول المقالات
$sql = "SELECT * FROM article";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afficher Articles</title>
</head>
<body>
<h1>Liste des Articles</h1>
<div id="tblar">
<?php if ($result->num_rows > 0): ?>
    <table class="table table-bordered" id="tblarticle">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Description</th>
            <th>Stock Min</th>
            <th>Stock Initial</th>
            <th>Prix</th>
            <th>Unité</th>
            <th>Action</th>
        </tr>
        </thead>
<tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr id-data="<?php echo $row['id_article']; ?>">
                <td><?php echo $row['id_article']; ?></td>
                <td><?php echo $row['nom']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['stock_min']; ?></td>
                <td><?php echo $row['stock_initial']; ?></td>
                <td><?php echo is_null($row['prix']) ? 'N/A' : $row['prix']; ?></td>
                <td><?php echo $row['unite']; ?></td>
                <td>
                    <a id="modify" onclick='editArticle(this,<?php echo $row["id_article"]; ?> )'  href="#" style="color:green;"  >
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16"><path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/></svg>
                       </a>

                    <a href="#" onclick='deleteArticle(<?php echo $row["id_article"]; ?>)' style="color:red">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                        </svg>
                    </a>



                </td>
            </tr>
        <?php endwhile; ?>
</tbody>
    </table>
</div>
<?php else: ?>
    <p>Aucun article trouvé.</p>
<?php endif; ?>

<?php
// إغلاق الاتصال بقاعدة البيانات
$conn->close();
?>
</body>
</html>
