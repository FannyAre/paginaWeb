<?php
    include("../funciones.php");
    global $db;
    
    $codigo =(isset($_POST['cb_productos']) && !empty($_POST['cb_productos']))? trim($_POST['cb_productos']):"";
    
    $msj= "" ;

    if($codigo == ""){
        $msj="1";
    }
    else{
        $sql = "UPDATE `producto` 
                SET `estado_producto`= 1 
                WHERE `codigo` = '$codigo' 
        ";
        
        $rs = $db->query($sql);
        $msj= "0";
    }

    header("location:ve_prod_baja.php?msj=$msj");
?>