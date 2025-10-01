<?php
session_start();
require('./credentials.php');
require('./Connection.php');
require('./function.php');
$con = new Connection($host, $dbName, $dbUser, $dbPassword);
$con->connect();
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $con->query("INSERT INTO campagna (nome,data_inizio,data_fine,note) values('" . $_POST['nome'] . "','" . $_POST['data_inizio'] . "','" . $_POST['data_fine'] . "','" . $_POST['descrizione'] . "')");
    header("Location: ./campagna.php");
}
if (isset($_GET['del'])) {
    $con->query("delete from campagna where id = " . $_GET['del'] . "");
    header("Location: ./campagna.php");
}
