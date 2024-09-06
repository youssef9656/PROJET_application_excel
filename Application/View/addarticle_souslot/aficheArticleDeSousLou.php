<?php
// تضمين ملف الاتصال بقاعدة البيانات
include '../../Config/connect_db.php';


if(isset($_GET["sous_lot_name"])){
    $sous_lot_name= $_GET["sous_lot_name"];

$sql ="SELECT * FROM article
WHERE id_article IN (
    SELECT article_id
    FROM `sous_lot_articles`
    WHERE sous_lot_id = (
        SELECT sous_lot_id
        FROM `sous_lots`
        WHERE sous_lot_name = '$sous_lot_name'
    )
);
";
$result = $conn->query($sql);



$query2 = "
    SELECT sous_lots.sous_lot_id, sous_lots.sous_lot_name, sous_lots.lot_id, lots.lot_name
    FROM sous_lots
    JOIN lots ON sous_lots.lot_id = lots.lot_id where sous_lots.sous_lot_name ='$sous_lot_name'
";
$result2 = mysqli_query($conn, $query2);
}


$query3 = "
    SELECT f.id_fournisseur, f.nom_fournisseur, l.lot_name
    FROM lot_fournisseurs lf
    JOIN fournisseurs f ON lf.id_fournisseur = f.id_fournisseur
    JOIN lots l ON lf.lot_id = l.lot_id where l.lot_name =( SELECT  lots.lot_name FROM sous_lots JOIN lots ON sous_lots.lot_id = lots.lot_id where sous_lots.sous_lot_name ='$sous_lot_name') 
    ORDER BY l.lot_name
";
$result3 = mysqli_query($conn, $query3);


?>

<div id="tblarARlot">
    <table  class="table table-bordered text-center m-0"  style="font-size: 10px;height: 100px" >
        <thead><th >lot</th><th>Fournisseur</th></thead>
        <tr>
    <?php
    while ($row = mysqli_fetch_assoc($result2)) {

        echo '<td  style="padding: 0px ; text-align: center; vertical-align: middle;font-weight:bold;font-size: 16px;background-color: #3dd5f3  ">' . htmlspecialchars($row['lot_name']) . '</td>';
        echo '<td style="padding: 0;" >';
    while ($row3 = mysqli_fetch_assoc($result3)) {

        echo '<p  style="padding:0 ;margin: 0; background-color: gold"  >' . htmlspecialchars($row3['nom_fournisseur']) . '</p><hr style="margin: 0">';

    }

        echo '</td></tr>';
        echo '<thead> <th  style="padding: 5px;background-color: #17944b !important;"  colspan="2">' . htmlspecialchars($row['sous_lot_name']) . '</th></thead>';
    }
    ?>

    </table>
    <?php if ($result->num_rows > 0): ?>
    <table class="table table-bordered text-center table-hover"  style="font-size: 13px" id="tblarticle">
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
            <tr id="<?php echo $row['id_article']; ?>">
                <td ><?php echo $row['id_article']; ?></td>
                <td ><?php echo $row['nom']; ?></td>
                <td ><?php echo $row['description']; ?></td>
                <td ><?php echo $row['stock_min']; ?></td>
                <td ><?php echo $row['stock_initial']; ?></td>
                <td ><?php echo is_null($row['prix']) ? 'N/A' : $row['prix']; ?></td>
                <td ><?php echo $row['unite']; ?></td>
                <td>

                    <a href="#" onclick='delteArticle(<?php echo $row["id_article"]; ?>)' style="color:red">
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
    <p></p>
<?php endif; ?>

<?php
// إغلاق الاتصال بقاعدة البيانات
$conn->close();
?>
</body>
</html>
