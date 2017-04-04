<?php

 $dbserver = "localhost";
  $dbuser = "admaptec_sibaseb";
  $password = "SIbase2017";
  $dbname = "admaptec_jmln2";

  $database = new mysqli($dbserver, $dbuser, $password, $dbname);

  if($database->connect_errno) {
    die("No se pudo conectar a la base de datos");
  }

  if(isset($_POST['edit'])){
  	$id=$_POST['id'];
  	$apellido=$_POST['apellido'];
  	$nombre=$_POST['nombre'];
  	$fecha=$_POST['fechNac'];
  	$padre=$_POST['padre'];
  	$tel=$_POST['telefono'];
  	$comp=$_POST['comp'];
  	$tel2=$_POST['telefono2'];
  	$comp2=$_POST['comp2'];


  	$stmt="";
  	if($_POST['activo'] == '1'){
  		if($tel2 > 0){
  			$stmt="UPDATE cmb_alumno SET apellidos='".$apellido."', nombre='".$nombre."', FECHA_NACIMIENTO='".$fecha."', PADRE='".$padre."', TELEFONO=".$tel.", COMPANIA='".$comp."', TEL2=".$tel2.", COMP2='".$comp2."', ACTIVO=1 WHERE idalumno=".$id."";
  		}else{
  			$stmt="UPDATE cmb_alumno SET apellidos='".$apellido."', nombre='".$nombre."', FECHA_NACIMIENTO='".$fecha."', PADRE='".$padre."', TELEFONO=".$tel.", COMPANIA='".$comp."', TEL2=NULL, COMP2='', ACTIVO=1 WHERE idalumno=".$id."";
  		}

  	}else{
  		if($tel2 > 0){
  			$stmt="UPDATE cmb_alumno SET apellidos='".$apellido."', nombre='".$nombre."', FECHA_NACIMIENTO='".$fecha."', PADRE='".$padre."', TELEFONO=".$tel.", COMPANIA='".$comp."', TEL2=".$tel2.", COMP2='".$comp2."', ACTIVO=0 WHERE idalumno=".$id."";
        $stmt2="UPDATE cmb_asignacion SET ACTIVO=0 WHERE IDALUMNO=".$id;
        $result2=$database->query($stmt2);
  		}else{
  			$stmt="UPDATE cmb_alumno SET apellidos='".$apellido."', nombre='".$nombre."', FECHA_NACIMIENTO='".$fecha."', PADRE='".$padre."', TELEFONO=".$tel.", COMPANIA='".$comp."', TEL2=NULL, COMP2='', ACTIVO=0 WHERE idalumno=".$id."";
        $stmt2="UPDATE cmb_asignacion SET ACTIVO=0 WHERE IDALUMNO=".$id;
        $result2=$database->query($stmt2);
  		}
  	}

  	$result=$database->query($stmt);
  	mysqli_close($database);
  	header('Location:	gestionAlumnos.php#line-'.$id);
  }else if($_POST['editObservaciones']){
  	$id=$_POST['id'];
  	$observaciones=$_POST['observaciones'];
  	$stmt="UPDATE cmb_alumno SET OBSERVACIONES='".$observaciones."' WHERE idalumno=".$id."";
  	$result=$database->query($stmt);
  	mysqli_close($database);
  	header('Location:	gestionAlumnos.php#line-'.$id);
  }
  mysqli_close($database);
?>
