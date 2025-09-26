<?php
session_start();
require('credentials.php');
require('./Connection.php');
require('./function.php');
$nomePagina = 'Campagna';


?>
<!DOCTYPE html>
<html lang="en">
<?php require('./header.php');
require('navigation.php');
?>
<style>
    /* From Uiverse.io by Yaya12085 */
    .custum-file-upload {
        height: 200px;
        width: 300px;
        display: flex;
        flex-direction: column;
        align-items: space-between;
        gap: 20px;
        cursor: pointer;
        align-items: center;
        justify-content: center;
        border: 2px dashed #cacaca;
        background-color: rgba(255, 255, 255, 1);
        padding: 1.5rem;
        border-radius: 10px;
        box-shadow: 0px 48px 35px -48px rgba(0, 0, 0, 0.1);
    }

    .custum-file-upload .icon {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .custum-file-upload .icon svg {
        height: 80px;
        fill: rgba(75, 85, 99, 1);
    }

    .custum-file-upload .text {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .custum-file-upload .text span {
        font-weight: 400;
        color: rgba(75, 85, 99, 1);
    }

    .custum-file-upload input {
        display: none;
    }

    .bg-overlay {
        position: fixed;
        display: none;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 998;
    }

    /* Card che parte nascosta */
    .bottom-card {
        position: fixed;
        bottom: -100%;
        /* parte fuori dallo schermo */
        left: 7.5%;
        width: 85%;
        transition: bottom 0.4s ease-in-out;
        z-index: 999;
        max-height: 30rem;
        overflow: scroll;
    }

    /* Stato attivo → visibile */
    .bottom-card.active {
        bottom: 5rem;
    }
</style>
<div class="container mt-3 mb-nav">
    <h1 id="title" class="text-center mb-3">Campagne Speciali</h1>


    <!-- Sfondo scuro -->
    <div id="bgOverlay" class="bg-overlay" onclick="hideCard()"></div>
    <button class="btn btn-secondary d-flex m-auto align-items-center" onclick="showCard()"><i class="bi bi-calendar2-plus"> Aggiungi Campagna</i></button>
    <!-- Card che sale dal basso -->
    <div id="bottomCard" class="bottom-card ">
        <div class="card mb-4 ">

            <!-- Upload immagine -->
            <!-- From Uiverse.io by Yaya12085 -->

            <div class="card-body">
                <form method="post" action="./elimina.php" enctype="multipart/form-data">

                    <!-- Titolo -->
                    <div class="mb-3">
                        <label class="form-label">Titolo</label>
                        <input type="text" name="nome" class="form-control" placeholder="Inserisci Nome" required>
                    </div>

                    <!-- Date -->
                    <div class="mb-3">
                        <label class="form-label">Dal</label>
                        <input type="date" name="data_inizio" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Al</label>
                        <input type="date" name="data_fine" class="form-control" required>
                    </div>

                    <!-- Descrizione -->
                    <div class="mb-3">
                        <label class="form-label">Descrizione</label>
                        <textarea name="descrizione" class="form-control" rows="3" placeholder="Inserisci descrizione"></textarea>
                    </div>

                    <!-- Avanzamento -->




                    <!-- Pulsanti -->
                    <div class="d-flex flex-row justify-content-around">
                        <button type="submit" class="btn btn-primary w-40">Salva</button>
                        <button type="reset" class="btn btn-danger w-40" onclick="hideCard()">Annulla</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        // Anteprima immagine caricata
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById('preview').src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        // Aggiorna barra progresso live
        document.querySelector('input[name="progresso"]').addEventListener('input', function() {
            const val = this.value;
            const bar = document.getElementById('progress-bar');
            bar.style.width = val + "%";
            bar.textContent = val + "%";
        });
    </script>
    <div class="cards d-flex flex-row justify-content-around flex-wrap">
        <?php
        if (isset($_SESSION['username'])) {
            $con = new Connection($host, $dbName, $dbUser, $dbPassword);
            $con->connect();

            // Connessione DB



            $sql = "SELECT * FROM campagna";


            $result = $con->fetchAll($sql);

            if (count($result) > 0) {
                foreach ($result as $camp) {
                    renderCampagna($camp['nome'], $camp['data_inizio'], $camp['data_fine'], $camp['note'], $camp['id'], $con);
                }
            } else {
                echo "<p>Nessuna campagna trovata</p>";
            }
        } else {
            header("location: ./index.php");
        }
        ?>









    </div>
</div>

<script>
    function showCard() {
        document.getElementById("bottomCard").classList.add("active");
        document.getElementById("bgOverlay").style.display = "block";
    }

    function hideCard() {
        document.getElementById("bottomCard").classList.remove("active");
        document.getElementById("bgOverlay").style.display = "none";
    }
</script>

</body>

</html>