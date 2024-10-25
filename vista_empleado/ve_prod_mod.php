<?php 
    include("../encabezado.php");

    if (!perfil_valido(1)) {
        header("location:../index.php");
    }

    global $db;
    $codigo= "";
    $rsCod="";

    //se recargo la pagina, es decir ya se selecciono un producto de las listas y se rellenan los campos
    if(isset($_GET['cod']) && !empty($_GET['cod'])){
        $codigo= $_GET['cod'];
                
        $sql  = "SELECT `codigo`,`cod_categoria`,`cod_subcategoria`,`descripcion`,`material`,`color`,`caracteristicas`,`marca`,`stock`,`precio`
                FROM `producto` 
                WHERE `codigo`='$codigo';
        ";                       
        $rsCod = $db->query($sql);                 
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

        function llenarCamposProd(){ 
            codigo = document.getElementById('cb_productos').value;
            window.location.href = "http://localhost/maciel/vista_empleado/ve_prod_mod.php?cod=" + codigo;
        }

        function esDecimal(nro) {
            return !isNaN(parseFloat(nro)) && isFinite(nro);
        }

        function validar(){
            document.getElementById("e_error").innerHTML="";
            
            var codigo =  document.getElementById("cb_productos").value;
            var descripcion = document.getElementById("descripcion").value;
            var material = document.getElementById("material").value;
            var color = document.getElementById("color").value;
            var caracteristicas = document.getElementById("caracteristicas").value;
            var marca = document.getElementById("marca").value;
            var cantidad = document.getElementById("cant").value;            
            var categoria = document.getElementById("cb_categoria").value;
            var subcategoria = document.getElementById("cb_subcategoria").value;
            var precio = document.getElementById("precio").value;

            var listYaSeleccionada = document.getElementById('detalleSelect').textContent;
            txtErrores = "";
            
            if(listYaSeleccionada =="" && categoria == "0"){
                txtErrores = "Eliga la categoria";
            }
            else if(listYaSeleccionada =="" && subcategoria == "0"){
                txtErrores = "Eliga la subcategoria";
            }
            else if(listYaSeleccionada =="" && codigo == "0"){
                txtErrores = "Debe Seleccionar el producto";
            }
            else if( descripcion == null || descripcion.trim() == ""){
                txtErrores = "Debe ingresar la descripción";
            }
            else if(material  == null || material.trim() == ""){
                txtErrores = "Debe ingresar el material ";
            }
            else if(color  == null || color.trim() == ""){
                txtErrores = "Debe ingresar el color ";
            }
            else if(caracteristicas  == null || caracteristicas.trim() == ""){
                txtErrores = "Debe ingresar las caracteristicas";
            }
            else if(marca  == null || marca.trim() == ""){
                txtErrores = "Debe ingresar la marca";
            }
            else if(cantidad  == null || cantidad.trim() == ""){
                txtErrores = "Debe ingresar la cantidad";
            }
            else if(isNaN(cantidad)){
                txtErrores = "La cantidad debe ser un numero";
            }
            else if(cantidad <= 0){
                txtErrores = "La cantidad debe ser mayor a cero";
            }
            else if(precio == ""){
                txtErrores = "Debe ingresar el precio";
            }
            else if(!esDecimal(precio)){
                txtErrores = "Ingrese un precio correctamente. No utilice punto para separar los miles y los decimales se indican con una coma";
            } 
            else {               
                var nro = precio;
                var precioString = nro.toString();
                var ubicacionPunto = precioString.indexOf(".");

                var resultado = precioString.length - ubicacionPunto - 1;
                
                if( resultado != 2){
                    txtErrores = "El precio debe tener 2 decimales";
                }  
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
                $resultadoModProd="";

                if(isset($_GET['msj'])){  
                    $msj = $_GET['msj'];
    
                    if($msj == "0"){
                        $resultadoModProd = "El producto seleccionado se ha modificado correctamente";
                    }
                    else if($msj == "1"){
                        $resultadoModProd = "Debe ingresar la categoria";
                    }
                    else if($msj == "2"){
                        $resultadoModProd = "Debe ingresar la subcategoria";
                    }
                    else if($msj == "3"){
                        $resultadoModProd = "Debe seleccionar el producto";
                    }
                    else if($msj == "4"){
                        $resultadoModProd = "Debe ingresar la descripción";
                    }
                    else if($msj == "5"){
                        $resultadoModProd = "Debe ingresar el material";
                    }
                    else if($msj == "6"){ 
                        $resultadoModProd = "Debe ingresar el color";
                    }
                    else if($msj == "7"){
                        $resultadoModProd = "Debe ingresar la caracteristica";
                    }
                    else if($msj == "8"){
                        $resultadoModProd = "Debe ingresar la marca";
                    }
                    else if($msj == "9"){
                        $resultadoModProd= "Debe ingresar la cantidad";
                    }    
                    else if($msj == "10"){
                        $resultadoModProd = "Debe ingresar el precio";
                    }    
                    else if($msj =="11"){
                        $resultadoModProd ="El tamaño de la imagen debe ser menor";
                    }
                    else if($msj == "12"){
                        $resultadoModProd ="El archivo seleccionado debe ser una imagen png, jpg o jpeg";
                    }
                    if($resultadoModProd == "El producto seleccionado se ha modificado correctamente"){
						echo"
							alert('$resultadoModProd');
							window.location = 'http://localhost/maciel/vista_empleado/ve_prod_mod.php';
						";

					}
					else{
						echo "
							document.getElementById('e_error').innerHTML=''; 
							let error = document.getElementById('e_error');
							let hijo = document.createTextNode('$resultadoModProd');
							error.appendChild(hijo);
						";
					}     
                }
            ?>
            
        }
    </script>
     
    <style>
        
        main {
            background-color: #D3D3D3;
            height: 2000px;
        }

        button{
            cursor: pointer;
            width:200px;
        }

        main > a{
            cursor: pointer;
        }

        main div{
			background-color:transparent;
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

    <main id='main'>

        <h1> Modificación de un producto</h1>

        <form  id='combo' name='combo' action='mod_prod.php' method='POST' class='cont' enctype="multipart/form-data">
            <?php           
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
                    <select name='cb_productos' id='cb_productos' class='hover' onchange='return llenarCamposProd()'>                  
                    </select>
                ";
                
                echo $listas;

                if(isset($_GET['cod'])){//se refresco la pagina y se rellenan los datos
    
                    foreach ($rsCod as $row) {
                        $sqlCatYSubcat = "SELECT nombre_subcategoria, nombre_categoria 
                                          FROM `subcategoria`  INNER JOIN categoria on (subcategoria.cod_categoria = categoria.cod_categoria )
                                          WHERE categoria.cod_categoria = ".$row['cod_categoria']."
                                          and subcategoria.cod_subcategoria =".$row['cod_subcategoria']."
                        ";
                        $rsCatYSubcat = $db->query($sqlCatYSubcat);

                        foreach ($rsCatYSubcat as $row1) {
                            echo"<br><br><br>
                                    <p id='detalleSelect'>
                                       'La categoria seleccionada es: ".$row1['nombre_categoria']."<br>
                                        La subcategoria seleccionada es: ".$row1['nombre_subcategoria']."
                                    </p>
                                <br><br><br>
                            ";
                        }

                        echo "  <input type='hidden' name='codigo' value='".$_GET['cod']."'/> 
                                <div class='contenedor'>
                                    <label for='descripcion' class='col-sm-2 form-label'>Descripción</label>
                                    <div class='cont-input'>
                                        <input type='text' class='form-control' name='descripcion' id='descripcion' title='Descripción' value='".$row['descripcion']."'>
                                    </div>
                                </div>  

                                <div class='contenedor'>
                                    <label for='material' class='col-sm-2 form-label'>Material</label>
                                    <div class='cont-input'>
                                        <input type='text' class='form-control' name='material' id='material' title='Material' value='".$row['material']."'>
                                    </div>
                                </div>
                    
                                <div class='contenedor'>
                                    <label for='color' class='col-sm-2 form-label'>Color</label>
                                    <div class='cont-input'>
                                        <input type='text' class='form-control' name='color' id='color' title='Color' value='".$row['color']."'> 
                                    </div>
                                </div>
                    
                                <div class='contenedor'>
                                    <label for='caracteristicas' class='col-sm-2 form-label'>Caracteristicas</label>
                                    <div class='cont-input'>
                                        <input type='text' class='form-control' name='caracteristicas' id='caracteristicas' title='Caracteristicas' value='".$row['caracteristicas']."'>
                                    </div>
                                </div>
                    
                                <div class='contenedor'>
                                    <label for='marca' class='col-sm-2 form-label'>Marca</label>
                                    <div class='cont-input'>
                                        <input type='text' class='form-control' name='marca' id='marca' title='Marca' value='".$row['marca']."'> 
                                    </div>
                                </div>
                    
                                <div class='contenedor'>
                                    <label for='cant' class='col-sm-2 form-label'>Cantidad</label>
                                    <div class='cont-input'>
                                        <input type='text' class='form-control' name='cant' id='cant' title='Cantidad' value='".$row['stock']."'>  
                                    </div>
                                </div> 
                    
                                <div class='contenedor'>
                                    <label for='precio' class='col-sm-2 form-label'>Precio</label>
                                    <div class='cont-input'>
                                        <input type='text' class='form-control' name='precio' id='precio' title='Precio' value='".$row['precio']."'>  
                                    </div>
                                </div> 
                                
                                <label for='imagen' class='col-sm-2 form-label'>Imagen</label>
                                <input type='file' name='imagen' title='imagen del producto' id='imagen'>
                                                                          
                                <div class='cont-input'>
                                    <input type='submit' name='aceptar' class='btn-enviar hover' title='Aceptar' value='Aceptar' onclick='javascript:return validar()'>
                                </div>
                    
                                <div class='cont-input'>
                                    <p id='e_error'> </p>
                                </div>
                        ";
                    }
                }
                else{
                    echo "
                        <input type='hidden' name='codigo' value=''/> 

                        <p id='detalleSelect'>  </p>

                        <div class='contenedor'>
                            <label for='descripcion' class='col-sm-2 form-label'>Descripción</label>
                            <div class='cont-input'>
                                <input type='text' class='form-control' name='descripcion' id='descripcion' title='Descripción' value=''>
                            </div>
                        </div>  

                        <div class='contenedor'>
                            <label for='material' class='col-sm-2 form-label'>Material</label>
                            <div class='cont-input'>
                                <input type='text' class='form-control' name='material' id='material' title='Material' value=''>
                            </div>
                        </div>
            
                        <div class='contenedor'>
                            <label for='color' class='col-sm-2 form-label'>Color</label>
                            <div class='cont-input'>
                                <input type='text' class='form-control' name='color' id='color' title='Color' value=''> 
                            </div>
                        </div>
            
                        <div class='contenedor'>
                            <label for='caracteristicas' class='col-sm-2 form-label'>Caracteristicas</label>
                            <div class='cont-input'>
                                <input type='text' class='form-control' name='caracteristicas' id='caracteristicas' title='Caracteristicas' value=''>
                            </div>
                        </div>
            
                        <div class='contenedor'>
                            <label for='marca' class='col-sm-2 form-label'>Marca</label>
                            <div class='cont-input'>
                                <input type='text' class='form-control' name='marca' id='marca' title='Marca' value=''> 
                            </div>
                        </div>
            
                        <div class='contenedor'>
                            <label for='cant' class='col-sm-2 form-label'>Cantidad</label>
                            <div class='cont-input'>
                                <input type='text' class='form-control' name='cant' id='cant' title='Cantidad' value=''>  
                            </div>
                        </div> 
            
                        <div class='contenedor'>
                            <label for='precio' class='col-sm-2 form-label'>Precio</label>
                            <div class='cont-input'>
                                <input type='text' class='form-control' name='precio' id='precio' title='Precio' value=''>  
                            </div>
                        </div> 
                              
                        <label for='imagen' class='col-sm-2 form-label'>Imagen</label>
                        <input type='file' name='imagen' title='imagen del producto' id='imagen' >
                                          
                        <div class='cont-input'>
                            <input type='submit' name='aceptar' class='btn-enviar hover' title='Aceptar' value='Aceptar' onclick='javascript:return validar()'>
                        </div>
            
                        <div class='cont-input'>
                            <p id='e_error'> </p>
                        </div>
                    ";
                }                       
            ?>
        </form>
    </main>
</body>
</html>