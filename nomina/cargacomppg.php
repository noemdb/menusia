<?include ("../class/conect.php");  include ("../class/funciones.php"); $cod_tipo_per=$_GET["cod_tipo_per"]; $grado=$_GET["grado"]; $paso=$_GET["paso"];  
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0; $monto_compen=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{ $sueldo_paso=0; $sueldo_grado=0; $msuel=0; $mcompen=0;
  $sqlg="SELECT * FROM NOM040 where cod_tipo_personal='$cod_tipo_per' and grado='$grado' and  paso='$paso'"; $resg=pg_query($sqlg); $filasg=pg_num_rows($resg);
  if($filasg>=1){ $registrog=pg_fetch_array($resg,0);   $sueldo_paso=$registrog["monto"]; }   
  $sqlg="SELECT * FROM NOM040 where cod_tipo_personal='$cod_tipo_per' and grado='$grado' and  paso='000'"; $resg=pg_query($sqlg); $filasg=pg_num_rows($resg);
  if($filasg>=1){ $registrog=pg_fetch_array($resg,0);   $sueldo_grado=$registrog["monto"]; }
  if($sueldo_grado==0){ $msuel=$sueldo_paso; } else{ $msuel=$sueldo_grado;  $mcompen=$sueldo_paso-$sueldo_grado;  }  $monto_compen=formato_monto($mcompen);
}
?>
<input class="Estilo10" name="txtcompensacion" type="text" id="txtcompensacion" size="16" maxlength="16" style="text-align:right" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" value="<? echo $monto_compen;?>"  onKeypress="return validarNum(event)">
