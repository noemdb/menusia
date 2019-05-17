<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL);
$codigo_mov=$_POST["txtcodigo_mov"];$ref_comp=$_POST["txtref_comp"];
$ced_rif=$_POST["txtced_rif"];$nro_factura=$_POST["txtnro_factura"]; $rif_fact=$_POST["txtrif_fact"];
$nro_con_factura=$_POST["txtnro_con_factura"];$fecha_factura=$_POST["txtfecha_factura"];
$monto_sin_iva=$_POST["txtmonto_sin_iva"];$monto_iva1_so=$_POST["txtmonto_iva1_so"]; $monto_iva4_so=$_POST["txtmonto_iva4_so"];
$tasa_iva1=$_POST["txttasa_iva"]; $monto_factura=$_POST["txtmonto_factura"];    $campo_str2=$_POST["txtcampo_str2"];
if($ref_comp=='S'){$ref_compromiso=$_POST["txtreferencia_comp"];$tipo_compromiso=$_POST["txttipo_compromiso"]; $monto_iva3_so=$_POST["txtmonto_iva3_so"];}
else{$ref_compromiso="00000000";$tipo_compromiso="0000"; $monto_iva3_so=0;}
$monto_sin_iva=formato_numero($monto_sin_iva); if(is_numeric($monto_sin_iva)){$monto_sin_iva=$monto_sin_iva;} else{$monto_sin_iva=0;}
$tasa_iva1=formato_numero($tasa_iva1); if(is_numeric($tasa_iva1)){$tasa_iva1=$tasa_iva1;} else{$tasa_iva1=0;}
$monto_iva1_so=formato_numero($monto_iva1_so); if(is_numeric($monto_iva1_so)){$monto_iva1_so=$monto_iva1_so;} else{$monto_iva1_so=0;}
$monto_iva4_so=formato_numero($monto_iva4_so); if(is_numeric($monto_iva4_so)){$monto_iva4_so=$monto_iva4_so;} else{$monto_iva4_so=0;}
$monto_factura=formato_numero($monto_factura); if(is_numeric($monto_factura)){$monto_factura=$monto_factura;} else{$monto_factura=0;}
$monto_iva3_so=formato_numero($monto_iva3_so); if(is_numeric($monto_iva3_so)){$monto_iva3_so=$monto_iva3_so;} else{$monto_iva3_so=0;}
$equipo = getenv("COMPUTERNAME");$MInf_Usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR INCLUYENDO....","<br>";$url="Det_inc_fact_ord.php?codigo_mov=".$codigo_mov."&ref_comp=".$ref_comp."&ced_rif=".$ced_rif;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $error=0;   $sSQL="Select * from PAG029 WHERE codigo_mov='$codigo_mov' and nro_factura='$nro_factura'";$resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('FACTURA YA EXISTE EN LA ORDEN');</script><? }  
  if($error==0){$sSQL="Select nro_orden from PAG016 WHERE rif_factura='$rif_fact' and nro_factura='$nro_factura' and (nro_orden in (select nro_orden from pag001 where ced_rif='$rif_fact' and anulado='N'))";$resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
    if($filas>0){ $reg=pg_fetch_array($resultado); $otra_ord=$reg["nro_orden"]; echo "FACTURA ESTA EN LA ORDEN ".$otra_ord;
	  $error=1; ?> <script language="JavaScript"> muestra('FACTURA YA EXISTE CON OTRA ORDEN');</script><? } }
  if($error==0){ $tmonto_s=$monto_sin_iva; if($tmonto_s<0){ $tmonto_s=$tmonto_s*-1;}    $tmontof=$monto_factura; if($tmontof<0){ $tmontof=$tmontof*-1;}
    if($tmonto_s>$tmontof){$error=1; ?> <script language="JavaScript"> muestra('MONTO CON IVA NO PUEDE SER MENOR A MONTO SIN IVA');</script><?}
    if($monto_iva1_so>$monto_sin_iva){$error=1; ?> <script language="JavaScript"> muestra('MONTO SIN IVA NO PUEDE SER MENOR A MONTO OBJETO');</script><?}
    if(($monto_sin_iva<>$monto_factura)and($tasa_iva1==0)){$error=1; ?> <script language="JavaScript"> muestra('TASA DE IVA INVALIDA');</script><?}
    if (checkData($fecha_factura)=='1'){$error=0;}else{$error=1; ?> <script language="JavaScript">muestra('FECHA FACTURA NO ES VALIDA');</script><? }
    if($error==0){$sSQL="SELECT ced_rif FROM pre099 WHERE ced_rif='$rif_fact'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
      if ($filas==0){$error=1;?><script language="JavaScript">muestra('RIF FACTURA NO EXISTE EN BENEFICIARIO');</script><?}    }
	if($error==0){ $sfecha=formato_aaaammdd($fecha_factura); $monto_iva1=$monto_factura-$monto_sin_iva;  $monto_iva1=cambia_coma_numero($monto_iva1);    
	  $StrSQL="select max(campo_str1) as campo_str1 from pag029 where codigo_mov='$codigo_mov'"; $resultado=pg_query($StrSQL); $filas=pg_num_rows($resultado);
      if($filas>0){$registro=pg_fetch_array($resultado); $nro_linea=$registro["campo_str1"]; } $nro_linea=$nro_linea+1; $nro_linea=Rellenarcerosizq($nro_linea,4);  
	  $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG029(1,'$codigo_mov','$nro_factura','$nro_con_factura','$ref_compromiso','$tipo_compromiso','$sfecha',$monto_sin_iva,$monto_iva1_so,$tasa_iva1,$monto_iva1,0,0,0,$monto_iva3_so,0,0,$monto_iva4_so,0,0,$monto_factura,'$rif_fact','N','N','$nro_linea','$campo_str2')");
      $error=pg_errormessage($conn);$error="ERROR GRABANDO: ".substr($error,0,91); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
    }
  }
}
pg_close();   error_reporting(E_ALL ^ E_WARNING);
if ($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script> <? }else {?>  <script language="JavaScript">history.back();</script> <? } 
?>