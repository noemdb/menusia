<?include ("../class/conect.php");  include ("../class/funciones.php"); $equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");   $fecha_hoy=asigna_fecha_hoy();
$sueldo_actual=$_POST["txtsueldo_actual"]; $sueldo_nuevo=$_POST["txtsueldo_nuevo"]; $cod_cargod=$_POST["txtcodigo_cargo_d"]; $cod_cargoh=$_POST["txtcodigo_cargo_h"]; $condicion=$_POST["txtcondicion"];
$sueldo_actual=formato_numero($sueldo_actual); if(is_numeric($sueldo_actual)){$sueldo_actual=$sueldo_actual;}else{$sueldo_actual=0;} 
$sueldo_nuevo=formato_numero($sueldo_nuevo); if(is_numeric($sueldo_nuevo)){$sueldo_nuevo=$sueldo_nuevo;}else{$sueldo_nuevo=0;} 
echo "ESPERE POR FAVOR ACTUALIZANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{  $error=0; $existe_ret=0;    
    if($sueldo_actual==0){$error=1; ?> <script language="JavaScript"> muestra('MONTO DE SUELDO ACTUAL INVALIDO');</script><?}
	if($sueldo_nuevo==0){$error=1; ?> <script language="JavaScript"> muestra('MONTO DE SUELDO NUEVO INVALIDO');</script><?}
	if($error==0){ $diferencia=$sueldo_nuevo-$sueldo_actual;  
	  $sql="Select * from NOM004 WHERE (codigo_cargo>='$cod_cargod' and codigo_cargo<='$cod_cargoh') and (sueldo_cargo=$sueldo_actual)"; 
	  If($condicion=="MENOR"){ $sql="Select * from NOM004 WHERE (codigo_cargo>='$cod_cargod' and codigo_cargo<='$cod_cargoh') and (sueldo_cargo<$sueldo_actual)"; }
	  $res=pg_query($sql);
	  while($reg=pg_fetch_array($res)){         $codigo_cargo=$reg["codigo_cargo"];  $sueldo_cargo=$reg["sueldo_cargo"];
		 $sSQL="Update nom004 set sueldo_cargo=$sueldo_nuevo where codigo_cargo='$codigo_cargo'"; $resultado=pg_exec($conn,$sSQL); $errore=pg_errormessage($conn); 		 
		 if(!$resultado){ echo "Actualizando Cargo ".$codigo_cargo." ".$errore,"<br>"; ?><script language="JavaScript">muestra('<? echo substr($errore,0,90); ?>');</script><?  }
		 else{ }	  
	  }	
	}
 }
pg_close(); 
if($error==0){?><script language="JavaScript"> muestra('Proceso Finalizado'); window.close(); window.opener.location.reload(); </script> <?}else{?><script language="JavaScript">history.back();</script><?}
?> 

