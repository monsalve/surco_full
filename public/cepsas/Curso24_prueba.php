<?php 
//@ini_set('display_errors', 'on');
include($_SERVER['DOCUMENT_ROOT'].'/defines.php');
include(B_TOOLS .'/controlador.php');
session_start();
//$token = $_GET['token'];
//$usu = $_GET['usu'];
//print_r($_GET);

if(isset($_SESSION['usuario']))
	echo $_SESSION['usuario'];

$row=array();
if(isset($_SESSION['alumno']))
{
	$alumno = $_SESSION['alumno'];
	$row = consultarAlumno($alumno);
}

if (isset($_POST['cerrar_sesion']))
{
	session_destroy();
	header('Location: cursos.php');
}
$BanFalta=0;
$r1=$r2=$r3=$r4=$r5=$r6=$r7=$r8=$r9=$r10=0;

if(isset($_POST['Enviar']))
{
	$correctas = 0;
	$respuestas=array();
	
	$res1 = $_POST['res1'];
	if(count($res1)>0)
	{
		foreach($res1 as $r1){}
		if($r1 == "a")
			$correctas = $correctas+1;
	}
	else{$BanFalta=1;}
	$respuestas[1]=$r1;
	
	$res2 = $_POST['res2'];
	if(count($res2)>0)
	{
		foreach($res2 as $r2){}
		if($r2 == "d")
			$correctas = $correctas+1;
	}
	else{$BanFalta=1;}
	$respuestas[2]=$r2;
	
	$res3 = $_POST['res3'];
	if(count($res3)>0)
	{
		foreach($res3 as $r3){}
		if($r3 == "b")
			$correctas = $correctas+1;
	}
	else{$BanFalta=1;}
	$respuestas[3]=$r3;
	
	$res4 = $_POST['res4'];
	if(count($res4)>0)
	{
		foreach($res4 as $r4){}
		if($r4 == "v")
			$correctas = $correctas+1;
	}
	else{$BanFalta=1;}
	$respuestas[4]=$r4;
	
	$res5 = $_POST['res5'];
	if(count($res5)>0)
	{
		foreach($res5 as $r5){}
		if($r5 == "v")
			$correctas = $correctas+1;
	}
	else{$BanFalta=1;}	
	$respuestas[5]=$r5;
	
	$res6 = $_POST['res6'];
	if(count($res6)>0)
	{
		foreach($res6 as $r6){}
		if($r6 == "v")
			$correctas = $correctas+1;
	}
	else{$BanFalta=1;}
	$respuestas[6]=$r6;
	
	$res7 = $_POST['res7'];
	if(count($res7)>0)
	{
		foreach($res7 as $r7){}
		if($r7 == "v")
			$correctas = $correctas+1;
	}
	else{$BanFalta=1;}
	$respuestas[7]=$r7;
	
	$res8 = $_POST['res8'];
	if(count($res8)>0)
	{
		foreach($res8 as $r8){}
		if($r8 == "v")
			$correctas = $correctas+1;
	}
	else{$BanFalta=1;}
	$respuestas[8]=$r8;
	
	$res9 = $_POST['res9'];
	if(count($res9)>0)
	{
		foreach($res9 as $r9){}
		if($r9 == "v")
			$correctas = $correctas+1;
	}
	else{$BanFalta=1;}
	$respuestas[9]=$r9;
	
	$res10 = $_POST['res10'];
	if(count($res10)>0)
	{
		foreach($res10 as $r10){}
		if($r10 == "f")
			$correctas = $correctas+1;
	}
	else{$BanFalta=1;}
	$respuestas[10]=$r10;
	
	$resultado = (($correctas / 10) * 100);
	
	
	if(isset($_SESSION['alumno']))
	{
		$alumno = $_SESSION['alumno'];
		$row = consultarAlumno($alumno);
		
		$id_alumno = $row['id'];
		$curso = 24;
		
		
	}
	if($BanFalta==0)
	{
		$resultado = resultadoPrueba($id_alumno, $curso, $resultado);
		respuestasPrueba($id_alumno,$curso,$respuestas);
		header ("location: Curso24.php");
	}
	else
	{?>
		<script>
			alert("Se deben responder todas las preguntas!!!");
		</script>
<?php	
	}
}
?>
<!DOCTYPE html>
<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>C.E.P.S.A.S. | Curso 24</title>
		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<link rel="stylesheet" href="tools/web/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="tools/web/css/font-awesome.min.css">
		<link rel="stylesheet" href="tools/web/css/ionicons.min.css">
	   <!-- Theme style -->
		<link rel="stylesheet" href="tools/web/dist/css/AdminLTE.css">
		<!-- AdminLTE Skins. Choose a skin from the css/skins
			 folder instead of downloading all of them to reduce the load. -->
		<link rel="stylesheet" href="tools/web/dist/css/skins/_all-skins.min.css">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->	
		<style>
			table{
			    margin: 0 auto;
			}
		</style>		
	</head>
	<body class="skin-blue sidebar-mini">
	<!-- contenido a copiar para generar la cabecera -->
		<header class="main-header">
			<nav class="navbar navbar-static-top">
				<div class="container">
					<div class="navbar-header">
						<a class="navbar-brand" href="../../index2.html"><b>C.E.P.</b>S.A.S.</a>
						<button data-target="#navbar-collapse" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
							<i class="fa fa-bars"></i>
						</button>
					</div>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div id="navbar-collapse" class="collapse navbar-collapse pull-left">
						            
					</div><!-- /.navbar-collapse -->
					<!-- Navbar Right Menu -->
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">
						<!-- User Account Menu -->
							<li class="dropdown user user-menu">
						<!-- Menu Toggle Button -->
						<!-- validar si el usuario ya esta en session y si esta mostrar el nombre en caso contrario mandarlo a la pantalla de logueo
							 de estudiantes y regresar a esta pantalla-->
								<a data-toggle="dropdown" class="dropdown-toggle" href="#">
						<!-- The user image in the navbar-->
									<img alt="User Image" class="user-image" src="tools/web/dist/img/user.png">
						<!-- hidden-xs hides the username on small devices so only the image appears. -->
									<?php	
										$DatosAlumno= estudiante($id,$_SESSION['alumno']);
										if(isset($_SESSION['alumno']))
										{ ?>
											<?=$row['nombre1']?> 
											<?=$row['nombre2']?> 
											<?=$row['apellido1']?> 
											<?=$row['apellido2']?>
											
									<?php	
										}
										else
										{?>
											<a href="LoginEstudiante.php">Ingresar</a>
									<?	}?>
										
									
									<?php
									if(isset($_SESSION['alumno']))
									{
									?>
									<form action="" method="POST">
										<input type="submit" name="cerrar_sesion" value="Cerrar sesi&oacute;n">
									</form>
									<?php
									}
									else
									{
										
									}
									?>
								</a>                  
							</li>
						</ul>
					</div><!-- /.navbar-custom-menu -->
				</div><!-- /.container-fluid -->
			</nav>
		</header>
		<div>
			<form action="" method="POST">
				<table border='1' style="width:800px" >
					<thead>
						<th colspan="4" style="text-align:center"><b>Curso 24 : RESCATE VERTICAL EN ALTURAS - Prueba de conocimientos</b></th>
					</thead>
					
					<tbody>
						<tr>
							<td colspan="4">Marque la respuesta correcta.</td>
						</tr>
						
						<tr>
							<td><b>No.</b></td>
							<td colspan="3" style="text-align:center"><b>Pregunta</b></td>
						</tr>
						
						<tr>
							<td rowspan="5"><b>1.</b></td>
							<td colspan="3">Qué  Resolución establece el Reglamento de Seguridad para protección contra caídas en trabajo en alturas?</td>
						</tr>
						<tr>
							<td><b>a.</b></td><td>1409 -2012</td>
							<td><input type="radio" name="res1[]" <?php if($r1=="a"&&$r1!="0"){ echo "checked"; }?> value="a"></td>
						</tr>
						<tr>
							<td><b>b.</b></td><td>1326-2011</td>
							<td><input type="radio" name="res1[]" <?php if($r1=="b"&&$r1!="0"){ echo "checked"; }?> value="b"></td>
						</tr>
						<tr>
							<td><b>c.</b></td><td>7123-2014</td>
							<td><input type="radio" name="res1[]" <?php if($r1=="c"&&$r1!="0"){ echo "checked"; }?> value="c"></td>
						</tr>
						<tr>
							<td><b>d.</b></td><td>Ninguna de las anteriores</td>
							<td><input type="radio" name="res1[]" <?php if($r1=="d"&&$r1!="0"){ echo "checked"; }?> value="d"></td>
						</tr>
						
						<tr>
							<td rowspan="5"><b>2.</b></td>
							<td colspan="3">¿Antes de realizar cualquier  trabajo en alturas se debe  contar con…..?</td>
						</tr>
						<tr>
							<td><b>a.</b></td>
							<td>un permiso de trabajo.</td>
							<td><input type="radio" name="res2[]" <?php if($r2=="a"&&$r2!="0"){ echo "checked"; }?> value="a"></td>
						</tr>
						<tr>
							<td><b>b.</b></td>
							<td>equipos de protección contra caídas </td>
							<td><input type="radio" name="res2[]" <?php if($r2=="b"&&$r2!="0"){ echo "checked"; }?> value="b"></td>
						</tr>
						<tr>
							<td><b>c.</b></td>
							<td>El personal capacitado para realizar la tarea</td>
							<td><input type="radio" name="res2[]" <?php if($r2=="c"&&$r2!="0"){ echo "checked"; }?> value="c"></td>
						</tr>
						<tr>
							<td><b>d.</b></td>
							<td>Todas las anteriores</td>
							<td><input type="radio" name="res2[]" <?php if($r2=="d"&&$r2!="0"){ echo "checked"; }?> value="d"></td>
						</tr>
						
						<tr>
							<td rowspan="5"><b>3.</b></td>
							<td colspan="3">¿Cuál es la  definición de un  Anclaje?</td>
						</tr>
						<tr>
							<td><b>a.</b></td>
							<td>Es el conjunto de elementos que intervienen en una caída para absorber la energía generada. Su función es lograr una detención “amortiguada” y así evitar que el cuerpo sufra daños</td>
							<td><input type="radio" name="res3[]" <?php if($r3=="a"&&$r3!="0"){ echo "checked"; }?> value="a"></td>
						</tr>
						<tr>
							<td><b>b.</b></td>
							<td>Punto seguro al que pueden conectarse equipos personales de protección contra caídas con resistencia certificada a la rotura y un factor de seguridad, diseñados y certificados en su instalación por un fabricante y/o una persona calificada. Puede ser fijo o móvil según la necesidad</td>
							<td><input type="radio" name="res3[]" <?php if($r3=="b"&&$r3!="0"){ echo "checked"; }?> value="b"></td>
						</tr>
						<tr>
							<td><b>c.</b></td>
							<td>Son las que se utilizan en todas las maniobras en las que existe riesgo de caída a fin de asegurar progresiones de primero o de segundo de cuerda.</td>
							<td><input type="radio" name="res3[]" <?php if($r3=="c"&&$r3!="0"){ echo "checked"; }?> value="c"></td>
						</tr>
						<tr>
							<td><b>d.</b></td>
							<td>Todas las anteriores</td>
							<td><input type="radio" name="res3[]" <?php if($r3=="d"&&$r3!="0"){ echo "checked"; }?> value="d"></td>
						</tr>
						
						
						<tr>
							<td colspan="4"><b>Marque &#34;V&#34; si es verdadero &#34;F&#34; si es falsa la afirmaci&oacute;n.</b></td>
						</tr>
						
						
						<tr>
							<td rowspan="3"><b>4.</b></td>
							<td colspan="4">Son las que se utilizan en todas las maniobras en las que existe riesgo de caída a fin de asegurar progresiones de primero o de segundo de cuerda.</td>
						</tr>
						<tr>
							<td colspan="2">F</td>
							<td><input type="radio" name="res4[]" <?php if($r4=="f"&&$r4!="0"){ echo "checked"; }?> value="f"></td>
						</tr>
						<tr>
							<td colspan="2">V</td>
							<td><input type="radio" name="res4[]" <?php if($r4=="v"&&$r4!="0"){ echo "checked"; }?> value="v"></td>
						</tr>
						
						<tr>
							<td rowspan="3"><b>5.</b></td>
							<td colspan="3">todos los implemos de protección contra caídas tiene que tener una resistencia mínima de 5.000 libras (22,2 kilonewtons – 2.272 kg)</td>
						</tr>
						<tr>
							<td colspan="2">F</td>
							<td><input type="radio" name="res5[]" <?php if($r5=="f"&&$r5!="0"){ echo "checked"; }?> value="f"></td>
						</tr>
						<tr>
							<td colspan="2">V</td>
							<td><input type="radio" name="res5[]" <?php if($r5=="v"&&$r5!="0"){ echo "checked"; }?> value="v"></td>
						</tr>
						
						
						
						<tr>
							<td rowspan="3"><b>6.</b></td>
							<td colspan="3">el plan de rescate, debe estar diseñado acorde con los riesgos de la actividad en alturas desarrollada, se deben asignar equipos de rescate certificados para toda la operación y contar con brigadistas o personal formado para tal fin</td>
						</tr>
						<tr>
							<td colspan="2">F</td>
							<td><input type="radio" name="res6[]" <?php if($r6=="f"&&$r6!="0"){ echo "checked"; }?> value="f"></td>
						</tr>
						<tr>
							<td colspan="2">V</td>
							<td><input type="radio" name="res6[]" <?php if($r6=="v"&&$r6!="0"){ echo "checked"; }?> value="v"></td>
						</tr>
						
						<tr>
							<td rowspan="3"><b>7.</b></td>
							<td colspan="3">El empleador debe asegurar que el trabajador que desarrolla trabajo en alturas, cuente con un sistema de comunicación y una persona de apoyo disponible para que, de ser necesario, reporte de inmediato la emergencia</td>
						</tr>
						<tr>
							<td colspan="2">F</td>
							<td><input type="radio" name="res7[]" <?php if($r7=="f"&&$r7!="0"){ echo "checked"; }?> value="f"></td>
						</tr>
						<tr>
							<td colspan="2">V</td>
							<td><input type="radio" name="res7[]" <?php if($r7=="v"&&$r7!="0"){ echo "checked"; }?> value="v"></td>
						</tr>
						
						<tr>
							<td rowspan="3"><b>8.</b></td>
							<td colspan="3">todo el personal se debe Realizar las evaluaciones médicas ocupacionales y el manejo y contenido de las historias clínicas ocupacionales conforme a lo establecido en las Resoluciones 2346 de 2007 y 1918 de 2009 expedidas por el Ministerio de la Protección Social o las normas que las modifiquen, sustituyan o adicionen</td>
						</tr>
						<tr>
							<td colspan="2">F</td>
							<td><input type="radio" name="res8[]" <?php if($r8=="f"&&$r8!="0"){ echo "checked"; }?> value="f"></td>
						</tr>
						<tr>
							<td colspan="2">V</td>
							<td><input type="radio" name="res8[]" <?php if($r8=="v"&&$r8!="0"){ echo "checked"; }?> value="v"></td>
						</tr>
						
						<tr>
							<td rowspan="3"><b>9.</b></td>
							<td colspan="3">Reentrenamiento: Proceso anual obligatorio, por el cual se actualizan conocimientos y se entrenan habilidades y destrezas en prevención y protección contra caídas</td>
						</tr>
						<tr>
							<td colspan="2">F</td>
							<td><input type="radio" name="res9[]" <?php if($r9=="f"&&$r9!="0"){ echo "checked"; }?> value="f"></td>
						</tr>
						<tr>
							<td colspan="2">V</td>
							<td><input type="radio" name="res9[]" <?php if($r9=="v"&&$r9!="0"){ echo "checked"; }?> value="v"></td>
						</tr>
						
						<tr>
							<td rowspan="3"><b>10.</b></td>
							<td colspan="3">Aseguramiento estático: cuando el dispositivo de freno (ocho, nudo dinámico) permite el deslizamiento de la cuerda, se produce una fricción que transforma parte de la energía en calor</td>
						</tr>
						<tr>
							<td colspan="2">F</td>
							<td><input type="radio" name="res10[]" <?php if($r10=="f"&&$r10!="0"){ echo "checked"; }?> value="f"></td>
						</tr>
						<tr>
							<td colspan="2">V</td>
							<td><input type="radio" name="res10[]" <?php if($r10=="v"&&$r10!="0"){ echo "checked"; }?> value="v"></td>
						</tr>
						
						<tr align="center">
							<td colspan="4">
								<input type="submit" value="Enviar" name="Enviar" class="btn btn-success">
								<a href="Curso24.php" class="btn btn-default">Regresar</a>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
	</body>		
</html>	