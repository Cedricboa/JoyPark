<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JoyPark - Là où la magie commence</title>
  <link rel="stylesheet" href="index.css">
</head>
<body class="index-page">
  <!-- En-tête avec logo -->
  <header class="top-header">
    <img src="images/logo-png.png" alt="JoyPark Logo" class="logo">
    <div class="hero-text">
        <h1>JoyPark</h1>
        <p>Là où la magie commence</p>
    </div>
</header>

  <!-- Barre de navigation noire -->
  <nav class="main-nav">
    <ul>
      <li><a href="attractions.php">Attractions</a></li>
      
      <li><a href="tickets.php">Billets</a></li>
      <li><a href="events.php">Événements</a></li>
      <li><a href="help.php">Aide</a></li>
    </ul>
  </nav>

  <!-- Contenu principal -->
  <main class="welcome-section">
    <h1>Bienvenue à JoyPark</h1>
    <p>Là où la magie commence ✨</p>
  </main>

  <!-- Pied de page -->
  <footer>
    <p>&copy; <?= date("Y") ?> JoyPark - Là où la magie commence.</p>
  </footer>
</body>
</html>
