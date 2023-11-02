<?php
include 'db-config.php';

$RezeptID = "";
$Name = "";
$Zubereitungstext = "";
$selectedIngredients = array(); // Array für ausgewählte Zutaten

$errorMessage = "";
$successMessage = "";

// Prüfen, ob eine RezeptID zum Bearbeiten übergeben wurde
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

    // Ausgewählte Zutaten für das Rezept abrufen
    $sql = "SELECT ZutatID FROM rezept_zutat WHERE RezeptID = $RezeptID";
    $result = $connection->query($sql);

    while ($row = $result->fetch_assoc()) {
        $selectedIngredients[] = $row['ZutatID'];
    }
}

// Prüfen, ob ein Formular gesendet wurde (zum Speichern von Änderungen oder Erstellen eines neuen Rezepts)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $RezeptID = isset($_POST['RezeptID']) ? $_POST['RezeptID'] : "";
    $Name = $_POST["Name"];
    $Zubereitungstext = $_POST["Zubereitungstext"];
    $selectedIngredients = isset($_POST['selectedIngredients']) ? $_POST['selectedIngredients'] : array();

    if (empty($Name) || empty($Zubereitungstext)) {
        $errorMessage = "Bitte Name und Zubereitungstext angeben";
    } else {
        if (empty($RezeptID)) {
            // Neues Rezept erstellen
            $sql = "INSERT INTO rezepte (Name, Zubereitungstext) VALUES (?, ?)";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("ss", $Name, $Zubereitungstext);
        } else {
            // Rezept aktualisieren
            $sql = "UPDATE rezepte SET Name = ?, Zubereitungstext = ? WHERE RezeptID = ?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("ssi", $Name, $Zubereitungstext, $RezeptID);
        }

        if ($stmt->execute()) {
            $successMessage = "Rezept erfolgreich gespeichert";

            // Verknüpfung von Rezept und Zutaten in der Tabelle rezept_zutat aktualisieren
            $sql = "DELETE FROM rezept_zutat WHERE RezeptID = ?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("i", $RezeptID);
            $stmt->execute();

            foreach ($selectedIngredients as $zutatID) {
                $sql = "INSERT INTO rezept_zutat (RezeptID, ZutatID) VALUES (?, ?)";
                $stmt = $connection->prepare($sql);
                $stmt->bind_param("ii", $RezeptID, $zutatID);
                $stmt->execute();
            }

            // Weiterleitung zur Indexseite nach erfolgreichem Speichern
            header("Location: index.php");
            exit;
        } else {
            $errorMessage = "Fehler beim Speichern des Rezepts";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noodle - Rezept bearbeiten</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2>Rezept bearbeiten</h2>
        <?php
        if (!empty($errorMessage)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
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
                    <input type="text" class="form-control" name="Name" value="<?php echo $Name; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Zubereitung:</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Zubereitungstext" value="<?php echo $Zubereitungstext; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Zutaten auswählen:</label>
                <div class="col-sm-6">
                    <?php
                    // Lade alle verfügbaren Zutaten aus der Tabelle "zutaten"
                    $sql = "SELECT ZutatID, Zutat FROM zutaten";
                    $result = $connection->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        $isChecked = in_array($row['ZutatID'], $selectedIngredients) ? "checked" : "";
                        echo "<input type='checkbox' name='selectedIngredients[]' value='{$row['ZutatID']}' $isChecked> {$row['Zutat']}<br>";
                    }
                    ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Speichern</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="index.php" role="button">Abbrechen</a>
                </div>
            </div>
        </form>
        <a class="btn btn-primary" href="add-zutat.php">Zutat hinzufügen</a>
    </div>
</body>
</html>
