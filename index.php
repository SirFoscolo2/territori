<?php
session_start();
require('credentials.php');
$nomePagina = 'Home';


?>
<!DOCTYPE html>
<html lang="en">
<?php require('./header.php')?>

<body class="bg-light p-3">
    <?php

    require('Connection.php');

    if (isset($_SESSION['username'])) {
        //require('./navigation.php');
        $con = new Connection($host, $dbName, $dbUser, $dbPassword);
        $con->connect();
        $tFuori= $con->fetchOne("SELECT COUNT(*) AS numero_territori_fuori FROM stato WHERE fuori = 1;");
        $media= $con->fetchOne("SELECT AVG(frequenza) AS frequenza_media FROM (SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(value, ',', 3), ',', -1) AS territorio, COUNT(*) AS frequenza FROM registro WHERE date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) GROUP BY territorio) AS conteggi_territori;");
        $terScaduti= $con->fetchOne("SELECT
            COUNT(*) AS numero_territori_usciti
            FROM stato
            WHERE
            data < DATE_SUB(CURDATE(), INTERVAL 3 MONTH);");
        $assOggi= $con->fetchOne("SELECT
            COUNT(DISTINCT SUBSTRING_INDEX(SUBSTRING_INDEX(value, ',', 3), ',', -1)) AS numero_territori_assegnati_oggi
            FROM registro
            WHERE
            date = CURDATE()
            AND SUBSTRING_INDEX(SUBSTRING_INDEX(value, ',', 2), ',', -1) = 'a';");
        $assOggiPlus= $con->fetchOne("SELECT
  (
    SELECT COUNT(DISTINCT SUBSTRING_INDEX(SUBSTRING_INDEX(value, ',', 3), ',', -1))
    FROM registro
    WHERE
      date = CURDATE()
      AND SUBSTRING_INDEX(SUBSTRING_INDEX(value, ',', 2), ',', -1) = 'a'
    ) -
    (
    SELECT COUNT(DISTINCT SUBSTRING_INDEX(SUBSTRING_INDEX(value, ',', 3), ',', -1))
    FROM registro
        WHERE
        date = DATE_SUB(CURDATE(), INTERVAL 1 DAY)
        AND SUBSTRING_INDEX(SUBSTRING_INDEX(value, ',', 2), ',', -1) = 'a'
    ) AS differenza_assegnazioni;");
        require('./indexContent.php');
    } else {
        if (isset($_SESSION['errorLog'])) {
            echo '
                <div class="alert alert-danger d-flex align-items-center w-25 h-3" role="alert">
                    
                    <div>
                        Email o Password Errate
                    </div>
                </div>
            ';
        }

        require('./login2.php');
    }


    ?>
</body>

</html>

