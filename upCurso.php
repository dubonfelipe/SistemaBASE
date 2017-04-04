<?php
////////////////// CONEXION A LA BASE DE DATOS //////////////////
  $dbserver = "localhost";
  $dbuser = "admaptec_sibaseb";
  $password = "SIbase2017";
  $dbname = "admaptec_jmln2";
 
  $database = new mysqli($dbserver, $dbuser, $password, $dbname);

  if($database->connect_errno) {
    die("No se pudo conectar a la base de datos");
  }
  
  if(isset($_POST['edit'])){
  	$idcurso=$_POST['idcurso'];
  	$nombre=$_POST['nombre'];
  	$descripcion=$_POST['descripcion'];
  	
  	$stmt="";  	
  	if($_POST['activo'] == '1'){

	  	$stmt="UPDATE cmb_curso SET nombre='".$nombre."', descripcion= '".$descripcion."', activo=1 WHERE idcurso=".$idcurso;
	}else{
		$stmt="UPDATE cmb_curso SET nombre='".$nombre."', descripcion= '".$descripcion."', activo=0 WHERE idcurso=".$idcurso;
	}
	  	$result=$database->query($stmt);
	  	
  }
  mysqli_close($database);
  
  header('Location:	administracion.php#linea-'.$idcurso);
  
  ?>
