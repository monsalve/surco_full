<?php 
//@ini_set('display_errors', 'on');
include($_SERVER['DOCUMENT_ROOT'].'/defines.php');
include(B_TOOLS .'/controlador.php');
$token = $_GET['token'];
$usu = $_GET['usu'];
$fecha1 = new DateTime(null, new DateTimeZone('America/Bogota'));  // se captura la fecha y hora real de la zona
$ahora=$fecha1->format('Y-m-d H:i:s');
$usuario = datosusuario($usu);
$empresas =listar_empresas();
if($usuario['id_roll'] == 1)
	$roll = 'ADMINISTRADOR';
else
	$roll = 'ASISTENTE';

if(isset($_POST['crear']))
{
	$n1=$_POST['nombre1'];
	$n2=$_POST['nombre2'];
	$a1=$_POST['apellido1'];
	$a2=$_POST['apellido2'];
	$ced=$_POST['cedula'];
	$exp=$_POST['expedida'];
	$tel=$_POST['telefono'];
	$email=$_POST['email'];
	$emp=$_POST['empresa'];
	$fec=$ahora;
	if($n1 == '' OR $a1 == '' OR $ced == '' OR $exp == '')
	{	
		$crear = false;	
		
	}	
	else
	{	
		
		if($crear=crear_estudiante($n1,$n2,$a1,$a2,$ced,$exp,$tel,$email,$fec,$emp))
		$newURL = '/admin.php?usu='.$usu.'&token='.$token.'';
		else
			"error al crear estudiante";
		
			
	}	
			
}


if(isset($_POST['nombre_empresa']))
{
	$n_emp=$_POST['nombre_empresa'];
	$nit_emp=$_POST['nit_empresa'];
	$tel_emp=$_POST['tel_empresa'];
	if(crear_empresa($n_emp,$nit_emp,$tel_emp)){
		$redirURL = '/crear.php?usu='.$usu.'&token='.$token.'';
		header('Location: '.$redirURL);
	}
	else
		"<escript>alert('error al crear la empresa')</script>";
	
			
}


?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>C.E.P.S.A.S. | Crear</title>
		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<link rel="stylesheet" href="<?= B_TOOLS_JS ?>web/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?= B_TOOLS_JS ?>web/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?= B_TOOLS_JS ?>web/css/ionicons.min.css">
	   <!-- Theme style -->
		<link rel="stylesheet" href="<?= B_TOOLS_JS ?>web/dist/css/AdminLTE.css">
		<!-- AdminLTE Skins. Choose a skin from the css/skins
			 folder instead of downloading all of them to reduce the load. -->
		<link rel="stylesheet" href="<?= B_TOOLS_JS ?>web/dist/css/skins/_all-skins.min.css">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->	
				
	</head>
	<body class="skin-blue sidebar-mini">
		<?php if(isset($token) AND $token != '')
			{
		?>		
		<div class="wrapper">

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
              <ul class="nav navbar-nav">
                <li class="active"><a href="#">CREAR ESTUDIANTE<span class="sr-only">(current)</span></a></li>
              </ul>             
            </div><!-- /.navbar-collapse -->
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
              <ul class="nav navbar-nav">
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                  <!-- Menu Toggle Button -->
                  <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <!-- The user image in the navbar-->
                    <img alt="User Image" class="user-image" src="tools/web/dist/img/user.png">
                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                    <span class="hidden-xs"><?=$usuario['primer_nombre']?> <?=$usuario['segundo_nombre']?> <?=$usuario['primer_apellido']?> <?=$usuario['segundo_apellido']?> - <?= $roll ?></span>
                  </a>
                  
                </li>
              </ul>
            </div><!-- /.navbar-custom-menu -->
          </div><!-- /.container-fluid -->
        </nav>
      </header>
      <!-- Full Width Column -->
      <div class="content-wrapper" style="min-height: 242px;">
        <div class="container">
          <!-- Content Header (Page header) -->
			  <section class="content-header">
				<h1>
				  DATOS GENERALES 
				  <small>Estudiante</small>
				</h1>
				<ol class="breadcrumb">
				  <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
				  <li><a href="admin.php?usu=<?=$usu?>&token=<?=$token?>">Administrador</a></li>
				  <li class="active">Crear</li>
				</ol>
			  </section>

          <!-- Main content -->
			<section class="content">
				<div class="row">
					<div class="col-xs-12">
						<div class="box box-info oculto" id="form_crear_emp">
							<div class="box-header with-border">
							  <h3 class="box-title">Crear Empresa</h3>
							</div><!-- /.box-header -->
							<!-- form start -->
							<form class="form-horizontal" name="frmdatos" method="post" action="">
								<div class="box-body">
									<div class="form-group">
										<label for="nombre_empresa" class="col-sm-2 control-label">Empresa:</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="nombre_empresa" placeholder="Empresa" name="nombre_empresa">
										</div>
									</div>
									<div class="form-group">
										<label for="nit_empresa" class="col-sm-2 control-label">Nit Empresa:</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="nit_empresa" placeholder="Nit Empresa" name="nit_empresa">
										</div>
									</div>
									<div class="form-group">
										<label for="tel_empresa" class="col-sm-2 control-label">Teléfono Empresa:</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="tel_empresa" placeholder="Teléfono Empresa" name="tel_empresa">
										</div>
									</div>
									<div class="alert alert-danger alert-dismissible oculto" id="error">
										<h4><i class="icon fa fa-ban"></i> Alert!</h4>
										Faltan campos obligatorios por llenar.
									</div>
								</div><!-- /.box-body -->
								<div class="box-footer">
									<a href="javascript:void(0);" class="btn btn-default" onclick="cancelar();">Cancelar</a>
									<a href="javascript:void(0);" class="btn btn-info" onclick="enviar_datos_empresa();">Crear Empresa</a>
								</div><!-- /.box-footer -->
							</form>
						</div><!-- /.box -->
								
					
						<div class="box box-info">
							<div class="box-header with-border">
							  <h3 class="box-title">Formulario</h3>
							</div><!-- /.box-header -->
							<!-- form start -->
							<form class="form-horizontal" method="post" action="">
							  <div class="box-body">
								
								<?php 
									if(isset($crear) AND $crear == false)
									{ 
								?>	
								<div class="alert alert-danger alert-dismissible">
									<h4><i class="icon fa fa-ban"></i> Alert!</h4>
									Faltan campos obligatorios por llenar.
								</div>
								<?php
									}
									if(isset($crear) AND $crear == true)
									{	
								?>
								<div class="alert alert-success alert-dismissible">
									<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
									<h4>	<i class="icon fa fa-check"></i> OK!</h4>
									El alumno ha sido creado correctamente.
								</div>
								<?php 
									} 
								?>
								<div class="form-group">
								  <label for="nombre1" class="col-sm-2 control-label">Nombre 1</label>
								  <div class="col-sm-10">
									<input type="text" class="form-control" id="nombre1" placeholder="Nombre1" name="nombre1">
								  </div>
								</div>
								<div class="form-group">
								  <label for="nombre2" class="col-sm-2 control-label">Nombre 2</label>
								  <div class="col-sm-10">
									<input type="text" class="form-control" id="nombre2" placeholder="Nombre2" name="nombre2">
								  </div>
								</div>
								<div class="form-group">
								  <label for="apellido1" class="col-sm-2 control-label">Apellido 1</label>
								  <div class="col-sm-10">
									<input type="text" class="form-control" id="apellido1" placeholder="Apellido 1" name="apellido1">
								  </div>
								</div>
								<div class="form-group">
								  <label for="apellido2" class="col-sm-2 control-label">Apellido 2</label>
								  <div class="col-sm-10">
									<input type="text" class="form-control" id="apellido2" placeholder="Apellido 2" name="apellido2">
								  </div>
								</div>
								<div class="form-group">
								  <label for="cedula" class="col-sm-2 control-label">Cédula</label>
								  <div class="col-sm-10">
									<input type="text" class="form-control" id="cedula" placeholder="Cédula" name="cedula">
								  </div>
								</div>
								<div class="form-group">
								  <label for="expedida" class="col-sm-2 control-label">Expedida en</label>
								  <div class="col-sm-10">
									<input type="text" class="form-control" id="expedida" placeholder="Expedida en" name="expedida">
								  </div>
								</div>
								<div class="form-group">
								  <label for="telefono" class="col-sm-2 control-label">Teléfono</label>
								  <div class="col-sm-10">
									<input type="text" class="form-control" id="telefono" placeholder="Teléfono" name="telefono">
								  </div>
								</div>
								 <div class="form-group">
								  <label for="email" class="col-sm-2 control-label">Email</label>
								  <div class="col-sm-10">
									<input type="email" class="form-control" id="email" placeholder="Email" name="email">
								  </div>
								</div>
								<div class="form-group">
								    <label for="email" class="col-sm-2 control-label">Empresa</label>
									<div class="col-sm-10">
										<select name="empresa"  id="empresa" class="form-control">
										<option value="">--Seleccione--</option>
										<?php 
											while($datos = $empresas->fetch_array())
											{
																				
										?>	
											<option value="<?=$datos['id']?>"><?=$datos['empresa']?></option>
										<?php		  
											}
										?>	
										</select>
									</div>
								</div>
								<div class="form-group" id="datos_empresa">
								 
								</div>	
							  </div><!-- /.box-body -->
							  <div class="box-footer">
								<a href="admin.php?usu=<?=$usu?>&token=<?=$token?>" class="btn btn-default">Regresar</a>
								<a href="javascript:void(0);" class="btn btn-success" onclick="crear_empresa();">Crear Empresa</a>
								<button type="submit" class="btn btn-info pull-right" name="crear">Crear Alumno</button>
							  </div><!-- /.box-footer -->
							</form>
						</div><!-- /.box -->
					</div>
						
				</div>
			</section><!-- /.content -->
        </div><!-- /.container -->
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="container">
          <div class="pull-right hidden-xs">
            <b>Version</b> 1.0
          </div>
          <strong>Copyright &copy; MBC-Partners S.A.S  -  2016   <a href="http://www.mbc-partners.com.co">www.mbc-partners.com.co</a></strong>    All rights reserved.
        </div><!-- /.container -->
      </footer>
    </div>	

	<script src="<?= B_TOOLS_JS ?>web/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?= B_TOOLS_JS ?>web/bootstrap/js/bootstrap.min.js"></script>
    <!-- Morris.js charts -->
	<script src="<?= B_TOOLS_JS ?>web/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= B_TOOLS_JS ?>web/plugins/datatables/dataTables.bootstrap.min.js"></script>
 	<script src="<?= B_TOOLS_JS ?>mbcaccionistas.js"></script>
	   
    <!-- page script -->
    <script>
		
		function enviar_datos_empresa(){
			 contador=0;
			 if(document.frmdatos.nombre_empresa.value=="")
				 contador=1;
			 if(document.frmdatos.nit_empresa.value=="")
				 contador=1;
			 if(document.frmdatos.tel_empresa.value=="")
				 contador=1;
			 if(contador == 0){
			 document.frmdatos.submit();
			 }
			 else
			 {
				$('#error').removeClass('oculto'); 
			 }
		}
		
		$(function () {
			//$("#example1").DataTable();	
			 $("#example1").DataTable({
			"lengthMenu": [[20, 30, 40, -1], [20, 30, 40, "All"]]
			});
			
		});
		function crear_empresa(){
			$('#form_crear_emp').removeClass('oculto');
		}
		function cancelar(){
			$('#form_crear_emp').addClass('oculto');
		}
		$(document).ready(function(){
				$('#empresa').on('change',function(){
					var id = this.value;
					$.ajax({
						type:"POST",
						url:"consultar_empresa.php",
						data:{'id':id},
						success: function(msg){
							$('#datos_empresa').html('');
							$('#datos_empresa').html(msg);
							
						}
					});
				});
				
		});  
		  
    </script>
	<?php
		}
		else
			echo "<h1>ACCESO NO AUTORIZADO</h1>";	
	?>
  </body>
</html>
