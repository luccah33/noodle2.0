<?php
include('template.php');
?>

<!DOCTYPE html>

<html>
<head>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lilita+One&display=swap" rel="stylesheet">
  <style>
    body {
      background-color: #ffcc80;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-start;
      height: 100vh;
      margin: 0;
    }

    .logo-container {
      margin-right: 20px;
    }

    .logo-container img {
      height: 70px;
    }

    .navbar .logout-button {
      background-color: white;
      color: orange;
      font-family: 'Lilita One', sans-serif;
      border: none;
      border-radius: 20px;
      padding: 10px 20px;
    }

    .welcome {
      font-family: 'Lilita One', sans-serif;
      font-size: 108px;
      color: white;
      margin-top: 20px;
    }

    .noodlen {
      font-family: 'Lilita One', sans-serif;
      font-size: 24px;
      color: white;
      margin-top: 20px;
    }

    /* Stil für das Pasta-Bildfenster */
    .pasta-window {
      display: flex;
      justify-content: center;
      align-items: center;
      width: 300px;
      height: 200px;
      border-radius: 20px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
      margin: 20px 0;
      overflow: hidden;
      position: relative;
    }

    .pasta-window img {
      max-width: 100%;
      height: auto;
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      animation: fadeImage 2s alternate;
    }

    @keyframes fadeImage {
      0% {
        opacity: 1;
      }
      100% {
        opacity: 0;
      }
    }

    /* Stil für den Noodle-Los-Button */
    .noodle-button {
      background-color: orange;
      color: white;
      font-family: 'Lilita One', sans-serif;
      font-size: 24px;
      border: none;
      border-radius: 50px;
      padding: 10px 20px;
      margin: 20px auto;
      display: block;
      cursor: pointer;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
      transition: background-color 0.3s;
    }

    .noodle-button:hover {
      background-color: #ff9966;
      transform: scale(1.05);
      color: rgb(255, 255, 255);
    }
  </style>
</head>
<body>
  <a href="logout.php"></a>

  <!-- Willkommensbereich -->
  <div class="welcome">
    Welcome!
  </div>

  <!-- Bereich "Bereit zu Noodlen" -->
  <div class="noodlen">
    Bereit zu Noodlen?
  </div>

  <!-- Pasta-Bildfenster -->
  <div class="pasta-window">
    <img src="./img/PastaBilder/Bild1.jpg" alt="PastaBild1">
  </div>

  <!-- Noodle-Los-Button mit Formular -->
  <form action="/noodle2.0/index.php" method="POST">
  <button type="submit" class="noodle-button">
    Noodle Los! &#10148;
  </button>
</form>




  <script>
    const pastaImages = [
      "./img/PastaBilder/Bild1.jpg",
      "./img/PastaBilder/Bild2.jpg",
      "./img/PastBilder/Bild3.jpg",
      "./img/PastaBilder/Bild4.jpg",
      "./img/PastaBilder/Bild5.jpg"
    ];

    const pastaWindow = document.querySelector(".pasta-window img");
    let currentImageIndex = 0;

    function changePastaImage() {
      currentImageIndex = (currentImageIndex + 1) % pastaImages.length;
      pastaWindow.src = pastaImages[currentImageIndex];
    }

    // Setze den Intervall für den Bildwechsel alle 10 Sekunden, nach einer 10-sekündigen Verzögerung
    setTimeout(function () {
      changePastaImage();
      setInterval(changePastaImage, 10000);
    }, 10000);
  </script>
</body>
</html>
