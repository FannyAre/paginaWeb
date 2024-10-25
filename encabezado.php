<?php   
    include("funciones.php");

    if (perfil_valido(1)){
        $encab =  " <form action='lupa.php' method='POST' id='encabEmpleado'>
                    
                <h1 id='hEncab'> <span id='spanEncab'>Catato Hogar </span></h1>
                 <div id='imagen'>
                    <br><br><br>"
                        . crear_barra() . "
                     </div>
                        <nav id='navigation'>
                            <ul>
                                <li><a href='ve.php'>Productos</a></li>
                                <li><a href='ve_cat_abm.php'>Categorias</a></li>
                                <li><a href='ve_consultas.php'>Consultas</a></li>
                                <li><a href='ventas.php'>Ventas</a></li>
                                <li><a href='usuarios.php'>Usuarios</a></li>
                            </ul>
                        </nav> 
                        </form>
        ";
    }
    else {
        $encab = "
                <form action='lupa.php' method='POST'>
                        <div id='html-slot'>
                            <span>¡Envíos a todo el país!</span>
                        </div>  
                        <div id='container-buscar'>
                            <div id='logo'>
                                <a href='index.php' id='link-logo'> 
                                    <i id='titulo-principal'>CATATO HOGAR</i>
                                </a>
                            </div>
                            <div id='buscar'>
                                <label for='header-buscar'>Busqueda:</label>
                                <input type='text' name='txtFiltro' id='header-buscar' placeholder='Buscar productos por color, marca, material o caracteristicas '>
                                <div id='btn-lupa'>
                                    <button type='submit' name='bLupa' id='lupa' onclick='subcategoria.php' title='Buscar'><img src='images/lupa.png' alt='Lupa de buscar' style='width:20px;' height='20' id='perfil'></button>               
                                </div>
                            </div>"
                            .   crear_barra() .
                "
                            <a href='carrito_compras.php' title='Carrito de compras' class='header-img' id='usu-car'><img src='images/carrito.png' alt='Carrito de compras' style='width:30px;' height='30'></a>
                        </div>     
                        <div id='nav'> 
                            <nav id='navigation'>
                                <ul>
                                    <li><a href='index.php'>Inicio</a></li>
                                    <li><a href='productos.php'>Productos</a></li> 
                                    <li><a href='acerca_de.php'>Acerca de</a></li>
                                    <li><a href='contacto.php'>Contacto</a></li>
                                </ul>
                            </nav>
                        </div>  
                        </form>
        ";
    }
?>