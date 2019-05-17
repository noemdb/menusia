<?include ("../class/conect.php");  include ("../class/funciones.php");include ("../class/configura.inc");error_reporting(E_ALL);
$nro_orden=$_POST["txtnro_orden"]; $tipo_compromiso=$_POST["txttipo_compromiso"]; $fecha_anu = $_POST["txtfecha_anu"]; $descrip_anu = $_POST["txtdescrip_anu"];
$unidad_sol=""; $equipo = getenv("COMPUTERNAME"); $minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR ANULANDO....","<br>";
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if(pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $error=0; $Nom_Emp=busca_conf();
  if($error==0){ $l_cat=0; $sql="Select campo503,campo504,campo526 from SIA005 where campo501='05'";    $resultado=pg_query($sql);
    if($registro=pg_fetch_array($resultado,0)){ $formato_presup=$registro["campo504"]; $formato_cat=$registro["campo526"];  $l_cat=strlen($formato_cat);
    if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$$registro["campo503"];}}  }
  $sSQL="Select * from comp016 WHERE nro_orden='$nro_orden' and tipo_compromiso='$tipo_compromiso'";    $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado); 
  if($filas==0){$error=1;?><script language="JavaScript">muestra('NUMERO ORDEN DE SERVICIO NO EXISTE');</script><?}
   else { $reg=pg_fetch_array($resultado);  $fecha_orden=$reg["fecha_orden"];  $adescripcion=$reg["concepto"];  $anulado=$reg["anulado"]; $cancelada=$reg["cancelada"];
     if($anulado=='S'){$error=1;?><script language="JavaScript">muestra('ORDEN YA ESTA ANULADA');</script><?}
     if($error==0){$sfecha=$fecha_orden;if(checkData($fecha_anu)=='1'){$error=0;$afecha=formato_aaaammdd($fecha_anu);} else{$error=1; ?> <script language="JavaScript">muestra('FECHA ANULACION NO ES VALIDA');</script><? }}
     if($error==0){if($afecha<$sfecha){$error=1; ?> <script language="JavaScript">muestra('FECHA ANULACION NO PUEDE SER MENOR A FECHA DE LA ORDEN');</script><? } }
     if(($error==0)and(substr($tipo_compromiso,0,1)=="A")){$error=1;?><script language="JavaScript">muestra('ORDEN DE SERVICIO NO PUEDE SER ELIMINADA');</script><?}
     if($error==0){$nmes=substr($fecha_anu,3, 2); if($SIA_Periodo>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA DE ANULACION MENOR A ULTIMO PERIODO CERRADO');</script><?} }
     if($error==0){$sql="SELECT referencia_pago,tipo_pago FROM PRE008 WHERE (referencia_comp='$nro_orden') And (tipo_compromiso='$tipo_compromiso') and (anulado='N')"; $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
       if($filas>0){$error=1;?><script language="JavaScript">muestra('Tiene Pagos que Refieren al Compromiso, No puede ser Anulado');</script><?}
     }
     if($error==0){$sql="SELECT referencia_caus FROM PRE007 WHERE (referencia_comp='$nro_orden') And (tipo_compromiso='$tipo_compromiso') and (anulado='N')"; $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
       if($filas>0){$error=1;?><script language="JavaScript">muestra('Tiene Pagos que Refieren al Causado, No puede ser Anulado');</script><?}
     }
     if($error==0){$sql="SELECT referencia_ajuste,tipo_ajuste FROM PRE011 WHERE (referencia_comp='$nro_orden') And (tipo_compromiso='$tipo_compromiso') and (anulado='N')";  $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
       if($filas>0){$error=1;?><script language="JavaScript">muestra('Tiene Ajustes que Refieren al Compromiso, No puede ser Anulado');</script><?}
     }
     if($error==0){$ $sql="SELECT * FROM SER_ORD_SERVICIO where nro_orden='$nro_orden' and tipo_compromiso='$tipo_compromiso' order by nro_linea";  $res=pg_query($sql);
       while($registro=pg_fetch_array($res)){$total=$total+($registro["cantidad"]*$registro["monto"])+$registro["total_iva"];
         $desc_cod=$desc_cod.", SERVICIO:".$registro["cod_servicio"].' '.$registro["concepto_linea"]." CANTIDAD:".$registro["cantidad"]." MONTO:".$registro["monto"]; }
     }
     if($error==0){ $sfecha=formato_aaaammdd($sfecha); $afecha=formato_aaaammdd($fecha_anu); $sql="SELECT ANULA_COMP016('$nro_orden','$tipo_compromiso','$afecha','$descrip_anu','$usuario_sia','$minf_usuario')";
       $resultado=pg_exec($conn,$sql); $error=pg_errormessage($conn); $error=substr($error, 0, 61);
       if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } else{?><script language="JavaScript">muestra('ANULO EXITOSAMENTE');</script><?
           $desc_doc="ORDEN DE SERVICIO:  NUMERO:".$nro_orden.", DESCRIPCION:".$adescripcion.", MONTO ORDEN:".$total;  $desc_doc=$desc_doc.$desc_cod;
           $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('09','$usuario_sia','$usuario_sia','$equipo','Anulo','$afecha','$desc_doc')");
           $error=pg_errormessage($conn);  $error=substr($error, 0, 61);if(!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }}
     }
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING);if($error==0){?><script language="JavaScript">window.close(); window.opener.location.reload();</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? } 
?>