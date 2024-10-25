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
        main{
            height:470px;
        }

        .cont{
            display:flex;
            width:1300px;
            height:500px;
            background-color: #000;
            margin:auto;
        }

        label{
            color:white;
            width:100%;
        }

        main div{
			background-color:white;
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

        #cerrar{
            padding:4px 5px 5px;
            text-decoration: none;
            color: white;
            background-color:black;
            height:20px;
            border-radius: 5px;
            margin:auto;
        }

        .cont-cat{
            background-color: #000;
            width:400px;
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

        <div class='cont'>
            <div class='cont-cat'>
                <button class='btn hover' onclick="window.location.href='ve_cat_alta.php'">ALTA <BR> Categorías</button>
                <button class='btn hover' onclick="window.location.href='ve_cat_baja.php'">BAJA <BR> Categorías</button>
                <button class='btn hover' onclick="window.location.href='ve_cat_mod.php'">MODIFICACIÓN Categorías</button>
            </div>

            <div class='cont-cat'>
                <button class='btn hover' onclick="window.location.href='ve_subc_alta.php'">ALTA <BR> Subcategorías</button>
                <button class='btn hover' onclick="window.location.href='ve_subc_baja.php'">BAJA <BR> Subcategorías</button>
                <button class='btn hover' onclick="window.location.href='ve_subc_mod.php'">MODIFICACIÓN Subcategorías</button>
            </div>
        </div>
        
    </main>
    
</body>
</html>