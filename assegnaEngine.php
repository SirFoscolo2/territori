<?php 
    session_start();
    require('credentials.php');
    require './Connection.php';
   
    
    if(isset($_SESSION['username'])){
        try{
            $dataform= $_POST['data'];
            $nome = $_POST['nome'];
            $cognome = $_POST['cognome'];
            $id= $_POST['id'];
            
            $con = new Connection($host, $dbName, $dbUser, $dbPassword);
            $con->connect();
            $nome = ucwords($nome);
            $cognome = ucwords($cognome);




            
            if(empty($dataform)){
                $data=date('Y-m-d',time());
            }else{
                $data=$dataform;
            }
            
            $nextMonth = date('Y-m-d', strtotime('+1 month', strtotime($data)));
            $cont= $con->fetchOne("SELECT `data` FROM `rientrate` WHERE `id`= $id ORDER BY `data` DESC LIMIT 1");
            
            $query ="INSERT INTO `uscite`(`id`, `nome`, `cognome`, `data`) VALUES ('$id', '$nome', '$cognome', '$data')";

            //registro
            $stringaReg= $_SESSION['username'].",a,".$id.",".$nome." ".$cognome;
            
            $queryReg ="INSERT INTO `registro`(`value`, `date`) VALUES ('$stringaReg', '$data')";
            $query1 = "UPDATE `stato` SET `fuori`='1',`nome`='".$nome."',`cognome`='".$cognome."',`data`='".$data."', `scadenza`='".$nextMonth."' WHERE id = ".$id."";
            $rowF= $con-> fetchOne("SELECT * FROM `stato` WHERE `id`= \"$id\"");
            echo $rowF['fuori'];
            if(!$cont['data']&&$rowF['fuori']==0){
                $con->query($query);
                $con->query($query1);
                $con->query($queryReg);
            }else{
                if($cont['data']<=$data&&$rowF['fuori']==0){
                    $con->query($query);
                    $con->query($query1);
                    $con->query($queryReg);
                }else{
                    $_SESSION['erroreric']=true;
                }
            }
            
            $_SESSION['just-assegn']= $rowF['link'];
            $_SESSION['maps']= $rowF['maps'];
            $_SESSION['nomeTer']= $rowF['nomeTer'];
            $_SESSION['note']= $rowF['note'];
            header("location: ./assegna.php");
        
            

        }
        catch(PDOException $e){
            echo "errore ". $e->getMessage();
            return null;
        }
    }else{
        header("location: ./index.php");

    }
?>
