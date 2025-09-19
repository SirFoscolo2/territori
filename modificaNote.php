<?php
session_start();
require('credentials.php');
$nomePagina = 'ModificaNota';


?>
<!DOCTYPE html>
<html lang="en">
<?php require('./header.php');
require('navigation.php');
?>

<body>
    <h1 id="title" class="text-center mt-6">Modifica Interattiva</h1>
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
    //require('./navigation.php');
    $con = new Connection($host, $dbName, $dbUser, $dbPassword);
    $con->connect();



    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       
        if(isset($_POST['campi'])){
            $stringaNuova= "";
           foreach ($_POST['campi'] as $campo){
            $stringaNuova= $stringaNuova.$campo.";";
           }
           $con->query("update stato set note= ".$stringaNuova." ");

        }
    }
    
    $res= $con->fetchOne("select note from stato where id= '".$_GET['info']."'");

  ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
        function addInput(value) {
        const container = document.getElementById("inputContainer");

        // div per il gruppo input
        const div = document.createElement("div");
        div.className = "input-group mb-2";

        // input di testo
        const input = document.createElement("input");
        input.type = "text";
        input.name = "campi[]";
        input.className = "form-control";
        if(value!="vuoto"){
            input.value=value;
        }else{
            input.placeholder = "Inserisci testo...";
        }
        

        // bottone rimuovi
        const btn = document.createElement("button");
        btn.type = "button";
        btn.className = "btn btn-outline-danger";
        btn.innerHTML = '<i class="bi bi-trash"></i>'; // icona cestino
        btn.onclick = function() {
        div.remove();
        };

        // compongo il gruppo
        div.appendChild(input);
        div.appendChild(btn);

        container.appendChild(div);
    }
</script>

    <div class="container py-5">
    <form id="myForm" class="card shadow p-4" method="POST" action ="">
        <h3 class="mb-4 text-center">Form con input dinamici</h3>

        <div id="inputContainer" class="mb-3">
        <!-- Qui compariranno gli input -->
        <script>
            let string= "<?=$res['note']?>";
            console.log("stringa"+string);
            let stringSplit= string.split(";");
            for(let i = 0; i<stringSplit.length-1; ++i){
                addInput(stringSplit[i]);
                console.log(stringSplit[i]);
            }
        </script>
        </div>

        <div class="d-flex justify-content-between flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary flex-grow-1" onclick="addInput('vuoto')">
            <i class="bi bi-plus-circle"></i> Aggiungi input
        </button>
        <button type="submit" class="btn btn-success flex-grow-1">
            <i class="bi bi-send"></i> Invia
        </button>
        </div>
    </form>
    </div>
    <form action="note.php" id="filtro" method="post" class="container py-5 ">
        <button class="btn btn-outline-success d-flex justify-content-around w-100 text-center" type="submit">Torna alle Note</button>
      </form>
    <script>


    
    </script>

  <?php
  } else {
    header("location: ./index.php");
  }



  ?>


</body>

</html>