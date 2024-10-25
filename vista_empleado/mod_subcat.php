<?php 
    //*********************/
    //se puede modificar el nombre
    //*********************/
    require '../funciones.php';  
    require '../inc/conn.php';
    
    $codCat = (isset($_POST['cb_categoria']) && !empty($_POST['cb_categoria']))? trim($_POST['cb_categoria']):"";
    $codSubCat = (isset($_POST['cb_subcategoria']) && !empty($_POST['cb_subcategoria']))? trim($_POST['cb_subcategoria']):"";
    $nombreNuevo = (isset($_POST['nombreCat']) && !empty($_POST['nombreCat']))? trim($_POST['nombreCat']):"";

    $msj = ""; 

    if($codCat == ""){
        $msj = "1";
    }
    else if($codSubCat == ""){
        $msj = "2";
    }
    else if($nombreNuevo == ""){
        $msj = "3";
    }
    else{//solo se puede cambiar el nombre
        
        $sql = "UPDATE `subcategoria` 
                SET `nombre_subcategoria`='$nombreNuevo'
                WHERE `cod_subcategoria`= $codSubCat;
        "; 

        $rs = $db->query($sql);   
        $msj = "0" ;
    }
        
    header("location:ve_subc_mod.php?msj=$msj");    
?>