<?php
session_start();
if(isset($_SESSION['usuario'])){
echo "<br><br><a href=../?page=ingreso&logout=true>Desconectar</a>";
echo "<h2 style=color:gray> Hola ".$_SESSION['nombre']."</h2>";
//eliminar producto
if(isset($_GET['accion'])){
  if($_GET['accion']=="e"){
    $idProducto=$_GET['idProducto'];
    $imagen=$_GET['imagen'];//sirve para eliminar la imagen en la carpeta
    $rta=borrarProducto($idProducto, $imagen);
    echo mostrarMensajes($rta);
  }
}
if(isset($_GET['estado'])){
  $idProducto=$_GET['idProducto'];
  $estado=$_GET['estado'];
  $rta=actualizarEstado($idProducto,$estado);
  echo mostrarMensajes($rta);
}
?>
<h1>listado de productos</h1>
<table class="table">
<a href="./?page=gestionProductos&accion=n">Crear nuevo producto</a>
<br>

<br>
  <thead>
    <tr>
      <th scope="col">id Producto</th>
      <th scope="col">Nombre</th>
      <th scope="col">Precio</th>
      <th scope="col">Marca</th>
      <th scope="col">Categoria</th>
      <th scope="col">Presentacion</th>
      <th scope="col">Stock</th>
      <th scope="col">Imagen</th>
      <th colspan="3">Operacion</th>
    </tr>
  </thead>
  <tbody>
    <?php
      require "conexion.php";
      $sql="select p.idProducto,p.Nombre,p.Precio,p.Presentacion,p.Stock,p.Imagen,p.Estado,m.Nombre as marca,c.Nombre as categoria from productos p INNER JOIN marcas m ON p.Marca=m.idMarca INNER JOIN categorias c ON p.Categoria=c.idCategoria";
      //mysqli_query($conexion, $sql);
      //foreach($conexion->query($sql) as $row){ consultas simples
      $query=$conexion->prepare($sql);//prepara una consulta antes de enviarla mejora el rendimiento
      $query->execute(); //Para con sultas mas amplias con where
      while($row=$query->fetch()){//extrae informacion al ejecutar consulta y lo guarda en un arreglo.
    ?>
    <tr>
      <th scope="row"><?php echo $row['idProducto']; ?></th>
      <td><?php echo $row['Nombre']; ?></td>
      <td><?php echo $row['Precio']; ?></td>
      <td><?php echo $row['marca']; ?></td>
      <td><?php echo $row['categoria']; ?></td>
      <td><?php echo $row['Presentacion']; ?></td>
      <td><?php echo $row['Stock']; ?></td>
      <td>
        <?php if(isset($row['Imagen']) && $row['Imagen'] != ""): ?>
          <p>Imagen no encontrada</p>
        <?php else: ?>
          <img src="../images/productos/<?php echo $row['Imagen']; ?>" style="width:50px">
        <?php endif; ?> 
      </td>
      <td><a onclick="return confirm('Seguro que vas a eliminarme?');" href="./?page=listado&accion=e&idProducto=<?php echo $row['idProducto'];?>&imagen=<?php echo $row['Imagen']; ?>">Eliminar</a></td>
      <td><a href="./?page=gestionProductos&accion=a&idProducto=<?php echo $row['idProducto'];?>">Actualizar</a></td>
      
    </tr>
    <td>
    <?php
      if($row['Estado']==1){//producto activo
      ?>
      <a href="./?page=listado&idProducto=<?php echo $row['idProducto'];?>&estado=0">Desactivar</a>
      <?php
      }else{
      ?> 
      <a href="./?page=listado&idProducto=<?php echo $row['idProducto'];?>&estado=1">Activar</a>
      <?php
      }
      ?> 
    </td>
    <?php
      }
    }else{
      header("location:../?page=ingreso&rta=0x021");
    }
    ?>
  </tbody>
</table>