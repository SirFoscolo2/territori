<?php
session_start();
require('credentials.php');
$nomePagina = 'Ritiro';


?>
<!DOCTYPE html>
<html lang="en">
<?php require('./header.php');
require('navigation.php');
?>

<body>
    <?php

    require('./Connection.php');
    require('./function.php');
    if (isset($_SESSION['username'])) {
        //require('./navigation.php');
        $con = new Connection($host, $dbName, $dbUser, $dbPassword);
        $con->connect();
    ?>
        <div class="container mt-6">
            <h1 id="title" class="text-center">Ritira Territorio</h1>
            <div class="user-card">


                <form class="d-flex mt-3" role="search" action="ritira.php" id="filtroNome" method="post">
                    <input class="form-control me-2" name="chiave" type="search" placeholder="Inserisci numero o nome" aria-label="Cerca" />
                    <button class="btn btn-outline-success" type="submit">Cerca</button>
                </form>
                <button type="button" onclick="toggleDiv4()" class="btn  mt-2" style="border:1px solid #dee2e6"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                    </svg></button>
                <div id="myDiv">
                    <form action="ritira.php" id="filtro" method="post" class="mt-2 w-100 ">

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



                </div>

                <script>
                    function toggleDiv4() {
                        const div = document.getElementById("myDiv");
                        div.classList.toggle("open");
                    }
                </script>
            </div>

            <?php

            $querybase = "SELECT * FROM stato WHERE fuori = '1' ";
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
                $querybase = "SELECT * FROM stato WHERE fuori = '1' AND nome like '" . $_POST['chiave'] . "%' OR fuori = '1' AND cognome like'" . $_POST['chiave'] . "%'  OR fuori = '1' AND nomeTer like'" . $_POST['chiave'] . "%'";
            }
            if (isset($_POST['chiave']) && intval($_POST['chiave']) != 0) {
                $querybase = "SELECT * FROM stato WHERE fuori = '1' AND id='" . $_POST['chiave'] . "'";
            }
            if (isset($_POST['o']) && $_POST['o'] == "si") {

                $querybase = $querybase . "  ORDER BY id ASC";
                ++$controller;
            } else {
                $querybase = $querybase . " ORDER BY data ASC";
            }

            // Simulazione di dati provenienti da un database o da un array
            $utenti = $con->fetchAll($querybase);
            if (count($utenti) == 0) {
                echo "<h2 class=\"text-center\">Non trovo nulla di simile <strong>:(</strong></h2>
      
      ";
                echo '
      <form action="ritira.php" id="filtro" method="post" class="mt-2 w-100 ">
        <button class="btn btn-outline-success d-flex justify-content-around w-100 text-center" type="submit">Vedi tutti i territori</button>
      </form>
      ';
            }
            foreach ($utenti as $utente) {
                $id = $utente['id'];
                $nomeTer = $utente['nomeTer'];
                $nome = $utente['nome'];
                $cognome = $utente['cognome'];
                $data = $utente['data'];
                $zona = $utente['zona'];

                echo '<div class="user-card" data-user-id="' . $id . '">';
                echo '    <div class="user-top">';
                echo '      <div class="user-data">';
                echo '        <div class="badge-number-red" onclick="selezione(' . $id . ')">' . $nomeTer . '</div>';
                echo '        <div>';
                echo '          <div><strong>' . $nome . ' ' . $cognome . '</strong></div>';
                echo '          <div class="user-info">Uscito: ' . convertToEuropean($data) . '</div>';
                echo '          <div class="user-location">' . $zona . '</div>';
                echo '        </div>';
                echo '      </div>';
                echo '      <div class="user-actions">';
                echo '        <button onclick="toggleDiv(' . $id . ')">';
                echo '          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">';
                echo '            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />';
                echo '            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8-5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />';
                echo '          </svg>';
                echo '        </button>';
                echo '        <button class="show-panel-button" data-action="upload">';
                echo '          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-file-earmark-arrow-down-fill" viewBox="0 0 16 16">
                                <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1m-1 4v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 0 1 .708-.708L7.5 11.293V7.5a.5.5 0 0 1 1 0" />
                            </svg>';
                echo '        </button>';
                echo '      </div>';
                echo '    </div>';
                echo "      
    
      <div id=\"" . $id . "\" class=\"content1\">
      <img src=\"./img/" . $nomeTer . ".jpg\" class=\"w-100\" alt=\"\"> 

      <button onclick=\"closeDiv(" . $id . ")\">Chiudi</button>
      </div>
   ";
                echo '    <div class="user-details-panel" id="details-' . $id . '" style="display: none;">';
                $info = '<p class="align-items-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"></path>
  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"></path>
</svg>  Nel caso la data non venisse impostata verra salvata la data di oggi
            </p>';
                echo "

    <form action=\"ritiraEngine.php\" method=\"post\">
    
      <h2 class=\"text-center mb-2 mt-2 \">Stai ritirando il territorio a $nome</h2>

      <div class=\"form-group mb-3\">
          <input class=\"form-control\" type=\"date\" id=\"dateStandard\" name=\"data\">
      </div>
      <input type=\"hidden\" value=\"$id\" name=\"id\">
      $info
      



      <button type=\"submit\" class=\"btn btn-secondary\">Ritira</button>

    </form>


    ";


                echo '</div>';
                echo '</div>';
            }

            ?>
        </div>

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
            let sele= [];
            for(let i = 0; i<140; ++i){
                sele.push(false);
            }
            let n= 0;
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
            function t2(array){
                let str= "";
                for(let i = 0; i<array.length;++i ){
                    if(array[i]==true){
                        str = str+i+";";
                    }
                }
                
                return str;
            }
            function t(array){
                let str= "";
                let c= false;
                for(let i = 0; i<array.length;++i ){
                    
                    if(array[i]==true){
                        c= true;
                        str = str+"<li class=\"list-group-item text-center\">"+ i+"</li>";
                    }
                    console.log(array);
                }
                if(c==true){
                    str= str+"<form method=\"POST\" action=\"ritiraEngine.php\"><input class=\"btn bg-warning  mt-2 w-100\" type=\"submit\" value=\"Ritira\"><input name=\"infos\" type=\"hidden\" value=\"" +t2(sele)+"\"></form>";

                }
                

                return str;
            }

            function selezione(id){
                if(document.querySelector(`[data-user-id="${id}"]`).style.border == "1px solid red"){
                    const userDiv = document.querySelector(`[data-user-id="${id}"]`);
                    userDiv.style.border = "1px solid #ddd";
                    sele[id]= false; 
                    document.getElementById("contenitoree").innerHTML=t(sele);
                    
                }else{
                    const userDiv = document.querySelector(`[data-user-id="${id}"]`);
                    userDiv.style.border = "1px solid red"; 
                    sele[id]= true;
                    console.log(sele);
                    document.getElementById("contenitoree").innerHTML=t(sele);
                }


            }
            
        </script>
        <ul class="list-group fixed-bottom right-0  p-3 w-50" id="contenitoree">

        </ul>
        <a href="#title" style="display: flex;position:fixed;bottom:1rem;right:1rem;width:30px;height:30px;background-color:green;border-radius:50%;">


        </a>

        <?php
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