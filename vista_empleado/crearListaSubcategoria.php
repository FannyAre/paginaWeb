<?php 
    include("../funciones.php");
    
    $id_estado = $_POST['id_estado'];
    global $db;

    $sql = "SELECT `nombre_subcategoria` ,`cod_subcategoria`
            FROM `subcategoria` 
            WHERE `estado_subcategoria` = 0
            and `cod_categoria` in(
                                    select `cod_categoria`
                                    from categoria
                                    where `cod_categoria` = $id_estado
                                        )
            ORDER BY `nombre_subcategoria` ASC 
    ";
            
    $rs = $db->query($sql);

    $html = "<option value='0'> Seleccionar Subcategoria </option>";

    foreach ($rs as $row) {
        $html .= " <option value='".$row['cod_subcategoria']."'> " .ucfirst($row['nombre_subcategoria']) . "</option>";
    }
    
    echo $html;
?>