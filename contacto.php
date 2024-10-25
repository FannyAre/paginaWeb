<!DOCTYPE html>
<?php  
    include("encabezado.php");
    include("pie.php");

	if (perfil_valido(1)) {
        header("location:vista_empleado/ve.php");
    }  

?>
<html lang="es">
<head>
	<meta charset="utf-8">
    <title>Catato Hogar</title>
    <meta name="viewport" content="width=device-width" >
    <link type="text/css"  href="css/estilos.css" rel="stylesheet">
	 
	<style>
		body{
			margin: 0;
		}
		main{
			padding:20px 0;
			background-color: #fef7f1;
		}
		.cont-con{
			padding-top: 10px;
			display:flex;
			flex-flow: column;
			justify-content: center;
			height: 420px;
			width: 380px;
			margin: 0 auto;
			border: 2px solid black;
			background-color: #D3D3D3;
			border-radius:5px;
		}

        .input{
			width: 340px;
			height: 50px;
			margin: auto;
			background-color: #D3D3D3;
			border: 2px solid black;
			color: black;
			padding-left: 10px;
			font-size: 1.2em;
	    }

		.input::placeholder { 
			color: black;
			padding-left: 2px;
		 }

	    .txt-area{
		   height: 100px;
		   width: 340px;
		   background-color: #D3D3D3;
		   border: 2px solid black;
		   color: black;
		   padding-left: 10px;
		   font-size: 1.2em;
		   margin: auto;
	    }

		.cont-btn{
			display:flex;
			justify-content: flex-end;
			padding-right:10px;
			margin: auto;
		}
		
	    .btn-enviar{
		   height: 40px;
		   width:100px;
		   border: 2px solid black;
		   font-size:1.2em;
		   background-color: white;
		   border-radius: .1875rem;

	    }

		.btn-enviar:hover {
            background-color: rgb(112, 112, 112);
            transition: all 0.3s linear;
            color: white;
            cursor:pointer
        }

		#e_error{
			color: red;
			font-size: 0.8em;
		}
    </style>

	<script>

		function validar(){
            document.getElementById("e_error").innerHTML="";

			nombre = document.getElementById("nombre").value;
			apellido = document.getElementById("apellido").value;
			email = document.getElementById("email").value;
			txtIngresado = document.getElementById("txtIngresado").value;

			txtErrores = "";

			if( nombre == null || nombre.trim() == ""){
				txtErrores += "Debe ingresar su nombre";
			}
			else if( apellido == null || apellido.trim() == ""){
				txtErrores += "Debe ingresar su apellido";
			}
			else if( email == null || email.trim() == ""){
				txtErrores += "Debe ingresar su email";
			}
			else if( txtIngresado == null || txtIngresado.trim() == ""){
				txtErrores += "Debe ingresar una consulta";
			}

			let devolucion = false;
            
            if(txtErrores == ""){
				devolucion = true;
			}
  
            if (!devolucion){
                let error = document.getElementById("e_error");
                let hijo = document.createTextNode(txtErrores);
				error.appendChild(hijo);
            }

            return devolucion;
		}   
		
		window.onload = function(){           
            <?php 
                $resultadoNuevoContacto="";
				
                if(isset($_GET['msj'])){ 
					if($_GET['msj'] == "0"){
                        $resultadoNuevoContacto ="La consulta fue enviada correctamente";
                    }
                    else if($_GET['msj'] == "1"){
                        $resultadoNuevoContacto ="Debe ingresar su nombre";
                    }
                    else if($_GET['msj'] == "2"){
                        $resultadoNuevoContacto ="Debe ingresar apellido";
                    }
                    else if($_GET['msj'] == "3"){
                        $resultadoNuevoContacto ="Debe ingresar su email";
                    }
					else if($_GET['msj'] == "4"){
                        $resultadoNuevoContacto ="Debe ingresar su consulta";
                    } 

					if($resultadoNuevoContacto == "La consulta fue enviada correctamente"){
						echo"
							alert('$resultadoNuevoContacto');
							window.location = 'http://localhost/maciel/contacto.php';
						";

					}
					else{
						echo "
							document.getElementById('e_error').innerHTML=''; 
							let error = document.getElementById('e_error');
							let hijo = document.createTextNode('$resultadoNuevoContacto');
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
		<?php echo $encab;?>
	</header>

    <main> 
		<h1>Contacto</h1>
		<form action="nuevo_contacto.php" method="post"> 
			<div class="cont-con">
				<label for='nombre'> Nombre </label>
				<input type="text" class="input" name="nombre" id="nombre" value="" Maxlength="35" >
				<label for='apellido'> Apellido </label>
				<input type="text" class="input" name="apellido" id="apellido"  value=""  >
				<label for='email'> Email </label>
				<input type="text" class="input" name="email" id="email"  value="">
				<br>
				<label for='txtIngresado'> Consulta </label>
				<textarea id="txtIngresado" class="txt-area" name="txtIngresado" ></textarea>
				
				<p id="e_error"> </p>

				<div class="cont-btn">
					<input type="submit" class="btn-enviar" name="enviar" id="enviar" title="Enviar" value="Enviar" onclick="javascript:return validar()"> <br>
				</div>
			</div>	
		</form>		 	 
	</main>
	
	<?php echo $pie;?>	
</body>
</html>