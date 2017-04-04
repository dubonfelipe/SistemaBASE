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
  
  
  
  $alumnos="SELECT * FROM cmb_alumno order by idalumno";
  $queryAlumnos= $database->query($alumnos);
  mysqli_close($database);
    
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

		<script>
				
				
				function recargar(){
					location.reload();
				}
				
			</script>
			
		<nav class="navbar navbar-light" style="background-color: #66ccff;">
			  <div class="container-fluid">
			    <div class="navbar-header">
				 <a class="navbar-brand" href="http://www.centromusicalbase.com/sibase/">
				 <span class="glyphicon glyphicon-home"></span>   Sistema Base</a>
			   </div>
	   	</nav>

		<header>
			<div class="alert alert-info text-center">
			<h2>GESTIÓN DE ALUMNOS</h2>
			</div>
		</header>
		
		<form method="post" class="form-horizontal">
				<h3 class="bg-primary text-center pad-basic no-btm">Inscribir alumno</h3>
				
				<div style="overflow-x:auto;" class="container center-div">
				<table class="table bg-info"  id="tabla">
					<tr>
						<td><label>Apellidos*:</label></br>
						<input required name="apellido" placeholder="Apellidos" maxlength="45"/></td>
						<td><label>Nombres*:</label></br>
						<input required name="nombre" placeholder="Nombres" maxlength="45"/></td>
						<td><label>Fecha de Nacimiento*:</label></br>
						<input required type="date" name="fechNac"
						step="1" min="1900-01-01" max="<?php echo date('Y-m-d');?>" 
						>
						</td>
					</tr>
					<tr>
						<td><label>Padre/Encargado*:</label></br>
						<input required name="padre" placeholder="Padre/Encargado" maxlength="50"/></td>
						<td><label>Teléfono 1*:</label></br>
						<input required name="telefono1" placeholder="Teléfono 1" maxlength="8"/></td>
						<td>
						<label>Compañía*:</label></br>
						<select required name="comp1" class="btn-default">
							<option value="CLARO">CLARO</option>
							<option value="TIGO">TIGO</option>
							<option value="MOVISTAR">MOVISTAR</option>
						</select>
						</td>
					</tr>
					<tr>
						<td></td>
						<td><label>Teléfono 2:</label></br>
						<input name="telefono2"  placeholder="Teléfono 2" maxlength="8"/></td>
						<td>
						<label>Compañía:</label></br>
						<select  name="comp2" class="btn-default">
							<option value=""></option>
							<option value="CLARO">CLARO</option>
							<option value="TIGO">TIGO</option>
							<option value="MOVISTAR">MOVISTAR</option>
						</select>
						</td>						
					</tr>
					<tr>
						<td></td>
						<td>
							<label>Observaciones:</label></br>
							<textarea cols="30" rows="3" name="observaciones" placeholder="Observaciones" maxlength="250"></textarea>
						</td>
						<td>
						<input type="submit" name="insertar" value="Insertar Alumno" class="btn btn-info"/>
						</td>
					</tr>
								
					
				</table>
				</div>

			</form>
			

			<?php
			
				$database = new mysqli($dbserver, $dbuser, $password, $dbname);

				if($database->connect_errno) {
				    die("No se pudo conectar a la base de datos");
				}else{

				//////////////////////// PRESIONAR EL BOTÓN //////////////////////////
				if(isset($_POST['insertar']))

				{
				

				$apellidos=($_POST['apellido']);
				$nombres=($_POST['nombre']);
				$fecha=($_POST['fechNac']);
				$padre=($_POST['padre']);
				$telefono1=($_POST['telefono1']);
				$compania1=($_POST['comp1']);
				$telefono2=($_POST['telefono2']);
				$compania2=($_POST['comp2']);
				$observaciones=($_POST['observaciones']);

				
				//verificar la duplicidad para apellido, nombre y fechanac
				
				$consultaD="SELECT idalumno, nombre FROM cmb_alumno WHERE apellidos='".$apellidos."' AND (nombre='".$nombres."' AND FECHA_NACIMIENTO='".$fecha."');";
				$resultD=$database->query($consultaD) or mysql_error();
				//si la consulta no arroja un registro repetido
				if(mysqli_num_rows($resultD)==0){
				 
				//////// QUERY DE INSERCIÓN ////////////////////////////
				$valores="";
				if($telefono2 > 0){
					$valores="('".$apellidos."', '".$nombres."', '".$fecha."', '".$padre."', ".$telefono1.", '".$compania1."', ".$telefono2.", '".$compania2."', '".$observaciones."', 1);";
					$sql = "INSERT INTO cmb_alumno(apellidos, nombre, FECHA_NACIMIENTO, PADRE, TELEFONO, COMPANIA, TEL2, COMP2, OBSERVACIONES, ACTIVO)
					VALUES".$valores;
				}else{
					$valores="('".$apellidos."', '".$nombres."', '".$fecha."', '".$padre."', ".$telefono1.", '".$compania1."',  '".$observaciones."', 1);";
					$sql = "INSERT INTO cmb_alumno(apellidos, nombre, FECHA_NACIMIENTO, PADRE, TELEFONO, COMPANIA,  OBSERVACIONES, ACTIVO)
					VALUES".$valores;
				}
						

					
				$sqlRes=$database->query($sql) or mysql_error();
				echo '<script>recargar();</script>';
				}				
				    
		
				}
					mysqli_close($database);	
				}			
				
				
			?>
			

			
			<div style="overflow-x:auto;">
			<table class="table table-active table-responsive table-bordered table-condensed">

					<thead>
					<tr class="info">
						<th>#</th>
						<th>Apellidos</th>
						<th>Nombres</th>
						<th>Fecha Nacimiento</th>
						<th width="50">Padre/Encargado</th>
						<th>Tel 1</th>
						<th>Compañía</th>
						<th>Tel 2</th>
						<th>Compañía</th>
						<th>Estado</th>
						<th width="250" class="text-centered">Opciones</th>

				    	</tr>
				    	</thead>
					<tbody>	
					

				    	<?php
				    	//for presenting data from DB
				    	$database = new mysqli($dbserver, $dbuser, $password, $dbname);

						  if($database->connect_errno) {
						    die("No se pudo conectar a la base de datos");
						  }
				   				  
				  	//iterando sobre las tuplas de la consulta
				    	while($registroAlumno  = $queryAlumnos->fetch_array( MYSQLI_BOTH)) 
				  {
					
					//creacion de elemento grafico para representar alumno activo o inactivo
					$botonActivo="";
					if($registroAlumno['ACTIVO'] == 1){
						$botonActivo='<button type="button" class="btn  btn-success" disabled> Activo </button>';
					}else{
						$botonActivo='<button type="button" class="btn  btn-danger" disabled>Inactivo</button>';
					}
					
					//creacion del boton que muestra numero de asignaciones
					$numAsign = 0;
					$scriptAsign = 'SELECT COUNT(*) AS conteo FROM cmb_asignacion WHERE ACTIVO=1 AND IDALUMNO = '.$registroAlumno['idalumno'];
					$queryAsign= $database->query($scriptAsign);
					while($asigncount = $queryAsign->fetch_array( MYSQLI_BOTH )){
						$numAsign = $asigncount['conteo'];
					}					
					
					if($numAsign != 1){						
						$btnAsigNum='<button type="button" class="btn  btn-default" disabled>'.$numAsign.' Asignaciones</button>';
					}else{
						$btnAsigNum='<button type="button" class="btn  btn-default" disabled>'.$numAsign.' Asignación</button>';
					}
					
					//creacion de la lista para editar compania de telefono1
					$compania1="";
					if($registroAlumno['COMPANIA'] == "CLARO"){
						$compania1='<option value="CLARO">CLARO</option>
							<option value="TIGO">TIGO</option>
							<option value="MOVISTAR">MOVISTAR</option>';
					}else if($registroAlumno['COMPANIA'] == "TIGO"){
						$compania1='<option value="TIGO">TIGO</option>
						<option value="CLARO">CLARO</option>
						<option value="MOVISTAR">MOVISTAR</option>';
					}else{
						$compania1='<option value="MOVISTAR">MOVISTAR</option>
						<option value="CLARO">CLARO</option>
						<option value="TIGO">TIGO</option>';
					}
					
					//creacion de la lista para editar compania de telefono2
					$compania2="";
					if($registroAlumno['COMP2'] == "CLARO"){
						$compania2='<option value="CLARO">CLARO</option>
							<option value="TIGO">TIGO</option>
							<option value="MOVISTAR">MOVISTAR</option>';
					}else if($registroAlumno['COMP2'] == "TIGO"){
						$compania2='<option value="TIGO">TIGO</option>
						<option value="CLARO">CLARO</option>
						<option value="MOVISTAR">MOVISTAR</option>';
					}else if($registroAlumno['COMP2'] == "MOVISTAR"){
						$compania2='<option value="MOVISTAR">MOVISTAR</option>
						<option value="CLARO">CLARO</option>
						<option value="TIGO">TIGO</option>';
					}else{//puede no existir telefono 2 para un alumno
						$compania2='<option value=""></option>
							<option value="CLARO">CLARO</option>
							<option value="TIGO">TIGO</option>
							<option value="MOVISTAR">MOVISTAR</option>';
					}
					
					
					//creacion de elemento grafico del formulario para alumno activo o inactivo en la edicion
					$checkActivo="";
					if($registroAlumno['ACTIVO'] == 1){
					 	$checkActivo='<label class="form-check-label">
											 <input type="radio" class="form-check-input" name="activo" checked value="1">
											 Activo
										    </label></br>
									<label class="form-check-label">
											 <input type="radio" class="form-check-input" name="activo" value="0">
											 Inactivo
										    </label>';
					}else{
						$checkActivo='<label class="form-check-label">
											 <input type="radio" class="form-check-input" name="activo" value="1">
											 Activo
										    </label></br>
									<label class="form-check-label">
											 <input type="radio" class="form-check-input" name="activo" value="0" checked>
											 Inactivo
										    </label>';
					}
					
					
					//creacion de boton que servira como enlace a la pagina de asignacion
					$btnAsignar="";
					if($registroAlumno['ACTIVO'] == 1){
						$btnAsignar='<form action="asignaciones.php" method="POST">
							<input type="hidden" name="idalumno" value="'.$registroAlumno['idalumno'].'"/></br>
							<input type="submit" name="insertar" value="Asignar" class="btn btn-primary btn-block"/>
						</form>';
					}else{
						$btnAsignar='';
					}
					

				  echo '<tr id="line-'.$registroAlumno['idalumno'].'">
				    	<td>'.$registroAlumno['idalumno'].'</td>
				    	<td>'.$registroAlumno['apellidos'].'</td>
				    	<td>'.$registroAlumno['nombre'].'</td>
				    	<td>'.date_format(date_create($registroAlumno['FECHA_NACIMIENTO']), 'd-m-Y').'</td>
				    	<td>'.$registroAlumno['PADRE'].'</td>
				    	<td>'.$registroAlumno['TELEFONO'].'</td>
				    	<td>'.$registroAlumno['COMPANIA'].'</td>
				    	<td>'.$registroAlumno['TEL2'].'</td>
				    	<td>'.$registroAlumno['COMP2'].'</td>
				    	<td>'.$botonActivo.'</br></br>'.$btnAsigNum.'</td>
				    	<td>
				    	
				       	
				    	
				    	<button class="btn btn-warning" data-toggle="modal" data-target="#edit-'.$registroAlumno['idalumno'].'">Editar</button>
				    	
				    	<div class="modal fade" id="edit-'.$registroAlumno['idalumno'].'" tabindex="-1" role="dialog"
				    	aria-labelledby="editLabel-'.$registroAlumno['idalumno'].'">
				    		<div class="modal-dialog" role="document">
				    			<div class="modal-content">
				    				<div class="modal-header">
				    					<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
				    					<h4 class="modal-tittle" id="editLabel-'.$registroAlumno['idalumno'].'">Editar</h4>
				    				</div>
				    				<form class="form-vertical" method="POST" action="upAlumno.php">
				    					<div class="modal-body form-group">
				    						<input type="hidden" name="id" value="'.$registroAlumno['idalumno'].'"/>
				    						<label class"control-label col-sm-2">Nombres: </label><input class="form-control" required name="apellido" id="apellido-'.$registroAlumno['idalumno'].'" value="'.$registroAlumno['apellidos'].'" maxlength="45" /></br>
				    						<label class"control-label col-sm-2">Apellidos: </label><input class="form-control" required name="nombre" id="nombre-'.$registroAlumno['idalumno'].'" value="'.$registroAlumno['nombre'].'" maxlength="45" /></br>
				    						<label class"control-label col-sm-2">Fecha de Nacimiento:</label>
										<input class="form-control" required type="date" name="fechNac" id="fechNac-'.$registroAlumno['idalumno'].'" step="1" min="1900-01-01" max="<?php echo date('.'Y-m-d'.');?>" value="'.date_format(date_create($registroAlumno['FECHA_NACIMIENTO']), 'Y-m-d').'" ></br>
										<label class"control-label col-sm-2">Padre/Encargado: </label><input class="form-control" required name="padre" id="padre-'.$registroAlumno['idalumno'].'" value="'.$registroAlumno['PADRE'].'" maxlength="50" /></br>
										<label class"control-label col-sm-2">Teléfono 1: </label><input class="form-control" required name="telefono" id="telefono-'.$registroAlumno['idalumno'].'"  value="'.$registroAlumno['TELEFONO'].'" maxlength="8" /></br>
										<label class"control-label col-sm-2">Compañía: </label><select class="form-control" required name="comp" id="comp-'.$registroAlumno['idalumno'].'" class="btn-default" value="'.$registroAlumno['COMPANIA'].'">
							'.$compania1.'
										</select></br>	
										
										<label class"control-label col-sm-2">Teléfono 2: </label><input class="form-control"  name="telefono2" id="tel2-'.$registroAlumno['idalumno'].'"  value="'.$registroAlumno['TEL2'].'" maxlength="8" /></br>
										<label class"control-label col-sm-2">Compañía: </label><select class="form-control"  name="comp2" id="comp2-'.$registroAlumno['idalumno'].'" class="btn-default" value="'.$registroAlumno['COMP2'].'">
							'.$compania2.'
										</select></br>
										
										 <div class="form-check">
										    '.$checkActivo.'
										  </div>
																								
				    					</div>
				    					<div class="modal-footer">
				    						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				    						<input type="submit" name="edit" value="Actualizar" class="btn btn-primary"/>
				    					</div>
				    				</form>
				    			</div>
				    		</div>
				    	</div>		
				    	
				    	 	<button class="btn btn-info" data-toggle="modal" data-target="#observaciones-'.$registroAlumno['idalumno'].'">Observaciones</button>
				    	
				    	<div class="modal fade" id="observaciones-'.$registroAlumno['idalumno'].'" tabindex="-1" role="dialog"
				    	aria-labelledby="observacionesLabel-'.$registroAlumno['idalumno'].'">
				    		<div class="modal-dialog" role="document">
				    			<div class="modal-content">
				    				<div class="modal-header">
				    					<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
				    					<h4 class="modal-tittle" id="observacionesLabel-'.$registroAlumno['idalumno'].'">Observaciones del alumno: '.$registroAlumno['nombre'].'  '.$registroAlumno['apellidos'].'</h4>
				    				</div>
				    				<form class="form-vertical" method="POST" action="upAlumno.php">
				    					<div class="modal-body form-group">
				    						<input type="hidden" name="id" value="'.$registroAlumno['idalumno'].'"/>
				    						<label class"control-label col-sm-2">Observaciones: </label>
				    						<textarea cols="60" rows="6" name="observaciones" maxlength="250">'.$registroAlumno['OBSERVACIONES'].'</textarea>				    						
				    						<div class="modal-footer">
				    						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				    						<input type="submit" name="editObservaciones" value="Actualizar" class="btn btn-primary"/>
				    						</div>
				    					</div>
				    				</form>
				    			</div>
				    		</div>
				    	</div>	
				    	
				    			    				    		
				     '.$btnAsignar.'  				   
				    	</td>			    	
				    </tr>';
				   }
				   
				   	mysqli_close($database);	
				    	?>

				    	
				    	</tbody>
			</table>
			</div>
			
			
	</body>
</html>

