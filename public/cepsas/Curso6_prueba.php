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
		if($r2 == "b")
			$correctas = $correctas+1;
	}
	else{$BanFalta=1;}
	$respuestas[2]=$r2;
	$res3 = $_POST['res3'];
	if(count($res3)>0)
	{
		foreach($res3 as $r3){}
		if($r3 == "a")
			$correctas = $correctas+1;
	}
	else{$BanFalta=1;}
	$respuestas[3]=$r3;
	$res4 = $_POST['res4'];
	if(count($res4)>0)
	{
		foreach($res4 as $r4){}
		if($r4 == "d")
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
		if($r8 == "f")
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
		if($r10 == "v")
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
		$curso = 6;	
	}
	if($BanFalta==0)
	{
		$resultado = resultadoPrueba($id_alumno, $curso, $resultado);
		respuestasPrueba($id_alumno,$curso,$respuestas);
		header ("location: Curso6.php");
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
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>C.E.P.S.A.S. | Curso 6</title>
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
				<table border='1' style="width:800px">
					<thead>
						<th colspan="4" style="text-align:center">Curso 6 : MANEJO Y ALMACENAMIENTO DE SUSTANCIAS PELIGROSAS - Prueba de conocimientos</th>
					</thead>
					
					<tbody>
						<tr>
							<td colspan="4">Marque la respuesta correcta.</td>
						</tr>
						
						<tr>
							<td style="text-align:center"><b>No.</b></td>
							<td colspan="3" style="text-align:center"><b>Pregunta</b></td>
						</tr>
						
						<tr>
							<td rowspan="5"><b>1.</b></td>
							<td colspan="3">la utilizaci&oacute;n de productos qu&iacute;micos en el trabajo, cada frasco, envase , garrafa, tambor, tanque o vasija que contenga cualquier tipo de sustancia qu&iacute;mica, debe estar debidamente etiquetado y marcado con la identidad del producto qu&iacute;mico que contiene y debe incluir tambi&eacute;n las advertencias sobre sus riesgos. &iquest;Est&aacute; conforme a la ley?.</td>
						</tr>
						<tr>
							<td><b>a.</b></td>
							<td>Ley 55 de 1993</td>
							<td><input type="radio" name="res1[]" <?php if($r1=="a"&&$r1!="0"){ echo "checked"; }?> value="a"></td>
						</tr>
						<tr>
							<td><b>b.</b></td>
							<td>Ley 11 de 1987</td>
							<td><input type="radio" name="res1[]" <?php if($r1=="b"&&$r1!="0"){ echo "checked"; }?> value="b"></td>
						</tr>
						<tr>
							<td><b>c.</b></td>
							<td>Ley 38 de 2001</td>
							<td><input type="radio" name="res1[]" <?php if($r1=="c"&&$r1!="0"){ echo "checked"; }?> value="c"></td>
						</tr>
						<tr>
							<td><b>d.</b></td>
							<td>Ley 65 de 1998</td>
							<td><input type="radio" name="res1[]" <?php if($r1=="d"&&$r1!="0"){ echo "checked"; }?> value="d"></td>
						</tr>
						
						<tr>
							<td rowspan="5"><b>2.</b></td>
							<td colspan="3">Indican con precisi&oacute;n el nombre del producto, su estado f&iacute;sico y su concentraci&oacute;n.</td>
						</tr>
						<tr>
							<td><b>a.</b></td>
							<td>Las Tapas</td>
							<td><input type="radio" name="res2[]" <?php if($r2=="a"&&$r2!="0"){ echo "checked"; }?> value="a"></td>
						</tr>
						<tr>
							<td><b>b.</b></td>
							<td>Las Etiquetas</td>
							<td><input type="radio" name="res2[]" <?php if($r2=="b"&&$r2!="0"){ echo "checked"; }?> value="b"></td>
						</tr>
						<tr>
							<td><b>c.</b></td>
							<td>El envase</td>
							<td><input type="radio" name="res2[]" <?php if($r2=="c"&&$r2!="0"){ echo "checked"; }?> value="c"></td>
						</tr>
						<tr>
							<td><b>d.</b></td>
							<td>Todas las anteriores</td>
							<td><input type="radio" name="res2[]" <?php if($r2=="d"&&$r2!="0"){ echo "checked"; }?> value="d"></td>
						</tr>
						
						<tr>
							<td rowspan="5"><b>3.</b></td>
							<td colspan="3">Es una clasificaci&oacute;n originada en la Organizaci&oacute;n Mar&iacute;tima Internacional - Manejo de Carga Peligrosa (IMDG por su sigla en ingl&eacute;s).</td>
						</tr>
						<tr>
							<td><b>a.</b></td>
							<td>OMI</td>
							<td><input type="radio" name="res3[]" <?php if($r3=="a"&&$r3!="0"){ echo "checked"; }?> value="a"></td>
						</tr>
						<tr>
							<td><b>b.</b></td>
							<td>DOT</td>
							<td><input type="radio" name="res3[]" <?php if($r3=="b"&&$r3!="0"){ echo "checked"; }?> value="b"></td>
						</tr>
						<tr>
							<td><b>c.</b></td>
							<td>CMY</td>
							<td><input type="radio" name="res3[]" <?php if($r3=="c"&&$r3!="0"){ echo "checked"; }?> value="c"></td>
						</tr>
						<tr>
							<td><b>d.</b></td>
							<td>Ninguna de las anteriores</td>
							<td><input type="radio" name="res3[]" <?php if($r3=="d"&&$r3!="0"){ echo "checked"; }?> value="d"></td>
						</tr>
						
						<tr>
							<td rowspan="5"><b>4.</b></td>
							<td colspan="3">El sistema de pictogramas o etiquetas de la CEE es obligatorio para los proveedores de sustancias qu&iacute;micas peligrosas del continente</td>
						</tr>
						<tr>
							<td><b>a.</b></td>
							<td>Americano</td>
							<td><input type="radio" name="res4[]" <?php if($r4=="a"&&$r4!="0"){ echo "checked"; }?> value="a"></td>
						</tr>
						<tr>
							<td><b>b.</b></td>
							<td>Asi&aacute;tico</td>
							<td><input type="radio" name="res4[]" <?php if($r4=="b"&&$r4!="0"){ echo "checked"; }?> value="b"></td>
						</tr>
						<tr>
							<td><b>c.</b></td>
							<td>Africano</td>
							<td><input type="radio" name="res4[]" <?php if($r4=="c"&&$r4!="0"){ echo "checked"; }?> value="c"></td>
						</tr>
						<tr>
							<td><b>d.</b></td>
							<td>Europeo</td>
							<td><input type="radio" name="res4[]" <?php if($r4=="d"&&$r4!="0"){ echo "checked"; }?> value="d"></td>
						</tr>
						
						<tr>
							<td colspan="6">
							<span><b>Marque la respuesta &#34;F&#34; si es falsa, &#34;V&#34; si es verdadera.</b></span>
							</td>
						<tr>
						
						<tr>
							<td rowspan="3"><b>5.</b></td>
							<td colspan="3">El N&uacute;mero de las Naciones Unidas, Corresponde a un n&uacute;mero de identificaci&oacute;n designado por la Organizaci&oacute;n de las Naciones Unidas para cada sustancia qu&iacute;mica comercial.</td>
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
							<td colspan="3">El sistema NFPA ha sido adoptado en los EEUU y en muchos otros pa&iacute;ses como complemento de los otros sistemas de identificaci&oacute;n e informaci&oacute;n, especialmente para recipientes como tanques estacionarios y carro tanques.</td>
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
							<td colspan="3">Las Hojas de Datos de Seguridad (conocidas en ingl&eacute;s como Material Safety Data Sheets o MSDS), contienen informaci&oacute;n valiosa y detallada sobre las propiedades f&iacute;sicas y qu&iacute;micas de las sustancias</td>
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
							<td colspan="3">El casco, anteojos y carteas, hacen parte de los criterios tlv&#39;s para sustancias qu&iacute;micas</td>
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
							<td colspan="3">El almacenamiento de sustancias peligrosas es de cr&iacute;tica importancia, ya que estas sustancias pueden quemar, explotar, contaminar, corroer, disolver, manchar, y producir reacciones perjudiciales.<td>
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
							<td colspan="3">En el almacenamiento se debe considerar la reactividad y/o toxicidad de las sustancias.</td>
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
								<a href="Curso6.php" class="btn btn-default">Regresar</a>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
	</body>		
</html>	