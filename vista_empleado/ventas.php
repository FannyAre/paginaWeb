<?php 
    include("../encabezado.php");

    if (!perfil_valido(1)) {
        header("location:../index.php");
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
		main div{
			height:200px;
			width:500px;
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

        #barra_superior{
            display:flex;
            justify-content:center;
            align-items:center;
            width: 160px;
            font-size: 1.3rem;
            background-color: #40D6E5;
            border-radius: 5px;
            height:30px;
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

		.btn-enviar{
			width:300px;
			height:60px;
		}

		main{
			align-items:start;
		}
        main{
            display:flex;
            justify-content:center;
        }
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

    <h1> Ventas </h1>
    <br>
    <table>
        <thead>
            <tr>
                <th>
                    Codigo producto
                </th>
                <th>
                    Descripcion
                </th>
                <th>
                    Cantidad
                </th>
                <th>
                    Precio por unidad
                </th>
                <th>
                    Subtotal
                </th>  
                <th>
                    Usuario
                </th>           
                <th>
                    Email
                </th>          
            </tr>
        </thead> 
                      
        <?php 
            global $db; 
                            
            $sql= "SELECT `producto_codigo`,`cantidad`,`precio_unidad`, descripcion, apellido, nombre,email
                   FROM `pedido` inner JOIN producto on(producto_codigo = codigo) inner JOIN usuario on (usuario_id = usuario.id)
            "; 
            $rs = $db->query($sql);

        ?>          

        <tbody>                      
            <?php 
                $totalSubtotal = 0;
                $totalCantidad = 0;
                $totalPrecioUnitario = 0;
                foreach ($rs as $row) {    
                    $subTotal = $row['cantidad'] * $row['precio_unidad']; 
                    $totalCantidad += $row['cantidad'];
                    $totalPrecioUnitario += $row['precio_unidad'];
                    $totalSubtotal += $subTotal;                      
                    echo "                                         
                        <tr>  
                            <td>                                                      
                                ".$row['producto_codigo'] ."
                            </td>
                            <td>                                                      
                                ".$row['descripcion'] ."
                            </td>   
                            <td>                                                      
                                ".$row['cantidad'] ."
                            </td>  
                            <td>                                                      
                                ".$row['precio_unidad'] ."
                            </td>  
                            <td>                                                      
                                $subTotal
                            </td>   
                            <td>                                                      
                                ".$row['apellido'] .$row['nombre'] ."
                            </td>   
                            <td>                                                      
                                ".$row['email'] ."
                            </td>                                                 
                        </tr>";
                } 
            ?>                               
        </tbody> 

        <tfoot>
            <tr>  
                <td colspan="2">                                                      
                    Totales:
                </td>   
                <td>
                    <?php echo $totalCantidad;?>                       
                </td>
                <td>
                    <?php echo $totalPrecioUnitario;?>
                </td>
                <td>
                    <?php echo $totalSubtotal;?>
                </td>                           
            </tr> 
        </tfoot>

    </table>  
</body>
</html> 