<?php
/*
Archivo:  PersonalHospitalario.php
Objetivo: clase que encapsula la información de una persona que labora en el hospital
Autor:    
*/
include_once("AccesoDatos.php");
include_once("Persona.php");
class Pacientes extends Persona{
	
	private $nIdPac=0;
	
	//Constantes para mejor lectura de código
	CONST TIPO_MED = 1;
	CONST TIPO_ADMISION = 2;
	CONST TIPO_ADMOR = 3;
   
    
   
    function setIdPac($pnIdPac){
       $this->nIdPac = $pnIdPac;
    }   
    function getIdPac(){
       return $this->nIdPac;
    }
	
	/*Busca por clave, regresa verdadero si lo encontró*/
	function buscar(){
	$oAccesoDatos=new AccesoDatos();
	$sQuery="";
	$arrRS=null;
	$bRet = false;
		if ($this->nIdPac==0)
			throw new Exception("Paciente->buscar(): faltan datos");
		else{
			if ($oAccesoDatos->conectar()){
		 		$sQuery = " SELECT sNombre, sApePat, sApeMat, dFecNacim, 
								  sSexo, sAlergias 
							FROM paciente 
							WHERE nIdPac = ".$this->nIdPac;
				$arrRS = $oAccesoDatos->ejecutarConsulta($sQuery);
				$oAccesoDatos->desconectar();
				if ($arrRS){
					$this->sNombre = $arrRS[0][0];
					$this->sApePat = $arrRS[0][1];
					$this->sApeMat = $arrRS[0][2];
					$this->dFechaNacim = DateTime::createFromFormat('Y-m-d',$arrRS[0][3]);
					$this->sSexo = $arrRS[0][4];
					$this->sAlergias = $arrRS[0][5];
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
		    $this->sSexo == "" OR $this->sAlergias == "" OR $this->dFechaNacim==null)
			throw new Exception("Pacientes->insertar(): faltan datos");
		else{
			if ($oAccesoDatos->conectar()){
			
		 		$sQuery = "INSERT INTO paciente (sNombre, sApePat, sApeMat, 
											dFecNacim, sSexo, sAlergias) 
					VALUES ('".$this->sNombre."', 
					'".$this->sApePat."', 
					".($this->sApeMat==""?"null":"'".$this->sApeMat."'").",
					'".$this->dFechaNacim->format('Y-m-d')."', 
					'".$this->sSexo."', 
					'".$this->sAlergias."');";
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
		if ($this->nIdPac==0 OR $this->sNombre == "" OR $this->sApePat == "" OR 
		    $this->sSexo == "" OR $this->sAlergias == "" OR $this->dFechaNacim==null)
			throw new Exception("Pacientes->modificar(): faltan datos");
		else{
			if ($oAccesoDatos->conectar()){
		 		$sQuery = "UPDATE paciente 
					SET sNombre= '".$this->sNombre."' , 
					sApePat= '".$this->sApePat."' , 
					sApeMat= ".($this->sApeMat==""?"null":"'".$this->sApeMat."'").",
					dFecNacim = '".$this->dFechaNacim->format('Y-m-d')."',
					sSexo = '".$this->sSexo."', 
					sAlergias = '".$this->sAlergias."'
					WHERE nIdPac = ".$this->nIdPac;
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
		if ($this->nIdPac==0)
			throw new Exception("Pacientes->borrar(): faltan datos");
		else{
			if ($oAccesoDatos->conectar()){
				
		 		$sQuery = "DELETE FROM paciente
							WHERE nIdPac = ".$this->nIdPac;
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
	$oPacientes=null;
	$arrResultado=false;
		if ($oAccesoDatos->conectar()){
			
		 	$sQuery = "SELECT nIdPac,sNombre, sApePat, sApeMat, dFecNacim,  ssexo, sAlergias
			 from paciente
			 ORDER BY nIdPac";
				
			$arrRS = $oAccesoDatos->ejecutarConsulta($sQuery);
			
			$oAccesoDatos->desconectar();
			
			if ($arrRS){
				
				foreach($arrRS as $aLinea){
					
					$oPacientes = new Pacientes();
					
					$oPacientes->setIdpac($aLinea[0]);
					$oPacientes->setNombre($aLinea[1]);
					$oPacientes->setApePat($aLinea[2]);
					$oPacientes->setApeMat($aLinea[3]);
					$oPacientes->setFechaNacim(DateTime::createFromFormat('Y-m-d',$aLinea[4]));
					$oPacientes->setsexo($aLinea[5]);
					$oPacientes->setAlergias($aLinea[6]);
            		$arrResultado[$j] = $oPacientes;
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