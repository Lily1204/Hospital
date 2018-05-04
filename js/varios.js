function evalua(oNombre, oApePat, rbSexo, oFecha){
var sErr="";
var bRet = false;

	if (oNombre.disabled==false && oNombre.value=="")
		sErr= sErr + "\n Falta nombre";

	if (oApePat.disabled==false && oApePat.value=="")
		sErr= sErr + "\n Falta apellido paterno";

	if (rbSexo[0].checked==false && rbSexo[1].checked==false)
		sErr= sErr + "\n Falta indicar sexo";

	if (oFecha.disabled==false && oFecha.value=="")
		sErr= sErr + "\n Falta fecha de nacimiento";
	
	if (sErr == "")
		bRet = true;
	else
		alert(sErr);
	
	return bRet;
}