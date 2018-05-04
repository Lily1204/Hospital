<?php
/*
Archivo:  resABC.php
Objetivo: ejecuta la afectación al personal y retorna a la pantalla de consulta general
Autor:  BAOZ  
*/
include_once("modelo\Pacientes.php");
session_start();

$sErr=""; $sOpe = ""; $sCve = "";
$oPacientes = new Pacientes();

	/*Verificar que exista la sesión*/
	if (isset($_SESSION["usu"]) && !empty($_SESSION["usu"])){
		/*Verifica datos de captura mínimos*/
		if (isset($_POST["txtClave"]) && !empty($_POST["txtClave"]) &&
			isset($_POST["txtOpe"]) && !empty($_POST["txtOpe"])){
			$sOpe = $_POST["txtOpe"];
			$sCve = $_POST["txtClave"];
			$oPacientes->setIdPac($sCve);
			
			if ($sOpe != "b"){
                
				$oPacientes->setNombre($_POST["txtNombre"]);
				$oPacientes->setApePat($_POST["txtApePat"]);
				$oPacientes->setApeMat($_POST["txtApeMat"]);
				$oPacientes->setFechaNacim(DateTime::createFromFormat('Y-m-d', $_POST["txtFecNacim"]));
				$oPacientes->setSexo($_POST["rbSexo"]);
				$oPacientes->setAlergias($_POST["txtAlergias"]);
			}
			try{
				if ($sOpe == 'a')
					$nResultado = $oPacientes->insertar();

				else if ($sOpe == 'b')
                    $nResultado = $oPacientes->borrar();
                   
				else 
					$nResultado = $oPacientes->modificar();
					
				if ($nResultado != 1){
					$sError = "Error en bd";
				}
			}catch(Exception $e){
				//Enviar el error específico a la bitácora de php (dentro de php\logs\php_error_log
				error_log($e->getFile()." ".$e->getLine()." ".$e->getMessage(),0);
				$sErr = "Error en base de datos, comunicarse con el administrador";
			}
		}
		else{
			$sErr = "Faltan datos";
		}
	}
	else
		$sErr = "Falta establecer el login";
	
	if ($sErr == "")
		header("Location: tabpacientes.php");
	else
		header("Location: error.php?sError=".$sErr);
	exit();
?>