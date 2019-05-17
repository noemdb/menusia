<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc"); error_reporting(E_ALL);
$nro_orden=$_POST["txtnro_orden"]; $tipo_causado=$_POST["txttipo_causado"]; $fecha_anu = $_POST["txtfecha_anu"]; $descrip_anu = $_POST["txtdescrip_anu"]; $comp_automatico=$_POST["txtcomp_automatico"];
$unidad_sol=""; $equipo = getenv("COMPUTERNAME"); $minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR ANULANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if(pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $error=0; $Nom_Emp=busca_conf();
  if($error==0){$campo502="NNNNNNNNNNNNNNNNNNNN";   $sql="Select campo502,campo503 from SIA005 where campo501='01'"; $resultado=pg_query($sql);
    if ($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];} }
    $gen_ord_ret=substr($campo502,0,1); $gen_comp_ret=substr($campo502,1,1); $gen_pre_ret=substr($campo502,2,1); $ant_presup=substr($campo502,14,1);  $fecha_aut=substr($campo502,5,1);
    $campo502="NNNNNNNNNNNNNNNNNNNN"; $sql="Select campo502,campo503,campo510 from SIA005 where campo501='06'"; $resultado=pg_query($sql);
    if ($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];}} $valida_c=substr($campo502,2,1); $comp_dif=substr($campo502,1,1); if($comp_dif=="S"){$statusc="D";}else{$statusc="A";}
    $l_cat=0; $sql="Select campo503,campo504,campo526 from SIA005 where campo501='05'";    $resultado=pg_query($sql);
    if($registro=pg_fetch_array($resultado,0)){ $formato_presup=$registro["campo504"]; $formato_cat=$registro["campo526"];  $l_cat=strlen($formato_cat);
    if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$$registro["campo503"];}}
  }
  $sql="Select * from PAG001 where nro_orden='$nro_orden' and tipo_causado='$tipo_causado'";  $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
  if($filas==0){$error=1;?><script language="JavaScript">muestra('NUMERO DE ORDEN NO EXISTE');</script><?}
   else { $reg=pg_fetch_array($resultado);  $fecha_causado=$reg["fecha"];  $adescripcion=$reg["concepto"];
     $status=$reg["status"]; $retencion=$reg["retencion"]; $total_ajuste=$reg["total_ajuste"];  $anulado=$reg["anulado"];
     if($anulado=='S'){$error=1;?><script language="JavaScript">muestra('ORDEN YA ESTA ANULADA');</script><?}
     if($error==0){$sfecha=$fecha_causado;if(checkData($fecha_anu)=='1'){$error=0;$afecha=formato_aaaammdd($fecha_anu);} else{$error=1; ?> <script language="JavaScript">muestra('FECHA ANULACION NO ES VALIDA');</script><? }}
     if($error==0){if($afecha<$sfecha){$error=1; ?> <script language="JavaScript">muestra('FECHA ANULACION NO PUEDE SER MENOR A FECHA DE LA ORDEN');</script><? } }
     if($error==0){ $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);  $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer); $afecha=formato_aaaammdd($fecha_anu);
       if (($afecha>$Fec_Fin_Ejer)or($afecha<$Fec_Ini_Ejer)){$error=1;?><script language="JavaScript">muestra('FECHA DE ANULACION INVALIDA');</script><?}
     }
	 if($status=="I"){$error=1;?><script language="JavaScript">muestra('ORDEN DE PAGO ESTA CANCELADA');</script><?}
     if($status=="L"){$error=1;?><script language="JavaScript">muestra('ORDEN DE PAGO ESTA LIBERADA');</script><?}
     if($retencion=="S"){$error=1;?><script language="JavaScript">muestra('ORDEN DE PAGO ES UNA RETENCION');</script><?}
     if($total_ajuste>0){$error=1;?><script language="JavaScript">muestra('ORDEN DE PAGO TIENE AJUSTE');</script><?}
     if(($error==0)and(substr($tipo_causado,0,1)=="A")){$error=1;?><script language="JavaScript">muestra('ORDEN DE PAGO NO PUEDE SER ANULADA');</script><?}
     if($error==0){$nmes=substr($fecha_anu,3, 2); if($SIA_Periodo>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA DE ANULACION MENOR A ULTIMO PERIODO CERRADO');</script><?} }
     if($error==0){
       $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);  $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);
       if (($afecha>$Fec_Fin_Ejer)or($afecha<$Fec_Ini_Ejer)){$error=1;?><script language="JavaScript">muestra('FECHA ANULACION INVALIDA');</script><?}
     }
	 if($error==0){$sql="SELECT referencia_pago,tipo_pago FROM PRE008 WHERE (referencia_caus='$nro_orden') And (tipo_causado='$tipo_causado') and (anulado='N')"; $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
       if($filas>0){$error=1;?><script language="JavaScript">muestra('Tiene Pagos que Refieren al Causado, No puede ser Anulado');</script><?}
     }
     if($error==0){$sql="SELECT cod_banco,nro_cheque FROM PAG007 WHERE (Nro_Orden='$nro_orden') And (tipo_causado='$tipo_causado') and (anulado='N')"; $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
       if($filas>0) {$error=1;?><script language="JavaScript">muestra('Cheque que Refieren a la Orden, No puede ser Anulado');</script><?}
     }
     if($error==0){$sql="SELECT referencia_ajuste,tipo_ajuste FROM PRE011 WHERE (referencia_caus='$nro_orden') And (tipo_causado='$tipo_causado') and (anulado='N')";  $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
       if($filas>0){$error=1;?><script language="JavaScript">muestra('Tiene Ajustes que Refieren al Causado, No puede ser Anulado');</script><?}
     }
	 
     if($error==0){$sql="SELECT ano_fiscal,mes_fiscal,nro_comprobante FROM BAN027 Where (Referencia='$nro_orden') And (Tipo_Mov='O/P') And (Tipo_Operacion<>'A')"; $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
       if($filas>0){$error=1;?><script language="JavaScript">muestra('Existe Comprobante de Retencion IVA Asociado a la Orden');</script><?}
     }
     if($error==0){$sql="SELECT nro_planilla FROM BAN012 Where (Referencia='$nro_orden') And (Tipo_Mov='O/P') And (anulada='N')"; $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
       if($filas>0){$reg=pg_fetch_array($resultado);  $nro_planilla=$reg["nro_planilla"]; $error=1;?><script language="JavaScript">muestra('Existe Comprobante de Retencion Asociado a la Orden');</script><?}
     }
	 if ($error==0){$sql="SELECT nro_orden_ret,nro_cheque_r,tipo_pago_r from PAG004 Where (status_r='I') and (nro_orden_ret='$nro_orden')";  $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
       if ($filas>0){ $reg=pg_fetch_array($resultado); echo "Documento que Cancela: ".$reg["tipo_pago_r"]." Referencia:".$reg["nro_cheque_r"],"<br>"; 
	         $error=1;?><script language="JavaScript">muestra('Orden Tiene Retenciones Cancelada');</script><?}
	 }
     if($error==0){$sql="SELECT * FROM codigos_causados where referencia_caus='$nro_orden' and tipo_causado='$tipo_causado' order by cod_presup"; $res=pg_query($sql); $total=0;$desc_cod="";
        while($registro=pg_fetch_array($res)){$total=$total+$registro["monto"]; $cod_presup=$registro["cod_presup"]; $unidad_sol=substr($cod_presup,0, $l_cat);  $desc_cod=$desc_cod.", CÓDIGO:".$registro["cod_presup"]." FUENTE:".$registro["fuente_financ"]." MONTO:".$registro["monto"];}
     }
	 if(($error==0)and($valida_c=="S")){ $tipo_comp='O'.$tipo_causado;
	    $sql="SELECT referencia,status from con002 Where referencia='$nro_orden' And fecha='$fecha_causado' And tipo_comp='$tipo_comp'"; $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
       if ($filas>0){ $reg=pg_fetch_array($resultado); $mstatusc=$reg["status"]; if($mstatusc=="A"){$error=1;?><script language="JavaScript">muestra('Comprobante Contable de la Orden esta Actualizado, debe cambiar a Diferido');</script><?} }
	 }
     if($error==0){ $sfecha=formato_aaaammdd($sfecha);
       $resultado=pg_exec($conn,"SELECT ANULA_ORDEN('$nro_orden','$tipo_causado','$fecha_causado','$afecha','$descrip_anu','$unidad_sol','$minf_usuario')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);
       if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } else{?><script language="JavaScript">muestra('ANULO EXITOSAMENTE');</script><?
           $desc_doc="ORDEN DE PAGO:  NUMERO:".$nro_orden.",DOCUMENTO:".$tipo_causado.",  DESCRIPCION:".$adescripcion;
           $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('01','$usuario_sia','$usuario_sia','$equipo','Anulo','$afecha','$desc_doc')");
           $error=pg_errormessage($conn);  $error=substr($error, 0, 61);if(!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }}
     }
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING);if($error==0){?><script language="JavaScript"> window.close(); window.opener.location.reload();</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? } ?>