<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc"); error_reporting(E_ALL);
$nro_orden=$_POST["txtnro_orden"]; $tipo_causado=$_POST["txttipo_causado"];  $fecha_hoy=asigna_fecha_hoy();
$fecha_c=$_POST["txtfecha_canc"]; $nro_cheque=$_POST["txtnro_cheque"]; $cod_banco=$_POST["txtcod_banco"];

$unidad_sol=""; $equipo = getenv("COMPUTERNAME"); $minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR ANULANDO....","<br>";
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if(pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $error=0; $Nom_Emp=busca_conf();
  if($error==0){ $l_cat=0; $sql="Select campo503,campo504,campo526 from SIA005 where campo501='05'";    $resultado=pg_query($sql);
    if($registro=pg_fetch_array($resultado,0)){ $formato_presup=$registro["campo504"]; $formato_cat=$registro["campo526"];  $l_cat=strlen($formato_cat);
    if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$$registro["campo503"];}}
  }
  $sql="Select * from ORD_PAGO_ANT where nro_orden='$nro_orden' and tipo_causado='$tipo_causado'";  $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
  if($filas==0){$error=1;?><script language="JavaScript">muestra('NUMERO DE ORDEN NO EXISTE');</script><?}
   else { $reg=pg_fetch_array($resultado);  $status=$reg["status"]; $fecha_causado=$reg["fecha"];
	 /*
	 if($status=="I"){$error=1;?><script language="JavaScript">muestra('ORDEN DE PAGO ESTA CANCELADA');</script><?}
     */
	 if($cod_banco=="0000"){ $nro_cheque=""; $status="N"; $fecha_c=$fecha_hoy; $mmens="ELIMINO CANCELACION EXITOSAMENTE";}
	 else{  $status="I"; $mmens="CANCELO EXITOSAMENTE";
	   $sSQL="SELECT cod_banco,cod_contable,activa,fecha_activa,fecha_desactiva FROM ban002 WHERE cod_banco='$cod_banco'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
        if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE BANCO  NO EXISTE');</script><? }
       else{$registro=pg_fetch_array($resultado,0); $codc_bancoA=$registro["cod_contable"]; }
	 
	 }
	 
     if($error==0){$sfecha=$fecha_causado;if(checkData($fecha_c)=='1'){$error=0;$afecha=formato_aaaammdd($fecha_c);} else{$error=1; ?> <script language="JavaScript">muestra('FECHA ANULACION NO ES VALIDA');</script><? }}
     if($error==0){if($afecha<$sfecha){$error=1; ?> <script language="JavaScript">muestra('CANCELACION NO PUEDE SER MENOR A FECHA DE LA ORDEN');</script><? } }
     if($error==0){$nmes=substr($fecha_c,3, 2); if($SIA_Periodo>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA CANCELACION MENOR A ULTIMO PERIODO CERRADO');</script><?} }
     if($error==0){
       $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);  $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);
       if (($afecha>$Fec_Fin_Ejer)or($afecha<$Fec_Ini_Ejer)){$error=1;?><script language="JavaScript">muestra('FECHA CANCELACION INVALIDA');</script><?}
     }
     if($error==0){ $SQL="Update pag022 set status='$status',cod_banco='$cod_banco',nro_cheque='$nro_cheque',fecha_cheque='$fecha_c' where nro_orden='$nro_orden' and tipo_causado='$tipo_causado'"; 
       $resultado=pg_exec($conn,$SQL);  $error=pg_errormessage($conn); $error=substr($error, 0, 61);
       if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } else{?><script language="JavaScript">muestra('<?echo $mmens?>');</script><?}
	   
     }
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING);if($error==0){?><script language="JavaScript"> window.close(); window.opener.location.reload();</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? } ?>