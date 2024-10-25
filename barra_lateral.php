<?php  	
	require 'inc/conn.php';
	
	if (perfil_valido(1)) {
        header("location:vista_empleado/ve.php");
    }  

	function crearBarraLateral(){

		if ((isset($_GET['prod'])) && (!empty($_GET['prod']))){
			global $db;
			$arrColores = [];
			$arrMarcas = [];
			$variable = $_GET['prod'];
			$variable = substr($variable,0,4);
			
			$where_sql = " WHERE cod_subcategoria = $variable";
			
			$sql = "SELECT descripcion, material,color,caracteristicas,marca,stock, precio
					FROM `producto` 
					$where_sql";

			$rs = $db->query($sql); 


			foreach ($rs as $row) {

				if(empty($arrColores[$row['color']])){
					$arrColores[$row['color']] = 0;						
				}										
				if(empty($arrMarcas[$row['marca']])){
					$arrMarcas[$row['marca']] = 0;
				}					
			}
			
			//obtener el precio minimo
			$sql1 ="SELECT min(precio) 
					FROM `producto`
					$where_sql; ";

			$rs1 = $db->query($sql1);
			
			foreach ($rs1 as $row) {
				$valorMin = implode($row);
			}

			//obtener el precio maximo
			$sql2 = "SELECT max(precio) 
					FROM `producto`
					$where_sql; ";

			$rs2 = $db->query($sql2);
			
			foreach ($rs2 as $row) {
				$valorMax = implode($row);
			}

			$producto = $_GET['prod'];
			
			echo" 
				<form action='subcategoria.php?prod=$producto' method='post' id='datos'> 
					<label class='ltitulo' for='orden'><b>Ordenamiento</b></label>
					<div class='btn-select' >
						<select class='form-select' name='orden' id='orden' > 
							<option value='-1' selected> &#60;&#60;Ordenar por&#62;&#62;</option>				
							<option value='0'> Menor precio </option>
							<option value='1'> Mayor precio </option>	
							<option value='2'> Mas vendidos </option>
						</select>
					</div>
			";

			ksort($arrColores);
			
			echo"<br>
					<b>Colores</b>
					<div id='colores' class='input' name='colores'>
			";
			
			foreach($arrColores as $indice => $valor){
				$id = str_replace(" ","",$indice);
				echo" 
					
					<input type='checkbox' class='form-check-input' name='color[]' id='$id' value='$indice'>													  																															
					<label for='$id' > ".ucfirst($indice)."</label>						
				";
			}

			echo"</div> <br> 
				<b>Marcas</b> 
				<div id='marcas' class='input' name ='marcas'>
			";	
			
			foreach($arrMarcas as $indice => $valor){
				$id = str_replace(" ","",$indice);
				echo "	
					<label for='$id'> ".ucfirst($indice)."</label>						
					<input type='checkbox' class='form-check-input' name='marca[]' id='$id' value='$indice'>						
				";
			}
			
			echo "</div>	
					<br>
					<div id='min-max'>
						<label id='lmaxmin' for='valorMin'><b>Minimo:</b></label>		
						<input type='number' name='valorMin' id='valorMin'  class='min-max' placeholder='minimo' min='$valorMin'  value='$valorMin' >
						<br> <label id='lmaxmin' for='valorMax'><b>Maximo:</b></label>
						<input type='number' name='valorMax' id='valorMax'  class='min-max' placeholder='maximo' max='$valorMax' value='$valorMax' > 
						
						<input type='hidden' name='valorMaxOriginal' id='valorMaxOriginal' value='$valorMax' >
						<input type='hidden' name='valorMinOriginal' id='valorMinOriginal' value='$valorMin' >		

						<br>					
					</div><br>	
					<p id='e_error'>

					</p> 
					<div id='botones' class='botones'>
						<input type='submit'  id='filtros' class='btn-filtros' name='Aplicar filtros'  value='Aplicar filtros' onclick='javascript:return validarBarraLateral()'>						
					</div>
				</form>";
		};		
	}						
?>