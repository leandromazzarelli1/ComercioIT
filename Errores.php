<?php
function verificar($numero){
    if($numero<5){
        throw new Exception("<br>El valor no puede ser menor a cinco");
    }elseif($numero==10){
        throw new Exception("<br>El valor no puede ser 10");
    }
    return true;
}
try{
    $numero=2;
    echo "primeras lineas de codigo";
    echo "<br> segundas lineas";
    verificar($numero);
    /*if($numero<5){
        throw new Exception("<br>El valor no puede ser menos a cinco");
    }//crea una excepcion*/
    echo "<br>aqui estoy en mi programa";
    echo "<br>codeando";
}catch(Exception $e){//capturamos y tenemos que darle una variable
    echo "<br>Error".$e->getMessage();
}finally{
    echo "<br>Soy el final y me estoy mostrando"; 
}
/*
try{//conjunto de sentencias, todo lo que se ejecuta se pone aca

}catch{//si lo que se ejecuta tiene un error se muestra aca

}finally{
    //ejecutar algo extra si o si
}



*/
?>