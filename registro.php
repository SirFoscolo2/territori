<?php
session_start();
require('credentials.php');
if (isset($_SESSION['username'])) {
    require './Connection.php';
    require('./function.php');
    $con = new Connection($host, $dbName, $dbUser, $dbPassword);
    $con->connect();
    $info = $con->fetchAll("SELECT * FROM registro ORDER BY id DESC");
    



?>
    <!DOCTYPE html>
    <html lang="en">
    <?php require('./header.php')?>


    <body>
    <?php require('./navigation.php')?>

        <h1 class="titolo  mt-3 text-center">
            Registro attivita
        </h1>
        <div class="container">
            <table class="table  table-striped">
                <thead>
                    <tr>    
                        <th>Utente</th>
                        <th>Azione</th>
                        <th>Ter</th>

                        <th>Data</th>
                        <th>Fratello</th>



                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($info as $data) {
                        $splitted = explode(",", $data['value']);
                        $res=$con->fetchOne("select nomeTer from stato where id=".$splitted[2]."");
                        if ($splitted[1] == "a") {
                            echo "      
                        <tr>
                        <td>" . $splitted[0] . "</td>
                        <td style=\"background-color:rgb(151, 204, 162);\">➡️</td>
                        <td>" . $res['nomeTer'] . "</td>
                        <td>" . convertToEuropean($data['date']) . "</td>
                        <td>" . $splitted[3] . "</td>
                        
                      </tr>";
                        } else {
                            echo "      
                        <tr>
                        <td>" . $splitted[0] . "</td>
                        <td style=\"background-color:rgb(196, 129, 103);\">⬅️</td>
                        <td>" . $res['nomeTer'] . "</td>
                        <td>" . convertToEuropean($data['date']) . "</td>
                        <td>//</td>
                        
                      </tr>";
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </body>

    </html>
<?php
} else {
    header("location: ../index.php");
}

?>