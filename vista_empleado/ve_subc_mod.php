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
	
    <script  src="../js/jquery-3.6.1.min.js">      
    </script>

    <script>
                        $(document).ready(function(){//detectamos un cambio en el combobox
                            $('#cb_categoria').change(function () {
                                $('#cb_categoria option:selected').each(function(){//obtenemos la variable seleccionada
                                    id_estado = $(this).val();
                                    $.post('crearListaSubcategoria.php', {
                                        id_estado: id_estado
                                    },function(data){
                                    $('#cb_subcategoria').html(data);//regresa el html
                                    });
                                }); 
                            })
                        }                    
                        );		

    </script>

    <script>

        function validar(){                
            let devolucion = false;
            let txtErrores = "";
            document.getElementById('e_error').innerHTML='';
                
            var codCat = document.getElementById("cb_categoria").value;
            var codSubCat = document.getElementById("cb_subcategoria").value;
            var nombre = document.getElementById("nombreCat").value;

            if(codCat =="0"){
                txtErrores="Debe seleccionar la categoria";
            }
            else if(codSubCat =="0"){
                txtErrores="Debe seleccionar la subcategoria";
            }
            else if(nombre == null || nombre.trim() == ""){
                txtErrores="Debe seleccionar la subcategoria";
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
                $resultadoSubcatMod="";

                if(isset($_GET['msj'])){
            
                    if($_GET['msj'] == "0"){
                        $resultadoSubcatMod ="La subcategoria fue modificada correctamente";
                    }
                    else if($_GET['msj'] == "1"){
                        $resultadoSubcatMod ="Debe seleccionar la categoria";
                    }
                    else if($_GET['msj'] == "2"){
                        $resultadoSubcatMod ="Debe seleccionar la subcategoria";
                    }
                    else if($_GET['msj'] == "3"){
                        $resultadoSubcatMod ="Debe ingresar el nombre que desea modificar";
                    } 
                    if($resultadoSubcatMod == "La subcategoria fue modificada correctamente"){
						echo"
							alert('$resultadoSubcatMod');
							window.location = 'http://localhost/maciel/vista_empleado/ve_subc_mod.php';
						";

					}
					else{
						echo "
							document.getElementById('e_error').innerHTML=''; 
							let error = document.getElementById('e_error');
							let hijo = document.createTextNode('$resultadoSubcatMod');
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
            height: 700px;
            background-color: #CDCACA; 
        }

        label {
            background-color: #CDCACA;
            padding-left: 0%;
            font-size: 20px;
        }

        .btn {
            height: 80px;
            font-size: 2em;
            background-color: #40D6E5;
        }
        .cont-input {
            background-color: transparent;
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
 
    <main id='main'> 

        <h1> Modificacion de una subcategoria</h1>

        <div class='cont-baj'>

            <form method="POST" action="mod_subcat.php">

                <?php  
                    echo "
                        <label for='cb_categoria'>CATEGORIA</label> <br>
                            <select id='cb_categoria' class='hover' name='cb_categoria'>   
                                <option value='0'> Selecciona categoria </option> ";
                            
                    $sql = "SELECT `nombre_categoria` ,`cod_categoria`
                            FROM `categoria` 
                            WHERE `estado_categoria` = 0
                            and `cod_categoria` in(
                                                    SELECT cat.cod_categoria
                                                    FROM categoria as cat INNER JOIN subcategoria as subcat on(cat.cod_categoria = subcat.cod_categoria)
                                                    where subcat.estado_subcategoria = 0
                                                )            
                            ORDER BY `nombre_categoria` ASC
                    ";
                    global $db;             
                    $rs = $db->query($sql);

                    foreach ($rs as $row) {
                        echo " <option value='".$row['cod_categoria']."'> " .ucfirst($row['nombre_categoria']) . "</option>";
                    } 
                    
                    echo "
                        </select>				
                        <label for='cb_subcategoria'>SUBCATEGORIA</label> <br>
                        <select name='cb_subcategoria' id='cb_subcategoria' class='hover'> 
                                
                        </select>
                    "; 
                ?> 

                <br>
                    
                <div class='cont-btn'>

                <br>
                    
                <div class='contenedor'>
                    <label for='nombreCat' class='col-sm-2 form-label'>Cambiar nombre:</label>
                    <div class='cont-input'>
                            <input type="text" name="nombreCat" id="nombreCat" title="Ingrese el nombre de la subcategoria" value=""> 
                    </div>           	 
                </div>

                <br><br><br>

                <input type='submit' onclick='javascript:return validar()' class='btn-enviar' id='Agregar' title='Agregar' value='Modificar Categoria'>     
                                     
                <p id="e_error"></p>

                </div>
            </form>
        </div>
	</main>
</body>
</html>