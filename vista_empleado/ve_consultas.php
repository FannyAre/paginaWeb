<?php   
include("../encabezado.php");

    if (!perfil_valido(1)) {
        header("../location:index.php");
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Catato Hogar</title>
    <meta name="viewport" content="width=device-width" >
    <link type="text/css"  href="../css/ve_estilos.css" rel="stylesheet">	

    <style>
        table{
            border: 2px solid #000;
            width:600px;
            margin-bottom: 40px;
        }
        th{
            border: 1px solid #000;
        }

        tr{
            height:30px;
        }

        td{
            border: 1px solid #000;
            text-align:center;
        }

        th{
            border: 2px solid #000;
        }
        #main{
            height:800px;
            padding-top:20px;
            background-color:white;
        }

        body{
            background-color:white;
        }

        main div{
			height:100px;
			width:300px;
		}

        #imagen{
            display:flex;
            align-items:center;
            width: 100%;
            
        }
        #buscar{
            display:flex;
            justify-content: center;
            align-items: center;
            width:80%;
            height:100%;
            margin-left:50px;
        }

        #btn-lupa{
            width:40px;
            height:40px;
            display:flex;
            align-items:center;
            margin-right:20px;
        }

        #header-buscar{
            width:490px;
            margin:0;
        }

        #lupa{
            height:33px;
            border-radius:5px;
        }

        #span{
            width:110px;
            margin: auto;
        }

        #cerrar{
            padding:4px 5px 5px;
            text-decoration: none;
            color: white;
            background-color:black;
            height:20px;
            border-radius: 5px;
            margin:auto;
        }
        #hEncab {
            background-color: darkgray;
            color: black;
            border-color:black;
            background-image: url('../images/encab.png');
            margin: auto;
            background-color: #40D6E5;
        }
        #spanEncab{
            font-size: xx-large;
            background-color: #40D6E5;

        }
    </style>

</head>
<body>

    <header> 
        <?php echo $encab; ?> 
	</header>

    <h1>  Consultas de Clientes </h1>
    <table>    
        <tr>
            <th> Email </th>
            <th> Nombre </th>
            <th> Apellido </th>
            <th> Consulta </th>
            <th> Esta respondido </th>
            <th> Es usuario registrado </th>
        </tr>
              
        <?php
            global $db;
            $sql  = "SELECT `email`,`nombre`,`apellido`,`texto`,`respondido` ,`respondido`,`id_usuario`
                    FROM `consulta` 
            ";
                              
            $rs = $db->query($sql);
            
            foreach ($rs as $row) {

                $esUsuario = $row['id_usuario'] =='NULL' ? "No":"Si";
                $estado = $row['respondido'] == '0'? "No":"Si";
                
                echo"    
                        <tr>
                            <td> ".$row['email']." </td>  
                            <td> ".$row['nombre']." </td>
                            <td> ".$row['apellido']." </td>  
                            <td> ".$row['texto']." </td> 
                            <td> $estado </td>  
                            <td> $esUsuario </td>
                        </tr>
                ";
            } 
        ?>        
    </table>
    
</body>
</html>