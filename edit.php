<?php
$RezeptID= "";
$Name="";
$Zubereitungstext="";
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
            <input type="hidden" vale ="<?php echo $RezeptID; ?>">
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
