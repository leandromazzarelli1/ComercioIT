<?php 
require_once "functions.php";
if(isset($_GET['page'])){
	$page=$_GET['page'];
}else{
	$page='inicio';
}

include "header.php"; ?>

			<section id="page">
			<?php CargarPagina($page); ?>	
			</section>
<?php include "footer.php"?>		


