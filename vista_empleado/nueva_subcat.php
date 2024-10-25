<?php 
    require '../funciones.php';  
    require '../inc/conn.php';
    
    $categoria = (isset($_POST['cb_categoria']) && !empty($_POST['cb_categoria']))? trim($_POST['cb_categoria']):"";
    $nombreSubCat = (isset($_POST['nombre']) && !empty($_POST['nombre']))? trim($_POST['nombre']):"";

    $msj = "";
    $existeSubCategoria = false;
    $existeSubCategoriaDadaDeBaja = false;

    if($categoria != ""){//verifico si existe esa subcategoria con una categoria existente en la BD
        global $db;

        $sql = "SELECT `nombre_subcategoria`,`estado_subcategoria`
                FROM `subcategoria` 
                WHERE `nombre_subcategoria`='$nombreSubCat'
                and `cod_categoria` = $categoria;
        "; 
        $rs = $db->query($sql);

        foreach ($rs as $row) { 
            $existeSubCategoria = true; 

            if($row['estado_subcategoria'] == 1){
                $existeSubCategoriaDadaDeBaja = true;
            }   
        } 
    }  
    
    if($categoria == ""){
        $msj = "1"; 
    }   
    else if($nombreSubCat ==""){
        $msj = "2";
    }
    else if($existeSubCategoria && !$existeSubCategoriaDadaDeBaja){
        $msj = "3";
    }
    else{
        if($existeSubCategoriaDadaDeBaja){//ya existia esa subcategoria dada de baja por lo que se le cambia su estado
            
            $sql1 = "UPDATE `subcategoria` 
                    SET `estado_subcategoria`=0
                    WHERE `nombre_subcategoria` ='$nombreSubCat'"; 

            $rs1 = $db->query($sql1);
        }
        else{
            $sql1 = "INSERT INTO `subcategoria`( `nombre_subcategoria`, `estado_subcategoria`, `cod_categoria`)
                    VALUES ('$nombreSubCat', 0 ,$categoria)"; 

            $rs1 = $db->query($sql1);
        } 
        $msj= "0";//operacion exitosa       
    }
    header("location:ve_subc_alta.php?msj=$msj");
?>