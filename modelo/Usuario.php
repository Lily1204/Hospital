<?php
/*
Archivo:  Usuario.php
Objetivo: clase que encapsula la información de un usuario
Autor:    
*/
include_once("AccesoDatos.php");
include_once("PersonalHospitalario.php");
class Usuario{
	private $nClave = 0;
	private $sPwd = "";
	private $oPersonalHosp = null;
	private $oAD = null;

	public function getPersHosp(){
		return $this->oPersonalHosp;
	}
	public function setPersHosp($valor){
		$this->oPersonalHosp = $valor;
	}

	public function getClave(){
		return $this->nClave;
	}
	public function setClave($valor){
		$this->nClave = $valor;
	}

	public function getPwd(){
		return $this->sPwd;
	}
	public function setPwd($valor){
		$this->sPwd = $valor;
	}
	
	public function buscarCvePwd(){
	$bRet = false;
	$sQuery = "";
	$arrRS = null;
		if (($this->nClave == 0 || $this->sPwd == "") )
			throw new Exception("Usuario->buscar: faltan datos");
		else{
			$sQuery = "SELECT t1.nIdPersonal 
					   FROM usuario t1
					   WHERE t1.nCveUsu = ".$this->nClave."
					   AND t1.sContrasenia = '".$this->sPwd."'";
			//Crear, conectar, ejecutar, desconectar
			$oAD = new AccesoDatos();
			if ($oAD->conectar()){
				$arrRS = $oAD->ejecutarConsulta($sQuery);
				$oAD->desconectar();
				if ($arrRS != null){
					$this->oPersonalHosp = new PersonalHospitalario();
					$this->oPersonalHosp->setIdPersonal($arrRS[0][0]);
					$this->oPersonalHosp->buscar();
					$bRet = true;
				}
			}
		}
		return $bRet;
	}
}
?>