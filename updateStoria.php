<?php
session_start();
require('./credentials.php');
require('./Connection.php');
require('./function.php');
$mode=$_GET['mode'];

if($mode=="1"){
    $nnome = $_POST['nome'];
    $ncognome = $_POST['cognome'];
    $ndata = $_POST['data'];
    $vnome = $_GET['vecchioNome'];
    $vcognome = $_GET['vecchioCognome'];
    $vdata = $_GET['vecchiaData'];
    //prendo l'ultima data con cui ha interagito il terriotrio 
    $ultimaUscita= $_SESSION['ultimaUscita'];
    //pulisco la variabile di sessione
    $_SESSION['ultimaUscita']="";
    
    $id = $_GET['id'];
    if(empty($nnome)){
        $nnome= $vnome;
    }
    if(empty($ncognome)){
        $ncognome= $vcognome;

    }


    try {
        $con = new Connection($host, $dbName, $dbUser, $dbPassword);
        $con->connect();
        $query = $con->getConn()->prepare("UPDATE `uscite` SET `nome`=:nnome, `cognome`=:ncognome,`data`=:ndata WHERE `id`=:id AND `cognome`=:vcognome AND `nome`=:vnome AND `data`=:vdata");
        //query controllo, prendo la data nello stato che sarà l'ultima data con cui si è interagito
        
        $result=$con->fetchOne("SELECT `fuori` FROM `stato` WHERE `id`='".$id."'");   
        //se l'ultima data corrisponde a quella che sto modificando e il territorio è fuori, salvo in stato la data modificata 
        if($result['fuori']==1 && $vdata= $ultimaUscita){
            $query1 = $con->getConn()->prepare("UPDATE `stato` SET `data`=:ndata WHERE `id`=:id ");
            $query1->bindParam(':id', $id); 
            $query1->bindParam(':ndata', $ndata);          
            $query1->execute();
            

        }
        $query->bindParam(':nnome', $nnome);
        $query->bindParam(':ncognome', $ncognome);
        $query->bindParam(':ndata', $ndata);
        $query->bindParam(':id', $id);
        $query->bindParam(':vcognome', $vcognome);
        $query->bindParam(':vnome', $vnome);
        $query->bindParam(':vdata', $vdata);
        $query->execute();
        
        $_SESSION['ricercaStoria']= $id;
        
        header("location: ./storia.php");
        exit();
    } catch(PDOException $e) {
        echo "Errore: " . $e->getMessage();
    }
}elseif($mode=="0"){

    $ultimoRientro=$_SESSION['ultimoRientro'];
    $_SESSION['ultimoRientro']="";
    $ndata = $_POST['data'];

    $vdata = $_GET['vecchiaData'];
    $id = $_GET['id'];

    try {
        $con = new Connection($host, $dbName, $dbUser, $dbPassword);
        $con->connect();
        $query = $con->getConn()->prepare("UPDATE `rientrate` SET `data`=:ndata WHERE `id`=:id AND `data`=:vdata");
        
        //query controllo, prendo la data nello stato che sarà l'ultima data con cui si è interagito

        $result=$con->fetchOne("SELECT `fuori` FROM `stato` WHERE `id`='".$id."'");   
   
        //se l'ultima data corrisponde a quella che sto modificando e il territorio è fuori, salvo in stato la data modificata 
        if($result['fuori']==0 && $vdata= $ultimoRientro){
            $query1 = $con->getConn()->prepare("UPDATE `stato` SET `data`=:ndata WHERE `id`=:id ");
            $query1->bindParam(':id', $id); 
            $query1->bindParam(':ndata', $ndata);          
            $query1->execute();
            

        }
        $query->bindParam(':ndata', $ndata);
        $query->bindParam(':id', $id);
        $query->bindParam(':vdata', $vdata);
        $query->execute();
        $_SESSION['ricercaStoria']= $id;
        header("location: ./storia.php");
        exit();
    } catch(PDOException $e) {
        echo "Errore: " . $e->getMessage();
    }
}
?>
