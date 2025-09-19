<?php
session_start();
require('./credentials.php');
require('./Connection.php');
require('./function.php');

if (isset($_SESSION['username'])) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tabella Territori</title>
        <style>
            *{
                padding: 0;
                margin: 0;
                border-collapse: collapse;
                text-align: center;
            }
            body {
                font-family: Arial, sans-serif;
                width: 80%;
                display: block;
                margin: auto;
            }
            table {
                border-collapse: collapse;
                width: 100%;
                margin-bottom: 4rem;
                min-width: 65rem;
                border-color: black;
                border: 5px solid black;
            }
            th, td {
               
                padding: 0.5rem;
            }
            th {
                background-color: #f2f2f2;
                padding:0;
                font-weight: lighter;
                color: #535252;
            }
            .col1 {border :1px solid black; padding: 0;}
            .col2 {border :1px solid black; padding:0;}
            .col3, .col4, .col5, .col6 {
                width: 18.5%;
                padding: 0;
                margin: 0;
            }
            .ret-top { height: 50%; 
                text-align: center;
                border: 1px solid black;
                min-height:1.5rem;    align-content: center;}
            .ret-bottom { display: flex; flex-direction: row; height: 50%;min-height:1.5rem;    }
            .ret-bottom-ret { flex: 1; border: 1px solid black;    align-content: center;}
        </style>
    </head>
    <body>
        <h1 style="margin: 1rem;">
        REGISTRAZIONE DELLE ASSEGNAZIONI DEL TERRITORIO
        </h1>
        <h2 style="display:flex;justify-content:flex-start;margin: 2rem;">
            Anno di servizio: <u>2024/25</u>
        </h2>
    <table>
        <thead>
            <tr>
                <th class="col1">Terr. N.</th>
                <th class="col2">Restituito <br>l'ultima volta</th>
                <th class="col3">
                    <div class="ret-top">Assegnato a</div>
                    <div class="ret-bottom">
                        <div class="ret-bottom-ret">Assegnato il</div>
                        <div class="ret-bottom-ret">Restituito il</div>
                    </div>
                </th>
                <th class="col4">
                    <div class="ret-top">Assegnato a</div>
                    <div class="ret-bottom">
                        <div class="ret-bottom-ret">Assegnato il</div>
                        <div class="ret-bottom-ret">Restituito il</div>
                    </div>
                </th>
                <th class="col5">
                    <div class="ret-top">Assegnato a</div>
                    <div class="ret-bottom">
                        <div class="ret-bottom-ret">Assegnato il</div>
                        <div class="ret-bottom-ret">Restituito il</div>
                    </div>
                </th>
                <th class="col6">
                    <div class="ret-top">Assegnato a</div>
                    <div class="ret-bottom">
                        <div class="ret-bottom-ret">Assegnato il</div>
                        <div class="ret-bottom-ret">Restituito il</div>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $map = []; // evita warning
            $con = new Connection($host, $dbName, $dbUser, $dbPassword);
            $con->connect();
            $row = $con->fetchAll("SELECT * FROM stato");
        
            foreach ($row as $r){
                $map[$r['id']] = $r['nomeTer'];
            }

            for ($i = 1; $i < 150; ++$i) {
                $queryUscite = $con->getConn()->prepare("
                    SELECT u.id, u.nome, u.cognome, u.data AS uscita_data
                    FROM uscite u
                    WHERE u.id = :id
                    ORDER BY u.data ASC
                ");
                $queryUscite->bindParam(':id', $i, PDO::PARAM_INT);
                $queryUscite->execute();
                $uscite = $queryUscite->fetchAll(PDO::FETCH_ASSOC);

                $queryRientri = $con->getConn()->prepare("
                    SELECT r.id, r.data AS rientro_data
                    FROM rientrate r
                    WHERE r.id = :id
                    ORDER BY r.data ASC
                ");
                $queryRientri->bindParam(':id', $i, PDO::PARAM_INT);
                $queryRientri->execute();
                $rientri = $queryRientri->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($uscite)) {
                    echo "<tr>
                        <td class=\"col1\">" . ($map[(string)$i] ?? $i) . "</td>";

                    $ultimoRientro = (!empty($rientri) && isset($rientri[count($rientri)-1]['rientro_data']))
                        ? date("d/m/Y", strtotime($rientri[count($rientri)-1]['rientro_data']))
                        : "Mai restituito";

                    echo "<td class=\"col2\">" . $ultimoRientro . "</td>";

                    $numUscite = count($uscite);
                    $numRientri = count($rientri);
                    $enter = 0;

                    for ($j = 0; $j < $numUscite; $j++) {
                        $uscita = $uscite[$j];
                        $rientro = ($j < $numRientri && isset($rientri[$j]['rientro_data']))
                            ? date("d/m/Y", strtotime($rientri[$j]['rientro_data']))
                            : "Non rientrato";

                        if ($enter % 4 == 0 && $enter != 0) {
                            echo "</tr><tr><td class=\"col1\">" . ($map[(string)$i] ?? $i) . "</td><td class=\"col2\">" . $ultimoRientro . "</td>";
                        }

                        $uscitaDataItaliana = date("d/m/Y", strtotime($uscita['uscita_data']));

                        echo "
                            <td class=\"col3\">
                                <div class=\"ret-top\"><strong>" . htmlspecialchars($uscita['nome']) . " " . htmlspecialchars($uscita['cognome']) . "</strong></div>
                                <div class=\"ret-bottom\">
                                    <div class=\"ret-bottom-ret\">" . $uscitaDataItaliana . "</div>
                                    <div class=\"ret-bottom-ret\">" . $rientro . "</div>
                                </div>
                            </td>";
                        $enter++;
                    }

                    $celleMancanti = 4 - ($enter % 4);
                    if ($celleMancanti < 4) { // evita di aggiungerle se è già pieno
                        for ($k = 0; $k < $celleMancanti; ++$k) {
                            echo "
                            <td class=\"col3\">
                                <div class=\"ret-top\"></div>
                                <div class=\"ret-bottom\">
                                    <div class=\"ret-bottom-ret\"></div>
                                    <div class=\"ret-bottom-ret\"></div>
                                </div>
                            </td>";
                        }
                    }
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
    </body>
    </html>
    <?php
} else {
    header("location: ./index.php");
}
?>
