<?php
require "conexion.php";
//crear producto
if(isset($_GET['accion'])){
    if(isset($_POST['guardar'])){
        /*
        $_FILES["file"]["type"];
        ["Nombre imagen"]      ["size"]
                        ["name"]
                        ["tmp_name"];
        */
        $nombre=$_POST['nombre'];
        $precio=$_POST['precio'];
        $marca=$_POST['marca'];
        $categoria=$_POST['categoria'];
        $presentacion=$_POST['presentacion'];
        $stock=$_POST['stock'];
        $imagen=$_FILES['imagen'];
        //var_dump($imagen);
        $rta=crearProducto($nombre,$precio,$marca,$categoria,$presentacion,$stock,$imagen);
        echo mostrarMensajes($rta);
    }
}
//obtener datos del producto a editar
if(isset($_GET['idProducto'])){
    $idProducto=$_GET['idProducto'];
    $valor=obtenerProducto($idProducto);
    $valorMarca=obtenerMarcaProducto($valor['Marca']);
    $valorCategoria=obtenerCategoriaProducto($valor['Categoria']);
    //var_dump($valor);
    
}
//actualizar el producto
if(isset($_POST['editar'])){
   $idProducto=$_POST['idProducto'];
   $nombre=$_POST['nombre'];
   $precio=$_POST['precio'];
   $marca=$_POST['marca'];
   $categoria=$_POST['categoria'];
   $presentacion=$_POST['presentacion'];
   $stock=$_POST['stock'];
   $imagenActual=$_POST['imagenActual'];
   $imagen=$_FILES['imagen'];//["name"];al llamarlo por al nombre si esta vacio significa que se puede usar en una funcion para despues borrarlo
    $mensaje = actualizarProducto($idProducto,$nombre,$precio,$marca,$categoria,$presentacion,$stock,$imagen,$imagenActual);
    echo mostrarMensajes($mensaje);
}




//Para cambiar de totulo en actualizar o cargar nuevo por la url

    if($_GET['accion']=="n"){
      echo '<h1>crear otro producto</h1>';

    }else if($_GET['accion']=="a"){

        echo '<h1>Actualizar producto</h1>';
        
    }
?>
 



            <div class="contact-form">
                <form action="" method="post" enctype="multipart/form-data">

                    <input type="text" class="textbox" name="nombre" 
                    <?php
                    if(isset($_GET['idProducto'])){
                    ?>
                    value="<?php echo $valor['Nombre']; ?>"
                    <?php
                     }else{
                    ?>
                    placeholder="Nombre"
                    <?php
                    }
                    ?>
                    >

                    

                    <input type="text" class="textbox" name="precio"
                    <?php
                    if(isset($_GET['idProducto'])){
                    ?>
                    value="<?php echo $valor['Precio']; ?>"
                    <?php
                     }else{
                    ?>
                    placeholder="Precio"
                    <?php
                    }
                    ?>
                    >


                    <select name="marca" class="form-control">


                    <?php
                    $sql = "select * from marcas";
                    $conexion->prepare($sql);
                    foreach($conexion->query($sql) as $row){
                    ?>
                   <option value="<?php echo $row['idMarca']; ?>"><?php echo $row['Nombre']; ?></option>
                    <?php } ?>



                    <?php
                    if(isset($_GET['idProducto'])){
                    ?>
                    <option selected value="<?php echo $row['idMarca']; ?>"><?php echo $valorMarca['Nombre']?></option>
                    <?php
                    }else{
                    ?>
                    <option>Marca</option>
                    <?php
                    }
                    ?>  

                    </select><br>
                    <select name="categoria" class="form-control">





                    <?php
                    $sql = "select * from categorias";
                    $conexion->prepare($sql);
                    foreach($conexion->query($sql) as $row){
                    ?>
                    <option value="<?php echo $row['idCategoria']; ?>"><?php echo $row['Nombre']; ?></option>
                    <?php } ?>

                    <?php
                    if(isset($_GET['idProducto'])){
                    ?>
                    <option selected value="<?php echo $row['idCategoria']; ?>"><?php echo $valorCategoria['Nombre']?></option>
                    <?php
                    }else{
                    ?>
                    <option>Categoria</option>
                    <?php
                    }
                    ?>  

                    </select>




                    <input type="text" class="textbox" name="presentacion"
                    <?php
                    if(isset($_GET['idProducto'])){
                    ?>
                    value="<?php echo $valor['Presentacion']; ?>"
                    <?php
                     }else{
                    ?>
                    placeholder="Presentacion"
                    <?php
                    }
                    ?>
                    >


                    <input type="text" class="textbox" placeholder="Stock" name="stock"
                    <?php
                    if(isset($_GET['idProducto'])){
                    ?>
                    value="<?php echo $valor['Stock']; ?>"
                    <?php
                     }else{
                    ?>
                    placeholder="Stock"
                    <?php
                    }
                    ?>
                    >
                    
                    <input type="hidden" name="idProducto" value="<?php echo $_GET['idProducto'];?>" >
                    <?php
                    if($_GET['accion']=="a"){
                    ?>
                    <img src="../images/productos/<?php echo $valor['Imagen']; ?>" style="width:200px">
                    <input type="hidden" name="imagenActual" value="<?php echo $valor['Imagen'];?>" >
                    <?php   // sirve para mostrar la imagen viaja para guardarla
                    }
                    ?>
                    <input type="file" name="imagen">
                    
                    <?php
                    if($_GET['accion']=="n"){
                    ?>
                    <input type="submit" name="guardar" value="Guardar nuevo producto">
                    <?php
                    }elseif($_GET['accion']=="a"){
                    ?>
                    <input type="submit" name="editar" value="editar producto">   
                     <?php   
                    }
                    ?>
                    <div class="clearfix"></div>
                </form>
            </div>