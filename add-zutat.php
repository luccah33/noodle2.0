<?php
include 'db-config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $zutat = $_POST['zutat'];

    if (!empty($zutat)) {
        $sql = "INSERT INTO zutaten (Zutat) VALUES (?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("s", $zutat);

        if ($stmt->execute()) {
            header("Location: create.php"); // Zurück zu create.php
            exit;
        } else {
            $errorMessage = "Fehler beim Hinzufügen der Zutat.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zutat hinzufügen</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2>Zutat hinzufügen</h2>
        <?php
        if (!empty($errorMessage)) {
            echo "
            <div class='alert alert-danger' role='alert'>
                $errorMessage
            </div>
            ";
        }
        ?>
        <form method="post">
            <div class="mb-3">
                <label for="zutat" class="form-label">Zutat:</label>
                <input type="text" class="form-control" id="zutat" name="zutat" required>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Fertig</button>
                <a class="btn btn-secondary" href="create.php">Abbrechen</a>
            </div>
        </form>
    </div>
</body>
</html>
