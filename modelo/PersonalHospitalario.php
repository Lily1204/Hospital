<?php
/*
Archivo:  PersonalHospitalario.php
Objetivo: clase que encapsula la información de una persona que labora en el hospital
Autor:    
*/
include_once("AccesoDatos.php");
include_once("Persona.php");
class PersonalHospitalario extends Persona{
	private $nTipo=0;
	private $nIdPersonal=0;
	
	//Constantes para mejor lectura de código
	CONST TIPO_MED = 1;
	CONST TIPO_ADMISION = 2;
	CONST TIPO_ADMOR = 3;
   
    function setTipo($pnTipo){
       $this->nTipo = $pnTipo;
    }
    function getTipo(){
       return $this->nTipo;
    }
   
    function setIdPersonal($pnIdPersonal){
       $this->nIdPersonal = $pnIdPersonal;
    }   
    function getIdPersonal(){
       return $this->nIdPersonal;
    }
	
	/*Busca por clave, regresa verdadero si lo encontró*/
	function buscar(){
	$oAccesoDatos=new AccesoDatos();
	$sQuery="";
	$arrRS=null;
	$bRet = false;
		if ($this->nIdPersonal==0)
			throw new Exception("PersonalHospitalario->buscar(): faltan datos");
		else{
			if ($oAccesoDatos->conectar()){
		 		$sQuery = " SELECT sNombre, sApePat, sApeMat, dFecNacim, 
								  sSexo, nTipo 
							FROM personalHospitalario 
							WHERE nIdPersonal = ".$this->nIdPersonal;
				$arrRS = $oAccesoDatos->ejecutarConsulta($sQuery);
				$oAccesoDatos->desconectar();
				if ($arrRS){
					$this->sNombre = $arrRS[0][0];
					$this->sApePat = $arrRS[0][1];
					$this->sApeMat = $arrRS[0][2];
					$this->dFechaNacim = DateTime::createFromFormat('Y-m-d',$arrRS[0][3]);
					$this->sSexo = $arrRS[0][4];
					$this->nTipo = $arrRS[0][5];
					$bRet = true;
				}
			} 
		}
		return $bRet;
	}
	/*Insertar, regresa el número de registros agregados*/
	function insertar(){
	$oAccesoDatos=new AccesoDatos();
	$sQuery="";
	$nAfectados=-1;
		if ($this->sNombre == "" OR $this->sApePat == "" OR 
		    $this->sSexo == "" OR $this->nTipo == 0 OR $this->dFechaNacim==null)
			throw new Exception("PersonalHospitalario->insertar(): faltan datos");
		else{
			if ($oAccesoDatos->conectar()){
		 		$sQuery = "INSERT INTO personalHospitalario (sNombre, sApePat, sApeMat, 
											dFecNacim, sSexo, nTipo) 
					VALUES ('".$this->sNombre."', '".$this->sApePat."', 
					".($this->sApeMat==""?"null":"'".$this->sApeMat."'").",
					'".$this->dFechaNacim->format('Y-m-d')."', 
					'".$this->sSexo."', ".$this->nTipo.");";
				$nAfectados = $oAccesoDatos->ejecutarComando($sQuery);
				$oAccesoDatos->desconectar();			
			}
		}
		return $nAfectados;
	}
	
	/*Modificar, regresa el número de registros modificados*/
	function modificar(){
	$oAccesoDatos=new AccesoDatos();
	$sQuery="";
	$nAfectados=-1;
		if ($this->nIdPersonal==0 OR $this->sNombre == "" OR $this->sApePat == "" OR 
		    $this->sSexo == "" OR $this->nTipo == 0 OR $this->dFechaNacim==null)
			throw new Exception("PersonalHospitalario->modificar(): faltan datos");
		else{
			if ($oAccesoDatos->conectar()){
		 		$sQuery = "UPDATE PersonalHospitalario 
					SET sNombre= '".$this->sNombre."' , 
					sApePat= '".$this->sApePat."' , 
					sApeMat= ".($this->sApeMat==""?"null":"'".$this->sApeMat."'").",
					dFecNacim = '".$this->dFechaNacim->format('Y-m-d')."',
					sSexo = '".$this->sSexo."', 
					nTipo = ".$this->nTipo."
					WHERE nIdPersonal = ".$this->nIdPersonal;
				$nAfectados = $oAccesoDatos->ejecutarComando($sQuery);
				$oAccesoDatos->desconectar();
			}
		}
		return $nAfectados;
	}
	
	/*Borrar, regresa el número de registros eliminados*/
	function borrar(){
	$oAccesoDatos=new AccesoDatos();
	$sQuery="";
	$nAfectados=-1;
		if ($this->nIdPersonal==0)
			throw new Exception("PersonalHospitalario->borrar(): faltan datos");
		else{
			if ($oAccesoDatos->conectar()){
		 		$sQuery = "DELETE FROM PersonalHospitalario 
							WHERE nIdPersonal = ".$this->nIdPersonal;
				$nAfectados = $oAccesoDatos->ejecutarComando($sQuery);
				$oAccesoDatos->desconectar();
			}
		}
		return $nAfectados;
	}
	
	/*Busca todos los registros del personal hospitalario, 
	 regresa falso si no hay información o un arreglo de PersonalHospitalario*/
	function buscarTodos(){
	$oAccesoDatos=new AccesoDatos();
	$sQuery="";
	$arrRS=null;
	$aLinea=null;
	$j=0;
	$oPersHosp=null;
	$arrResultado=false;
		if ($oAccesoDatos->conectar()){
		 	$sQuery = "SELECT nIdPersonal,sNombre, sApePat, sApeMat, 
							  dFecNacim, sSexo, nTipo 
				FROM personalHospitalario 
				ORDER BY nIdPersonal";
			$arrRS = $oAccesoDatos->ejecutarConsulta($sQuery);
			$oAccesoDatos->desconectar();
			if ($arrRS){
				foreach($arrRS as $aLinea){
					$oPersHosp = new PersonalHospitalario();
					$oPersHosp->setIdPersonal($aLinea[0]);
					$oPersHosp->setNombre($aLinea[1]);
					$oPersHosp->setApePat($aLinea[2]);
					$oPersHosp->setApeMat($aLinea[3]);
					$oPersHosp->setFechaNacim(DateTime::createFromFormat('Y-m-d',$aLinea[4]));
					$oPersHosp->setSexo($aLinea[5]);
					$oPersHosp->setTipo($aLinea[6]);
            		$arrResultado[$j] = $oPersHosp;
					$j=$j+1;
                }
			}
			else
				$arrResultado = false;
        }
		return $arrResultado;
	}
}
?>