<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="../meditation.css">
  <link rel="stylesheet" type="text/css" href="../styles-mobile.css" media="screen and (max-width: 767px)">
  <link rel="stylesheet" type="text/css" href="../styles-desktop.css" media="screen and (min-width: 768px)">
  <title>Meditation</title>
</head>

<body>


  <!-- include the menu sidebar -->
  <?php include 'sidebar.php'; ?>

  <a href="cart.php" id="cart-icon" title="View Cart">
    <img src="../assets/images/shopping-cart.png" alt="Cart">
  </a>

  <h1>Meditation</h1>


  <form>
    Select type of meditation
    <div>
      <input type="radio" name="meditationtype" id="mindfulness">
      <label for="mindfulness">Mindfulness Meditation</label>
      <p class="popup-description">
        Mindfulness meditation involves paying full attention to the present
        moment without judgment. It often focuses on the breath or bodily sensations and is
        excellent for reducing stress and increasing self-awareness.
      </p>

    </div>
    <div>
      <input type="radio" name="meditationtype" id="transmed">
      <label for="transmed">Transcendental Meditation</label>
      <p class="popup-description">
        TM is a mantra-based meditation technique. Practitioners repeat a specific mantra silently
        to promote relaxation and self-transcendence. It's known for its simplicity and effectiveness in reducing
        stress.
      </p>
    </div>

    <div>
      <input type="radio" name="meditationtype" id="metta">
      <label for="metta">Loving-Kindness Meditation (Metta)</label>
      <p class="popup-description">
        Metta meditation aims to cultivate feelings of love and compassion. Practitioners mentally repeat
        loving and kind phrases towards themselves and others, promoting a sense of goodwill and empathy.
      </p>
    </div>

    <div>
      <input type="radio" name="meditationtype" id="zazen">
      <label for="zazen">Zazen</label>
      <p class="popup-description">
        Zazen is a fundamental meditation practice in Zen Buddhism.
        It involves sitting in a specific posture, focusing on the breath, and
        observing thoughts without attachment. The goal is to attain insight and enlightenment.
      </p>
    </div>

    <div>
      <input type="radio" name="meditationtype" id="nidra">
      <label for="nidra">Yoga Nidra</label>
      <p class="popup-description">
        Also known as yogic sleep, Yoga Nidra is a guided meditation that induces
        deep relaxation. It often involves body scanning and visualization to reduce tension
        and promote mental clarity.
      </p>
    </div>

  </form>

  <footer>
    <p style="text-align: center;"><em>Designed and Created by Cüneyt Aksoy and Paul Keiser
        <br>
        MIT License - 2023</em>
    </p>
  </footer>

</body>

</html>