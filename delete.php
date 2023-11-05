<?php
include 'db-config.php';
include('template.php');

$RezeptID = "";
$Name = "";
$Zubereitungstext = "";

$errorMessage = "";
$successMessage = "";

// Prüfen, ob eine RezeptID zum Löschen übergeben wurde
if (isset($_GET['id'])) {
    $RezeptID = $_GET['id'];

    // Daten des ausgewählten Rezepts abrufen
    $sql = "SELECT * FROM rezepte WHERE RezeptID = $RezeptID";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $Name = $row['Name'];
        $Zubereitungstext = $row['Zubereitungstext'];
    }
}

// Prüfen, ob das Löschen bestätigt wurde
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $confirmDelete = isset($_POST['confirmDelete']) ? $_POST['confirmDelete'] : "";

    if ($confirmDelete === "Ja") {
        // Lösche zuerst verknüpfte Datensätze in rezept_zutat Tabelle
        $sql = "DELETE FROM rezept_zutat WHERE RezeptID = $RezeptID";
        $connection->query($sql);

        // Dann das Rezept löschen
        $sql = "DELETE FROM rezepte WHERE RezeptID = $RezeptID";
        if ($connection->query($sql) === TRUE) {
            $successMessage = "Rezept wurde erfolgreich gelöscht";

            // Weiterleitung zur Indexseite nach erfolgreichem Löschen
            header("Location: index.php");
            exit;
        } else {
            $errorMessage = "Fehler beim Löschen des Rezepts: " . $connection->error;
        }
    } else {
        // Löschen abgebrochen, zur Indexseite weiterleiten
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lilita+One&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #ffcc80 !important;
            font-family: 'Lilita One', sans-serif !important;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noodle - Rezept löschen</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2>Rezept löschen</h2>
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
        <?php
        if (!empty($successMessage)) {
            echo "
            <div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>$successMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
        ?>
        <form method="post">
            <input type="hidden" name="RezeptID" value="<?php echo $RezeptID; ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Name:</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Name" value="<?php echo $Name; ?>" disabled>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Zubereitung:</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Zubereitungstext" value="<?php echo $Zubereitungstext; ?>" disabled>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3 d-grid">
                    <button type="submit" name="confirmDelete" value="Ja" class="btn btn-danger">Löschen</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="index.php" role="button">Abbrechen</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
