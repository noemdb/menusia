<?include ("../class/conect.php"); include ("../class/funciones.php");include ("../class/configura.inc"); error_reporting(E_ALL);
$referencia_dife = $_POST["txtreferencia_dife"]; $tipo_diferido = $_POST["txttipo_diferido"]; $fecha_anu = $_POST["txtfecha_anu"]; $descrip_anu = $_POST["txtdescrip_anu"];
$equipo = getenv("COMPUTERNAME"); $minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR ANULANDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $error=0; $Nom_Emp=busca_conf();
  if($error==0){  $l_cat=0; $sql="Select campo503,campo504,campo526 from SIA005 where campo501='05'";    $resultado=pg_query($sql);
    if($registro=pg_fetch_array($resultado,0)){ $formato_presup=$registro["campo504"]; $formato_cat=$registro["campo526"];  $l_cat=strlen($formato_cat);
    if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$$registro["campo503"];}}
  }
  $sSQL="Select * from pre023 WHERE referencia_dife='$referencia_dife' and tipo_diferido='$tipo_diferido'"; $resultado=pg_exec($conn,$sSQL);   $filas=pg_numrows($resultado);
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE MOVIMIENTO DIFERIDO NO EXISTE');</script><?}
   else{   $registro=pg_fetch_array($resultado); $fecha_diferido=$registro["fecha_diferido"];      $adescripcion=$registro["descripcion_dife"]; $anulado=$registro["anulado"];
     $sql="Select * from pre033 WHERE referencia_dife='$referencia_dife' and tipo_diferido='$tipo_diferido'";  $res=pg_query($sql);    $total=0;$desc_cod="";   $sfecha=$fecha_diferido;
     while($registro=pg_fetch_array($res)){ $total=$total+$registro["monto_diferido"];     $desc_cod=$desc_cod.", CODIGO:".$registro["cod_presup"]." FUENTE:".$registro["fuente_financ"]." MONTO:".$registro["monto_diferido"];
     }
     if($anulado=='S'){$error=1;?><script language="JavaScript">muestra('DIFERIDO YA ESTA ANULADO');</script><?}
     if($error==0){$sfecha=$fecha_diferido; if (checkData($fecha_anu)=='1'){$error=0;$afecha=formato_aaaammdd($fecha_anu);}
       else{$error=1; ?> <script language="JavaScript">muestra('FECHA ANULACION NO ES VALIDA');</script><? }
     }
     if($error==0){if ($afecha<$sfecha){$error=1; ?> <script language="JavaScript">muestra('FECHA ANULACION NO PUEDE SER MENOR A FECHA DEL DIFERIDO');</script><? }     }
	 if($error==0){$nmes=substr($fecha_anu,3, 2); if($SIA_Periodo>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA DE ANULACION MENOR A ULTIMO PERIODO CERRADO');</script><?} }
     if($error==0){ $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);  $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer); $afecha=formato_aaaammdd($fecha_anu);
       if (($afecha>$Fec_Fin_Ejer)or($afecha<$Fec_Ini_Ejer)){$error=1;?><script language="JavaScript">muestra('FECHA DE ANULACION INVALIDA');</script><?}
     }
	 if($error==0){  $sql="Select * from pre006 WHERE diferido='S' and ref_aep='$referencia_dife' and tipo_documento='$tipo_diferido'"; $resultado=pg_exec($conn,$sql);   $filas=pg_numrows($resultado);
       if ($filas>=1){ $registro=pg_fetch_array($resultado); $ref_comp=$registro["referencia_comp"]; $tipo_comp=$registro["tipo_compromiso"]; $error=1;?><script language="JavaScript">muestra('MOVIMIENTO DIFERIDO TIENE COMPROMISO, REFERENCIA COMPROMISO: <? echo $ref_comp.' '.$tipo_comp; ?> ');</script><?}
     }  
     if($error==0){$resultado=pg_exec($conn,"SELECT ANULA_pre023('$referencia_dife','$tipo_diferido','$afecha','$descrip_anu','$usuario_sia','$minf_usuario')");  $merror=pg_errormessage($conn);  $merror=substr($merror,0,91);
       if (!$resultado){$error=1;  ?><script language="JavaScript">muestra('<? echo $merror; ?>');</script><? }   else{?><script language="JavaScript">muestra('ANULO EXITOSAMENTE');</script><?
           $desc_doc="MOV.DIFERIDO: DOCUMENTO:".$tipo_diferido.", REFERENCIA:".$referencia_dife.", DESCRIPCION:".$adescripcion;
           $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('05','$usuario_sia','$usuario_sia','$equipo','Anulo','$sfecha','$desc_doc')");  $merror=pg_errormessage($conn);  $merror=substr($merror,0,91); if (!$resultado){$error=1;  ?><script language="JavaScript">muestra('<?echo $merror;?>');</script><? }}
     }
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING);
if ($error==0){?><script language="JavaScript">cerrar_ventana();</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? } ?>