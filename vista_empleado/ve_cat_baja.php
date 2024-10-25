<?php 
    include("../encabezado.php");
    include ("../inc/conn.php");

    if (!perfil_valido(1)) {
        header("location:../index.php");
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    
    <meta charset="utf-8">
    <title>Catato Hogar</title>
    <meta name="viewport" content="width=device-width" >
    <link type="text/css"  href="../css/ve_estilos.css" rel="stylesheet">
	
    <script>

		function validar(){ 

            let devolucion = false;
            let txtErrores = "";

            var nombreCat = document.getElementById("categoria").value;
            
            if(nombreCat == null || nombreCat.trim() == ""){
                txtErrores="Debe seleccionar el nombre de la categoria";
            }
            else if(nombreCat =="0"){
                txtErrores="Debe seleccionar el nombre de la categoria";
            }
            
            if(txtErrores == ""){
                devolucion = true;
            }

            if (!devolucion){
                document.getElementById('e_error').innerHTML='';
                let error = document.getElementById("e_error");
                let hijo = document.createTextNode(txtErrores);
                error.appendChild(hijo);
            }
            return devolucion;
        }

        window.onload = function(){ 

            <?php  
                $devolucionBajaCat = "";

                if(isset($_GET['msj'])){
                    if($_GET['msj'] == "0"){
                        $devolucionBajaCat ="La categoria selecciona fue correctamente dada de baja";
                    }
                    else if($_GET['msj'] == "1"){
                        $devolucionBajaCat ="Debe seleccionar una categoria";
                    }
                    else if($_GET['msj'] == "2"){
                        $devolucionBajaCat ="La categoria seleccionada tiene productos asociados, eliminelos primero";
                    }
                    if($devolucionBajaCat == "La categoria selecciona fue correctamente dada de baja"){
						echo"
							alert('$devolucionBajaCat');
							window.location = 'http://localhost/maciel/vista_empleado/ve_cat_baja.php';
						";

					}
					else{
						echo "
							document.getElementById('e_error').innerHTML=''; 
							let error = document.getElementById('e_error');
							let hijo = document.createTextNode('$devolucionBajaCat');
							error.appendChild(hijo);
						";
					}
                }                      
            ?>           
        }       

	</script>

    <style>
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

        #contenedor-botones{
            width: 100%;
            background-color: #000;
        }

        main{
            display:flex;
            align-items: center;
            height:500px;
            background-color: #000;
        }
        main {
            display: flex;
            align-items: center;
            height: 500px;
            background-color: #CDCACA; 
        }

        label {
            background-color: #CDCACA;
            padding-left: 0%;
            font-size: 25px;
        }

        .btn {
            height: 80px;
            font-size: 2em;
            background-color: #40D6E5;
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

    <main>

        <h1> Baja categoria</h1>
        
        <?php  
            global $db; 

            //trae los nombres de las categorias
            $sql = "SELECT nombre_categoria,cod_categoria
                    FROM `categoria` 
                    WHERE estado_categoria = 0
                    ORDER BY nombre_categoria ASC 
            "; 

            $rs = $db->query($sql); 

            //lista de categorias
            $listas = " 
                    <select id='categoria' class='hover' name='categoria'> 
                    <option value='0'> Seleccionar Categoria </option>
            ";

            $nomCat = "";
            
            foreach ($rs as $row) {
                $listas .= " <option value='{$row['cod_categoria']}'> {$row['nombre_categoria']} </option> ";
                $nomCat .= $row['nombre_categoria'] . ",";	
            }

            $arrNomCat = explode(",",$nomCat); 

            $listas .= " </select> "; 

            $form="
                    <form action='eliminar_categoria.php' method='post' class='cont-baj'>
                        <label for='categoria'>CATEGORÍA</label> <br>
                            $listas
                        <br>
                        <div class='cont-btn'>
                            <input type='submit' class='btn-enviar' name='enviar' id='enviar' title='Enviar' value='Enviar' onclick='javascript:return validar()'> <br>
                        </div>
                        <p id='e_error'>

                        </p>
                    </form>			   
            ";
            echo $form;
        ?>
	</main>
    
</body>
</html>