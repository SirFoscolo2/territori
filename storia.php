<?php session_start();
require('./credentials.php');
$nomePagina = 'Storico Territorio';
 ?>
<!DOCTYPE html>
<html lang="en">
<?php require('header.php');

require('./Connection.php');
require('./function.php');
?>
<style>
    #ntbn {
    position: fixed;
    top: 6rem;
    left: 6rem;
    transform: translateX(-50%);
    background: #333;
    color: #fff;
    padding: 10px 20px;
    border-radius: 8px;
    font-family: sans-serif;
    font-size: 14px;
    display: none;
    z-index: 1000;
    }

    #ntbn .progress-bar {
    height: 4px;
    background: #4caf50;
    margin-top: 6px;
    border-radius: 4px;
    animation: progress 1.5s linear forwards;
    }

    @keyframes progress {
    from { width: 100%; }
    to   { width: 0%; }
    }

    .closed {
        display: none;
        flex-direction: column;
        position: fixed;
        width: 80%;
        background-color: #fff;
        left: 10%;
        top: 5rem;
        z-index: 2;

    }
    #blurDiv {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(8px);
            
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 24px;
            cursor: pointer;
          
        }
    .form-mod {
        display: none;

    }
    .w-alert{
        width: 2rem;
    }
</style>

<body>
    <?php require('navigation.php') ?>
    <h1 class="text-center mt-3">Storia territorio</h1>

    <div id="ntbn" class="notification-banner" style="display: none;">
        <div class="message">Elemento cambiato</div>
        <div class="progress-bar"></div>
    </div>
    <h2 class="mt-3 text-center">
        Inserisci il nome o numero del territorio
    </h2>
    <form method="POST" action="storia.php" class="d-flex w-75 m-auto" role="search">
        <input class="form-control me-2" type="search" name="id" placeholder="ES. g01" aria-label="Search" />
        <button class="btn btn-outline-success" type="submit">Cerca</button>
    </form>
    <div id="blurDiv" ></div>

    <div class="riga" id="principale">




        <h2 id="avviso" style="display:none;">ops sembra che non ci siano movimenti per questo territorio</h2>

        <script>
            function op(id) {
                if (document.getElementById(id).style.display == "flex") {
                    document.getElementById(id).style.display = "none";
                    document.getElementById("blurDiv").style.display = "none";
                    console.log("eccolo");

                } else {
                    document.getElementById(id).style.display = "flex";
                    document.getElementById("blurDiv").style.display = "flex";
                    console.log("eccolo 2");
                }
            }
        </script>

        <?php



        if (isset($_SESSION['username'])) {

            try {
                $con = new Connection($host, $dbName, $dbUser, $dbPassword);
                $con->connect();
                if (isset($_SESSION['ricercaStoria'])) {
                    $id= $_SESSION['ricercaStoria'];
                    unset($_SESSION['ricercaStoria']);
        ?>
                    <script>
                        var progressBar = document.querySelector('.progress-bar');
                        document.getElementById("ntbn").style.display = "flex";
                        setTimeout(function() {
                            progressBar.style.width = '100%';
                        }, 100);

                        // Hide notification banner after animation
                        setTimeout(function() {
                            var banner = document.querySelector('.notification-banner');
                            banner.style.height = '0';
                            banner.style.padding = '0';
                            banner.style.overflow = 'hidden';
                        }, 2100);
                    </script>
                    <?php
                }
                if (isset($_POST['id']) ||isset($_GET['id'])) {
                    
                    if(isset($_POST['id'])){
                        $id= $_POST['id'];
                    }elseif(isset($_GET['id'])){
                        $id= $_GET['id'];
                    }
                    $nTer = 0;
                    if (!$row = $con->fetchAll("SELECT * FROM `uscite` WHERE id= " . $id . " ORDER BY data ASC")) {
                    ?>
                        <script>
                            document.getElementById("avviso").style.display = "flex";
                            setTimeout(() => {
                                document.getElementById("avviso").style.display = "none";
                            }, 1500)
                        </script>
                    <?php

                    } else {


                        echo "
                        <h1 class=\"text-center  mt-3\">N." . $id . "</h1>
                        <table class=\"table table-striped-columns\">
                        <thead>
                            <tr>

                                <th>Data</th>
                                <th>Fratello</th>
                                <th>Modifica</th>
                            </tr>
                        </thead>
                        <tbody>";
                    }
                    $index = 0;
                    $ultimaUscita;
                    $ultimoRientro;
                    $queryuscite = $con->getConn()->prepare("SELECT * FROM `uscite` WHERE id= " . $id. " ORDER BY data ASC");
                    $queryentrate =  $con->getConn()->prepare("SELECT * FROM `rientrate` WHERE id = " . $id. " ORDER BY data ASC");
                    $queryuscite->execute([]);
                    $queryentrate->execute([]);
                    $comprensivo = [];
                    while ($row = $queryuscite->fetch(PDO::FETCH_ASSOC)) {
                        $row1 = $queryentrate->fetch(PDO::FETCH_ASSOC);
                        array_push($comprensivo,$row['id_record']);
                        array_push($comprensivo,$row1['id_record']);
                    ?>
                        <script>
                            function close() {
                                document.getElementById("avviso").style.display = "none";
                            }

                            function chiudiform() {
                                document.getElementById("ricerca").style.display = "none";
                            }
                            chiudiform();
                        </script>

        <?php

                        echo "
                        <tr>
                            
                            <td>Uscito:" . convertToEuropean($row['data']) . " -> <i>(".$row['id_record'].")</i></td>
                            <td>" . $row['nome'] . " " . $row['cognome'] . "</td>
                            <td><button class=\"btn btn-outline-success\" onclick=\"op(" . $index . ")\" value=\"Modifica\"  >Modifica</button> 


                            </td>
                            
                            <div class=\"closed p-4 rounded\" id= \"" . $index . "\">
                                <div class=\"alert alert-primary d-flex align-items-center\" role=\"alert\">
                                <svg xmlns=\"http://www.w3.org/2000/svg\" class=\"bi w-alert me-2\" viewBox=\"0 0 16 16\" role=\"img\" aria-label=\"Warning:\">
                                    <path d=\"M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z\"/>
                                </svg>
                                <div>
                                    Attenzione se cancelli questa uscita del territorio verrà cancellato anche il suo rientro  
                                </div>
                                </div>
                           
                                <form class=\"form-mod\"  action=\"updateStoria.php?vecchioNome=" . $row['nome'] . "&vecchioCognome=" . $row['cognome'] . "&vecchiaData=" . $row['data']. "& id=" . $row['id'] . "& mode=1 & id_record=".$row['id_record']."\" method=\"POST\">
                                
                                    <h4>Nel caso non venisse impostato il nome, quest ultimo rimarra lo stesso di prima</h4>
                                    <input class=\"form-control me-2 mt-3\" placeholder=\"" . $row['nome'] . "\" name=\"nome\" type=\"search\" aria-label=\"Cerca\" />
                                    
                                    <input class=\"form-control me-2 mt-3\"  placeholder=\"" . $row['cognome'] . "\" name=\"cognome\" type=\"search\" aria-label=\"Cerca\" />
                                    <div class=\"form-group mt-3\">
                                        <input class=\"form-control\" type=\"date\" id=\"dateStandard\" REQUIRED name=\"data\">
                                    </div>
                                    <div class=\"d-flex flex-row justify-content-around mt-3 mb-3\">
                                        
                                       
                                        <button type=\"submit\" class=\"btn btn-success\">Modifica</button>
                                        <a href=\"updateStoria.php?mode=2 &fuori=1& id_record=".$row['id_record']."&id=".$row['id']."\"><button type=\"button\" class=\"btn btn-outline-danger\">Elimina Record</button></a>
                                        <button type=\"button\" onclick=\"op(" . $index . ")\" class=\"btn btn-outline-success\">Esci</button>
                                        
                                        
                                    </div>
                                    
                                </form>
                                

                            </div>
                        </tr>
                        

                        ";
                        $ultimaUscita = $row['data'];
                        $index++;
                        if (isset($row1['id'])) {
                            echo "                        
                            <tr>
                                
                                <td>Rientrato:" . convertToEuropean($row1['data']) . " -> <i>(".$row1['id_record'].")</i></td>
                                <td>//</td>
                                <td><button class=\"btn btn-outline-success\" value=\"Modifica\" onclick=\"op($index)\">Modifica</button></td>
                                <div class=\"closed p-4 rounded\" id= \"" . $index . "\">
                                                                <div class=\"alert alert-primary d-flex align-items-center\" role=\"alert\">
                                <svg xmlns=\"http://www.w3.org/2000/svg\" class=\"bi w-alert me-2\" viewBox=\"0 0 16 16\" role=\"img\" aria-label=\"Warning:\">
                                    <path d=\"M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z\"/>
                                </svg>
                                <div>
                                    Attenzione se cancelli questo rientro del territorio verrà cancellata anche la sua uscita
                                </div>
                                </div>
                                    <form class=\"form-mod\" action=\"updateStoria.php?vecchiaData=" . $row1['data'] . " & id=" . $row1['id'] . " & mode=0 &id_record=".$row1['id_record']."\" method=\"POST\">
                                    <h4>Inserisci una nuova data</h4>
                                    <div class=\"form-group mt-3\">
                                        <input class=\"form-control\" type=\"date\" id=\"dateStandard\" REQUIRED name=\"data\">
                                    </div>
                                    <div class=\"d-flex flex-row justify-content-around mt-3 mb-3\">
                                        
                                        <button type=\"submit\" class=\"btn btn-success\">Modifica</button>
                                        

                                        <button type=\"button\" onclick=\"op(" . $index . ")\" class=\"btn btn-outline-success\">Esci</button>
                                        
                                        
                                    </div>
                                    </form>
                                </div>
                            </tr>
                            
                            ";
                            $index++;
                            $ultimoRientro = $row1['data'];
                        }
                    }

                    //mi faccio dare l'ultimo rientro e l'ultima uscita che ha avuto il territorio 
                    $_SESSION['ultimaUscita'] = $ultimaUscita;
                    $_SESSION['ultimoRientro'] = $ultimoRientro;
                    $_SESSION['comp']= $comprensivo;
                    
                    echo '<a class="btn btn-outline-success d-flex justify-content-around w-75 m-auto mb-3 " href="./storia.php">Ricarica Pagina</a>';
                    
                }
            } catch (PDOException $e) {
                echo "errore " . $e->getMessage();
                return null;
            }
        } else {
            header("location: ./index.php");
        }

        ?>

        </tbody>
        </table>

    </div>
</body>

</html>