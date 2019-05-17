<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../presupuesto/Ver_dispon.php"); include ("../class/configura.inc");   error_reporting(E_ALL); $periodo="01";
$codigo_mov=$_POST["txtcodigo_mov"]; $fecha=$_POST["txtFecha"]; $fecha_reg=$_POST["txtFecha_reg"]; $nusuario_sia=$_POST["txtusuario_sia"]; $afecta_p=$_POST["txtafect_pre"]; 
$url="Act_int_contab.php"; $ced_rif="G-20009014-6";
$unidad_sol="";$cod_banco='0000';$equipo = getenv("COMPUTERNAME");$minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
if (checkData($fecha)=='1'){$error=0;}else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE MOVIMIENTO NO ES VALIDA');</script><? }
if (checkData($fecha_reg)=='1'){$error=0;}else{$error=1; ?> <script language="JavaScript">muestra('FECHA REGISTRO NO ES VALIDA');</script><? }
if ($error==0){  $sfecha=formato_aaaammdd($fecha);  $rfecha=$sfecha; 
  $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
  if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
  if ($SIA_Definicion=="N"){$error=1;?><script language="JavaScript">muestra('ETAPA DE DEFINICIÒN ABIERTA');</script><?} $periodom=$SIA_Periodo;  $nmes=substr($fecha,3, 2);  
  if($error==0){ $l_cat=0;  $sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql);
    if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_cat=$registro["campo526"];$l_cat=strlen($formato_cat);}  } 
  $sql="Select campo502,campo503,campo510 from SIA005 where campo501='06'"; $resultado=pg_query($sql);
  if ($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; if ($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];}} 
 
  if($error==0){  $sSQL="Select * from CON012 where text(fecha_mov)='$sfecha' "; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
    if($filas>0){$error=1;?> <script language="JavaScript"> muestra('FECHA DE MOVIMIENTO YA PROCESADO');  </script>  <? }
  }
  if($periodom<$SIA_Periodo){$periodom=$SIA_Periodo;}if($periodom>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA DE MES MENOR A ULTIMO PERIODO CERRADO');</script><?}
 
  if($error==0){$total_mov=0; $t_debe=0; $t_haber=0; $balance=0;
    $sSQL="SELECT * FROM con014 where (codigo_mov='$codigo_mov') order by num_asiento,to_number(num_linea,'999999')"; $res=pg_query($sSQL);
	while($registro=pg_fetch_array($res)){ $monto_asiento=$registro["monto_mov"];  $monto_a=formato_monto($monto_asiento);  $dc=$registro["debito_credito"];
		if($monto_asiento<0){$monto_asiento=$monto_asiento*-1; if($dc=="D"){$dc="C";}else{$dc="D";}}
		if ($dc=="D"){$t_debe=$t_debe+$monto_asiento;}else{$t_haber=$t_haber+$monto_asiento;}
	} $total_mov=$t_debe; $balance=$t_debe-$t_haber; $balance=formato_monto($balance); $balance=cambia_coma_numero($balance);
	if($total_mov==0){$error=1;?><script language="JavaScript">muestra('MONTO TOTAL DEL MOVIMIENTO INVALIDO');</script><?}
	if($balance==0){$error=$error;}else{$error=1; echo $balance.' '.$t_debe.' '.$t_haber;  ?> <script language="JavaScript"> muestra('MOVIMIENTO NO CUADRA');</script><? }
 }
  if($error==0){ $t_debe=0; $t_haber=0;$balance=0;
    $sql="SELECT * FROM CON016  where codigo_mov='$codigo_mov' order by debito_credito desc,cod_cuenta"; $res=pg_query($sql);
    while($registro=pg_fetch_array($res)){ $monto_asiento=$registro["monto_asiento"]; $dc=$registro["debito_credito"]; $codigo_cuenta=$registro["cod_cuenta"];
    	if($dc=="D"){$t_debe=$t_debe+$monto_asiento;}else{$t_haber=$t_haber+$monto_asiento;}
        $sSQL="Select * from con001 WHERE codigo_cuenta='$codigo_cuenta'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); 
         if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA NO EXISTE');</script><? }
       else{ $reg=pg_fetch_array($resultado); if ($reg["cargable"]=="N"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA NO ES CARGABLE');</script><?} }

    } $balance=$t_debe-$t_haber; $balance=formato_monto($balance); $balance=cambia_coma_numero($balance); $dif=$total_mov-$t_debe;
    if($balance==0){$error=0;}else{$error=1; echo $balance.' '.$t_debe.' '.$t_haber; ?> <script language="JavaScript"> muestra('COMPROBANTE CONTABLE NO CUADRA');</script><? }
    if(($t_debe==0)or(($total_mov<>$t_debe)and($dif>0.001))){$error=1;  echo $total_mov.' '.$t_debe.' '.$t_haber; ?> <script language="JavaScript"> muestra('MONTO DEL COMPROBANTE CONTABLE NO VALIDO');</script><? }
  }
  if($error==0){ $fecha_pre=$fecha;  if($afecta_p=="SI"){$fecha_pre=$fecha_reg;}
    $sql="Select cod_presup,fuente_financ,sum(monto) as monto_c from CODIGOS_PRE026 where codigo_mov='$codigo_mov' group by cod_presup,fuente_financ"; $res=pg_query($sql); $total=0;
    while(($registro=pg_fetch_array($res))and($error==0)){
      $total=$total+$registro["monto_c"];$cod_presup=$registro["cod_presup"];$fuente_financ=$registro["fuente_financ"]; $monto_c=$registro["monto_c"];
      if (verifica_disponibilidad($conn,$cod_presup,$fuente_financ,$fecha_pre,$monto_c)==0){$error=0;}
         else{$error=1;?><script language="JavaScript">muestra('ERRRO EN EL CODIGO PRESUPUESTARIO:<? echo $cod_presup; ?> FUENTE:<? echo $fuente_financ; ?>');</script><?}
      }
 }	  
 if($error==0){ $rfecha=formato_aaaammdd($fecha); 
   if (($sfecha>$Fec_Fin_Ejer)or($sfecha<$Fec_Ini_Ejer)){$error=1;?><script language="JavaScript">muestra('FECHA DE MOVIMIENTO INVALIDA');</script><?}
   if (($rfecha>$Fec_Fin_Ejer)or($rfecha<$Fec_Ini_Ejer)){$error=1;?><script language="JavaScript">muestra('FECHA DE REGISTRO INVALIDA');</script><?}
 }
 if($error==0){ $resultado=pg_exec($conn,"SELECT INCLUYE_CON012('$codigo_mov','$fecha','$fecha_reg','$ced_rif','$nusuario_sia','$minf_usuario')");$error=pg_errormessage($conn);
     if (!$resultado){ echo $error; $error=substr($error,0,91); ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
      else{?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><? } }
}pg_close();error_reporting(E_ALL ^ E_WARNING);
if ($error==0){?><script language="JavaScript">document.location='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}
?>
