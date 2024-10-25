<?php  
	include ("encabezado.php");
	include ("barra_lateral.php"); 
	include ("pie.php");
	include ("inc/conn.php"); 
	
	if ($perfil == "E"){ 
		header("location:ve.php");
	}	 

	global $db;  

	function crearImagenes (){

		global $db;  

		if (isset($_GET['cat']) && !empty($_GET['cat'])){//se estan mostrando las subcategorias
			$categoria = $_GET['cat'];
	
			$sql = "SELECT `codigo`, `descripcion` ,`nombre_archivoprod` , nombre_subcategoria, subcat.cod_subcategoria as cod_subcategoria
					from producto as prod INNER JOIN subcategoria as subcat on (prod.cod_subcategoria = subcat.cod_subcategoria) INNER JOIN categoria as cat on(subcat.cod_categoria = cat.cod_categoria) 
					where nombre_categoria = '$categoria' 
					and estado_categoria = 0 
					and estado_producto = 0 
					and estado_subcategoria = 0 
					GROUP BY nombre_subcategoria
			";
			$rs = $db->query($sql);
	
			echo "<form action='listado_xls.php' method='post' id='form-filtrado' class='form-prod' name='form-filtrado'>	
						<h1 id='h1' style='display:none;'>CATÁLOGO</h1> 					
							Se muestran todos las subcategorias de ".$categoria."
						<div class='contenedor-imagenes'>				
			";
			
			foreach ($rs as $row) {
							
				echo "<div class='producto'>
						<img src='images/".$row['nombre_archivoprod']."' class='img-cat' alt='".$row['cod_subcategoria']."' > 
						<p class='descripcion'>". ucfirst($row['nombre_subcategoria'])." </p>
					</div>
				";           
			}
				
			echo "	</div>
				</form>
			";
		}
		else if (isset($_GET['prod'])){//se estan mostrando los productos
									   // si se selecciono algun filtro se adjuntara en el where
			$sql = "";
			$where_sql = "";
			$txtFiltros ="";

			$codSubcat = $_GET['prod'];
			$colores = (isset($_POST['color']))? $_POST['color']:-1;
			$marcas = (isset($_POST['marca']))? $_POST['marca']:-1;
			$precioMin = (isset($_POST['valorMin']))? $_POST['valorMin']:0;
			$precioMax = (isset($_POST['valorMax']))? $_POST['valorMax']:0;
			$orden = (isset($_POST['orden']))? $_POST['orden']:-1;
			$where_sql = " WHERE cod_subcategoria = $codSubcat ";
					
			$where_color = "";
			if ($colores != -1){
				if (count($colores) == 1){
					$where_color = " AND color = '$colores[0]' ";
					
					$txtFiltros .="Color: ". $colores[0] . "<br>";
				}
				else{
					$txtFiltros .="Colores: ";
	
					$where_color .= " AND ( ";
					for ($i=0;$i<count($colores)-1;$i++){ 
						$where_color .= " color = '$colores[$i]' OR " ;
						$txtFiltros .= $colores[$i] .", ";
					}
					$i = count($colores)-1;
					$where_color .= " color = '$colores[$i]') ";
					$txtFiltros .=  $colores[$i]. "<br>";
				}
			}
	
			$where_marca = "";
			if ($marcas != -1){
				if (count($marcas) == 1){
					$where_marca .= " AND marca = '$marcas[0]' ";
					$txtFiltros .= "Marca: " . $marcas[0] . "<br>";
				}
				else{
					$txtFiltros .= "Marcas: ";
					$where_marca .= " AND ( ";
					for ($i=0;$i<count($marcas)-1;$i++){
						$where_marca .= "  marca = '$marcas[$i]' OR ";
						$txtFiltros .= $marcas[$i] .", ";
					}
					$i = count($marcas)-1;
					$where_marca .= " marca = '$marcas[$i]') ";
					$txtFiltros .= $marcas[$i]. "<br>";
				}
			}
	
			$where_precio=""; 
	
			if ($precioMin!= 0 && $precioMax !=0){
				$where_precio = " precio >= $precioMin AND precio <= $precioMax ";
				$txtFiltros .= " Con un rango de precio entre " . $precioMax . " y " . $precioMin ;
			}
	
			$orderBy = "";
			$orderMasVen = 0;
			if($orden != -1){
				if ($orden == 0){
					$orderBy = " ORDER BY precio asc ";
				}
				else if ($orden == 1) {
					$orderBy = " ORDER BY precio desc ";
				}
				else {              
					$orderMasVen++;
				}
			}
			
	
			if($where_color != "" && $where_marca != ""){
				$where_sql .=  $where_color . $where_marca ;
			}
			else if ($where_color != ""){
				$where_sql .=  $where_color ;
			}
			else{
				$where_sql .=  $where_marca ;
			} 
			
			
			if($orderMasVen != 0){
				$sql = "SELECT `codigo`, `descripcion`, SUM(`cantidad`) ,`nombre_archivoprod`
						from `producto` 
						LEFT JOIN `pedido` ON `pedido`.producto_codigo = `producto`.codigo
						$where_sql
						AND estado_producto = 0
						GROUP  BY `codigo`
						ORDER  BY `cantidad` DESC;
				";
			}
			else{
				$sql = "
						SELECT `codigo`, `descripcion`,`nombre_archivoprod`
						FROM `producto` 
						$where_sql
						AND estado_producto = 0
						$orderBy
				";  
			}
			
			$rs = $db->query($sql);
			
			$form = "<form action='listado_xls.php' method='post' id='form-filtrado' class='form-prod' name='form-filtrado'>	
						<h1 id='h1' style='display:none;'>CATÁLOGO</h1> 					
							$txtFiltros
						<div class='contenedor-imagenes'>				
			";
				
			$i = 0;
			foreach ($rs as $row) {
				$i++;
				$form .= "		
						<div class='producto' style='padding: 50px;'>
							<img src='images/".$row['nombre_archivoprod']."' class='img-cat' alt='".$row['codigo']."' > 
							<p class='descripcion'>". ucfirst($row['descripcion'])." </p>
						</div>
				";		           
			}
			
			if($i == 0){//no se arrojaron resultados
				$form = "<h1 id='h1' style='display:none;'>CATÁLOGO</h1> 					
							No se han encontrado resultados para los siguientes filtros : <br>$txtFiltros							
				";
			}
			else{
				$form .= " 
					</div>
						</form> 
					<div class='btn-doc'>
						<input type='image' src='images/logo_excel.jpeg' class='excel' id='catalogo' alt='Exportar a excel'>
						<a href='javascript:window.print();' id='btn-imp' title='Imprimir listado.'>
							<img src='images/logo_imprimir.jpeg' id='imprimir' title='Imprimir listado.' alt='icono imprimir.' style='border:0;width:32px;height:32px;'>
						</a>
					</div>	
				";
			}
			
			echo $form;

		}
	} 
?>
<!DOCTYPE html>
<html lang="es"> 
<head> 
    <meta charset="UTF-8">
    <title>Catato Hogar</title>
    <link type="text/css"  href="css/estilos.css" rel="stylesheet"/>
	<script src="js/funciones.js"></script>

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

	<script>      
        window.onload = function() {
            let imagenes = document.getElementsByClassName('img-cat'); //Imagenes de los productos
            let barra = document.getElementsByClassName('barra-lateral'); //Barra lateral
            let catalogo = document.getElementById('catalogo'); //Boton excel
            let btn = document.getElementById('btn-imp'); //Boton imprimir
 
            for (j=0;j<imagenes.length;j++){//se muestran las subcategorias
                let imagen = imagenes[j].getAttribute('alt');
                imagenes[j].addEventListener("click", () => {
                    window.location = 'subcategoria.php?prod='+imagen;});
            };
  
            if (window.location.search.indexOf('?prod=') != -1){
                barra[0].style.visibility = 'visible'; //Mostrar barra lateral
 
                for (j=0;j<imagenes.length;j++){ //Al hacer click en un producto, enviar a detalle
                    let articulo = imagenes[j].getAttribute('alt');
                    imagenes[j].addEventListener("click", () => {window.location = 'detalle_articulo.php?art='+articulo;});
                };
 
                catalogo.addEventListener("click", () => { //Imprimir catalogo
                    let variable = "";
                    for (j=0;j<imagenes.length-1;j++){
                        variable += imagenes[j].getAttribute('alt') + ","; //todos los codigos separados por ,
                    }
                    variable+= imagenes[imagenes.length-1].getAttribute('alt');
                    window.location = 'listado_xls.php?imagen='+variable; //se manda por url, se recibe por get en listado_xls
                });
 
            }
            else if(window.location.search.indexOf('?cat=') != -1){
                let formulario = document.getElementById('form-filtrado');
                let contenedor = document.getElementsByClassName('contenedor-imagenes');
 
                barra[0].style.display = 'none';
 
                formulario.style.width = '100%';
                formulario.style.justifyContent = 'center';
                formulario.style.padding = '0';
 
                contenedor[0].style.justifyContent = 'center';
            }  
        }            
    </script>


</head>
<body id="body"> 

	<header>
		<?php echo $encab; ?> 
	</header>

	<main id="main">	

		<aside class="barra-lateral"> 
			<?php 
				crearBarraLateral();
			?>
		</aside>

		<?php 						 
			crearImagenes(); 
		?>
		
	</main>
		
	<?php 
		echo $pie;
	?>
	
</body>
</html>