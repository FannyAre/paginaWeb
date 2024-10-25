<?php 
    include("../encabezado.php");
    include("../pie.php");
    include ("../inc/conn.php");

    if (!perfil_valido(1)) {
        header("location:../index.php");
    }

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/ve_estilos.css" media="screen">
    <title>Catato Hogar - Las mejores marcas</title>
    
    <script>

        function validar(){
            document.getElementById("e_error").innerHTML="";
            
            var categoria =  document.getElementById("categoria").value;//select
            var nombreCat = document.getElementById("nombre").value;

            txtErrores = "";
            if(categoria == "0"){
                txtErrores = "Eliga la categoria";
            }
            //como se puede cambiar el nombre, la imagen o ambas lo voy a controlar del lado php
           
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
                if(isset($_GET['msj'])){
                    $resultadoCatMod ="";

                    if(isset($_GET['msj'])){
                        if($_GET['msj'] == "0"){
                            $resultadoCatMod ="Se modifico correctamente la categoria";
                        }
                        else if($_GET['msj'] == "1"){
                            $resultadoCatMod ="Se debe selecionar una categoria";
                        }
                        else if($_GET['msj'] == "2"){ 
                            $resultadoCatMod ="El nombre de la categoria ingresado ya existe";
                        }
                        else if ($_GET['msj'] == "3"){
                            $resultadoCatMod ="La imagen seleccionada supero el tamaño permitido";
                        }           
                        else if($_GET['msj'] == "4"){
                            $resultadoCatMod ="El archivo debe ser una imagen png, jpeg o jpeg";
                        }
                        if($resultadoCatMod == "Se modifico correctamente la categoria"){
                            echo"
                                alert('$resultadoCatMod');
                                window.location = 'http://localhost/maciel/vista_empleado/ve_cat_mod.php';
                            ";
    
                        }
                        else{
                            echo "
                                document.getElementById('e_error').innerHTML=''; 
                                let error = document.getElementById('e_error');
                                let hijo = document.createTextNode('$resultadoCatMod');
                                error.appendChild(hijo);
                            ";
                        }
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

        <h1> Modificación de una categoria</h1>
        
        <?php 
            global $db;

            $sql = "SELECT nombre_categoria ,cod_categoria
                    FROM `categoria`
                    WHERE estado_categoria = 0
                    GROUP BY nombre_categoria
            ";  
            
            $rs = $db->query($sql);
          
            $form = "  
                    <form action='mod_cat.php' method='post' enctype='multipart/form-data'>  
                        <select class='form-select' aria-label='Default select example' id='categoria' name='categoria' > 
                            <option value='0' selected> &#60;&#60;Seleccione una categoria &#62;&#62;</option>
            ";
    
            foreach ($rs as $row) { //categorias
                $form .= "                             	 
                     <option value='".$row['cod_categoria']."'>".$row['nombre_categoria']."</option>          	 
                ";
            }
    
            $form .= " </select>

                    <br> <br> 

                    <div class='contenedor'>
                        <label for='nombre' class='col-sm-2 form-label'>Nombre</label>
                        <div class='cont-input'>
                            <input type='text' class='form-control' name='nombre' id='nombre' title='Nombre' value=''>
                        </div>
                    </div>
    
                    <br> <br>

                    <div class='contenedor'>
                        <label for='imagenCat' class='col-sm-2 form-label'>Importar imagen</label>
                        <div class='cont-input'>
                            <input type='file' class='form-control' id='imagenCat' name='imagenCat' aria-label='Upload'>      	 
                        </div>           	 
                    </div>
    
                    <br> <br> 

                    <input type='submit' class='btn btn-secondary btn-lg' name='bAceptar' id='bAceptar' title='bAceptar' value='Aceptar' onclick='javascript:return validar()'>      	 
                    
                    
                    <p id='e_error'>
     
                    </p>
            </form>";
            echo $form; 
        ?>
    </main> 
    
</body>
</html>