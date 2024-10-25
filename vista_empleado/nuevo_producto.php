<?php 
    require '../funciones.php';  
    require '../inc/conn.php';
          
    $descripcion =(isset($_POST['descripcion']) && !empty($_POST['descripcion']))? trim($_POST['descripcion']):"";
    $material = (isset($_POST['material']) && !empty($_POST['material']))? trim($_POST['material']):"";
    $color = (isset($_POST['color']) && !empty($_POST['color']))? trim($_POST['color']):"";
    $caracteristicas = (isset($_POST['caracteristicas']) && !empty($_POST['caracteristicas']))? trim($_POST['caracteristicas']):"";
    $marca = (isset($_POST['marca']) && !empty($_POST['marca']))? trim($_POST['marca']):"";
    $cantidad = (isset($_POST['cant']) && !empty($_POST['cant']))? trim($_POST['cant']):"";
    $categoria = (isset($_POST['cb_categoria']) && !empty($_POST['cb_categoria']))? trim($_POST['cb_categoria']):"";
    $subcategoria = (isset($_POST['cb_subcategoria']) && !empty($_POST['cb_subcategoria']))? trim($_POST['cb_subcategoria']):"";
    $precio = (isset($_POST['precio']) && !empty($_POST['precio']))? trim($_POST['precio']):"";

    //recibimos los datos de la imagen   
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
    
    if($descripcion == ""){
        $msj = "1";
    }
    else if($material == ""){
        $msj = "2";
    }
    else if($color == ""){
        $msj = "3";
    }
    else if($caracteristicas == ""){
        $msj = "4";
    }
    else if($marca == ""){
        $msj = "5";
    }
    else if($cantidad == ""){
        $msj = "6";
    }
    else if($categoria == ""){
        $msj = "7";
    }
    else if($subcategoria == ""){
        $msj = "8";
    }
    else if($precio == ""){
        $msj = "9";
    }
    else if($existe_imagen == ""){
        $msj ="10";
    }    
    else if($tamanio_img >= 10000000){
        $msj ="11";
    }
    else if($tipo_img != "image/jpeg" && $tipo_img!="image/jpg" && $tipo_img!="image/png"){
        $msj ="12";
    }
    else{
        //hay que conseguir el codigo del producto nuevo
        global $db;
            
        //consigo el nombre de la categoria y subcategoria
        $nombreCategoria = "";
        $nombreSubCat = "";

        $sql = "SELECT cat.nombre_categoria as nombre_cat , subCat.nombre_subcategoria as nombre_subcat
                FROM `subcategoria` as subCat INNER JOIN categoria as cat on(subCat.cod_categoria = cat.cod_categoria)
                WHERE cat.cod_categoria = $categoria
                and subCat.cod_subcategoria = $subcategoria;
        "; 
                               
        $rs = $db->query($sql);

        foreach ($rs as $row) {           
            $nombreCategoria = $row['nombre_cat'];
            $nombreSubCat = $row['nombre_subcat'];
        }  

        //busco el codigo que tenga la categoria y subcategoria
        //si existe se busca el nro maximo
        $sql = "SELECT codigo
                FROM `producto`
                WHERE cod_categoria = $categoria
                and cod_subcategoria = $subcategoria;
        "; 
  
        $rs = $db->query($sql);
        $codigo = "";
        $codMayor = 0;

        foreach ($rs as $row) {// busco el maximo, al ser el campo alfanumerico no sirve el ORDER BY      
            $resultadoNro = substr($row['codigo'], 4,  (strlen($row['codigo']) % - 4));
                       
            if($resultadoNro > $codMayor){
                $codMayor = $resultadoNro;
            } 
            $codigo = $row['codigo'];
        }  
        
        if($codMayor == 0){//no arroja resultados por ende no hay productos cargados en esa categoria
            $codigo= mb_substr($nombreCategoria,0,2) . mb_substr($nombreSubCat,0,2) .  "1";
        }
        else{      
            $codigo= mb_substr($codigo,0,4) .  strval($codMayor  +1);
        }
        
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

        $sql1 = "INSERT INTO `producto`(`codigo`, `descripcion`, `cod_categoria`, `cod_subcategoria`, `material`, `color`, `caracteristicas`, `marca`, `stock`, `precio`, `estado_producto` ,`nombre_archivoprod`) 
                VALUES ('" . $codigo ."','" . $descripcion ."'," . $categoria ."," . $subcategoria .",'" . $material ."','" . $color ."','" . $caracteristicas  ."','" . $marca ."'," . $cantidad ."," . $precio ." , 0,'$nombre_img')
        "; 
           
        $rs1 = $db->query($sql1);
        $msj= "0"; //operacion exitosa
        
    }
    header("location:ve_prod_alta.php?msj=$msj");   
?>
