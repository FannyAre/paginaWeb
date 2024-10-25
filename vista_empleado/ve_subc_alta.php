<?php 
    include("../encabezado.php");

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
            font-size: 20px;
        }

        

        .cont {
            margin: 0 auto;
            padding: 1% 0;
            justify-content: center;
            width: 500px;
            border: 0px ;
            background-color: #CDCACA;
        }
        .btn {
            height: 80px;
            font-size: 2em;
            background-color: #40D6E5;
        }

        .input {
            width: 480px;
            height: 50px;
            margin: auto;
            border: 2px solid black;
            color: black;
            padding-left: 10px;
            font-size: 1.2em;
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

    <script>

        function validar(){
            document.getElementById("e_error").innerHTML="";
            
            var categoria =  document.getElementById("cb_categoria").value;
            var nombreSubCat = document.getElementById("nombre").value; 
            txtErrores = "";
            
            if(categoria == "0"){
                txtErrores = "Eliga la categoria";
            }
            else if(nombreSubCat ==null || nombreSubCat.trim() == ""  ){
                txtErrores = "Ingrese el nombre de la categoria que quiera modificar";
            }
           
            let devolucion = false;

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
                $resultadoSubcatAlta="";

                if(isset($_GET['msj'])){
            
                    if($_GET['msj'] == "0"){
                        $resultadoSubcatAlta ="La subcategoria fue ingresada correctamente";
                    }
                    else if($_GET['msj'] == "1"){
                        $resultadoSubcatAlta ="Debe seleccionar la categoria";
                    }
                    else if($_GET['msj'] == "2"){
                        $resultadoSubcatAlta ="Debe ingresar el nombre de la nueva subcategoria";
                    }
                    else if($_GET['msj'] == "3"){
                        $resultadoSubcatAlta ="La subcategoria ingresada ya existe";
                    }
                    if($resultadoSubcatAlta == "La subcategoria fue ingresada correctamente"){
						echo"
							alert('$resultadoSubcatAlta');
							window.location = 'http://localhost/maciel/vista_empleado/ve_subc_alta.php';
						";

					}
					else{
						echo "
							document.getElementById('e_error').innerHTML=''; 
							let error = document.getElementById('e_error');
							let hijo = document.createTextNode('$resultadoSubcatAlta');
							error.appendChild(hijo);
						";
					}
                }            
            ?>        
        }

    </script>

</head>
<body>

    <header> 
        <?php echo $encab; ?>
	</header>

    <main>

        <h1> Alta subcategoria</h1>
        
        <form action="nueva_subcat.php" class="cont"  method="POST" enctype="multipart/form-data">
            
            <?php
                echo "
                <label for='cb_categoria'>CATEGORIA</label> <br>
                    <select id='cb_categoria' class='hover' name='cb_categoria'>   
                        <option value='0'> Selecciona categoria </option> ";
                        
                $sql  = "SELECT `nombre_categoria` ,`cod_categoria`
                        FROM `categoria` 
                        ORDER BY `nombre_categoria` ASC
                ";
                
                global $db;         
                $rs = $db->query($sql);

                foreach ($rs as $row) {
                    echo" <option value='".$row['cod_categoria']."'> " .ucfirst($row['nombre_categoria']) . "</option>";
                } 

                echo "</select>	";
            ?>

			<br><br>
            
            <div class='contenedor'>
                <label for='nombre' class='col-sm-2 form-label'>Nombre</label>
                <div class='cont-input'>
                    <input type="text" name="nombre" id="nombre" title="Ingrese el nombre de la subcategoria" value=""> <br>
                </div>           	 
            </div>
           
            <br><br><br>
            
            <input type="submit"  name="bAgregarSubCat" id="bAgregarSubCat" title="Agregar subcategoria" value="Agregar subcategoria" onclick="javascript:return validar()">  <br>
            
            <p id='e_error'>  </p>     	 
                         
        </form>	
    </main> 
</body>
</html>