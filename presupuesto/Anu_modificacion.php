<?include ("../class/conect.php"); include ("../class/funciones.php");  include ("../class/configura.inc"); error_reporting(E_ALL);
$referencia_modif = $_POST["txtreferencia_modif"]; $tipo_modif = $_POST["txttipo_modif"];$fecha_anu = $_POST["txtfecha_anu"]; $descrip_anu = "";
$equipo = getenv("COMPUTERNAME"); $minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR ANULANDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $error=0; $Nom_Emp=busca_conf();
  if($error==0){  $l_cat=0; $sql="Select campo503,campo504,campo526 from SIA005 where campo501='05'";    $resultado=pg_query($sql);
    if($registro=pg_fetch_array($resultado,0)){ $formato_presup=$registro["campo504"]; $formato_cat=$registro["campo526"];  $l_cat=strlen($formato_cat);
    if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$$registro["campo503"];}}
  }
  $sSQL="Select referencia_modif,descripcion_modif,fecha_registro,anulado,fecha_modif from pre009 WHERE referencia_modif='$referencia_modif' and tipo_modif='$tipo_modif'";
  $resultado=pg_exec($conn,$sSQL);   $filas=pg_numrows($resultado);
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE LA MODIFICACION NO EXISTE');</script><?}
   else{$registro=pg_fetch_array($resultado);  $fecha_modif=$registro["fecha_modif"]; $adescripcion=$registro["descripcion_modif"]; $anulado=$registro["anulado"];
     if($anulado=='S'){$error=1;?><script language="JavaScript">muestra('MODIFICACION YA ESTA ANULADO');</script><?}
     if($error==0){$sfecha=$fecha_modif; if (checkData($fecha_anu)=='1'){$error=0;$afecha=formato_aaaammdd($fecha_anu);}
       else{$error=1; ?> <script language="JavaScript">muestra('FECHA ANULACION NO ES VALIDA');</script><? }
     }
     if($error==0){if ($afecha<$sfecha){$error=1; ?> <script language="JavaScript">muestra('FECHA ANULACION NO PUEDE SER MENOR A FECHA DE LA MODIFICACION');</script><? }
     }
	 if($error==0){$nmes=substr($fecha_anu,3, 2); if($SIA_Periodo>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA DE ANULACION MENOR A ULTIMO PERIODO CERRADO');</script><?} }
     if($error==0){ $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);  $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer); $afecha=formato_aaaammdd($fecha_anu);
       if (($afecha>$Fec_Fin_Ejer)or($afecha<$Fec_Ini_Ejer)){$error=1;?><script language="JavaScript">muestra('FECHA DE ANULACION INVALIDA');</script><?}
     }
     if($error==0){$resultado=pg_exec($conn,"SELECT ANULA_PRE009('$referencia_modif','$tipo_modif','0001','$afecha')");   $error=pg_errormessage($conn); $error=substr($error, 0, 61);
       if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }  else{?><script language="JavaScript">muestra('ANULO EXITOSAMENTE');</script><?
           $desc_doc="MODIFICACION PRESUPUESTARIA, TIPO:".$tipo_modif.", REFERENCIA:".$referencia_modif.", DESCRIPCION:".$adescripcion;
           $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('05','$usuario_sia','$usuario_sia','$equipo','Anulo','$sfecha','$desc_doc')");
           $error=pg_errormessage($conn);     $error=substr($error, 0, 61);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }}
     }
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING);if ($error==0){?><script language="JavaScript">window.close(); window.opener.location.reload();</script> <? }else {?>  <script language="JavaScript">history.back();</script> <? } ?>