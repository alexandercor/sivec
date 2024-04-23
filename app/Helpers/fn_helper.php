<?php

    if(!function_exists('bs64url_enc')){
        function bs64url_enc(string $input):string {
            return strtr(base64_encode($input), '+/=', '._-');
        }
    }

    if(!function_exists('bs64url_dec')){
        function bs64url_dec(string $input):string {
            return base64_decode(strtr($input, '._-', '+/='));
        }
    }

    if(!function_exists('fdate')){
        function fdate($fecha){
            $objDate = new dateTime($fecha);
            $fecha = $objDate->format('d/m/Y');
            return $fecha;
        }    
    }
    if(!(function_exists('prueba'))){
        function prueba() {
            return 'Bien';
        }
    }


// ***
?>