<?php
session_start();
require('credentials.php');
$nomePagina = 'Note';


?>
<!DOCTYPE html>
<html lang="en">
<?php require('./header.php');

?>

<body class="mb-nav">
  <style>
    /* CSS per lo sfondo sfocato (backdrop) */
        .modal-backdrop.show {
            backdrop-filter: blur(5px); /* Applica la sfocatura */
            background-color: rgba(0, 0, 0, 0.5); /* Sfondo semi-trasparente */
        }

        /* Opzionale: per centrare il contenuto del modal se necessario, anche se Bootstrap fa un buon lavoro */
        .modal-dialog-centered {
            display: flex;
            align-items: center;
            min-height: calc(100% - 1rem); /* Assicura che sia centrato anche con poco contenuto */
        }

        /* Stile per i pulsanti all'interno del banner */
        .banner-button {
            margin: 0 10px; /* Spazio tra i pulsanti */
        }
		.btn-whatsapp {
            background-color: #25D366; /* Colore verde di WhatsApp */
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
        }
		.btn-pdf {
            background-color: #0a58ca; /* Colore verde di WhatsApp */
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
        }
		.btn-pdf:hover {
            background-color: #031b3d; /* Colore verde di WhatsApp */
			color: white;
        }
        .btn-whatsapp:hover {
            background-color: #128C7E; /* Colore al passaggio del mouse */
            color: white;
        }

  </style>
  <?php

  require('./Connection.php');
  require('./function.php');
  if (isset($_SESSION['username'])) {
    require('./navigation.php');
    $con = new Connection($host, $dbName, $dbUser, $dbPassword);
    $con->connect();
  ?>

    <div class="container mt-3">
      <h1 id="title" class="text-center">Modifica Note Territorio</h1>
      <div class="user-card">


        <form class="d-flex mt-3" role="search" action="note.php" id="filtroNome" method="post">
          <input class="form-control me-2" name="chiave" type="search" placeholder="Inserisci numero o nome" aria-label="Cerca" />
          <button class="btn btn-outline-success" type="submit">Cerca</button>
        </form>
        <button type="button" onclick="toggleDiv4()" class="btn  mt-2" style="border:1px solid #dee2e6"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
          </svg></button>
        <div id="myDiv">
          <form action="note.php" id="filtro" method="post" class="mt-2 w-100 ">

            <div class="d-flex flex-row">
              <div class="d-flex flex-column justify-content-between w-50">
                <div class="form-check form-switch ">
                  <input class="form-check-input" type="checkbox" name="l" role="switch" id="switchCheckDefault" value="si">
                  <label class="form-check-label" for="switchCheckDefault">Lariano </label>
                </div>

                <div class="form-check form-switch">

                  <input class="form-check-input" type="checkbox" name="g" role="switch" id="switchCheckDefault" value="si">
                  <label class="form-check-label" for="switchCheckDefault">Giul.</label>
                </div>
              </div>
              <div class="d-flex flex-column justify-content-between w-50">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" name="v" role="switch" id="switchCheckDefault" value="si">
                  <label class="form-check-label" for="switchCheckDefault">Velletri</label>
                </div>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" name="r" role="switch" id="switchCheckDefault" value="si">
                  <label class="form-check-label" for="switchCheckDefault">Rc. Mas.</label>
                </div>
              </div>
            </div>
            <div class="d-flex flex-row justify-content-between w-100">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="o" role="switch" id="switchCheckDefault" value="si">
                <label class="form-check-label" for="switchCheckDefault">Ordina per numero</label>
              </div>

            </div>




            <button class="btn btn-outline-success d-flex justify-content-end" type="submit">Cerca</button>

          </form>


          <label class="switch" style="display: flex;position:fixed;bottom:4rem;right:1rem;">
            <input type="checkbox" onclick="nascondiVie()">
            <span class="slider"></span>
          </label>
        </div>

        <script>
          function toggleDiv4() {
            const div = document.getElementById("myDiv");
            div.classList.toggle("open");
          }
        </script>
      </div>

      <?php

      $querybase = "SELECT * FROM stato WHERE '0' = '0'";
      $plusL = "zona = 'Lariano'";
      $plusR = "zona = 'Rc. Mas'";
      $plusV = "zona = 'Velletri'";
      $plusG = "zona = 'Giul.'";
      $controller = 0;
      if (isset($_POST['l']) && $_POST['l'] == "si") {
        if ($controller > 0) {
          $querybase = $querybase . " OR " . $plusL;
        }
        $querybase = $querybase . " AND " . $plusL;
        ++$controller;
      }
      if (isset($_POST['r']) && $_POST['r'] == "si") {
        if ($controller > 0) {
          $querybase = $querybase . " OR " . $plusR;
        }
        $querybase = $querybase . "AND " . $plusR;
        ++$controller;
      }
      if (isset($_POST['v']) && $_POST['v'] == "si") {
        if ($controller > 0) {
          $querybase = $querybase . " OR " . $plusV;
        }
        $querybase = $querybase . "AND " . $plusV;
        ++$controller;
      }
      if (isset($_POST['g']) && $_POST['g'] == "si") {
        if ($controller > 0) {
          $querybase = $querybase . " OR " . $plusG;
        }
        $querybase = $querybase . "AND " . $plusG;
        ++$controller;
      }




      if (isset($_POST['chiave'])) {
        

        if (substr($_POST['chiave'], 0, 1) == ":" || substr($_POST['chiave'], 0, 3) == "via") {
          $querybase = "SELECT * FROM stato WHERE infoAgg like '%" .  substr($_POST['chiave'], 1, strlen($_POST['chiave'])) . "%'";
        } else {
          $querybase = "SELECT * FROM stato WHERE nome like '" . $_POST['chiave'] . "%' OR cognome like'" . $_POST['chiave'] . "%' OR nomeTer like'" . $_POST['chiave'] . "%'";
        }
      }

      
    if (isset($_POST['chiave'])) {
        if (substr($_POST['chiave'], 0, 1) == ":" || substr($_SESSION['key'], 0, 3) == "via") {
          $querybase = "SELECT * FROM stato WHERE  infoAgg like '%" .  substr($_SESSION['key'], 1, strlen($_SESSION['key'])) . "%'";
        } else {
          $querybase = "SELECT * FROM stato WHERE  nome like '" . $_POST['chiave']. "%' OR cognome like'" . $_POST['chiave']. "%' OR nomeTer like'" . $_POST['chiave'] . "%'";
        } 
    }
    if (isset($_POST['chiave']) && intval($_POST['chiave']) != 0) {
        $querybase = "SELECT * FROM stato WHERE  nomeTer='" . $_POST['chiave'] . "'";
    } 
    if(!isset($_POST['chiave'])){
        $querybase = $querybase . "  ORDER BY id ASC";
        ++$controller;
    }
      
    
      // Simulazione di dati provenienti da un database o da un array
      $utenti = $con->fetchAll($querybase);
      if (count($utenti) == 0) {
        echo "<h2 class=\"text-center\">Non trovo nulla di simile <strong>:(</strong></h2>
      
      ";
        echo '
      <form action="note.php" id="filtro" method="post" class="mt-2 w-100 ">
        <button class="btn btn-outline-success d-flex justify-content-around w-100 text-center" type="submit">Vedi tutti i territori</button>
      </form>
      ';
      }
      foreach($utenti as $utente){
            echo "
            <div class=\"card w-100 mb-5\">
            <img src=\"./img/".$utente['nomeTer'].".jpg\" class=\"card-img-top\" alt=\"...\">
            <div class=\"card-body\">
                <h5 class=\"card-title\">".$utente['nomeTer']."</h5>
                <p id=\"textToCopy\" class=\"card-text\"><strong>".note($utente['note'])."</strong></p>
                
                <button class=\"btn btn-primary\" onclick=\"copyText()\"><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"white\" class=\"bi bi-copy\" viewBox=\"0 0 16 16\">
                  <path fill-rule=\"evenodd\" d=\"M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z\"/>
                </svg></button>
                <a href=\"modificaNote.php?info=".$utente['id']."\" class=\"btn btn-primary\">Modifica Note</a>
            </div>
            </div>
            ";

      }
    ?>
    
    <script>
      function copyText() {
        // recupera solo il testo, senza HTML
        const text = document.getElementById("textToCopy").innerText;

        // metodo moderno
        if (navigator.clipboard && navigator.clipboard.writeText) {
          navigator.clipboard.writeText(text).then(() => {
            alert("Copiato: " + text);
          });
        } else {
          // fallback per browser vecchi
          const tmp = document.createElement("textarea");
          tmp.value = text;
          document.body.appendChild(tmp);
          tmp.select();
          document.execCommand("copy");
          document.body.removeChild(tmp);
          alert("Copiato: " + text);
        }
      }
      let i = true;

      function nascondiVie() {
        if (i == false) {
          const vie = document.querySelectorAll('.vie');
          vie.forEach(via => via.style.display = 'none');
          i = true;
        } else {
          const vie = document.querySelectorAll('.vie');
          vie.forEach(via => via.style.display = 'block');
          i = false;
        }

      }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JavaScript per mostrare il modal automaticamente all'apertura della pagina
        document.addEventListener('DOMContentLoaded', function() {
            var myModal = new bootstrap.Modal(document.getElementById('myCenteredModal'));
            myModal.show();
        });
    </script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const showPanelButtons = document.querySelectorAll('.show-panel-button');
        const allDetailsPanels = document.querySelectorAll('.user-details-panel');

        showPanelButtons.forEach(button => {
          button.addEventListener('click', function() {
            const action = this.dataset.action;
            const userCard = this.closest('.user-card');
            const userId = userCard.dataset.userId;
            const detailsPanel = document.getElementById(`details-${userId}`);

            if (detailsPanel) {
              // Nascondi tutti i pannelli di dettaglio
              allDetailsPanels.forEach(panel => {
                if (panel !== detailsPanel) {
                  panel.style.display = 'none';
                }
              });

              // Mostra/nascondi il pannello di dettaglio corrente
              detailsPanel.style.display = detailsPanel.style.display === 'none' ? 'block' : 'none';

              console.log(`Utente ID: ${userId}, Azione: ${action}`);
              // Qui potresti anche caricare dinamicamente i dati del pannello via AJAX
              // in base a userId e action
            }
          });
        });
      });
    </script>




    <script>
      function toggleDiv(id) {

        const content = document.getElementById(id);
        if (document.getElementById(id).style.display == "flex") {
          closeDiv(id);
          return;
        }
        content.style.display = "flex";
        content.style.top = "0";
        content.style.opacity = "1";

      }

      function closeDiv(id) {
        const content = document.getElementById(id);
        content.style.display = "none";
        content.style.top = "-100px";
        content.style.opacity = "0";
      }
    </script>
    <a href="#title" style="display: flex;position:fixed;bottom:1rem;right:1rem;width:30px;height:30px;background-color:green;border-radius:50%;">


    </a>

    <?php
    if (isset($_SESSION['just-assegn'])) {
      $messaggio = "```\nTerritorio n:".$_SESSION['nomeTer'] ."\nVedi piantina: ".$_SESSION['just-assegn'] ."";
      if($_SESSION['note']!=NULL){
        $messaggio = $messaggio.note($_SESSION['note']);
      }
      $messaggio = $messaggio."```";
      $messaggio = urlencode($messaggio);
      echo '
    <div class="modal fade" id="myCenteredModal" tabindex="-1" aria-labelledby="myCenteredModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myCenteredModalLabel">Come lo vuoi assegnare?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center ">
                    <div class="container text-center mb-3">
						<a href="https://wa.me/?text='.$messaggio.'" class="btn btn-whatsapp">
							<i class="fab fa-whatsapp"></i> Invia su WhatsApp
						</a>
					</div>
					<div  class="container text-center ">
						<a href="'.$_SESSION['just-assegn'].'" class="btn btn-pdf"> Vai al PDF</a>
					</div>
                </div>
                <div class="modal-footer justify-content-center">
                    
                    <button type="button" class="btn btn-danger banner-button" data-bs-dismiss="modal">Chiudi</button>
                </div>
            </div>
        </div>
    </div>
    ';
      unset($_SESSION['just-assegn']);
    }
    if (isset($_SESSION['erroreric'])) {
      echo '
        <div id="alertBanner" class="alert alert-danger d-flex align-items-center position-fixed bottom-0 end-0 w-75 m-3" role="alert">
            <div>
                Azione non riuscita <strong> Il territorio era fuori nel giorno inserito</strong>
            </div>
        </div>
        ';
      unset($_SESSION['erroreric']);
    }

    ?>
    <script>
      setTimeout(function() {
        const alertBanner = document.getElementById('alertBanner');
        if (alertBanner) {
          alertBanner.style.transition = 'opacity 0.5s ease';
          alertBanner.style.opacity = '0';
          setTimeout(() => alertBanner.remove(), 500); // Rimuove il banner dopo la transizione
        }
      }, 5000);
    </script>
    <script>
      setTimeout(function() {
        const alertBanner = document.getElementById('alertBanner1');
        if (alertBanner) {
          alertBanner.style.transition = 'opacity 0.5s ease';
          alertBanner.style.opacity = '0';
          setTimeout(() => alertBanner.remove(), 500); // Rimuove il banner dopo la transizione
        }
      }, 5000);
    </script>



  <?php
  } else {
    header("location: ./index.php");
  }



  ?>


</body>

</html>