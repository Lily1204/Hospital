<?php
/*
Archivo:  tabpacientes.php
Objetivo: consulta general sobre pacientes y acceso a operaciones detalladas
Autor:    
*/
include_once("modelo\Usuario.php");
include_once("modelo\PersonalHospitalario.php");
include_once("modelo\Pacientes.php");
session_start();
$sErr="";
$sNom="";
$arrPacientes=null;
$oUsu = new Usuario();
$oPacientes=new Pacientes();

	/*Verificar que exista sesión*/
	if (isset($_SESSION["usu"]) && !empty($_SESSION["usu"])){
		$oUsu = $_SESSION["usu"];
		$sNom = $oUsu->getPersHosp()->getNombre();
		try{
			//Buscar lista de pacientes
			$arrPacientes = $oPacientes->buscarTodos();
		
		}catch(Exception $e){
			//Enviar el error específico a la bitácora de php (dentro de php\logs\php_error_log
			error_log($e->getFile()." ".$e->getLine()." ".$e->getMessage(),0);
			$sErr = "Error en base de datos, comunicarse con el administrador";
		}
	}
	else
		$sErr = "Falta establecer el login";
	
	if ($sErr == ""){
		include_once("cabecera.html");
		include_once("menu.php");
		include_once("aside.html");
	}
	else{
	header("Location: error.php?sError=".$sErr);
		exit();
	}
?>
		<section>
			<h3>Pacientes</h3>
			<form name="formTablaGral" method="post" action= "abcPaciente.php">
				<input type="hidden" name="txtClave">
				<input type="hidden" name="txtOpe">
				<table border="1">
				<tr>
				<td>Clave</td>
				<td>Nombre</td>
				<td>ApellidoP</td>
				<td>ApellidoM</td>
				<td>FechaNacim</td>
				<td>Sexo</td>
				<td>Alergias</td>
				<td>operaciones</td>
				</tr>
				
					<?php

						if ($arrPacientes!=null){
							
							foreach($arrPacientes as $oPacientes){
										
					?>
					<tr>
						<td class="llave"><?php echo $oPacientes->getIdPac(); ?></td>
						<td class="llave2"><?php echo $oPacientes->getNombre(); ?></td>
						<td class="llave3"><?php echo $oPacientes->getApePat(); ?></td>
						<td class="llave4"><?php echo $oPacientes->getApeMat(); ?></td>
						<td class="llave4"><?php echo $oPacientes->getFechaNacim()->format('Y-m-d'); ?></td>
						<td class="llave6"><?php echo $oPacientes->getsexo(); ?></td>
						<td class="llave7"><?php echo $oPacientes->getAlergias(); ?></td>
						
						<td>
						
						
							<input type="submit" name="Submit" value="Modificar" onClick="txtClave.value=<?php echo $oPacientes->getIdPac(); ?>; txtOpe.value='m'">
							<input type="submit" name="Submit" value="Borrar" onClick="txtClave.value=<?php echo $oPacientes->getIdPac(); ?>; txtOpe.value='b'">
						</td>
					</tr>
					<?php 
							}//foreach
						}else{
							
					?>     
					<tr>
						<td colspan="2">No hay datos</td>
						
					</tr>
					<?php
						}
					?>
				</table>
				<input type="submit" name="Submit" value="Crear Nuevo" onClick="txtClave.value='-1';txtOpe.value='a'">
			</form>
		</section>
<?php
include_once("pie.html");
?>