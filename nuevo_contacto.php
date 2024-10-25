<?php 
    require 'funciones.php';  
    require 'inc/conn.php';

    if (perfil_valido(1)) {
		header("location:vista_empleado/ve.php");
	}

    $nombre =(isset($_POST['nombre']) && !empty($_POST['nombre']))? trim($_POST['nombre']):"";
    $apellido =(isset($_POST['apellido']) && !empty($_POST['apellido']))? trim($_POST['apellido']):""; 
    $email =(isset($_POST['email']) && !empty($_POST['email']))? trim($_POST['email']):"";
    $txtIngresado =(isset($_POST['txtIngresado']) && !empty($_POST['txtIngresado']))? trim($_POST['txtIngresado']):"";
    
    $msjError = "";

    if( $nombre == ""){
        $msjError = "1"; 
    }else if( $apellido == ""){
        $msjError = "2";
    }else if( $email == ""){
        $msjError = "3"; 
    }else if( $txtIngresado == ""){
        $msjError = "4";
    }
    else{  
        global $db;
        
        //1ero detecto si el mail corresponde a un usuario registrado
        $sql1 ="SELECT `id` 
                FROM `usuario` 
                WHERE `email`='$email'
        ";     
        
        $i=0; 
 
        $rs1 = $db->query($sql1); 
        $idUsuario = "Null";
        foreach ($rs1 as $row) { 
            $i++;        
            if($i !=0)   {
                $idUsuario = $row['id'];
                break;
            }
        }; 
        
        $sql  = " INSERT INTO `consulta` (`email`, `nombre`, `apellido`, `texto`, `respondido`, `id_usuario`) 
                  VALUES ('$email','$nombre','$apellido','$txtIngresado',false, $idUsuario)
        "; 
        
        $rs = $db->query($sql);
        $msjError ="0";
    
        if ($i == 0){
            header("location:contacto.php?msj=$msjError");
        }  
        else {//si un usuario registrado ingreso una consulta           
            header("location:consulta_usuario.php?msj=$msjError");                       
        }   
    }  
?>