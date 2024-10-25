    function validarBarraLateral(){
        
        document.getElementById('e_error').innerHTML="";
        txtErrores = "";
        
        let minimo = document.getElementById("valorMin").value; 
        let maximo = document.getElementById("valorMax").value;
        let minimoActual = document.getElementById("valorMinOriginal").value;
        let maximoActual = document.getElementById("valorMaxOriginal").value;

        if(minimoActual < minimo || minimoActual > maximo){ 
            txtErrores = "El valor minimo tiene que estar entre " + minimo + " y " + maximo;
        }
        else if(maximoActual > maximo || maximoActual < minimo){
            txtErrores = "El valor maximo tiene que estar entre " + minimo  + " y " + maximo;
        } 

        let devolucion = false;
        
        if(txtErrores == ""){
            devolucion = true;
        }

        if (!devolucion){
            let error = document.getElementById('e_error');
            let hijo = document.createTextNode(txtErrores);
            error.appendChild(hijo);
        }

        return devolucion;
    }
