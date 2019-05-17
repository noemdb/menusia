<?include ("../class/seguridad.inc");  include ("../class/conects.php");  include ("../class/funciones.php"); 
$ced_rif=$_GET["Gced_rif"];$equipo = getenv("COMPUTERNAME");$minf_usuario = $equipo." ".date("d/m/y H:i a");$fecha=asigna_fecha_hoy();
echo "ESPERE POR FAVOR ELIMINANDO....","<br>";$error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $error=0; $sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
  if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
  if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="01"; $opcion="01-0000035"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
   if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
  }$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{$error=1;} if($Mcamino{6}=="S"){$error=0;}else{$error=1;} if($error==1){?><script language="JavaScript"> muestra(' NO TIENE DERECHOS PARA EJECUTAR ESTA OPCION'); </script><?}
 }
 if($error==0){$sSQL="Select * from PRE099 WHERE ced_rif='$ced_rif'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CEDULA/RIF DE BENEFICIARIO NO EXISTE'); </script> <? }
   else{ $registro=pg_fetch_array($resultado,0); $nom_ant=$registro["nombre"];    
    $sSQL = "SELECT cod_presup FROM PRE006 WHERE (ced_rif='$ced_rif')";    $resultado=pg_exec($conn,$sSQL);    $filas=pg_numrows($resultado);
    if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('BENEFICIARIO TIENE COMPROMISOS, NO PUEDE SER ELIMINADO');</script><?}
    $sSQL = "SELECT cod_presup FROM PAG001 WHERE (ced_rif='$ced_rif')";    $resultado=pg_exec($conn,$sSQL);    $filas=pg_numrows($resultado);
    if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('BENEFICIARIO TIENE ORDENES DE PAGO, NO PUEDE SER ELIMINADO');</script><?}	
	$sSQL = "SELECT cod_presup FROM BAN006 WHERE (ced_rif='$ced_rif')";    $resultado=pg_exec($conn,$sSQL);    $filas=pg_numrows($resultado);
    if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('BENEFICIARIO TIENE CHEQUES, NO PUEDE SER ELIMINADO');</script><?}	
	$sSQL = "SELECT cod_presup FROM BAN012 WHERE (ced_rif='$ced_rif')";    $resultado=pg_exec($conn,$sSQL);    $filas=pg_numrows($resultado);
    if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('BENEFICIARIO TIENE PLANILLA DE RETENCION, NO PUEDE SER ELIMINADO');</script><?}	
	$sSQL = "SELECT cod_presup FROM BAN027 WHERE (ced_rif='$ced_rif')";    $resultado=pg_exec($conn,$sSQL);    $filas=pg_numrows($resultado);
    if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('BENEFICIARIO TIENE PLANILLA DE RETENCION IVA, NO PUEDE SER ELIMINADO');</script><?}	
   }
  if($error==0){$error=1;  if($fecha==""){$sfecha="2007-01-01";}else{$sfecha=formato_aaaammdd($fecha);}
     $sSQL="SELECT ACTUALIZA_PRE099(3,'$ced_rif','','','','','','','','','','','','','','','','','','','','','','','','','$sfecha','','','','','','',0,0,'$minf_usuario')";
     $resultado=pg_exec($conn,$sSQL);    $error=pg_errormessage($conn);   $error=substr($error, 0, 61);
     if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
      else{?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><? $error=0;   $desc_doc="CEDULA/RIF:".$ced_rif.",  NOMBRE BENEFICIARIO:".$nom_ant;
        $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('01','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");  $error=pg_errormessage($conn);  $error=substr($error, 0, 61);
        if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <?}}
  }
}
pg_close(); ?> <script language="JavaScript"> window.close(); window.opener.location.reload();  </script>