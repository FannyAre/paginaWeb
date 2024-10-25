<?php
    include ("encabezado.php");
	require 'inc/conn.php';
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
	
	<script>
		
		window.onload = function(){           
            <?php 
                $resultadoNuevaCompra="";

                if(isset($_GET['$msj'])){
            
                    if($_GET['msj'] == "0"){
                        $resultadoNuevaCompra ="La subcategoria fue ingresada correctamente";
                    }
                    else if($_GET['msj'] == "1"){
                        $resultadoNuevaCompra ="Debe ingresar ser un usuario registrado para comprar";
                    }
                    else if($_GET['msj'] == "2"){
                        $resultadoNuevaCompra ="La cantidad ingresada no es correcta ";
                    }
                    else if($_GET['msj'] == "3"){
                        $resultadoNuevaCompra ="Ha ocurrido un error y no se ha enviado el precio correctamente, intentelo mas tarde";
                    }
					else if($_GET['msj'] == "4"){
                        $resultadoNuevaCompra ="Ha ocurrido un error, intentelo mas tarde";
                    }
					 
					if($resultadoNuevaCompra == "La subcategoria fue ingresada correctamente"){
						echo"
							alert('$resultadoNuevaCompra');
							window.location = 'http://localhost/maciel/detalle_articulo.php';
						";

					}
					else{
						echo "
							document.getElementById('e_error').innerHTML=''; 
							let error = document.getElementById('e_error');
							let hijo = document.createTextNode('$resultadoNuevaCompra');
							error.appendChild(hijo);
						";
					}
					
					
                }            
            ?>        
        }
	</script>

	<style> 
		#body{
            font-family: "Salesforce Sans", serif;
            font-size: 1.2rem;
            line-height: 1.5em;
            margin: 0px;
        }

		#main{
			display:flex;
			padding-top: 20px;
			justify-content:center;
		}

		.img-cat {
			width:230px;
			height:230px;
			border-bottom: 0.1px solid rgba(205,205,205,0.7);
		}

		.contenedor-imagenes{
			width:800px;
			margin:0;
			display:flex;
			justify-content: start;
			flex-flow: wrap;
		}

		.barra-lateral {
			visibility:hidden;
			flex-flow: column wrap;
			align-content: flex-start;
			width:25%;
			color: #000;
			padding-left:4px;
			padding-right:4px;
			order: 0;
		}

		.producto{
			height:320px;
			margin-right:10px;
			margin-bottom:10px;
			background-color:white;
			cursor: pointer;
			border-radius:5px;
			overflow:hidden;
		}

		.producto img{
			width:230px;
			height:230px;
		}

		.descripcion{
			display:flex;
			width:230px;
			justify-content:center;
			text-align:center;
		} 

		/*ASIDE*/
		.input{
			display:flex;
			justify-content: start;
			flex-flow: row wrap;
			align-content: flex-start;
			align-items:center;
			padding-left:2px;
		}

		.btn-select{
			display:flex;
			flex-wrap: wrap;
			justify-content:center;
		}

		.input input{
			width:10px;
		}

		.input label{
			width:130px;
		}

		#min-max{
			width:300px;
			padding-left:4px;
		}

		.min-max{
			width: 60px;
		}

		aside div{
			width:100%;
		}
		aside select{
			width: 90%;
			height: 30px;
			background-color: #D3D3D3;
			border: 2px solid black;
			border-radius:5px;
			color: black;
			font-size: 1.2rem;
			text-align:center;
			margin:0 auto;
	    }

		#lmaxmin{
			padding-left:2px;
		}

		.ltitulo{
			padding-left:8px;
		}

		#botones{
			display:flex;
			flex-wrap: wrap;
			justify-content:center;
		}
		.btn-filtros{
		   background-color: #D3D3D3;
		   height: 40px;
		   width:200px;
		   cursor:pointer;
		   font-size:1.2rem;
		   border-radius: 5px;
		}

		.btn-filtros:hover{
			background-color: rgb(112, 112, 112);
            transition: all 0.3s linear;
            color: white;
            cursor:pointer;
		}

		#h1{
			margin:20px auto;
		}

		#parrafo-sr{
			width:700px;
			padding-left: 100px;
		}

		.btn-doc{
			order:2;
			width:80px;
		}

		@media print {				
			main { 
				font-size:18pt; 
				font-family:"times new roman",times;
				color:#000;
				background-color:#FFFFFF; 	
				width:100%;
				border:none;
			}

			#tit-catalogo {display:block;}
			header { display:none;}
			#datos { display:none;}
			#catalogo {display:none;}
			#imprimir {display: none;}
			#pie {display: none;}
		}

		#form-filtrado{
			display:flex;
			flex-wrap:wrap;
			order: 1;
			margin: 0;
    		justify-content: flex-start;
    		flex-flow: row wrap;
    		align-items: flex-start;
    		padding-left: 30px;
		}

		#catalogo{
			height:30px;
		}

		#btn-imp{
			height:30px;
		}
	</style>

</head>
<body>

	<header>
    	<?php echo $encab; ?>
	</header>

    <main id='main'>
		<?php
			global $db;
			$variable = $_GET['art'] ;
			$where_sql = "WHERE codigo = '$variable'";
			
			$sql = "SELECT codigo, descripcion, material, color, caracteristicas, marca, stock, precio
					FROM `producto`
					$where_sql; 
			";
			$rs = $db->query($sql); 
			
			foreach ($rs as $row) { 
					
				$caract = $row['caracteristicas'];
				$aCarac = explode (',', $caract);
				
				echo "<form action='nueva_compra.php' method='post'> 
								<div id='cont-images'>
									<img src='images/$variable.png' class='img-art' alt='{$row['descripcion']} '>                                   
								</div>
								<div id='cont-descripcion'>
									<input type='hidden' name='codImg' value='$variable' >
									
									<h1>{$row['descripcion']}</h1>
									<label for='precio'> Precio:</label>
									<input type='text' id='precio' name='precio' value='{$row['precio']}'  title='El precio es:{$row['precio']}' readonly>
									
									<h2>Características:</h2> 
									
									
									Material:  {$row['material']} <br>
									Color:  {$row['color']}  <br>
									Marca:  {$row['marca']} <br> 
									";
									
				for ($i=0;$i<count($aCarac);$i++){
					echo " $aCarac[$i] 
					<br> 
					";
				}
				
									
				if($row['stock'] == 0){
					echo "<p>
							Lo sentimos, no tenemos stock de este artículo.
						  </p>
					";
				}
				else{
					echo"";
						if ($perfil != "U"){
							echo"<p>Si desea comprar este artículo por favor regístrese </p>";
						} 
						else{
							echo"  <input type='number' id='cantidad' name='cantidad' value='1' min='1' max='{$row['stock']}' title='Seleccione el numero de articulos que quiere'/>
								   <input type='submit' id='btn-enviar' value='Agregar al carrito'>
								   <br> <br> <br>
							";
						}	 						
				}
				echo "</div>";
				echo "</form>";                    
			}
		?>
	</main>
		
	<?php 
		echo $pie; 
	?> 	 
	
</body>
</html>