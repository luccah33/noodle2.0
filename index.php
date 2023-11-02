<?php
include 'db-config.php';

// Abfrage, um alle Rezepte mit ihren Zutaten zu erhalten
$sql = "SELECT r.RezeptID, r.Name, r.Zubereitungstext, GROUP_CONCAT(z.Zutat SEPARATOR ', ') AS Zutaten
        FROM rezepte r
        LEFT JOIN rezept_zutat rz ON r.RezeptID = rz.RezeptID
        LEFT JOIN zutaten z ON rz.ZutatID = z.ZutatID
        GROUP BY r.RezeptID";

$result = $connection->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noodle - Rezepte</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2>Rezepte</h2>
        <a class="btn btn-primary" href="create.php" role="button">Neues Rezept</a>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>RezeptID</th>
                    <th>Name</th>
                    <th>Zutaten</th>
                    <th>Zubereitungstext</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['RezeptID']}</td>";
                        echo "<td>{$row['Name']}</td>";
                        echo "<td>{$row['Zutaten']}</td>";
                        echo "<td>{$row['Zubereitungstext']}</td>";
                        echo "<td> 
                                <a class='btn btn-primary btn-sm' href='edit.php?id={$row['RezeptID']}'>Edit</a>
                                <a class='btn btn-danger btn-sm' href='delete.php?id={$row['RezeptID']}'>Delete</a>
                                <a class='btn btn-primary btn-sm' href='view.php?id={$row['RezeptID']}'>Ansehen</a>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Keine Rezepte gefunden.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
