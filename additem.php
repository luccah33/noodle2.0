<?php
include('template.php');
include 'db-config.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Überprüfe, ob "item_name" und "item_quantity" im POST-Array vorhanden sind
    if (isset($_POST['item_name']) && isset($_POST['item_quantity'])) {
        $item_name = $_POST['item_name'];
        $item_quantity = $_POST['item_quantity'];
        $user_id = $_SESSION['user_id'];

        // Füge das Element in die Tabelle "items" ein
        $stmt = $connection->prepare("INSERT INTO items (user_id, item_name, item_quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $item_name, $item_quantity);

        if ($stmt->execute()) {
            $successMessage = "Item erfolgreich hinzugefügt.";
        } else {
            $errorMessage = "Fehler beim Hinzufügen des Items.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
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
    <title>Noodle - Rezepte</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"></head>
<body>
    <div class="container">
        <h1>Shopping List</h1>
        <?php
        if (!empty($errorMessage)) {
            echo "<div class='alert alert-danger'>$errorMessage</div>";
        }
        if (!empty($successMessage)) {
            echo "<div class='alert alert-success'>$successMessage</div>";
        }
        ?>
        <form method="POST">
            <div class="form-group">
                <label for="item_name">Item Name:</label>
                <input type="text" class="form-control" name="item_name" required>
            </div>
            <div class="form-group">
                <label for="item_quantity">Quantity:</label>
                <input type="number" class="form-control" name="item_quantity" required>
            </div>
            <div class="row mb-3">
    <div class="col-sm-3 d-grid">
        <button type="submit" class="btn btn-primary">Speichern</button>
    </div>
    <div class="col-sm-3 d-grid">
        <a class="btn btn-outline-primary" href="displayshoppinglist.php" role="button">Schließen</a>
    </div>
</div>
        </form>
    </div>
</body>
</html>
