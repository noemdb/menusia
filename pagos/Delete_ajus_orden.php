<?include ("../class/seguridad.inc"); include ("../class/conects.php");  include ("../class/funciones.php"); include ("../class/configura.inc"); error_reporting(E_ALL);
$referencia_aju=$_GET["txtreferencia_aju"];  $tipo_ajuste=$_GET["txttipo_ajuste"]; $fecha=$_GET["txtfecha"];
$equipo = getenv("COMPUTERNAME"); $tipo_ajuste_c="0001"; $minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $error=0;  $Nom_Emp=busca_conf();
  $sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
  if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
  if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="01"; $opcion="02-0000015"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
   if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
  }$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{$error=1;} if($Mcamino{6}=="S"){$error=0;}else{$error=1;} if($error==1){?><script language="JavaScript"> muestra(' NO TIENE DERECHOS PARA EJECUTAR ESTA OPCION'); </script><?}

  if($error==0){ $l_cat=0; $sql="Select campo503,campo504,campo526 from SIA005 where campo501='05'";    $resultado=pg_query($sql);
    if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_cat=$registro["campo526"];$l_cat=strlen($formato_cat); if ($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$$registro["campo503"];}}
  $sSQL="Select * from pre005 WHERE refierea='COMPROMISO'"; $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('DOCUMENTO DE AJUSTE A COMPROMISO NO EXISTE');</script><?} else{ $registro=pg_fetch_array($resultado); $tipo_ajuste_c=$registro["tipo_ajuste"]; }
  $sql="Select * from PAG019 WHERE referencia_aju_ord='$referencia_aju'"; $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA AJUSTE DE ORDEN NO EXISTE');</script><?}
   else { $reg=pg_fetch_array($resultado); $fecha_ajuste=$reg["fecha_aju_ord"];  $adescripcion=$reg["descripcion"]; $total_ajuste=$reg["monto_aju_ord"]; $tipo_causado=$reg["tipo_causado"];  $referencia_caus=$reg["nro_orden"]; }
     $sql="SELECT * FROM codigos_ajustes where tipo_ajuste='$tipo_ajuste' and referencia_ajuste='$referencia_aju' and  tipo_causado='$tipo_causado' and referencia_caus='$referencia_caus' order by cod_presup";
     $res=pg_query($sql); $total=0;$desc_cod="";
     while($registro=pg_fetch_array($res)){ $total=$total+$registro["monto"]; $desc_cod=$desc_cod.", CODIGO:".$registro["cod_presup"]." FUENTE:".$registro["fuente_financ"]." MONTO:".$registro["monto"];     }
     if (($error==0)and(substr($tipo_ajuste,0,1)=="A")){$error=1;?><script language="JavaScript">muestra('AJUSTE A ORDEN NO PUEDE SER ELIMINADA');</script><?}
     if ($error==0){ $nmes=substr($fecha,3, 2);
        if ($SIA_Periodo>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA AJUSTE DE ORDEN MENOR A ULTIMO PERIODO CERRADO');</script><?}
     }
     if($error==0){ $sfecha=formato_aaaammdd($fecha);
       $resultado=pg_exec($conn,"SELECT ELIMINA_PAG019('$referencia_aju','$tipo_ajuste','$tipo_ajuste_c')");$error=pg_errormessage($conn);  $error=substr($error,0,91);
       if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?} else{?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><?
         $desc_doc="AJUSTE ORDEN DE PAGO:  REFERENCIA:".$referencia_aju.", DOCUMENTO AJUSTE:".$tipo_ajuste.", FECHA:".$fecha.", DESCRIPCION:".$adescripcion.", TOTAL:".$total;$desc_doc=$desc_doc.$desc_cod;
         $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('01','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
         $error=pg_errormessage($conn);   $error=substr($error,0,91); if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }}
     }
   } 
}
pg_close(); error_reporting(E_ALL ^ E_WARNING);?> <script language="JavaScript">  window.close(); window.opener.location.reload(); </script>    