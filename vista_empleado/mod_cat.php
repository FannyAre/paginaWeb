<?php 
    //*********************/
    //se puede modificar el nombre, la imagen o ambos
    //*********************/
    require '../funciones.php';  
    require '../inc/conn.php';

    if (!perfil_valido(1)) { 
		header("location:../index.php"); 
	}  

    $nombreNuevo =(isset($_POST['nombre']) && !empty($_POST['nombre']))? trim($_POST['nombre']):"";
    $categoria = (isset($_POST['categoria']) && !empty($_POST['categoria']))? trim($_POST['categoria']):"";  
    
    //recibimos los datos de la imagen   
    $nombre_img= "";
    $tipo_img= "";
    $tamanio_img= ""; 
    $carpeta_destino=""; 
 
    //verifica si se subio una imagen  
    $existe_imagen = ($_FILES["imagenCat"]["tmp_name"] != "")? getimagesize($_FILES["imagenCat"]["tmp_name"]) : "";
   
    if($existe_imagen != ""){     
        $nombre_img= $_FILES['imagenCat']['name']; 
        $tipo_img= $_FILES['imagenCat']['type'];
        $tamanio_img= $_FILES['imagenCat']['size']; 
    }

    global $db;
    $categoriaExisteDadaDeBaja = false; 
    $categoriaExiste = false; 
   
    if($nombreNuevo != ""){//comprobamos si el nombre ya existe y si existe su estado 0=activo 1=eliminado

        $sql = "SELECT `nombre_categoria`, `estado_categoria`
                FROM `categoria` 
                WHERE `nombre_categoria` ='$nombreNuevo';
        "; 
        $rs = $db->query($sql);

        foreach ($rs as $row) {

            if($row['estado_categoria'] == 1) {//la categoria existe y esta dada de alta
                $categoriaExiste = true;   
                break;  
            } 
            else {//la categoria existe y esta dada de baja por lo que posteriormente se hara un update
                $categoriaExisteDadaDeBaja = true;   
                break;  
            }
        }  
    }

    $msj = "";

    if($nombreNuevo == "" && !$existe_imagen){//no ingreso nada para modificar
        $msj = "1";
    }    
    else if($categoria == ""){
        $msj = "2";
    }
    else if($categoriaExiste && !$categoriaExisteDadaDeBaja){
        $msj = "3";
    }
    else{ 

        if($existe_imagen){
            
            if($existe_imagen != "" && $existe_imagen == ""){ 
                $msj ="4";
            }
            else if ($existe_imagen != "" && $tamanio_img >= 10000000){
                $msj ="5";
            }
            else if($existe_imagen != "" && $tipo_img != "image/jpeg" && $tipo_img!="image/jpg" && $tipo_img!="image/png"){
                $msj ="6";
            }
        }

        if($msj == ""){

            if($existe_imagen != ""){//cambiamos la imagen

                //vemos si la imagen nueva va con el nombre de la categoria o el nombre ingresado
                $nombreFinal = $nombreNuevo;

                if($nombreNuevo == ""){
                    $sql = "SELECT `nombre_categoria` 
                            FROM `categoria`
                            WHERE `cod_categoria`= $categoria;
                    "; 
                    $rs = $db->query($sql);

                    foreach ($rs as $row) { 
                        $nombreFinal = $row['nombre_categoria'];
                        break;
                    }          
                }   

                //se cambia el nombre de la foto a nombreCategoria + png/jpeg/jpg
                $final_img = substr( $nombre_img, -3, 3);

                if($final_img == "png"){
                    $nombre_img= $nombreFinal . ".png";
                }
                else if($final_img == "jpg"){ 
                    $nombre_img= $nombreFinal . ".jpg";
                }
                else{
                    $nombre_img= $nombreFinal . ".jpeg";
                }
                
                //ruta donde se guardara la imagen en el servidor
                $carpeta_destino = $_SERVER['DOCUMENT_ROOT']. '/maciel/images/categorias/';

                //movemos la imagen a la carpeta    
                move_uploaded_file($_FILES['imagenCat']['tmp_name'], $carpeta_destino.$nombre_img);

                $sql = "UPDATE `categoria` 
                        SET `nombre_archivocat`='$nombre_img' 
                        WHERE `cod_categoria` = $categoria;
                "; 
        
                $rs = $db->query($sql);       
            }    

            if($nombreNuevo != ""){
                $sql ="";

                if($categoriaExisteDadaDeBaja){
                    $sql = "UPDATE `categoria` 
                            SET `estado_categoria`= 0
                            WHERE `cod_categoria` = $categoria;
                    ";
                }
                else{
                    $sql = "UPDATE `categoria` 
                            SET `nombre_categoria`='$nombreNuevo'
                            WHERE `cod_categoria` =$categoria;
                    ";
                   
                }
                $rs = $db->query($sql);            
            }
            $msj = "0";  
        }
    }
    header("location:ve_cat_mod.php?msj=$msj");   
?>