<?php
$nombre=$_POST['nombre'];
$email=$_POST['email'];
$mensaje=$_POST['mensajes'];
if(empty($nombre)){
   
   header("location:./?page=contacto&rta=0x001");

}elseif(!is_string($nombre) && is_numeric($nombre)){
    
    header("location:./?page=contacto&rta=0x001");

}elseif(is_numeric(substr($nombre, 0, 1)) || is_numeric(substr($nombre, -1, 1))){
    
    header("location:./?page=contacto&rta=0x001");

}elseif(strlen($nombre)<=3){

    header("location:./?page=contacto&rta=0x001");

}elseif(filter_var($email, FILTER_VALIDATE_EMAIL)===FALSE){
    
    header("location:./?page=contacto&rta=0x002");
}elseif(empty($email)){
    
    header("location:./?page=contacto&rta=0x002");
}elseif(empty($mensaje)){
    
    header("location:./?page=contacto&rta=0x003");

}elseif(strlen($mensaje)>50){ // 

    header("location:./?page=contacto&rta=0x003");
}else{
    $para="leandromazza19gmail.com";
    $asunto="Contacto desde mi tienda";
    $cabecera = "From:".$email."\r\n";
	$cabecera.= "MIME-Version: 1.0\r\n";
    $cabecera.= "Content-Type: text/html; charset=UTF-8\r\n";
    $cuerpo="<h1>Contacto desde tienda</h1>".$nombre;
    $cuerpo="<br><b>Email: </b>".$email;
    $cuerpo="<br><b>Mensaje: </b>".$mensaje;
    if (!mail($para, $asunto, $cuerpo, $cabecera)){
        
        header("location:./?page=contacto&rta=0x005");
         
    } else {
        
        header("location:./?page=contacto&rta=0x004");
        //variables ?page=algo & rta
    }
}






