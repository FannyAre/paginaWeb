<?php 
    require '../funciones.php';  
    require '../inc/conn.php';
    
    $categoria = (isset($_POST['categoria']) && !empty($_POST['categoria']))? trim($_POST['categoria']):"";
  
    $msj = "";
    
    global $db;
    $nroProdAsociados=0;

    if($categoria != ""){//veo si tiene productos asociados, si es asi error     
        $sql = "SELECT `codigo` 
                FROM `producto`
                WHERE `cod_categoria` =$categoria"; 

        $rs = $db->query($sql);
        
        foreach ($rs as $row) { 
            $nroProdAsociados+=1;  
        } 
    } 
   
    if($categoria == ""){
        $msj = "1";
    }   
    else if($nroProdAsociados !=0){
        $msj = "2";
    }
    else{
        $sql1 = "UPDATE `categoria` 
                SET `estado_categoria`=1 
                WHERE `cod_categoria` = $categoria
        "; 
                
        $rs1 = $db->query($sql1);
        $msj= "0"; //operacion exitosa               
    }
    
    header("location:ve_cat_baja.php?msj=$msj");   
?>
