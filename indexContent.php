<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="./styleIndex.css">
<div class="container py-3">
  <div id="splashOverlay" class="overlay" aria-hidden="true">
    <!-- From Uiverse.io by dexter-st -->
    <div class="loader-wrapper">
      <span class="loader-letter">B</span>
      <span class="loader-letter">e</span>
      <span class="loader-letter">n</span>
      <span class="loader-letter">v</span>

      <span class="loader-letter">e</span>
      <span class="loader-letter">n</span>
      <span class="loader-letter">u</span>
      <span class="loader-letter">t</span>
      <span class="loader-letter">o</span>

      <div class="loader"></div>
    </div>


  </div>
  <h1 class="welcome-title">✨ Benvenuto <?= $_SESSION['username'] ?> ✨</h1>

</div>

<!-- Card 1 -->
<div class="stat-card bg-white d-flex justify-content-between align-items-center">
  <div>
    <div class="stat-label">Territori Attualmente Fuori</div>
    <div class="stat-value"><?= $tFuori['numero_territori_fuori'] ?></div>
    <div class="stat-out"><?= $terScaduti['numero_territori_usciti'] ?> Ter. Scaduti</div>
  </div>
  <div class="stat-icon">
    <i class="bi bi-geo-alt"></i>
  </div>

</div>
<div class="stat-card bg-white d-flex justify-content-between align-items-center">
  <div>
    <div class="stat-label">Media Percorrenza Territorio</div>
    <div class="stat-value"><?= $media['frequenza_media'] ?></div>
    <div class="stat-change">Negli ultimi 6 mesi</div>
  </div>
  <div class="stat-icon">
    <i class="bi bi-info-square"></i>
  </div>

</div>


<!-- Card con pulsanti -->
<div class="stat-card bg-sel d-flex justify-content-between align-items-center">


  <div class="d-flex flex-wrap gap-3">
    <a href="assegna.php" class="action-btn">
      <div class="action-btn text-success">
        <i class="bi bi-link-45deg"></i>
        <div href="assegna.php" class="action-label text-success">Assegna</div>
      </div>
    </a>
    <a href="ritira.php" class="action-btn">
      <div class="action-btn text-danger">
        <i class="bi bi-layer-backward"></i>
        <div href="ritira.php" class="action-label text-danger">Ritira</div>
      </div>
    </a>
    <a href="storia.php" class="action-btn">
      <div class="action-btn text-primary">
        <i class="bi bi-clock-history"></i>
        <div class="action-label text-primary">Storia</div>
      </div>
    </a>
    <a href="registro.php" class="action-btn">
      <div class="action-btn text-primary">
        <i class="bi bi-journal-text"></i>
        <div class="action-label text-primary">Registro</div>
      </div>
    </a>


  </div>
</div>



<!-- Card 2 -->
<div class="stat-card bg-white d-flex justify-content-between align-items-center">
  <div>
    <div class="stat-label">Assegnati Oggi</div>
    <div class="stat-value"><?= $assOggi['numero_territori_assegnati_oggi'] ?></div>
    <div class="stat-change text-primary"><?php

                                          if (intval($assOggiPlus['differenza_assegnazioni']) > 0) {
                                            echo "+";
                                          } else {
                                            echo "-";
                                          }
                                          echo $assOggiPlus['differenza_assegnazioni'];
                                          ?> vs ieri</div>
  </div>
  <div class="stat-icon" style="background: rgba(40,167,69,0.1); color:#28a745;">
    <i class="bi bi-person-check"></i>
  </div>
</div>

<!-- Card 3 -->
<div class="stat-card bg-sel d-flex justify-content-between align-items-center">


  <div class="d-flex flex-wrap gap-3">
    <a href="link.php" class="action-btn">
      <div class="action-btn text-primary">
        <i class="bi bi-speedometer2"></i>
        <div class="action-label text-primary">Link Veloce</div>
      </div>
    </a>
    <a href="registro.php" class="action-btn">
      <div class="action-btn text-success">
        <i class="bi bi-journal-text"></i>
        <div class="action-label text-success">Registro</div>
      </div>
    </a>
    <a href="Foglio2.php" class="action-btn">
      <div class="action-btn text-warning">
        <i class="bi bi-eye"></i>
        <div class="action-label text-warning">Sorv.</div>
      </div>
    </a>
    <a href="note.php" class="action-btn">
      <div class="action-btn text-danger">
        <i class="bi bi-stickies"></i>
        <div class="action-label text-danger">Note</div>
      </div>
    </a>
  </div>
  <?php

  if (!isset($_SESSION['start'])) {
  ?>
    <script>
      (function() {
        const overlay = document.getElementById('splashOverlay');

        // Dopo 1 secondo (1000 ms) avvia la sfumatura
        setTimeout(() => {
          overlay.classList.add('hidden');
        }, 1000);

        // Dopo che la transizione è finita, rimuoviamo l'elemento dal DOM (opzionale)
        overlay.addEventListener('transitionend', (e) => {
          if (e.propertyName === 'opacity' && overlay.classList.contains('hidden')) {
            overlay.remove();
          }
        });

        // Se preferisci che la sfumatura duri esattamente 1 secondo,
        // cambia "transition: opacity 600ms" in "transition: opacity 1000ms" nel CSS.
      })();
    </script>
  <?php
    $_SESSION['start'] = true;
  } else {
  ?>
    <script>
      (function() {
        const overlay = document.getElementById('splashOverlay');

        // Dopo 1 secondo (1000 ms) avvia la sfumatura
        
          overlay.classList.add('hidden');
        

        // Dopo che la transizione è finita, rimuoviamo l'elemento dal DOM (opzionale)
        overlay.addEventListener('transitionend', (e) => {
          if (e.propertyName === 'opacity' && overlay.classList.contains('hidden')) {
            overlay.remove();
          }
        });

        // Se preferisci che la sfumatura duri esattamente 1 secondo,
        // cambia "transition: opacity 600ms" in "transition: opacity 1000ms" nel CSS.
      })();
    </script>
  <?php
  }


  ?>
</div>
<a class="btn btn-danger d-flex text-center justify-content-center" href="logout.php">Esegui Logout</a>