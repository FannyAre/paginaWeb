<?php 
    //*********************/
    //se puede modificar los atributos, la imagen o ambos
    //*********************/
    require '../funciones.php';  
    require '../inc/conn.php';
    
    global $db;
    $categoria = "";
    $subcategoria = "";
   
    $codigo =(isset($_POST['codigo']) && !empty($_POST['codigo']))? trim($_POST['codigo']):"";
    
    if($codigo != ""){//si existe el codigo lo busco en la BD para encontrar a que categoria y subcategoria pertenece
        
        $sql1 ="SELECT `cod_categoria`,`cod_subcategoria`
                FROM `producto` 
                WHERE `codigo` = '$codigo'
        ";
        $rs1 = $db->query($sql1);

        foreach($rs1 as $row){
            $categoria = $row['cod_categoria'];
            $subcategoria = $row['cod_subcategoria'];
            break;
        }
    }

    $descripcion =(isset($_POST['descripcion']) && !empty($_POST['descripcion']))? trim($_POST['descripcion']):"";
    $material = (isset($_POST['material']) && !empty($_POST['material']))? trim($_POST['material']):"";
    $color = (isset($_POST['color']) && !empty($_POST['color']))? trim($_POST['color']):"";
    $caracteristicas = (isset($_POST['caracteristicas']) && !empty($_POST['caracteristicas']))? trim($_POST['caracteristicas']):"";
    $marca = (isset($_POST['marca']) && !empty($_POST['marca']))? trim($_POST['marca']):"";
    $cantidad = (isset($_POST['cant']) && !empty($_POST['cant']))? trim($_POST['cant']):"";
    $precio = (isset($_POST['precio']) && !empty($_POST['precio']))? trim($_POST['precio']):"";

    //puede que eliga cambiar la imagen o no   
    $nombre_img= "";
    $tipo_img= "";
    $tamanio_img= ""; 
    $carpeta_destino="";
    $existe_imagen = ($_FILES["imagen"]["tmp_name"] != "")? getimagesize($_FILES["imagen"]["tmp_name"]) : "";
    
    if($existe_imagen != ""){
        $nombre_img= $_FILES['imagen']['name'];
        $tipo_img= $_FILES['imagen']['type'];
        $tamanio_img= $_FILES['imagen']['size']; 
    }

    $msj = "";

    if($categoria == ""){
        $msj = "1";
    }
    else if($subcategoria == ""){
        $msj = "2";
    }
    else if($codigo == ""){
        $msj = "3";
    }
    if($descripcion == ""){
        $msj = "4";
    }
    else if($material == ""){
        $msj = "5";
    }
    else if($color == ""){
        $msj = "6";
    }
    else if($caracteristicas == ""){
        $msj = "7";
    }
    else if($marca == ""){
        $msj = "8";
    }
    else if($cantidad == ""){
        $msj = "9";
    }   
    else if($precio == ""){
        $msj = "10";
    }
    else if(($existe_imagen != "") && ($tamanio_img >= 10000000)){
        $msj ="11";
    }
    else if($existe_imagen != "" && $tipo_img != "image/jpeg" && $tipo_img!="image/jpg" && $tipo_img!="image/png"){
        $msj ="12";
    }
    else{      
        $sql = "UPDATE `producto` SET 
                                    `descripcion`='$descripcion',
                                    `cod_categoria`=$categoria,
                                    `cod_subcategoria`=$subcategoria,
                                    `material`='$material',
                                    `color`='$color',
                                    `caracteristicas`='$caracteristicas',
                                    `marca`='$marca',
                                    `stock`=$cantidad,
                                    `precio`=$precio
                WHERE `codigo` = '$codigo'
        "; 
        
        $rs = $db->query($sql);
        $msj= "0";//operacion exitosa

        if($existe_imagen != ""){
            //se cambia el nombre de la foto a codigo + png/jpeg/jpg

            $final_img = substr( $nombre_img, -3, 3);
            
            if($final_img == "png"){
                $nombre_img= $codigo . ".png";
            }
            else if($final_img == "jpg"){ 
                $nombre_img= $codigo . ".jpg";
            }
            else{
                $nombre_img= $codigo . ".jpeg";
            }
        
            //ruta donde se guardara la imagen en el servidor
            $carpeta_destino = $_SERVER['DOCUMENT_ROOT']. '/maciel/images/';
            
            //movemos la imagen a la carpeta    
            move_uploaded_file($_FILES['imagen']['tmp_name'], $carpeta_destino.$nombre_img);
        }     
    }
    header("location:ve_prod_mod.php?msj=$msj");   
?>
