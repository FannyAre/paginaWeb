<?php 
    include("encabezado.php"); 
    include("pie.php");  
    include ("inc/conn.php");

    if (perfil_valido(3)) {
       header("location:index.php");
    }
    else if (perfil_valido(1)) {
        header("location:vista_empleado/ve.php");
    }  
?>
<!DOCTYPE html>
<html lang="es">
<head> 
    <meta charset="utf-8">
    <title>Catato Hogar</title>
    <meta name="viewport" content="width=device-width" >
    <link type="text/css"  href="css/estilos.css" rel="stylesheet">
	
    <style>
        main{
            display:flex;
            justify-content:center;
            flex-wrap:wrap;
        }

        .cont-perfil{
            margin: 40px 0;
        }

        .botones {
            border: groove; 
            background-color: gainsboro;
            padding: 1%;
        }
    </style>

</head>
<body id="body">

    <header> 
        <?php echo $encab; ?> 
    </header>

    <main>

        <?php echo $cont_usuarios; ?>
        
        <h1> Informacion Personal:</h1>

        <?php 
            global $db; 
            $nombreUser = $_SESSION['user'];
        
            $sql= "SELECT nombre_usuario, perfil, nro_dni, nombre, apellido, email, provincia, ciudad, direccion
                    FROM `usuario`
                    WHERE nombre_usuario='$nombreUser'
            "; 
         
            $rs = $db->query($sql);
        
            $infoPersonal = "";
            foreach ($rs as $row) {
                $infoPersonal = "<div class='cont-perfil'> 
                                    Nombre de usuario: {$row['nombre_usuario']} <br>
                                    Numero de DNI: {$row['nro_dni']} <br>
                                    Nombre: {$row['nombre']} <br>
                                    Apellido: {$row['apellido']} <br>
                                    Email: {$row['email']} <br>
                                    Provincia: {$row['provincia']} <br>
                                    Ciudad: {$row['ciudad']} <br>
                                    Direccion: {$row['direccion']} <br>
                                </div>
                ";
            }
            echo  $infoPersonal;
        ?>
    </main>

    <?php
        echo $pie;
    ?>
    
</body>
</html>