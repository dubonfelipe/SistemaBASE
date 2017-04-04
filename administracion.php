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
  
  
  
  $cursos="SELECT * FROM cmb_curso;";
  $queryCursos= $database->query($cursos);
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
			<h2>CONFIGURACIÓN PARA ADMINSITRADOR</h2>
			</div>
		</header>
		
		<form method="post" class="form-horizontal">
				<h3 class="bg-primary text-center  mx-auto">Agregar curso</h3>
				
				<div style="overflow-x:auto;" class="container center_div">
				<table class="table bg-info"  id="tabla">
					<tr>
						<td></td>
						<td><label>Nombre del curso*: </label></td>
						<td>
						<input required name="nombre" placeholder="Nombre (30 caracteres)" maxlength="30"/>
						</td>
						<td><label>Descripción*: </label></td>
						<td>
						<input required name="descripcion" placeholder="Descripción (45 caracteres)" maxlength="45"/>
						</td>
						<td><input type="submit" name="insertar" value="Insertar" class="btn btn-info"/></td>
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
					if(isset($_POST['insertar'])){
				

					$nombre=($_POST['nombre']);
					$descripcion=($_POST['descripcion']);	
				
									 
					$consultaD="SELECT * FROM cmb_curso WHERE nombre='".$nombre."' AND descripcion='".$descripcion."';";
					$resultD=$database->query($consultaD) or mysqli_error($database);
					//si la consulta no arroja un registro repetido
					if(mysqli_num_rows($resultD)==0){		
									 
						//////// QUERY DE INSERCIÓN ////////////////////////////
						$valores="";
						$valores="('".$nombre."', '".$descripcion."', 1);";
						$sql = "INSERT INTO cmb_curso(nombre, descripcion, activo)
							VALUES".$valores;
										
						$sqlRes=$database->query($sql) or mysql_error();
						echo '<script>recargar();</script>';
					}									
					}
					mysqli_close($database);		
				 }		    			
			?>
			
			
			
			<div style="overflow-x:auto;">
			<table class="table table-active table-responsive table-bordered table-condensed table-striped">

					<thead>
					<tr class="info">
						
						<th>Código del curso</th>
						<th>Nombre del curso</th>
						<th>Descripción</th>
						<th>Estado</th>						
						<th width="160">Opción</th>
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
				    	while($registroCurso  = $queryCursos->fetch_array( MYSQLI_BOTH)) 
				  {
					
					
				  	//creacion de elemento grafico para representar alumno activo o inactivo
					$botonActivo="";
					if($registroCurso['activo'] == 1){
						$botonActivo='<button type="button" class="btn  btn-success" disabled> Activo </button>';
					}else{
						$botonActivo='<button type="button" class="btn  btn-danger" disabled>Inactivo</button>';
					}	
					
					//creacion de elemento grafico del formulario para curso activo o inactivo en la edicion
					$checkActivo="";
					if($registroCurso['activo'] == 1){
					 	$checkActivo='<label class="form-check-label">
											 <input type="radio" class="form-check-input" name="activo" checked value="1">Activo</label></br>
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
					

				  echo '<tr id="linea-'.$registroCurso['idcurso'].'">
				  	<td>'.$registroCurso['idcurso'].'</td>
				    	<td>'.$registroCurso['nombre'].'</td>
				    	<td>'.$registroCurso['descripcion'].'</td>
				    	<td>'.$botonActivo.'</td>
				    	<td><button class="btn btn-warning" data-toggle="modal" data-target="#edit-'.$registroCurso['idcurso'].'">Editar</button>
				    	
				    	<div class="modal fade" id="edit-'.$registroCurso['idcurso'].'" tabindex="-1" role="dialog"
				    	aria-labelledby="editLabel-'.$registroCurso['idcurso'].'">
				    		<div class="modal-dialog" role="document">
				    			<div class="modal-content">
				    				<div class="modal-header">
				    					<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
				    				<h4 class="modal-tittle" id="editLabel-'.$registroCurso['idcurso'].'">Editar Curso: '.$registroCurso['nombre'].'</h4>
				    				</div>
				    				<form class="form-vertical" method="POST" action="upCurso.php">
				    					<div class="modal-body form-group">
				    						<label class"control-label col-sm-2">Código: </label><input class="form-control" required name="idcurso" id="idcurso-'.$registroCurso['idcurso'].'" value="'.$registroCurso['idcurso'].'" readonly /></br>
				    						<label class"control-label col-sm-2">Nombre del Curso: </label><input class="form-control" required name="nombre" id="nombre-'.$registroCurso['idcurso'].'" value="'.$registroCurso['nombre'].'" maxlength="30"/></br>
				    						<label class"control-label col-sm-2">Descripción: </label><input class="form-control" required name="descripcion" id="descripcion-'.$registroCurso['idcurso'].'" value="'.$registroCurso['descripcion'].'" maxlength="45" /></br>											
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
