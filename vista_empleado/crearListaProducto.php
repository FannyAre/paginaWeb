<?php 
    include("../funciones.php");
   
    $id_subcategoria = $_POST['id_estado'];
    global $db;

    $sql = "SELECT `codigo`,`descripcion`
            FROM `producto`  
            WHERE `cod_subcategoria` = '".$id_subcategoria."' 
            and estado_producto = 0
            ORDER BY `codigo` ASC
    ";
            
    $rs = $db->query($sql);

    $html = "<option value='0'>Seleccione un Producto</option>";

    foreach ($rs as $row) {        
        $html .= " <option value='".$row['codigo']."'> " .ucfirst($row['descripcion']) . "</option>";
    }
    
    echo $html;
?>