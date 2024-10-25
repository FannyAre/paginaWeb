<?php
    include ('inc/session.php');
    require 'inc/conn.php';

    function crear_barra() {
        global $user;
        global $perfil;
        $links=''; 

        if ($user=='') {
            $links = "<a href='login.php' title='Iniciar sesion' id='iniciarSesion'> Iniciar sesión</a>";
        } else if($perfil=='E'){
            $links = "  <span title='Nombre de usuario' id='span'> {$_SESSION['nombre']}  </span>
                        <a href='../cerrar_sesion.php'  id='cerrar' title='Cerrar sesión de usuario'> X </a>";
        } 
        else if($perfil=='U'){
            $links = "<a href='informacion_personal.php' title='Perfil'> <span> {$_SESSION['nombre']} </span> &nbsp;</a>
                        <a href='cerrar_sesion.php' title='Cerrar sesión de usuario'> X </a>";
        }
                        
        $barra_sup ="<div id='barra_superior'>
                        $links
                    </div> ";
                    
        return  $barra_sup;
    }

    function perfil_valido($opcion) {
        global $perfil; 

        switch($opcion){
            case 1: 
                $valido=($perfil=='E')? true:false; 
                break;
            case 2: 
                $valido=($perfil=='U')? true:false;
                break;	
            case 3: 
                $valido=($perfil=='')? true:false; 
                break;
            default:
                $valido=false; 
        }           
        
        return $valido;  
    }

    define('PSW_SEMILLA','34a@$#aA9823$');	
	
	function generar_clave_encriptada($password) {			
		$salt = PSW_SEMILLA;		 
		$psw_encript = hash('sha512', $salt.$password);				
		return $psw_encript; 
	}

    function mostrarInfoPersonal(){
        global $db; 
        $nombreUser = $_SESSION['user'];

        $sql= "SELECT nombre_usuario, perfil, nro_dni, nombre, apellido, email, provincia, ciudad, direccion
                FROM `usuario`
                WHERE nombre_usuario='$nombreUser'
        ";  
    
        $rs = $db->query($sql);

        foreach ($rs as $row) {
            echo "<div class='contenedor-botones'> 
                    Nombre de usuario: {$row['nombre_usuario']} <br>
                    Numero de DNI: {$row['nro_dni']} <br>
                    Nombre: {$row['nombre']} <br>
                    Apellido: {$row['apellido']} <br>
                    Email: {$row['email']} <br>
                    Provincia: {$row['provincia']} <br>
                    Ciudad: {$row['ciudad']} <br>
                    Direccion: {$row['direccion']} <br>
                  </div>
            ";
        }
    }   

    $cont_usuarios =" <div class='contenedor-botones'>      
                        <a href='informacion_personal.php' title='' class='botones'>
                            Informacion personal 
                        </a>
                        <a href='consulta_usuario.php' title='' class='botones'>
                            Historial de consultas       
                        </a>
                        <a href='cerrar_sesion.php' title='' class='botones'> 
                            Cerrar sesion   
                        </a>
                    </div> 
    ";
?>