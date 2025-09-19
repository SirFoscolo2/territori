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

