<?php 
    session_start();
    require('credentials.php');
    require './Connection.php';
    if(isset($_SESSION['username'])){
        try{
            $con = new Connection($host, $dbName, $dbUser, $dbPassword);
            $con->connect();
            $data= date('Y-m-d',time());
            $nextMonth = date('Y-m-d', strtotime('+3 weeks', strtotime($data)));
            if(isset($_POST['infos'])){
                $terTorit= explode(";",$_POST['infos']);
                echo $_POST['infos'];
                foreach ($terTorit as $ter){
                        if($ter!=""){
                            $stringaReg= $_SESSION['username'].",r,".$ter;

                            $con->query("INSERT INTO `rientrate`(`id`, `data`) VALUES ('".intval($ter)."','".$data."')");
                            $con->query("UPDATE `stato` SET `fuori`='0',`data`='".$data."', `scadenza`= '".$nextMonth."' WHERE id = ".intval($ter)."");
                            $con->query("INSERT INTO `registro`(`value`, `date`) VALUES ('$stringaReg', '$data')");
                        }
                }

            }else{
                $dataform= $_POST['data'];


                if(empty($dataform)){
                    $data=date('Y-m-d',time());
                }else{
                    $data=$dataform;
                }
                $id= $_POST['id'];
                

                $stringaReg= $_SESSION['username'].",r,".$id;
                
                $cont= $con->fetchOne("SELECT `data` FROM `uscite` WHERE `id`= $id ORDER BY `data` DESC LIMIT 1");





                $rowF= $con->fetchOne("SELECT `fuori` FROM `stato` WHERE `id`= \"$id\"");



                if(!$cont['data']&&$rowF['fuori']==1){
                    $con->query("INSERT INTO `rientrate`(`id`, `data`) VALUES ('".$id."','".$data."')");
                    $con->query("UPDATE `stato` SET `fuori`='0',`data`='".$data."', `scadenza`= '".$nextMonth."' WHERE id = ".$id."");
                    $con->query("INSERT INTO `registro`(`value`, `date`) VALUES ('$stringaReg', '$data')");
                }else{
                    if($cont['data']<=$data&&$rowF['fuori']==1){
                        $con->query("INSERT INTO `rientrate`(`id`, `data`) VALUES ('".$id."','".$data."')");
                        $con->query("UPDATE `stato` SET `fuori`='0',`data`='".$data."', `scadenza`= '".$nextMonth."' WHERE id = ".$id."");
                        $con->query("INSERT INTO `registro`(`value`, `date`) VALUES ('$stringaReg', '$data')");
                    }else{
                        $_SESSION['erroreric']="si1";
                    }
                } 
            }
            
            
            header("location: ./ritira.php");

        }
        catch(PDOException $e){
            echo "errore ". $e->getMessage();
            return null;
        }
    }else{
        header("location: ./ritira.php");

    }


?>