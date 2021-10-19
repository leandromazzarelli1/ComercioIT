<?php
require "admin/conexion.php";
function mostrarMensajes($rta){

    switch($rta){
        case "0x001":
            $mensaje="<span style=color:red>Nombre invalido</span>";
        break;
        case "0x002":
            $mensaje="<span style=color:red>Email invalido</span>";
        break;
        case "0x003":
            $mensaje="<span style=color:red>Mensaje invalido</span>";
        break;
        case "0x004":
            $mensaje="<span style=color:green>Correo enviado</span>";
        break;
        case "0x005":
            $mensaje="<span style=color:red>Coreo no enviado</span>";
        break;
        case "0x006":
            $mensaje="<span style=color:green>Producto eliminado correctamente</span>";
        break;
        case "0x007":
            $mensaje="<span style=color:red>No puedo eliminar el producto</span>";
        break;
        case "0x008":
            $mensaje="<span style=color:green>Producto agregado corectamente</span>";
        break;
        case "0x009":
            $mensaje="<span style=color:red>No puedo agregar el producto</span>";
        break;
        case "0x010":
            $mensaje="<span style=color:green>El producto se actualizó</span>";
        break;
        case "0x011":
            $mensaje="<span style=color:red>El producto no se actualizó</span>";
        break;
        case "0x012":
            $mensaje="<span style=color:green>El producto combio de estado</span>";
        break;
        case "0x013":
            $mensaje="<span style=color:red>El producto no se ha modificado</span>";
        break;
        case "0x014":
            $mensaje="<span style=color:red>Claves distintas</span>";
        break;
        case "0x015":
            $mensaje="<span style=color:green>Usuario registrado correctamente</span>";
        break;
        case "0x016":
            $mensaje="<span style=color:red>No puedo registrarte</span>";
        break;
        case "0x017":
            $mensaje="<span style=color:red>Error usuario incorecto</span>";
        break;
        case "0x018":
            $mensaje="<span style=color:red>Error clave es incorecta</span>";
        break;
        case "0x019":
            $mensaje="<span style=color:red>Error no existe el usuario en el sistema</span>";
        break;
        case "0x020":
            $mensaje="<span style=color:red>Error no ejecutar tu solicitud</span>";
        break;
        case "0x021":
            $mensaje="<span style=color:red>Primero ingresa el usuario</span>";
        break;
    }
    return $mensaje;
}

function CargarPagina($page){
    try{
        $page = $page.".php";

        if(file_exists($page)) {
            include $page;
        }else{ 
            include "404.php";
        
        }  
    }catch(Exception $e){//capturamos y tenemos que darle una variable
        echo "<br>Error".$e->getMessage();

    }
}

function mostrarProductos(){
    $archivo="listadoProductos.csv";
			if($file=fopen($archivo, 'r')){
				while(($valor=fgetcsv($file, 1000, ",")) !== FALSE){
		?>
					<div class="product-grid">
						<div class="content_box">
							<a href="./?page=producto">
								<div class="left-grid-view grid-view-left">
									<img src="images/productos/<?php echo $valor[0]; ?>.jpg" class="img-responsive watch-right" alt=""/>
								</div>
							</a>
							<h4><a href="#"><?php echo $valor[1];?></a></h4>
							<p><?php echo $valor[5];?></p>
							<span><?php echo $valor[2];?></span>
						</div>
					</div>
		<?php
				}
				
				
				fclose($file);
			}else{
				echo "error";
			}

}
//eliminamos productos
function borrarProducto($idProducto,$imagen){
    global $conexion;
    /*$sql="delete from productos where idProducto=:idProducto";
    $producto=$conexion->prepare($sql);
    $producto->bindParam(":idProducto", $idProducto, PDO::PARAM_INT);
    */

    unlink("../images/productos/".$imagen);
    $sql="delete from productos where idProducto=?";
    $producto=$conexion->prepare($sql);
    $producto->bindParam(1, $idProducto, PDO::PARAM_INT);
    if($producto->execute()){
        $rta="0x006";
    }else{
        $rta="0x007";
    }
    return $rta;
}

//para crear los productos
function crearProducto($nombre,$precio,$marca,$categoria,$presentacion,$stock, $imagen){
    global $conexion;
    $imagenName=$imagen["name"];//nombre carpeta
    $imagenTmp=$imagen['tmp_name'];//Nombre temporar que le da el server
    $uploads_dir="../images/productos";
    //Guarda la imagen en la carpeta ruta
    move_uploaded_file($imagenTmp, "$uploads_dir/$imagenName");
    $sql="insert into productos (Nombre,Precio,Marca,Categoria,Presentacion,Stock,Imagen) values (?,?,?,?,?,?,?)";
    $producto=$conexion->prepare($sql);
    $producto->bindParam(1, $nombre,PDO::PARAM_STR);
    $producto->bindParam(2, $precio,PDO::PARAM_STR);
    $producto->bindParam(3, $marca,PDO::PARAM_INT);
    $producto->bindParam(4, $categoria,PDO::PARAM_INT);
    $producto->bindParam(5, $presentacion,PDO::PARAM_STR);
    $producto->bindParam(6, $stock,PDO::PARAM_INT);
    $producto->bindParam(7, $imagenName,PDO::PARAM_STR);
    if($producto->execute()){
        $rta="0x008";
    }else{
        $rta="0x009";
    }
    return $rta;
}

//conexion para usar los id producto
function obtenerProducto($idProducto){
    global $conexion;
    $sql="select * from productos where idProducto=?";
    $producto=$conexion->prepare($sql);
    $producto->bindParam(1, $idProducto, PDO::PARAM_INT);//pasamos incognito 1 para que el sistema sepa donde esta el ?
    if($producto->execute()){//canal entre el php y el sistema query para mas complejo
        $producto=$producto->fetch();
    }
    return $producto;
}

///conecxion para tomar los datos para marca
function obtenerMarcaProducto($idMarca){
    global $conexion;
    $sql="select * from marcas where idMarca=?";
    $producto=$conexion->prepare($sql);
    $producto->bindParam(1, $idMarca, PDO::PARAM_INT);//pasamos incognito 1 para que el sistema sepa donde esta el ?
    if($producto->execute()){//canal entre el php y el sistema query para mas complejo
        $producto=$producto->fetch();
    }
    return $producto;
}


///conecxion para tomar los datos para CATEGORIA

function obtenerCategoriaProducto($idCategoria){
    global $conexion;
    $sql="select * from categorias where idCategoria=?";
    $producto=$conexion->prepare($sql);
    $producto->bindParam(1, $idCategoria, PDO::PARAM_INT);//pasamos incognito 1 para que el sistema sepa donde esta el ?
    if($producto->execute()){//canal entre el php y el sistema query para mas complejo
        $producto=$producto->fetch();
    }
    return $producto;
}
// acutalizar el producto que vamos a agregar
function actualizarProducto($idProducto,$nombre,$precio,$marca,$categoria,$presentacion,$stock,$imagen,$imagenActual){
    global $conexion;
    $imagenName=$imagen["name"];//nombre imagen
    if($imagenName==" "){
        $imagenName=$imagenActual;
    }else{//si entra aca sube el archivo nuevo
    $imagenTmp=$imagen['tmp_name'];//Nombre temporar que le da el server
    $uploads_dir="../images/productos/";
    //Guarda la imagen en la carpeta ruta
    move_uploaded_file($imagenTmp, "$uploads_dir/$imagenName");
    $imagenActual=$uploads_dir.$imagenActual;// recordamos la ruta de la imagen actual para que recuerde el lugar a eliminar
    unlink($imagenActual);//borramos la imagen actual si la actualizamos
    }
    
    $sql="update productos set Nombre=?, Precio=?, Marca=?, Categoria=?, Presentacion=?, Stock=?, Imagen=? where idProducto=?";
    $producto=$conexion->prepare($sql);
    $producto->bindParam(1, $nombre, PDO::PARAM_STR);
    $producto->bindParam(2, $precio, PDO::PARAM_STR);
    $producto->bindParam(3, $marca, PDO::PARAM_INT);
    $producto->bindParam(4, $categoria, PDO::PARAM_INT);
    $producto->bindParam(5, $presentacion, PDO::PARAM_STR);
    $producto->bindParam(6, $stock, PDO::PARAM_INT);
    $producto->bindParam(7, $imagenName, PDO::PARAM_STR);
    $producto->bindParam(8, $idProducto, PDO::PARAM_INT);
    if($producto->execute()){
        $rta="0x010";
    }else{
        $rta="0x011";
    }
    return $rta;
}
function actualizarEstado($idProducto, $estado){
    global $conexion;
    $sql="update productos set Estado=? where idProducto=?";
    $producto=$conexion->prepare($sql);
    $producto->bindParam(1, $estado,PDO::PARAM_INT);
    $producto->bindParam(2, $idProducto,PDO::PARAM_INT);
    if($producto->execute()){
        $rta="0x012";
    }else{
        $rta="0x013";
    }
    return $rta;
}
function crearUsuario($nombre,$apellido,$email,$usuario,$clave){
    global $conexion;
    $clave=password_hash($clave, PASSWORD_DEFAULT);
    $codigo="abcdefghi*jklmnopqrstuvwxyz%zyABCDEFGHIJKLMN+OPQRSTUVWXYZ0123456789";
    $codigo=md5(str_shuffle($codigo));
    //enviar correo
    $para='leandromazza19@gmail.com';
    $asunto="Activar cuenta";
    $cabecera= "From" . $para . "\r\n";
    $cabecera.= "MINE-Version: 1.0\r\n";
    $cabecera.= "Content-Type: text/html; charset=UTF-8\r\n";
    $cuerpo="<img src=https://es.freelogodesign.org/Content/img/logo-samples/flooop.png style=width:30%>";
    $cuerpo.="<h1 style=color:pink>Activacion de cuenta</h1>";
    $cuerpo.="<b>Click en el siguiente enlace para activar su cuenta</b>";
    $cuerpo.="<a style=background-color:blue;color:tomato;padding:20px;text-decoration:none; href=https://miweb.com/activacionDeUsuario.php?correo".$email."&codigo=".$codigo."&estado=1>Activar cuenta</a><br><br> chau";
    mail($para, $asunto, $cuerpo, $cabecera);
    $sql="insert into usuarios (Nombre,Apellido,Mail,Usuario,Clave,Codigo) values (?,?,?,?,?,?)";
    $producto=$conexion->prepare($sql);
    $producto->bindParam(1,$nombre,PDO::PARAM_STR);
    $producto->bindParam(2,$apellido,PDO::PARAM_STR);
    $producto->bindParam(3,$email,PDO::PARAM_STR);
    $producto->bindParam(4,$usuario,PDO::PARAM_STR);
    $producto->bindParam(5,$clave,PDO::PARAM_STR);
    $producto->bindParam(6,$codigo,PDO::PARAM_STR);
    if($producto->execute()){
        $rta="0x015";
    }else{
        $rta="0x016";
    }
    return $rta;
}
 function accederUsuario($usuario, $clave){
     global $conexion;
     $sql="select * from usuarios where Usuario=?";
     $producto = $conexion->prepare($sql);
     $producto->bindParam(1, $usuario, PDO::PARAM_STR);
    if($producto->execute()){
        $dato=$producto->fetch();
        if($dato){
            if($dato['Estado']==0){//si existe
                header("location:./?page=ingreso&rta=0x017");
            }else{
                $claveC=$dato['Clave'];
                $usuarioC=$dato['Usuario'];//si la clave y el usuarios con correctos
                if(password_verify($clave,$claveC)){//secion correcta
                    session_start();
                    $_SESSION['usuario']=$usuarioC;//si la secion que llega de la base de datos es corecta
                    $_SESSION['nombre']=$dato['Nombre'];
                    header("location:./admin/?page=listado");
                }else{
                    header("location:./?page=ingreso&rta=0x018"); 
                }
            }//si dato no existe
        }else{
            header("location:./?page=ingreso&rta=0x019"); 
        }
        
    }else{
        header("location:./?page=ingreso&rta=0x020");
    }
    return $rta;

 }
?>