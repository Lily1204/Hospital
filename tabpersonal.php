<?php
/*
Archivo:  tabpersonal.php
Objetivo: consulta general sobre personal hospitalario y acceso a operaciones detalladas
Autor:   BAOZ 
*/
include_once("modelo\Usuario.php");
include_once("modelo\PersonalHospitalario.php");
session_start();
$sErr="";
$sNom="";
$arrPersHosp=null;
$oUsu = new Usuario();
$oPersHosp = new PersonalHospitalario();
	/*Verificar que exista sesión*/
	if (isset($_SESSION["usu"]) && !empty($_SESSION["usu"])){
		$oUsu = $_SESSION["usu"];
		$sNom = $oUsu->getPersHosp()->getNombre();
		try{
			$arrPersHosp = $oPersHosp->buscarTodos();
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
			<h3>Personal Hospitalario</h3>
			<form name="formTablaGral" method="post" action="abcPersHosp.php">
				<input type="hidden" name="txtClave">
				<input type="hidden" name="txtOpe">
				<table border="1">
					<tr>
						<td>Clave</td>
						<td>Nombre</td>
						<td>Operaci&oacute;n</td>
					</tr>
					<?php
						if ($arrPersHosp!=null){
							foreach($arrPersHosp as $oPersHosp){
					?>
					<tr>
						<td class="llave"><?php echo $oPersHosp->getIdPersonal(); ?></td>
						<td><?php echo $oPersHosp->getNombreCompleto(); ?></td>
						<td>
							<input type="submit" name="Submit" value="Modificar" onClick="txtClave.value=<?php echo $oPersHosp->getIdPersonal(); ?>; txtOpe.value='m'">
							<input type="submit" name="Submit" value="Borrar" onClick="txtClave.value=<?php echo $oPersHosp->getIdPersonal(); ?>; txtOpe.value='b'">
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