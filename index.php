<?php   
    include("encabezado.php"); 
    include("pie.php");
    include ("inc/conn.php");

    if ($perfil == "E"){ 
        header("location:vista_empleado/ve.php");
    } 

    function agregarImgCategorias(){  
        global $db;

        //se suben solo las categorias que esten activas (estado=0) con subcategorias y productos activos
        $sql = "SELECT `nombre_categoria`  ,cat.`cod_categoria` as cod_categoria,`nombre_archivocat` 
                FROM `categoria` as cat INNER JOIN subcategoria as subCat ON(cat.cod_categoria = subCat.cod_categoria) 
                INNER JOIN producto as prod ON(prod.cod_subcategoria = subcat.cod_subcategoria) 
                WHERE `estado_categoria` = 0 
                AND estado_subcategoria = 0 
                AND estado_producto = 0 
                AND prod.cod_categoria = cat.cod_categoria
                GROUP BY cat.`cod_categoria`
                ORDER BY `nombre_categoria` ASC;
        ";

        $rs = $db->query($sql);

        foreach ($rs as $row) { //categorias
            $codCat =  $row['cod_categoria'];
            $nomCat =  $row['nombre_categoria'];
            $archivo = $row['nombre_archivocat'] ;
            
            echo " <div class='categoria'>
                        <div class='cont-images'> 
                            <img src= 'images/categorias/$archivo' alt='$nomCat' class='img-cat'>
                            <div class='texto'>
                            <p class='img-titulo'>".
                                strtoupper($nomCat) .
                            "</p>";

            //se buscan las subcategorias que tengan productos asociados/activos
            $sql1 ="SELECT `nombre_subcategoria` 
                    FROM `subcategoria` as subCat inner JOIN producto as prod on(subCat.cod_subcategoria = prod.cod_subcategoria) 
                    WHERE prod.cod_categoria = $codCat         
                    AND `estado_subcategoria` = 0
                    AND `estado_producto` = 0
                    GROUP BY `nombre_subcategoria` 
            ";

            $rs1 = $db->query($sql1);

            echo "<p class='img-texto'>";

            $txt = " ";
            foreach ($rs1 as $row1){ //subcategorias
                $txt .= $row1['nombre_subcategoria'] . " <br> ";   
            }
            //agrega las diferentes subcategorias que pertenecen a esa categoria
            echo "" .  ucwords($txt) . "          
                            </p>     
                        </div>
                    </div>
                </div>";
        }
                
    }  
?>
<!DOCTYPE html>
<html lang="es">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width" >
    <link type="text/css"  href="css/estilos.css" rel="stylesheet">
    <title>Catato Hogar</title>

    <style>
        main{
            background-color: #fef7f1;
            padding-top: 30px;
        }

        .categorias {
            display: flex;
            width:70%;
            flex-wrap: wrap;
            justify-content: center;
            padding-left:15%;
            padding-right:15%;
        }

        .cont-images img{
            border-radius: 5px;
            transition: all 0.5s linear;
            width: 300px;
            height: 300px;
        }

        .categoria{
            display:flex;
            justify-content:center;
            width:50%;
            height:400px;
            align-items:center;
        }

        .cont-images{
            position: relative;
            display: inline-block;
            text-align: center;
            cursor: pointer;
        }

        .texto{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #ecab0f;
            opacity: 0;
        }

        .img-titulo{
            display:flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2em;
            background-color: rgba(0,0,0,0.45);
            border-radius:5px;
            width:180px;
            height:40px;
        }

        .img-texto{
            background-color: rgba(0,0,0,0.45);
            border-radius:5px;
            width:160px;
            margin:auto;
        }
    </style>

    <script>

        function ponerMouse(texto,imagen){
            texto.style.transition = "opacity 0.4s linear";
            texto.style.opacity = "1";
            imagen.style.transform="scale(0.9)";
            imagen.style.borderRadius= "10px";
        }

        window.onload = function() {
           let img_cat = document.getElementsByClassName('img-cat');
           let txt_cat = document.getElementsByClassName('texto');
 
            for (i=0;i<img_cat.length;i++){
                let img = img_cat[i];
                let txt = txt_cat[i];

                img.addEventListener ("mouseover", () => {ponerMouse(txt,img);});
                img.addEventListener ("mouseout", ()=>{img.style.transform="scale(1)";
                                                       txt.style.opacity = "0";;}
                                     ); 
                txt.addEventListener ("mouseover", () => {ponerMouse(txt,img);});
            };

            let imagenes = document.getElementsByClassName('cont-images');
            for (j=0;j<imagenes.length;j++){
                let imagen = img_cat[j].getAttribute('alt');
                imagenes[j].addEventListener("click", () => {window.location = 'subcategoria.php?cat='+imagen;});
            };
        };
        
    </script>
</head>
<body id="body">

    <header> 
        <?php echo $encab;  ?>
    </header>

    <main>
        <h1> Inicio del sitio </h1>
        <form class="categorias">
            <?php agregarImgCategorias(); ?>
        </form>
    </main>
    
    <?php
        echo $pie;
    ?>  
     
</body>
</html>