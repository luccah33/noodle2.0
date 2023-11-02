<?php
include 'db-config.php';

$RezeptID = "";
$Name = "";
$Zubereitungstext = "";
$Zutaten = array(); // Hier verwenden wir ein Array, um alle Zutaten zu speichern

$errorMessage = "";

// Prüfen, ob eine RezeptID zum Anzeigen übergeben wurde
if (isset($_GET['id'])) {
    $RezeptID = $_GET['id'];

    // Daten des ausgewählten Rezepts abrufen
    $sql = "SELECT r.Name, r.Zubereitungstext, z.Zutat
            FROM rezepte r
            LEFT JOIN rezept_zutat rz ON r.RezeptID = rz.RezeptID
            LEFT JOIN zutaten z ON rz.ZutatID = z.ZutatID
            WHERE r.RezeptID = $RezeptID";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $Name = $row['Name'];
        $Zubereitungstext = $row['Zubereitungstext'];
        
        // Füge die Zutaten dem Array hinzu
        $Zutaten[] = $row['Zutat'];
        
        // Verwende eine Schleife, um alle Zutaten zu erfassen
        while ($row = $result->fetch_assoc()) {
            $Zutaten[] = $row['Zutat'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noodle - Rezept anzeigen</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2 class="text-center">Rezept anzeigen</h2>
        <?php
        if (!empty($errorMessage)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
        ?>
        <form>
            <input type="hidden" name="RezeptID" value="<?php echo $RezeptID; ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Name:</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Name" value="<?php echo $Name; ?>" disabled>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Zutaten:</label>
                <div class="col-sm-6">
                    <?php
                    foreach ($Zutaten as $zutat) {
                        echo "<input type='text' class='form-control' name='Zutat' value='$zutat' disabled><br>";
                    }
                    ?>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Zubereitung:</label>
                <div class="col-sm-6">
                    <textarea class="form-control" name="Zubereitungstext" rows="5" disabled><?php echo $Zubereitungstext; ?></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="index.php" role="button">Zurück</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
