<?php
    session_start();
    require('credentials.php');
    require('./Connection.php');
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $con = new Connection($host,$dbName,$dbUser,$dbPassword);
        $con->connect();
        //$user = $_POST['user'];
        $username = $_POST['username'];
        $pass = $_POST['pass'];
        $res=$con->fetchAll("SELECT * from users where username=? and password=?",[$username,hash("sha256",$pass)]);
        if(count(value: $res )== 1){
            $_SESSION['username']= $username;
            
            
            header("location: ./index.php");

        }else{
            $_SESSION['errorLog']=true;
            header("location: ./index.php");
        }

    }

?>