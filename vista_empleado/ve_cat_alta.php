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

    <script> 

        function validar(){   

            let devolucion = false;
            let txtErrores = "";
            
            var nombreCat = document.getElementById("nombre").value;
            if(nombreCat == null || nombreCat.trim() == ""){
                txtErrores="Debe ingresar el nombre de la categoria";
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
                $resultadoNuevaCat =""; 

                if(isset($_GET['msj'])){
                    if($_GET['msj'] == "0"){
                        $resultadoNuevaCat = "La categoria ha sido ingresada correctamente";
                    }
                    else if($_GET['msj'] == "1"){
                        $resultadoNuevaCat = "Ingrese el nombre de la categoria";
                    }
                    else if($_GET['msj'] == "2"){ 
                        $resultadoNuevaCat = "La categoria ingresada ya existe";
                    }
                    else if($_GET['msj'] == "3"){
                        $resultadoNuevaCat = "Ingrese una imagen para la categoria";
                    }
                    else if($_GET['msj'] == "4"){
                        $resultadoNuevaCat = "El tamaño de la imagen subida supera el maximo permitido";
                    }
                    else if($_GET['msj'] == "5"){
                        $resultadoNuevaCat = "El archivo subido tiene que ser una imagen png, jpeg o png";
                    }
                    if($resultadoNuevaCat == "La categoria ha sido ingresada correctamente"){
						echo"
							alert('$resultadoNuevaCat');
							window.location = 'http://localhost/maciel/vista_empleado/ve_cat_alta.php';
						";

					}
					else{
						echo "
							document.getElementById('e_error').innerHTML=''; 
							let error = document.getElementById('e_error');
							let hijo = document.createTextNode('$resultadoNuevaCat');
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
        
        <h1> Nueva categoria</h1>

        <form action='nueva_categoria.php' method='post' enctype='multipart/form-data'>
            
            <div class='contenedor'>
                <label for='nombre' class='col-sm-2 form-label'>Nombre</label>
                <div class='cont-input'>
                    <input type='text' class='form-control' name='nombre' id='nombre' title='Nombre' value=''> 
                </div>
            </div>
 
            <br>

            <div class='contenedor'>
                <label for='imagenCat' class='col-sm-2 form-label'>Archivo:</label>
                <div class='cont-input'>
                    <input type='file' class='form-control' name='imagenCat' id='imagenCat' >                  
                </div>
            </div>

            <br><br><br>
            <input type='submit' class='btn btn-secondary btn-lg' name='bAceptar' id='bAceptar' title='bAceptar' value='Aceptar' onclick='javascript:return validar()'>          
            
            <p id="e_error">

            </p>
            
        </form> 

        <br>

    </main>
    
</body>
</html>