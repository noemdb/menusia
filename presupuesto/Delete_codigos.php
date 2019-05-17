<?include ("../class/seguridad.inc"); include ("../class/conects.php");  include ("../class/funciones.php");
$codigo = $_GET["Gcodigo"]; $cod_fuente=substr($codigo,0,2);  $cod_presup=substr($codigo,2,32);$equipo = getenv("COMPUTERNAME"); echo "ESPERE POR FAVOR ELIMINANDO....","<br>"; $error=0;
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $error=0;  $sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U"; if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
    if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="05"; $opcion="01-0000005"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
     if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
    }$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{$error=1;} if($Mcamino{6}=="S"){$error=0;}else{$error=1;} if($error==1){?><script language="JavaScript"> muestra(' NO TIENE DERECHOS PARA EJECUTAR ESTA OPCION'); </script><?}
 }
 if($error==0){ $sSQL="Select * from pre001 WHERE cod_presup='$cod_presup' and cod_fuente='$cod_fuente'"; $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO NO EXISTE');  </script> <? }
   else{  $registro=pg_fetch_array($resultado);     $des_ant=$registro["denominacion"];   $cod_cont_ant=$registro["cod_contable"];  $sfecha=$registro["fecha_creado"];
     if ($registro["asignado"]>0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO TIENE ASIGNACIÓN, NO PUEDE SER ELIMINADO');</script><?}
     else{if ($registro["asignado"]!=$registro["disponible"]){$error=1; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO TIENE MOVIMIENTOS, NO PUEDE SER ELIMINADO');</script><?}}
  }
  if($error==0){ $l=strlen($cod_presup); $sql="select cod_presup from pre001 where substr(cod_presup,1,$l)='$cod_presup' and length(cod_presup)>$l"; $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
	if ($filas>1){$error=1; ?> <script language="JavaScript"> muestra('EXISTEN CODIGOS DE PRESUPUESTARIO CON NIVELES MAYORES');</script> <? } 
  }	
  if($error==0){
    $sSQL = "SELECT cod_presup FROM PRE036 WHERE (cod_presup='$cod_presup') And (fuente_financ='$cod_fuente')";   $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
    if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO TIENE COMPROMISOS, NO PUEDE SER ELIMINADO');</script><?}
    $sSQL = "SELECT cod_presup FROM PRE039 WHERE (cod_presup='$cod_presup') And (fuente_financ='$cod_fuente')"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
    if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO TIENE MODIFICACIONES, NO PUEDE SER ELIMINADO');</script><?}
    $sSQL = "SELECT cod_presup FROM PRE033 WHERE (cod_presup='$cod_presup') And (fuente_financ='$cod_fuente')";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
    if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO TIENE DIFERIDOS, NO PUEDE SER ELIMINADO');</script><?}
  }
  if($error==0){  $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE001(3,'$cod_presup','$cod_fuente','','','',0,0,0,0,'C','O','0','','2007-01-01',0,0,0,0,0,0,0,0,0,0,0,0)");
     $error=pg_errormessage($conn); $error=substr($error, 0, 90); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
      else{$error= "ELIMINO EXITOSAMENTE"; ?><script language="JavaScript"> muestra('<? echo $error; ?>'); </script><?
        $desc_doc="CODIGO PRESUPUETARIO:".$cod_presup.", FUENTE:".$cod_fuente.", DENOMINACION:".$des_ant.", COD.CONTABLE:".$cod_cont_ant;
        $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('05','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')"); $error=pg_errormessage($conn);$error=substr($error, 0,90);if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <?}}
  }
}
pg_close();?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>