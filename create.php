<?php
include 'db-config.php';

$Name = "";
$Zubereitungstext = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Name = $_POST["Name"];
    $Zubereitungstext = $_POST["Zubereitungstext"];

    if (empty($Name) || empty($Zubereitungstext)) {
        $errorMessage = "Bitte alle Felder ausfüllen";
    } else {
        // Füge das Rezept in die Tabelle "rezepte" ein
        $sql = "INSERT INTO rezepte (Name, Zubereitungstext) VALUES (?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ss", $Name, $Zubereitungstext);

        if ($stmt->execute()) {
            $successMessage = "Rezept erfolgreich erstellt";
            $newRezeptID = $connection->insert_id; // ID des neu erstellten Rezepts

            // Füge ausgewählte Zutaten in die Tabelle "rezept_zutat" ein
            if (isset($_POST['selectedIngredients']) && is_array($_POST['selectedIngredients'])) {
                foreach ($_POST['selectedIngredients'] as $zutatID) {
                    $sql = "INSERT INTO rezept_zutat (RezeptID, ZutatID) VALUES (?, ?)";
                    $stmt = $connection->prepare($sql);
                    $stmt->bind_param("ii", $newRezeptID, $zutatID);
                    $stmt->execute();
                }
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
    <title>Noodle - Neues Rezept anlegen</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2>Neues Rezept anlegen</h2>
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
        <form method="post">
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
                        echo "<input type='checkbox' name='selectedIngredients[]' value='{$row['ZutatID']}'> {$row['Zutat']}<br>";
                    }
                    ?>
                </div>
            </div>
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
            <div class="row mb-3">
                <div class="col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Speichern</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="index.php" role="button">Abbrechen</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
