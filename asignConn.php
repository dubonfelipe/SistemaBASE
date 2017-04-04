<html lang="es">

	<head>
		<title></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>


		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<!-- Optional theme -->

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>




	</head>

	<body>


		<nav class="navbar navbar-light" style="background-color: #66ccff;">
			  <div class="container-fluid">
			    <div class="navbar-header">
				 <a class="navbar-brand" href="http://www.centromusicalbase.com/sibase/">
				 <span class="glyphicon glyphicon-home"></span>   Sistema Base</a>
			   </div>
	   	</nav>

		<header>
			<div class="alert alert-info text-center">
			<h2>ASIGNACIONES</h2>
			</div>
		</header>


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

  if(isset($_POST['insert'])){
    $idalumno=$_POST['alumnoId'];
  	$idcurso=$_POST['curso'];
  	$idcatedratico=$_POST['maestro'];

    $consultaD="SELECT * FROM cmb_asignacion WHERE IDALUMNO='".$idalumno."' AND (IDCATEDRATICO='".$idcatedratico."' AND IDCURSO='".$idcurso."');";
    $resultD=$database->query($consultaD) or mysql_error();
    //si la consulta no arroja un registro repetido
    if(mysqli_num_rows($resultD)==0){
      $horario=$_POST['hora'];
    	$dia=$_POST['dia'];
    	$anio=date('Y');
    	$precio=$_POST['precio'];
    	$categoria=$_POST['categoria'];

    	$stmt="INSERT INTO cmb_asignacion(IDCURSO, IDCATEDRATICO, IDALUMNO, HORARIO, DIA, ANIO, PRECIO, CATEGORIA, ACTIVO)
    			VALUES(".$idcurso.", ".$idcatedratico.", ".$idalumno.", '".$horario."', '".$dia."', ".$anio.", ".$precio.", '".$categoria."', 1)";

    	$result=$database->query($stmt);
    	
    	echo '<div class="bg-success text-center text-white"><h3>¡Asignacion creada exitosamente!</h3></div>
    	<h4 class="text-muted text-center">Revise los datos y elija qué desea hacer.</h4>';

      
    }else{
    	echo '<div class="bg-warning  text-white text-center"><h3 class="bg-warning text-white text-center">No fue creada la asignación por existir previamente...</h3></div>
    	<h4 class="text-muted text-center">Revise los datos y elija qué desea hacer.</h4>';
    }
	
	


  }else if(isset($_POST['edit'])){
  	$idalumno=$_POST['idAlumno'];
  	$idcurso=$_POST['curso'];
  	$idcatedratico=$_POST['maestro'];
  	$horario=$_POST['hora'];
  	$dia=$_POST['dia'];
  	$anio=$_POST['anio'];
  	$precio=$_POST['precio'];
  	$categoria=$_POST['categoria'];

  	$stmt="";
  	if($_POST['activo'] == '1'){

	  	$stmt="UPDATE cmb_asignacion SET HORARIO='".$horario."', DIA= '".$dia."', ANIO=".$anio.", PRECIO=".$precio.", CATEGORIA='".$categoria."', ACTIVO=1 WHERE IDCURSO=".$idcurso." AND(IDALUMNO=".$idalumno." AND IDCATEDRATICO=".$idcatedratico.")";
	}else{
		$stmt="UPDATE cmb_asignacion SET HORARIO='".$horario."', DIA= '".$dia."', ANIO=".$anio.", PRECIO=".$precio.", CATEGORIA='".$categoria."', ACTIVO=0 WHERE IDCURSO=".$idcurso." AND(IDALUMNO=".$idalumno." AND IDCATEDRATICO=".$idcatedratico.")";
	}


  	$result=$database->query($stmt);
  	
  	echo '<div class="bg-primary text-center text-white"><h3>¡Asignacion editada exitosamente!</h3></div>
  	<h4 class="text-muted text-center">Revise los datos y elija qué desea hacer.</h4>';

  }
  //recuperando info de asignacion para mostrar resumen de creacion exitosa
      $datos="SELECT alumno.nombre as nombreAlumno, alumno.apellidos as apellidosAlumno, alumno.FECHA_NACIMIENTO, alumno.PADRE, alumno.TELEFONO, alumno.COMPANIA, alumno.TEL2, alumno.COMP2, maestro.idcatedratico, maestro.nombre AS nombreMaestro, curso.idcurso, curso.nombre as nombreCurso, asignacion.DIA, asignacion.HORARIO, asignacion.ANIO, asignacion.PRECIO, asignacion.CATEGORIA, asignacion.ACTIVO FROM cmb_asignacion asignacion INNER JOIN cmb_alumno alumno ON asignacion.IDALUMNO=alumno.idalumno INNER JOIN cmb_curso curso ON asignacion.IDCURSO=curso.idcurso INNER JOIN cmb_catedratico maestro ON asignacion.IDCATEDRATICO=maestro.idcatedratico WHERE asignacion.IDALUMNO=".$idalumno." AND (asignacion.IDCURSO=".$idcurso." AND asignacion.IDCATEDRATICO=".$idcatedratico.");";

      	$queryDatos= $database->query($datos);

      	while($registro  = $queryDatos->fetch_array( MYSQLI_BOTH))
    	{
      	 $nombreAlumno=$registro['nombreAlumno'];
      	 $apellido=$registro['apellidosAlumno'];
      	 $fechaNac=date_format(date_create($registro['FECHA_NACIMIENTO']), 'd-m-Y');
      	 $padre=$registro['PADRE'];
      	 $tel1=$registro['TELEFONO'];
      	 $comp1=$registro['COMPANIA'];
      	 $tel2=$registro['TEL2'];
      	 $comp2=$registro['COMP2'];
      	 $nombreMaestro=$registro['nombreMaestro'];
      	 $nombreCurso=$registro['nombreCurso'];
      	 $dia=$registro['DIA'];
      	 $horario=$registro['HORARIO'];
      	 $anio=$registro['ANIO'];
      	 $precio=$registro['PRECIO'];
      	 $categoria=$registro['CATEGORIA'];
      	 $activo=$registro['ACTIVO'];
      	}



      echo '<form  class="form-horizontal bg-default">
    <div class="form-group">
      <label class="control-label col-sm-2" for="idAlumno">Código:</label>
      <div class="col-sm-2">
        <input class="form-control" id="idAlumno" name="idAlumno" value="'.$idalumno.'" readonly>
      </div>
      <label class="control-label col-sm-2" for="nombre">Nombre:</label>
      <div class="col-sm-5">
        <input class="form-control" id="nombre" name="nombre" value="'.$nombreAlumno.' '.$apellido.'" readonly>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="fechaNac">Fecha de nacimiento:</label>
      <div class="col-sm-2">
        <input class="form-control" id="fechaNac" name="fechaNac" value="'.$fechaNac.'" readonly>
      </div>
      <label class="control-label col-sm-2" for="padre">Padre/Encargado:</label>
      <div class="col-sm-5">
        <input class="form-control" id="padre" name="padre" value="'.$padre.'" readonly>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="tel1">Teléfono 1:</label>
      <div class="col-sm-2">
        <input class="form-control" id="tel1" name="tel1" value="'.$tel1.'" readonly>
      </div>
      <label class="control-label col-sm-2" for="comp1">Compañía:</label>
      <div class="col-sm-2">
        <input class="form-control" id="comp1" name="comp1" value="'.$comp1.'" readonly>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="tel2">Teléfono 2:</label>
      <div class="col-sm-2">
        <input class="form-control" id="tel2" name="tel2" value="'.$tel2.'" readonly>
      </div>
      <label class="control-label col-sm-2" for="comp2">Compañía:</label>
      <div class="col-sm-2">
        <input class="form-control" id="comp2" name="comp2" value="'.$comp2.'" readonly>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="maestro">Maestro:</label>
      <div class="col-sm-3">
        <input type="text"  name="maestroValor" id="maestroValor" class="form-control col-sm-3" value="'.$nombreMaestro.'"  readonly>
      </div>
      <label class="control-label col-sm-2" for="curso">Curso:</label>
      <div class="col-sm-3">
        <input type="text"  name="cursoValor" id="cursoValor" class="form-control col-sm-3" value="'.$nombreCurso.'"  readonly>
      </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="diaValor">Día:</label>
    <div class="col-sm-2">
      <input type="text" name="diaValor" id="diaValor" class="form-control col-sm-2" value="'.$dia.'" readonly>
    </div>
    <label class="control-label col-sm-2" for="hora">Horario:</label>
    <div class="col-sm-2">
      <input type="text" name="hora" id="hora" class="form-control col-sm-2" value="'.$horario.'" readonly>
     </div>
     <label class="control-label col-sm-1" for="anio:">Año:</label>
    <div class="col-sm-1">
      <input class="form-control" id="anio" placeholder="" name="anio" value="'.$anio.'" readonly>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="precio:">Precio:</label>
    <div class="col-sm-2">
      <input class="form-control" id="precio" name="precio" value="'.$precio.'"  readonly>
    </div>
    <label class="control-label col-sm-2" for="categoria">Categoría:</label>
    <div class="col-sm-3">
      <input class="form-control" id="categoria" placeholder="Hasta 25 caracteres" name="categoria" value="'.$categoria.'" readonly>
    </div>
  </div>
  </form>
  
  
  <div class="row">
  <div class="col-xs-2 col-xs-offset-1">
  <form method="post" action="asignaciones.php">
  	<input type="hidden" name="idalumno" value="'.$idalumno.'">  
  	<input type="hidden" name="idcurso" value="'.$idcurso.'">
  	<input type="hidden" name="idcatedratico" value="'.$idcatedratico.'">
  	
  	<button type="submit" name="edit" class="btn btn-warning"> <i class="glyphicon glyphicon-pencil"></i>  Editar Asignación</button>
  	
  </form>
  </div>
  
  <div class="col-xs-2 col-xs-offset-2">
  <form method="post" action="listaAsignaciones.php">
  	<input type="hidden" name="idalumno" value="'.$idalumno.'">   
  	
  	<button type="submit" name="listar" class="btn btn-success"> <i class="glyphicon glyphicon-search"></i>  Ver asignaciones del alumno</button>
  
  </form>
  </div>
  
  <div class="col-xs-2 col-xs-offset-2">
  <a class="btn btn-info" href="gestionAlumnos.php#line-'.$idalumno.'">
				 <span class="glyphicon glyphicon-user"></span>   Gestión de alumnos</a>
  </div>

				 
 
  </div>
  
  
  
  ';
  
  mysqli_close($database);


  ?>

</body>
</html>
