<?php
include 'db-config.php';
include 'template.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}



$user_id = $_SESSION['user_id'];

// Retrieve user's shopping items
$stmt = $connection->prepare("SELECT id, item_name, item_quantity FROM items WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($item_id, $item_name, $item_quantity);

$shopping_list = [];
while ($stmt->fetch()) {
    $shopping_list[] = [
        'id' => $item_id,
        'name' => $item_name,
        'quantity' => $item_quantity,
    ];
}

$stmt->close();
$connection->close();
?>

<!DOCTYPE html>
<html>
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
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <h1>Shopping List</h1>
        
     <div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($shopping_list as $item) { ?>
                    <tr>
                        <td><?= $item['id'] ?></td>
                        <td><?= $item['name'] ?></td>
                        <td><?= $item['quantity']?></td>                  
                        </td>
                    </tr>
                    <?php } ?>

                </tbody>
                </table>
   
                </div>
                </div>
                <div>
        <a href="/noodle2.0/additem.php">
        <button class="logout-button">Hinzufügen</button>
        </div>
                </body>
                </html>