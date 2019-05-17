<?include ("../class/conect.php");  include ("../class/funciones.php");   $nro_orden=$_GET["orden"];  $codigo_mov=$_GET["codigo_mov"];
$monto_a=$_GET["monto"]; $monto_ret=$_GET["monto_ret"]; $monto_pas=$_GET["monto_pas"]; $monto_a=formato_numero($monto_a); if(is_numeric($monto_a)){$monto_a=$monto_a;} else{$monto_a=0;}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $codc_banco=""; $resta_abono=$monto_a+$monto_ret-$monto_pas; $monto_abono=0;
$sql="SELECT * FROM CODIGOS_PRE026 where codigo_mov='$codigo_mov' order by cod_presup";$res=pg_query($sql); //echo $sql;
while($registro=pg_fetch_array($res)){ $monto=$registro["monto"]; $monto_presup=$registro["monto_presup"]; $monto_credito=$registro["monto_credito"];   $amort_anticipo=$registro["amort_anticipo"]; 
  $cod_presup=$registro["cod_presup"]; $cod_presup=$registro["cod_presup"]; $cod_fuente=$registro["fuente_financ"]; $referencia_comp=$registro["referencia_comp"]; 
  $tipo_compromiso=$registro["tipo_compromiso"]; $tipo_imput_presu=$registro["tipo_imput_presu"];  $ref_imput_presu=$registro["ref_imput_presu"];  $m_cod=$monto_presup-$amort_anticipo;
  if(($m_cod>0)and($resta_abono>0)){  if($resta_abono>=$m_cod){$m_cod=$m_cod;}else{$m_cod=$resta_abono;}  
    $resta_abono=$resta_abono-$m_cod;  $monto_abono=$monto_abono+$m_cod;  if($tipo_imput_presu=="P"){$monto_c=0;}else{$monto_c=$m_cod;}
	$monto_c=cambia_coma_numero($monto_c); $m_cod=cambia_coma_numero($m_cod);		
	$resultado=pg_exec($conn,"SELECT  MOD_MONTO_PRE026('$codigo_mov','$cod_presup','$cod_fuente','$referencia_comp','$tipo_compromiso','$ref_imput_presu',$m_cod,$monto_c)"); $merror=pg_errormessage($conn); $error=substr($merror,0,91); 	
  } else{$resultado=pg_exec($conn,"SELECT  MOD_MONTO_PRE026('$codigo_mov','$cod_presup','$cod_fuente','$referencia_comp','$tipo_compromiso','$ref_imput_presu',0,0)"); $merror=pg_errormessage($conn); $error=substr($merror,0,91); }
}	
?><iframe src="Det_inc_cod_chqp.php?codigo_mov=<?echo $codigo_mov?>" width="846" height="290" scrolling="auto" frameborder="0"></iframe>