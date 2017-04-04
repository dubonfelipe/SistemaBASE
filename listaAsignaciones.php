<?php
////////////////// CONEXION A LA BASE DE DATOS //////////////////
 $dbserver = "localhost";
  $dbuser = "admaptec_sibaseb";
  $password = "SIbase2017";
  $dbname = "admaptec_jmln2";
?>




<html lang="es">

	<head>
		<title>Lista de asignaciones</title>
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
    <h2>LISTA DE ASIGNACIONES</h2>
    </div>
  </header>

	<?php
  	 if(isset($_POST['listar'])){

  	 $idalumno=$_POST['idalumno'];

  	 $database = new mysqli($dbserver, $dbuser, $password, $dbname);

	 if($database->connect_errno) {
	   die("No se pudo conectar a la base de datos");
	 }

	$alumno="SELECT * FROM cmb_alumno where idalumno=".$idalumno;
  	$queryAlumnos= $database->query($alumno);

  	while($registroAlumno  = $queryAlumnos->fetch_array( MYSQLI_BOTH))
	{
  	 $nombre=$registroAlumno['nombre'];
  	 $apellido=$registroAlumno['apellidos'];
  	 $fechaNac=date_format(date_create($registroAlumno['FECHA_NACIMIENTO']), 'd-m-Y');
  	 $padre=$registroAlumno['PADRE'];
  	 $tel1=$registroAlumno['TELEFONO'];
  	 $comp1=$registroAlumno['COMPANIA'];
  	 $tel2=$registroAlumno['TEL2'];
  	 $comp2=$registroAlumno['COMP2'];

  	}

  	echo '<form action="asignaciones.php" class="form-horizontal" method="POST">
  <h3 class="bg-primary text-center pad-basic no-btm">Datos del estudiante</h3>
  <div class="form-group">
    <label class="control-label col-sm-2" for="idalumno">Código:</label>
    <div class="col-sm-2">
      <input class="form-control" id="idalumno" name="idalumno" value="'.$idalumno.'" readonly>
    </div>
    <label class="control-label col-sm-2" for="nombre">Nombre:</label>
    <div class="col-sm-5">
      <input class="form-control" id="nombre" name="nombre" value="'.$nombre.' '.$apellido.'" readonly>
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
  <div class="col-sm-offset-8 col-sm-10">
    <input type="submit" name="insertar" class="btn btn-success" value="Asignar nuevo curso">
  </div>
</div>
  </form>

  <h3 class="bg-primary text-center pad-basic no-btm">Asignaciones</h3></br>';

  $asignaciones="SELECT cat.nombre as MAESTRO, cu.nombre as CURSO, a.DIA, a.HORARIO, a.ANIO, a.PRECIO, a.CATEGORIA, a.ACTIVO, a.IDCURSO, a.IDCATEDRATICO FROM cmb_asignacion a JOIN cmb_curso cu ON a.IDCURSO=cu.idcurso JOIN cmb_catedratico cat ON a.IDCATEDRATICO= cat.idcatedratico WHERE a.IDALUMNO=".$idalumno;

  $queryAsignaciones= $database->query($asignaciones);
  $numOfAsign = mysqli_num_rows($queryAsignaciones);
  if($numOfAsign == 1){
    echo '<h4 class="text-muted text-center">Total: '.$numOfAsign.' asignación</h4> </br>';
  }else{
    echo '<h4 class="text-muted text-center">Total: '.$numOfAsign.' asignaciones</h4> </br>';
  }

  	while($registroAsignacion  = $queryAsignaciones->fetch_array( MYSQLI_BOTH))
	{
		$botonActivo='';
		if($registroAsignacion['ACTIVO'] == 1){
			$botonActivo='<div class="col-sm-2">
  				<button type="button" class="btn  btn-success" disabled> Activa </button>
  				</div>';
		}else{
			$botonActivo='<div class="col-sm-2">
  				<button type="button" class="btn  btn-danger" disabled> Inactiva </button>
  				</div>';
		}

		echo '<form method="POST" action="asignaciones.php" class="form-horizontal bg-info">
  </br>
   <div class="form-group">
    <label class="control-label col-sm-2" for="maestro">Maestro:</label>
    <div class="col-sm-3">
      <input type="text" name="maestro" id="maestro" class="form-control col-sm-3" value="'.$registroAsignacion['MAESTRO'].'" readonly>
    </div>
    <label class="control-label col-sm-2" for="curso">Curso:</label>
    <div class="col-sm-3">
      <input type="text"  name="curso" id="curso" class="form-control col-sm-3" value="'.$registroAsignacion['CURSO'].'" readonly>
    </div>
    <div>
    	<input type="hidden" name="idalumno" value="'.$idalumno.'">
    	<input type="hidden" name="idcurso" value="'.$registroAsignacion['IDCURSO'].'">
    	<input type="hidden" name="idcatedratico" value="'.$registroAsignacion['IDCATEDRATICO'].'">
    </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="dia">Día:</label>
  <div class="col-sm-2">
    <input type="text"  name="dia" id="dia" class="form-control col-sm-10" value="'.$registroAsignacion['DIA'].'" readonly>
  </div>
  <label class="control-label col-sm-2" for="hora">Horario:</label>
  <div class="col-sm-2">
    <input type="text"  name="hora" id="hora" class="form-control col-sm-1" value="'.$registroAsignacion['HORARIO'].' "  readonly>
    </div>
  <label class="control-label col-sm-1" for="anio">Año:</label>
  <div class="col-sm-1">
    <input type="text"  name="anio" id="anio" class="form-control col-sm-1" value="'.$registroAsignacion['ANIO'].'"  readonly>
    </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="precio:">Precio:</label>
  <div class="col-sm-2">
    <input class="form-control" id="precio" name="precio" value="'.$registroAsignacion['PRECIO'].'" readonly>
  </div>
  <label class="control-label col-sm-2" for="categoria">Categoría:</label>
  <div class="col-sm-2">
    <input class="form-control" id="categoria" name="categoria" value="'.$registroAsignacion['CATEGORIA'].'" readonly>
  </div>
	'.$botonActivo.'

  <div class="col-sm-2">
    <input type="submit" class="btn btn-warning" name="edit" value="Editar asignación">
  </div>
</div>

  </br>
  </form></br>';
	}

  	}
  	?>
</body>
</html>
