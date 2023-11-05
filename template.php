<!DOCTYPE html>
<html>
<head>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lilita+One&display=swap" rel="stylesheet">
  <style>
    /* Allgemeine Stile f�r das zentrierte Layout */
    body {
      background-color: #ffcc80; /* Helloranger Hintergrund */
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-start; /* Von oben ausgerichtet */
      height: 100vh;
      margin: 0;
    }
 
    /* Stil f�r die Navigationsleiste */
    .navbar {
      background-color: orange;
      border-radius: 0 0 10px 10px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 20px;
      width: 100%;
    }
 
    /* Stil f�r das Bildcontainer auf der linken Seite */
    .logo-container {
      margin-right: 20px;
    }
 
    /* Stil f�r das Bild im Container */
    .logo-container img {
      height: 70px;
    }
 
    /* Stil f�r die Kn�pfe in der Navigationsleiste */
    .middle-buttons {
      display: flex;
      align-items: center;
    }
 
    .middle-buttons button {
      background-color: transparent;
      border: none;
      color: white;
      font-family: 'Lilita One', sans-serif;
      font-size: 16px;
      padding: 10px 20px;
      margin: 0 10px;
      border-radius: 20px;
      transition: background-color 0.3s;
    }
 
    .middle-buttons button:hover {
      background-color: #f1f1f1;
      color: orange;
    }
 
    /* Stil f�r den Logout-Button auf der rechten Seite */
    .navbar .logout-button {
      background-color: white;
      color: orange;
      font-family: 'Lilita One', sans-serif;
      border: none;
      border-radius: 20px;
      padding: 10px 20px;
    }
  </style>
</head>
<body>
 
<!-- Navigationsleiste -->
<div class="navbar">
  <div class="logo-container">
    <img src=".\img\transparent.png" alt="Logo" />
  </div>
  <div class="middle-buttons">
 
  <a href="/noodle2.0/displayshoppinglist.php">
  <button>Shoppingliste</button>
</a>
 
 
     <a href="/noodle2.0/welcome.php"> <!-- hiersoll  mal wohl welcome.html stehen !-->
    <button>Home</button>
    </a>
 
    <a href="/noodle2.0/index.php">
    <button>Kochen</button>
  </a>
  </div>
 
  <a href="/noodle2.0/logout.php">
  <button class="logout-button">Logout</button>
  </a>
</div>
