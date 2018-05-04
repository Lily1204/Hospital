<?php
/*
Archivo:  Persona.php
Objetivo: clase que encapsula la información de una persona
Autor:    
*/
class Persona{
	protected $sNombre="";
	protected $sApePat="";
	protected $sApeMat="";
	protected $dFechaNacim=null;
    protected $sSexo="";
    protected $sAlergias="";
   
    function setAlergias($psAlergias){
        $this->sAlergias = $psAlergias;
    }
    function getAlergias(){
        return $this->sAlergias;
     }
    function setNombre($psNombre){
       $this->sNombre = $psNombre;
    }
    function getNombre(){
       return $this->sNombre;
    }
   
    function setApePat($psApePat){
       $this->sApePat = $psApePat;
    }   
    function getApePat(){
       return $this->sApePat;
    }
   
    function setApeMat($psApeMat){
       $this->sApeMat = $psApeMat;
    }
    function getApeMat(){
       return $this->sApeMat;
    }
   
    function setFechaNacim($pdFechaNacim){
       $this->dFechaNacim = $pdFechaNacim;
    }
    function getFechaNacim(){
       return $this->dFechaNacim;
    }
   
    function setSexo($psSexo){
       $this->sSexo = $psSexo;
    }
    function getSexo(){
       return $this->sSexo;
    }
	
	function getNombreCompleto(){
		return $this->sApePat." ".$this->sApeMat." ".$this->sNombre;
	}
}
?>