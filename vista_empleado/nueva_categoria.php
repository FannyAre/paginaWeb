<?php 
    require '../funciones.php';  
    require '../inc/conn.php';
    
    $categoria = (isset($_POST['nombre']) && !empty($_POST['nombre']))? trim($_POST['nombre']):"";
   
    //recibimos los datos de la imagen   
    $nombre_img= "";
    $tipo_img= ""; 
    $tamanio_img= ""; 
    $carpeta_destino="";

    //verifico si subio un archivo
    $existe_imagen = ($_FILES["imagenCat"]["tmp_name"] != "")? getimagesize($_FILES["imagenCat"]["tmp_name"]) : "";
    if($existe_imagen != ""){
        $nombre_img= $_FILES['imagenCat']['name'];
        $tipo_img= $_FILES['imagenCat']['type'];
        $tamanio_img= $_FILES['imagenCat']['size']; 
    }

    $msj = "";
    $existeCategoria = false;
    $existeCategoriaDadaDeBaja = false;

    if($categoria != ""){//busco si la categoria ingresada existe en la BD
        global $db;

        $sql = "SELECT `nombre_categoria`,`estado_categoria`
                FROM `categoria` 
                WHERE `nombre_categoria`='$categoria';      
        "; 

        $rs = $db->query($sql);

        foreach ($rs as $row) { 

            $existeCategoria = true;  

            if($row['estado_categoria'] == 1){
                $existeCategoriaDadaDeBaja = true;
            } 
        } 
    } 
    
    if($categoria == ""){
        $msj = "1";
    }   
    else if($existeCategoria && !$existeCategoriaDadaDeBaja){
        $msj = "2";
    }
    else if($existe_imagen == ""){
        $msj ="3";
    }    
    else if($tamanio_img >= 10000000){
        $msj ="4";
    }
    else if($tipo_img != "image/jpeg" && $tipo_img!="image/jpg" && $tipo_img!="image/png"){
        $msj ="5";
    }
    else{
        //se cambia el nombre de la foto a codigo + png/jpeg/jpg

        $final_img = substr( $nombre_img, -3, 3);

        if($final_img == "png"){
            $nombre_img= $categoria . ".png";
        }
        else if($final_img == "jpg"){ 
            $nombre_img= $categoria . ".jpg";
        }
        else{
            $nombre_img= $categoria . ".jpeg";
        }
     
        //ruta donde se guardara la imagen en el servidor
        $carpeta_destino = $_SERVER['DOCUMENT_ROOT']. '/maciel/images/categorias/';
        
        //movemos la imagen a la carpeta    
        move_uploaded_file($_FILES['imagenCat']['tmp_name'], $carpeta_destino.$nombre_img);

        if($existeCategoriaDadaDeBaja){//ya existia esa categoria dada de baja por lo que se le cambia su estado
            
            $sql1 ="UPDATE `categoria` 
                    SET `estado_categoria`=0 
                    WHERE `nombre_categoria` = '$categoria'
            "; 
            $rs1 = $db->query($sql1);
        }
        else{//no existe la categoria
            $sql1 = "INSERT INTO `categoria`( `nombre_categoria`, `estado_categoria`, `nombre_archivocat`) 
                     VALUES ('$categoria',0,'$nombre_img')
            "; 
            $rs1 = $db->query($sql1);
        }
        
        $msj= "0"; //operacion exitosa        
    }
    header("location:ve_cat_alta.php?msj=$msj");   
?>
