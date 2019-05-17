<? include ("../class/seguridad.inc"); include ("../class/conects.php");  include ("../class/funciones.php");  include ("../class/configura.inc"); error_reporting(E_ALL);
$nro_orden=$_GET["txtnro_orden"];  $tipo_causado=$_GET["txttipo_causado"]; $fecha=$_GET["txtfecha"]; $comp_automatico=$_GET["comp_aut"];
$equipo = getenv("COMPUTERNAME"); $minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $error=0;  $Nom_Emp=busca_conf(); 
 $sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U"; if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
 if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="01"; $opcion="02-0000005"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
 $opcion="02-0000010"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$Mcamino.$reg["campo617"]; } else{ $Mcamino=$Mcamino."N";}
 }$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{$error=1;} if($Mcamino{6}=="S"){$error=0;}else{$error=1;} if($error==1){?><script language="JavaScript"> muestra(' NO TIENE DERECHOS PARA EJECUTAR ESTA OPCION'); </script><?}
 //echo $posicion." ".$Mcamino." ".$Mcamino{6},"<br>";
 }
 if($error==0){ $l_cat=0; $sql="Select campo503,campo504,campo526 from SIA005 where campo501='05'";    $resultado=pg_query($sql);
    if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_cat=$registro["campo526"];$l_cat=strlen($formato_cat); if ($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];}}
    $sql="Select campo502,campo503 from SIA005 where campo501='01'"; $resultado=pg_query($sql);  if($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];} } 
    $sql="Select campo502,campo503,campo510 from SIA005 where campo501='06'"; $resultado=pg_query($sql);  if($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; if ($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];}} $valida_c=substr($campo502,2,1);
  
  $sql="Select * from PAG001 where nro_orden='$nro_orden' and tipo_causado='$tipo_causado'";  $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('NUMERO DE ORDEN NO EXISTE');</script><?}
   else { $reg=pg_fetch_array($resultado);  $fecha_causado=$reg["fecha"];  $adescripcion=$reg["concepto"];  $status=$reg["status"]; $retencion=$reg["retencion"]; $total_ajuste=$reg["total_ajuste"];
     $sql="SELECT * FROM codigos_causados where referencia_caus='$nro_orden' and tipo_causado='$tipo_causado' order by cod_presup"; $res=pg_query($sql); $total=0;$desc_cod="";
     while($registro=pg_fetch_array($res)){ $total=$total+$registro["monto"];
       $desc_cod=$desc_cod.", CODIGO:".$registro["cod_presup"]." FUENTE:".$registro["fuente_financ"]." MONTO:".$registro["monto"];}
     if ($status=="I"){$error=1;?><script language="JavaScript">muestra('ORDEN DE PAGO ESTA CANCELADA');</script><?}
     if ($status=="L"){$error=1;?><script language="JavaScript">muestra('ORDEN DE PAGO ESTA LIBERADA');</script><?}
     if ($retencion=="S"){$error=1;?><script language="JavaScript">muestra('ORDEN DE PAGO ES UNA RETENCION');</script><?}
     if ($total_ajuste>0){$error=1;?><script language="JavaScript">muestra('ORDEN DE PAGO TIENE AJUSTE');</script><?}
     if (($error==0)and(substr($tipo_causado,0,1)=="A")){$error=1;?><script language="JavaScript">muestra('ORDEN DE PAGO NO PUEDE SER ELIMINADA');</script><?}
     if ($error==0){$nmes=substr($fecha,3, 2);if ($SIA_Periodo>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA DE ORDEN MENOR A ULTIMO PERIODO CERRADO');</script><?}}
     if ($error==0){$sql="SELECT referencia_pago,tipo_pago FROM PRE008 WHERE (referencia_caus='$nro_orden') and (tipo_causado='$tipo_causado')"; $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
       if($filas>0){$error=1;?><script language="JavaScript">muestra('Tiene Pagos que Refieren al Causado, No puede ser Eliminado');</script><?} }
     if ($error==0){$sql="SELECT cod_banco,nro_cheque FROM PAG007 WHERE (Nro_Orden='$nro_orden') and (tipo_causado='$tipo_causado')"; $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
       if($filas>0){$error=1;?><script language="JavaScript">muestra('Cheque que Refieren a la Orden, No puede ser Eliminado');</script><?}}
     if ($error==0){$sql="SELECT referencia_ajuste,tipo_ajuste FROM PRE011 WHERE (referencia_caus='$nro_orden') and (tipo_causado='$tipo_causado')"; $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
       if ($filas>0){$error=1;?><script language="JavaScript">muestra('Tiene Ajustes que Refieren al Causado, No puede ser Eliminado');</script><?}}
     if($comp_automatico=="S"){
	 if ($error==0){$sql="SELECT ano_fiscal,mes_fiscal,nro_comprobante FROM BAN027 Where (referencia='$nro_orden') And (tipo_mov='O/P')";  $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
       if ($filas>0){$error=1;?><script language="JavaScript">muestra('Existe Comprobante de Retencion IVA Asociado a la Orden');</script><?}}
     
	 if ($error==0){$sql="SELECT nro_planilla FROM BAN012 Where (referencia='$nro_orden') And (tipo_mov='O/P')";  $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
       if ($filas>0){$error=1;?><script language="JavaScript">muestra('Existe Comprobante de Retención Asociado a la Orden');</script><?} }
     }
	 if ($error==0){$sql="SELECT nro_orden_ret,nro_cheque_r,tipo_pago_r from PAG004 Where (status_r='I') and (nro_orden_ret='$nro_orden')";  $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
       if ($filas>0){ $reg=pg_fetch_array($resultado); echo "Documento que Cancela: ".$reg["tipo_pago_r"]." Referencia:".$reg["nro_cheque_r"],"<br>";  $error=1;?><script language="JavaScript">muestra('Orden Tiene Retenciones Cancelada');</script><?}
	 }
	 if(($error==0)and($valida_c=="S")){ $tipo_comp='O'.$tipo_causado;
	    $sql="SELECT referencia,status from con002 Where referencia='$nro_orden' And fecha='$fecha_causado' And tipo_comp='$tipo_comp'"; $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
       if ($filas>0){ $reg=pg_fetch_array($resultado); $mstatusc=$reg["status"]; if($mstatusc=="A"){$error=1;?><script language="JavaScript">muestra('Comprobante Contable de la Orden esta Actualizado, debe cambiar a Diferido');</script><?} }
	 }
	 if($error==0){$sfecha=formato_aaaammdd($fecha); $sqle="SELECT ELIMINA_ORDEN('$nro_orden','$tipo_causado','$sfecha')";
       $resultado=pg_exec($conn,$sqle);  $merror=pg_errormessage($conn);  $merror=substr($error, 0,121);
       if (!$resultado){echo $sqle; $error=1; ?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
        else{ $desc_doc="ORDEN PAGO:  NUMERO:".$nro_orden.", DOCUMENTO CAUSADO:".$tipo_causado.", FECHA:".$fecha.", DESCRIPCION:".$adescripcion.", TOTAL:".$total; $desc_doc=$desc_doc.$desc_cod;
            if($comp_automatico=="S"){ $sql="Delete FROM BAN027 Where (referencia='$nro_orden') And (tipo_mov='O/P')";  $resultado=pg_exec($conn,$sql); $sql="Delete  FROM BAN012 Where (referencia='$nro_orden') And (tipo_mov='O/P')";  $resultado=pg_exec($conn,$sql);}
		    ?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><?
         $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('01','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
         $error=pg_errormessage($conn);   $error=substr($error, 0, 121); if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }}
    }
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING);?> <script language="JavaScript"> window.close(); window.opener.location.reload(); </script>