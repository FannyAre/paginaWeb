<?php 
    require 'funciones.php';  
    require 'inc/conn.php';
    global $perfil;

    if ($perfil == "E"){
        header("location:vista_empleado/ve.php");
    }  
     
    $msjError = "";
     
    $cantidad =(isset($_POST['cantidad']) && !empty($_POST['cantidad']))? trim($_POST['cantidad']):"";
    $codProducto =(isset($_POST['codImg']) && !empty($_POST['codImg']))? trim($_POST['codImg']):"";
    $usuario = $user = (isset($_SESSION["user"]) && !empty($_SESSION["user"]))? trim($_SESSION["user"]):"";
    $precio =(isset($_POST['precio']) && !empty($_POST['precio']))? trim($_POST['precio']):"";
    
    if ($usuario == ""){
        $msjError = "1"; 
    }
    else if( $cantidad == "" && !is_numeric($cantidad)){
        $msjError = "2"; 
    }else if( $precio == "" && !is_numeric($precio)){
        $msjError = "3";
    }else if( $codProducto == "" ){
        $msjError = "4"; 
    }
    else{  
        global $db;
        $sqlUser  = "SELECT `id`
                    FROM `usuario` 
                    WHERE `nombre_usuario` ='$usuario'
        ";  
        $rsUser = $db->query($sqlUser);

        foreach($rsUser as $row){
            $usuario = $row['id'];
        }

        $sql  = "INSERT INTO `pedido`( `precio_unidad`, `cantidad`, `producto_codigo`, `usuario_id`) VALUES 
                    ('$precio','$cantidad','$codProducto',$usuario)
        ";  
        $rs = $db->query($sql);
        
        $sql2 ="UPDATE `producto` 
                SET `stock`=(stock - $cantidad)
                WHERE `codigo`='$codProducto' 
        ";        
        $rs2 = $db->query($sql2);   
        
        $msj = "0";
    } 

    if($msj == "0"){
        header("location:carrito_compras.php?msj=$msj");          
    }
    else{
        header("location:detalle_articulo.php?msj=$msj");          
    }        
?>