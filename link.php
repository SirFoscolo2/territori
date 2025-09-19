<?php
session_start();
require('credentials.php');
$nomePagina = 'Link';


?>
<!DOCTYPE html>
<html lang="en">
<?php require('./header.php') ?>

<body class="bg-light">
    <?php

    require('Connection.php');
    require('navigation.php');

    if (isset($_SESSION['username'])) {
        //require('./navigation.php');
        $con = new Connection($host, $dbName, $dbUser, $dbPassword);
        $con->connect();
    ?>
        <h1 class="mt-6 text-center">
            Link Veloce
        </h1>
        <h2 class="mt-3 text-center">
            Inserisci il nome o numero del territorio
        </h2>
        <form method="POST" action="link.php" class="d-flex w-75 m-auto" role="search">
            <input class="form-control me-2" type="search" name="search" placeholder="ES. g01" aria-label="Search" />
            <button class="btn btn-outline-success" type="submit">Cerca</button>
        </form>
        
    <?php
    if(isset($_POST['search'])){
        $link=$con -> fetchOne("select link,nomeTer from stato where nomeTer LIKE '".$_POST['search']."%'");
        echo'<a href="'.$link['link'].'" class=" btn btn-outline-success d-flex w-50 justify-content-around m-auto mt-5" type="submit">'.$link['nomeTer'].'</a>';
    }

    } else {
        if (isset($_SESSION['error'])) {
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