<?include ("../class/conect.php"); include ("../class/funciones.php");  include ("../class/configura.inc"); error_reporting(E_ALL);
$referencia_comp = $_POST["txtreferencia_comp"]; $tipo_compromiso = $_POST["txttipo_compromiso"];
$cod_comp = $_POST["txtcod_comp"];$fecha_anu = $_POST["txtfecha_anu"]; $descrip_anu = $_POST["txtdescrip_anu"];
$equipo = getenv("COMPUTERNAME"); $minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR ANULANDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $error=0; $Nom_Emp=busca_conf();
  if($error==0){  $l_cat=0; $sql="Select campo503,campo504,campo526 from SIA005 where campo501='05'";    $resultado=pg_query($sql);
    if($registro=pg_fetch_array($resultado,0)){ $formato_presup=$registro["campo504"]; $formato_cat=$registro["campo526"];  $l_cat=strlen($formato_cat);
    if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$$registro["campo503"];}}
  }
  $sSQL="Select * from pre006 WHERE referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and cod_comp='$cod_comp'";
  $resultado=pg_exec($conn,$sSQL);   $filas=pg_numrows($resultado);
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE COMPROMISO NO EXISTE');</script><?}
   else{$registro=pg_fetch_array($resultado);  $fecha_compromiso=$registro["fecha_compromiso"]; $adescripcion=$registro["descripcion_comp"]; $anulado=$registro["anulado"];
     if($anulado=='S'){$error=1;?><script language="JavaScript">muestra('COMPROMISO YA ESTA ANULADO');</script><?}
     if($error==0){$sfecha=$fecha_compromiso; if (checkData($fecha_anu)=='1'){$error=0;$afecha=formato_aaaammdd($fecha_anu);}
       else{$error=1; ?> <script language="JavaScript">muestra('FECHA ANULACION NO ES VALIDA');</script><? }
     }
     if($error==0){if ($afecha<$sfecha){$error=1; ?> <script language="JavaScript">muestra('FECHA ANULACION NO PUEDE SER MENOR A FECHA DEL COMPROMISO');</script><? }
     }
	 if($error==0){$nmes=substr($fecha_anu,3, 2); if($SIA_Periodo>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA DE ANULACION MENOR A ULTIMO PERIODO CERRADO');</script><?} }
     if($error==0){ $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);  $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer); $afecha=formato_aaaammdd($fecha_anu);
       if (($afecha>$Fec_Fin_Ejer)or($afecha<$Fec_Ini_Ejer)){$error=1;?><script language="JavaScript">muestra('FECHA DE ANULACION INVALIDA');</script><?}
     }
     if($error==0){$resultado=pg_exec($conn,"SELECT ANULA_PRE006('$referencia_comp','$tipo_compromiso','$cod_comp','$sfecha','$afecha','$descrip_anu','$minf_usuario')");
       $error=pg_errormessage($conn); $error=substr($error, 0, 91); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
        else{?><script language="JavaScript">muestra('ANULO EXITOSAMENTE');</script><?
           $desc_doc="MOV.COMPROMISO: DOCUMENTO:".$tipo_compromiso.", REFERENCIA:".$referencia_comp.", DESCRIPCION:".$adescripcion;   $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('05','$usuario_sia','$usuario_sia','$equipo','Anulo','$sfecha','$desc_doc')");
           $error=pg_errormessage($conn);     $error=substr($error, 0, 91);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }}
     }
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING);if ($error==0){?><script language="JavaScript">window.close(); window.opener.location.reload();</script> <? }else {?>  <script language="JavaScript">history.back();</script> <? } ?>