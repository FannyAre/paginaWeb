<?php 
	include ("encabezado.php");
    include("pie.php");
	require 'inc/conn.php';

	if ($perfil == "E"){ 
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
        body{
            margin:0;
        }

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

		.contenedor-subc img {
			width:230px;
			height:230px;
			border-bottom: 0.1px solid rgba(205,205,205,0.7);
		}

		.contenedor-imagenes{
			width:800px;
			margin:0;
			display:flex;
			justify-content: center;
			flex-flow: wrap;
		}

		.contenedor-subc{
			margin: 0;
			display: flex;
			justify-content: flex-start;
			flex-flow: row wrap;
			align-items: flex-start;
			width: 60%;
			padding-left:30px;
		}

		.barra-lateral {
			display:none;
			flex-flow: column wrap;
			align-content: flex-start;
			width:25%;
			color: #000;
			padding-left:4px;
			padding-right:4px;
		}

		.producto{
			height:400px;
            width:400px;
			margin-right:10px;
			margin-bottom:10px;
			background-color:white;
			cursor: pointer;
			border-radius:5px;
			overflow:hidden;
		}

        #prod{
            display:flex;
            flex-wrap: wrap;
            justify-content:center;
        }

        main img{
            width:400px;
            height:300px;
        }

		.descripcion{
			display:flex;
			width:230px;
			justify-content:center;
			text-align:center;
            margin:auto;
		} 

		/*ASIDE*/
		.input{
			display:flex;
			justify-content: center;
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
 
		#imprCatalogo:hover {
            background-color: rgb(112, 112, 112);
            transition: all 0.3s linear;
            color: white;
            cursor:pointer;
        }

		#imprCatalogo{
		   background-color: #ecab0f;
		   height: 40px;
		   width:200px;
		   cursor:pointer;
		   font-size:1.2rem;
		   border-radius: 5px;
		   margin: 10px auto;
		}
    </style>

	<script>

		window.onload = function() {
			
            let imagenes = document.getElementsByClassName('img-cat'); //Imagenes de los productos

            for (j=0;j<imagenes.length;j++){ //Al hacer click en un producto, enviar a detalle
                let articulo = imagenes[j].getAttribute('alt');
                imagenes[j].addEventListener("click", () => {window.location = 'detalle_articulo.php?art='+articulo;});
            };
           
        } 

	</script>

</head>
<body>   
	
    <header>
		<?php echo $encab;?>
	</header>
	
	<body>

		<main id="main">
			
			<?php
				global $db;
				
				if(isset($_POST['txtFiltro']) && !empty($_POST['txtFiltro'])){
					
					$filtro = $_POST['txtFiltro'];
					echo "<h1>Resultados de la busqueda: $filtro </h1>";

					$sql = "SELECT `codigo` , `descripcion`  
							FROM `producto` 
							WHERE `color` like '%". $filtro . "%' 
							OR `marca` like '%". $filtro . "%'  
							OR `material` like '%". $filtro . "%' 
							OR `caracteristicas` like '%". $filtro . "%' 
					";
					
					$rs = $db->query($sql);

					echo " <form action='detalle_articulo.php' id='prod' method='post' enctype='multipart/form-data'>";

					foreach ($rs as $row) {
						echo "<div class='producto'>
								<img src='images/{$row['codigo']}.png' class='img-cat' alt='".$row['codigo']."' title='". ucfirst($row['descripcion'])."'> 
								<p class='descripcion'>". ucfirst($row['descripcion'])." </p>
							</div>
						";          
					}
					echo " </form> ";  
				}
				else if (empty($_POST['txtFiltro'])){//se presiono el boton buscar pero no se ingreso nada
					echo "<h1>Ingrese un producto, marca, categoria o algun otro filtro </h1>";
				}			
			?>
		</main>
	</body>   
   	
	<?php echo $pie;?>

</body> 
</html>