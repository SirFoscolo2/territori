<?php
session_start();
require('credentials.php');
require './Connection.php';
if (isset($_SESSION['username'])) {
    try {
        $con = new Connection($host, $dbName, $dbUser, $dbPassword);
        $con->connect();
        $data = date('Y-m-d', time());
        $nextMonth = date('Y-m-d', strtotime('+3 weeks', strtotime($data)));

        


        $data = date('Y-m-d', time());
        $id = $_GET['id'];
        $nome= $_GET['nome'];
        $cognome= $_GET['cognome'];
        $stringaReg = $_SESSION['username'] . ",r," . $id; 
        $con->query("INSERT INTO `rientrate`(`id`, `data`) VALUES ('" . $id . "','" . $data . "')");
        $con->query("UPDATE `stato` SET `fuori`='0',`data`='" . $data . "', `scadenza`= '" . $nextMonth . "' WHERE id = " . $id . "");
        $con->query("INSERT INTO `registro`(`value`, `date`) VALUES ('$stringaReg', '$data')");

        
        $stringaReg= $_SESSION['username'].",a,".$id.",".$nome." ".$cognome;
        $con->query("INSERT INTO `registro`(`value`, `date`) VALUES ('$stringaReg', '$data')");
        $con->query("INSERT INTO `uscite`(`id`, `nome`, `cognome`, `data`) VALUES ('$id', '$nome', '$cognome', '$data')");
        $con->query("UPDATE `stato` SET `fuori`='1',`nome`='".$nome."',`cognome`='".$cognome."',`data`='".$data."', `scadenza`='".$nextMonth."' WHERE id = ".$id."");



        header("location: ./ritira.php");
    } catch (PDOException $e) {
        echo "errore " . $e->getMessage();
        return null;
    }
} else {
    header("location: ./ritira.php");
}
