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
    <title>Shopping List</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
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
