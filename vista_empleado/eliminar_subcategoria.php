<?php 
    require '../funciones.php';  
    require '../inc/conn.php';
      
    $categoria = (isset($_POST['cb_categoria']) && !empty($_POST['cb_categoria']))? trim($_POST['cb_categoria']):"";
    $subCategoria = (isset($_POST['cb_subcategoria']) && !empty($_POST['cb_subcategoria']))? trim($_POST['cb_subcategoria']):"";
    
    $msj = "";
    
    global $db;
    $nroProdAsociados=0;

    if($subCategoria != ""){ //veo si tiene productos asociados, si es asi error
        $sql = "SELECT `codigo` 
                FROM `producto`
                WHERE `cod_subcategoria` =$subCategoria"; 
        $rs = $db->query($sql);
        foreach ($rs as $row) { 
            $nroProdAsociados+=1;  
        } 
    } 
    
    if($categoria == ""){
        $msj = "1";
    }   
    if($subCategoria == ""){
        $msj = "2";
    }   
    else if($nroProdAsociados !=0){
        $msj = "3";
    }
    else{
        $sql1 = "UPDATE `subcategoria` 
                SET `estado_subcategoria`= 1
                WHERE `cod_subcategoria` = $subCategoria
        "; 

        $rs1 = $db->query($sql1);
        $msj= "0"; //operacion exitosa
        
    }
    header("location:ve_subc_baja.php?msj=$msj");    
?>
