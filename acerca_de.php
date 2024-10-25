<?php 
	include ("encabezado.php");
    include("pie.php");

    if (perfil_valido(1)) {
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
</head> 
<body>

    <header>
        <?php echo $encab; ?>
    </header>

    <main id="main">

        <div id="cont-acerca"> 
            <h1>Trabajo realizado por:</h1>
            <ul >              
                <li> Maciel Fanny </li>
                <li> Benedette David </li>
            </ul>
            <h2>Terminacion de la pagina con las vistas de los empleados: </h2>
            <ul >              
                <li> Maciel Fanny </li>
            </ul>
        </div>
        
    </main>
  	
    <?php 
        echo $pie;
    ?>
    
</body>
</html>