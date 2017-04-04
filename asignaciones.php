<?php
////////////////// VARIABLES DE CONEXION A LA BASE DE DATOS //////////////////
  $dbserver = "localhost";
  $dbuser = "admaptec_sibaseb";
  $password = "SIbase2017";
  $dbname = "admaptec_jmln2";
  
  $horas = array("08:00", "09:00", "10:00", "11:00", "12:00", "14:00", "15:00", "16:00", "17:00", "18:00");
  $dias = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
  
  $elementosHoras="";
  for($i=0; $i<(count($horas)-1); $i++){
  	if(strcmp($horas[$i], "12:00") !== 0){//todos los valores serviran como hora de inicio excepto las 12:00
  		$elementosHoras=$elementosHoras.'<option value="'.$horas[$i].'-'.$horas[$i+1].'">'.$horas[$i].'-'.$horas[$i+1].'</option>';
  	}
  }
  $elementosDias="";
  for($j=0; $j<count($dias); $j++){
  	$elementosDias=$elementosDias.'<option value="'.$dias[$j].'">'.$dias[$j].'</option>';
  }
  
?>

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
    <h2>ASIGNACIÓN</h2>
    </div>
  </header>
  
  <?php
  	 if(isset($_POST['insertar'])){
  	 
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
  	
  	
  	//representacion de los maestros.
  	$cated="SELECT idcatedratico, nombre FROM cmb_catedratico";
  	$queryMaestros= $database->query($cated);
	$maestros="";
  	while($registroMaestro  = $queryMaestros->fetch_array( MYSQLI_BOTH)) 
	{
			$maestros=$maestros.'<option value="'.$registroMaestro['idcatedratico'].'">'.$registroMaestro['nombre'].'</option>';
	}
	
	//representacion de los cursos
  	$curse="SELECT idcurso, nombre FROM cmb_curso where activo=1";
  	$queryCursos= $database->query($curse);
	$cursos="";
  	while($registroCurso  = $queryCursos->fetch_array( MYSQLI_BOTH)) 
	{
			$cursos=$cursos.'<option value="'.$registroCurso['idcurso'].'">'.$registroCurso['nombre'].'</option>';
	}
  	
  	
  	echo '<form method="post" class="form-horizontal bg-info" action="asignConn.php">
  <h3 class="bg-primary text-center pad-basic no-btm">Crear asignación</h3>
  <div class="form-group">
    <label class="control-label col-sm-2" for="alumnoId">Código:</label>
    <div class="col-sm-2">
      <input class="form-control" id="alumnoId" name="alumnoId" value="'.$idalumno.'" readonly/>
    </div>
    <label class="control-label col-sm-2" for="nombre">Nombre:</label>
    <div class="col-sm-5">
      <input class="form-control" id="nombre" name="nombre" value="'.$nombre.' '.$apellido.'" disabled="true">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="fechaNac">Fecha de nacimiento:</label>
    <div class="col-sm-2">
      <input class="form-control" id="fechaNac" name="fechaNac" value="'.$fechaNac.'" disabled="true">
    </div>
    <label class="control-label col-sm-2" for="padre">Padre/Encargado:</label>
    <div class="col-sm-5">
      <input class="form-control" id="padre" name="padre" value="'.$padre.'" disabled="true">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="tel1">Teléfono 1:</label>
    <div class="col-sm-2">
      <input class="form-control" id="tel1" name="tel1" value="'.$tel1.'" disabled="true">
    </div>
    <label class="control-label col-sm-2" for="comp1">Compañía:</label>
    <div class="col-sm-2">
      <input class="form-control" id="comp1" name="comp1" value="'.$comp1.'" disabled="true">
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="tel2">Teléfono 2:</label>
    <div class="col-sm-2">
      <input class="form-control" id="tel2" name="tel2" value="'.$tel2.'" disabled="true">
    </div>
    <label class="control-label col-sm-2" for="comp2">Compañía:</label>
    <div class="col-sm-2">
      <input class="form-control" id="comp2" name="comp2" value="'.$comp2.'" disabled="true">
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="maestro">Maestro* :</label>
    <div class="col-sm-3">
      <select required name="maestro" id="maestro" class="form-control col-sm-3" required>
       	'.$maestros.'
      </select>
    </div>
    <label class="control-label col-sm-2" for="curso">Curso* :</label>
    <div class="col-sm-3">
      <select required name="curso" id="curso" class="form-control col-sm-3" required>
      '.$cursos.'
      </select>
    </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="dia">Día* :</label>
  <div class="col-sm-2">
    <select required name="dia" id="dia" class="form-control col-sm-2" required>
    '.$elementosDias.'
    </select>
  </div>
  <label class="control-label col-sm-2" for="hora">Horario* :</label>
  <div class="col-sm-2">
    <select required name="hora" id="hora" class="form-control col-sm-2" required>
    '.$elementosHoras.'
    </select>
  </div> 
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="precio:">Precio* :</label>
  <div class="col-sm-2">
    <input class="form-control" id="precio" placeholder="Sólo números" name="precio" value="" maxlength="6" required>
  </div>
  <label class="control-label col-sm-2" for="categoria">Categoría* :</label>
  <div class="col-sm-3">
    <input class="form-control" id="categoria" placeholder="Hasta 25 caracteres" name="categoria" value="" maxlength="25" required>
  </div>
</div>


<div class="form-group">
  <div class="col-sm-offset-8 col-sm-10">
    <input type="submit" name="insert" value="Aceptar" class="btn btn-primary"/>
  </div>
</div>
  </form>';
  
  mysqli_close($database);
  	
  } else if(isset($_POST['edit'])){
  	 
  	 $idalumno=$_POST['idalumno'];
  	 $idcurso=$_POST['idcurso'];
  	 $idcatedratico=$_POST['idcatedratico'];
  	 
  	 
  	 $database = new mysqli($dbserver, $dbuser, $password, $dbname);

	 if($database->connect_errno) {
	   die("No se pudo conectar a la base de datos");
	 }
	 
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
  	
  	//representacion de los dias
  	$elementosDias='<option value="'.$dia.'">'.$dia.'</option>'.$elementosDias;
  	
  	//representacion de horarios
  	$elementosHoras='<option value="'.$horario.'">'.$horario.'</option>'.$elementosHoras;
  	
  	
  	
  	
				  	//representacion campo activo/inactivo
				  	$checkActivo="";
					if($activo==1){
					 	$checkActivo='<div class="form-group">
									  <label class="form-check-label control-label col-sm-9">
									    <div class="col-sm-9">
									  	<input type="radio" class="form-check-input" name="activo" checked value="1">
									    Activa
									  </div>
									</label>
									</div>

									<div class="form-group">
									  <label class="form-check-label control-label col-sm-9">
									    <div class="col-sm-9">
									    <input type="radio" class="form-check-input" name="activo"  value="0">
									    Inactiva
									  </div>
									  </label>
									</div>';
					}else{
						$checkActivo='<div class="form-group">
									  <label class="form-check-label control-label col-sm-9">
									    <div class="col-sm-9">
									  	<input type="radio" class="form-check-input" name="activo"  value="1">
									    Activa
									  </div>
									</label>
									</div>

									<div class="form-group">
									  <label class="form-check-label control-label col-sm-9">
									    <div class="col-sm-9">
									    <input type="radio" class="form-check-input" name="activo" checked value="0">
									    Inactiva
									  </div>
									  </label>
									</div>';
					}
  	
  	
  	echo '<form method="post" class="form-horizontal bg-info" action="asignConn.php">
  <h3 class="bg-primary text-center pad-basic no-btm">Editar asignación</h3>
  <div class="form-group">
    <label class="control-label col-sm-2" for="idAlumno">Código:</label>
    <div class="col-sm-2">
      <input class="form-control" id="idAlumno" name="idAlumno" value="'.$idalumno.'" readonly>
    </div>
    <label class="control-label col-sm-2" for="nombre">Nombre:</label>
    <div class="col-sm-5">
      <input class="form-control" id="nombre" name="nombre" value="'.$nombreAlumno.' '.$apellido.'" disabled="true">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="fechaNac">Fecha de nacimiento:</label>
    <div class="col-sm-2">
      <input class="form-control" id="fechaNac" name="fechaNac" value="'.$fechaNac.'" disabled="true">
    </div>
    <label class="control-label col-sm-2" for="padre">Padre/Encargado:</label>
    <div class="col-sm-5">
      <input class="form-control" id="padre" name="padre" value="'.$padre.'" disabled="true">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="tel1">Teléfono 1:</label>
    <div class="col-sm-2">
      <input class="form-control" id="tel1" name="tel1" value="'.$tel1.'" disabled="true">
    </div>
    <label class="control-label col-sm-2" for="comp1">Compañía:</label>
    <div class="col-sm-2">
      <input class="form-control" id="comp1" name="comp1" value="'.$comp1.'" disabled="true">
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="tel2">Teléfono 2:</label>
    <div class="col-sm-2">
      <input class="form-control" id="tel2" name="tel2" value="'.$tel2.'" disabled="true">
    </div>
    <label class="control-label col-sm-2" for="comp2">Compañía:</label>
    <div class="col-sm-2">
      <input class="form-control" id="comp2" name="comp2" value="'.$comp2.'" disabled="true">
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="maestro">Maestro* :</label>
    <div class="col-sm-3">
      <input type="hidden"  name="maestro" id="maestro" value="'.$idcatedratico.'">
      <input type="text"  name="maestroValor" id="maestroValor" class="form-control col-sm-3" value="'.$nombreMaestro.'" required readonly>
    </div>
    <label class="control-label col-sm-2" for="curso">Curso* :</label>
    <div class="col-sm-3">
    	<input type="hidden"  name="curso" id="curso" value="'.$idcurso.'">
      <input type="text"  name="cursoValor" id="cursoValor" class="form-control col-sm-3" value="'.$nombreCurso.'" required readonly>
    </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="dia">Día* :</label>
  <div class="col-sm-2">
    <select required name="dia" id="dia" class="form-control col-sm-2" required>
    '.$elementosDias.'
    </select>
  </div>
  <label class="control-label col-sm-2" for="hora">Horario* :</label>
  <div class="col-sm-2">
    <select required name="hora" id="hora" class="form-control col-sm-2" required>
    '.$elementosHoras.'
    </select>
  </div>
   <label class="control-label col-sm-1" for="anio:">Año* :</label>
  <div class="col-sm-1">
    <input class="form-control" id="anio" placeholder="" name="anio" value="'.$anio.'" required>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="precio:">Precio* :</label>
  <div class="col-sm-2">
    <input class="form-control" id="precio" placeholder="Sólo números" name="precio" value="'.$precio.'" maxlength="6" required>
  </div>
  <label class="control-label col-sm-2" for="categoria">Categoría* :</label>
  <div class="col-sm-3">
    <input class="form-control" id="categoria" placeholder="Hasta 25 caracteres" name="categoria" value="'.$categoria.'" maxlength="25" required>
  </div>
</div>

	'.$checkActivo.'

<div class="form-group">
  <div class="col-sm-offset-8 col-sm-10">
    <input type="submit" name="edit" value="Aceptar" class="btn btn-primary"/>
  </div>
</div>
  </form>';
  
  mysqli_close($database);
  	
  }
  
  ?>
   
</body>
</html>

