<?php 
    include("../encabezado.php");
    require '../inc/conn.php';

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

                        $(document).ready(function(){//detectamos un cambio en el combobox
                            $('#cb_subcategoria').change(function () {
                            
                                $('#cb_subcategoria option:selected').each(function(){//obtenemos la variable seleccionada
                                    id_estado = $(this).val();
                                    $.post('crearListaProducto.php', {
                                        id_estado: id_estado//id_subcategoria: id_subcategoria 
                                    },function(data){
                                    $('#cb_productos').html(data);//regresa el html
                                    });
                                });
                            })
                        });
    </script>

    <script>

		function validar(){
            txtErrores = "";
            devolucion = false;

            prodSeleccionado = document.getElementById("cb_productos").value;
            catSeleccionado = document.getElementById("cb_categoria").value;
            subcatSeleccionado = document.getElementById("cb_subcategoria").value;
            
            if(catSeleccionado== 0){
                devolucion = false,
                txtErrores="Debe seleccionar la categoria"
            }
            else if(subcatSeleccionado== 0){
                devolucion = false,
                txtErrores="Debe seleccionar la subcategoria"
            }
            else if(prodSeleccionado== 0){
                devolucion = false,
                txtErrores="Debe seleccionar el producto"
            }
            else{
                devolucion = true;
            }

            if (!devolucion){
                document.getElementById('e_error').innerHTML='';
                let error = document.getElementById('e_error');
				error.style.display = 'block';
                let hijo = document.createTextNode(txtErrores);
				error.appendChild(hijo);
            }
            return devolucion;
        }
        
        window.onload = function(){   

            <?php
                $devolucion = "";
                if(isset($_GET['msj'])){
                    if($_GET['msj'] == "0"){
                        $devolucion = "El producto seleccionado fue dado de baja correctamente";
                    }
                    else{
                        $devolucion = "Seleccione un producto";
                    }
                    if($devolucion == "El producto seleccionado fue dado de baja correctamente"){
						echo"
							alert('$devolucion');
							window.location = 'http://localhost/maciel/vista_empleado/ve_prod_baja.php';
						";

					}
					else{
						echo "
							document.getElementById('e_error').innerHTML=''; 
							let error = document.getElementById('e_error');
							let hijo = document.createTextNode('$devolucion');
							error.appendChild(hijo);
						";
					}

                }       
            ?>         
        }
	</script>

    <style> 
		.cont{
			width:400px;
		}

		.cont-btn{
			display:flex;
			justify-content:center;
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

        <h1> Baja de producto</h1>

		<?php 
        
            global $db;  

            $listas = "
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
            
            $rs = $db->query($sql);
        
            foreach ($rs as $row) {
                $listas .= " <option value='".$row['cod_categoria']."'> " .ucfirst($row['nombre_categoria']) . "</option>";
            } 
            
            $listas .= "
                </select>				
                <label for='cb_subcategoria'>SUBCATEGORIA</label> <br>
                    <select name='cb_subcategoria' id='cb_subcategoria' class='hover'> 
                        
                    </select>
                                
                    <label for='cb_productos'>PRODUCTOS</label> <br>
                        <select name='cb_productos' id='cb_productos' class='hover'> 
                            
                        </select>";
            $form="
                    <form class='cont' method='post' action='eliminar_producto.php'>
                            
                        ".$listas  ."
                        <br>

                        <div class='cont-btn'>
                            <input type='submit' class='btn-enviar hover' name='enviar' id='enviar' title='Enviar' value='Enviar' onclick='javascript:return validar()'> <br>
                        </div>
        
                        <p id='e_error' class='e_error'  style='display:none;'>   </p>
                    </form>			   
            ";
            echo $form;
		?>
	</main>
    
</body>
</html>