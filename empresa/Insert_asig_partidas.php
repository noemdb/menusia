<?include ("../class/conect.php");  include ("../class/funciones.php"); $formato_presup="XX-XX-XX-XXX-XX-XX-XX"; $formato_categoria="XX-XX-XX";
$login=$_POST["txtusuario"];$cod_presup=$_POST["txtcod_presup"];$fuente_financ=$_POST["txtcod_fuente"]; $fecha=asigna_fecha_hoy();$equipo = getenv("COMPUTERNAME");$MInf_Usuario = $equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR INCLUYENDO....","<br>"; $url="Det_asig_part.php?musuario=".$login;
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql);  $filas=pg_num_rows($resultado);
  if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"]; $formato_categoria=$registro["campo526"]; $formato_partida=$registro["campo527"];}    
  $long_c=strlen($formato_presup); $lc=strlen($formato_categoria); $c=strlen($formato_categoria)+2; $p=strlen($formato_partida); $error=0;
  $sSQL="Select * from SIA008 WHERE usuario='$login' and cod_presup='$cod_presup' and cod_fuente='$fuente_financ'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO YA EXISTE EN EL MOVIMIENTO');</script><? }
   else{
    if((strlen($cod_presup)==strlen($formato_presup))or(strlen($cod_presup)>=strlen($formato_categoria))){
	  $sSQL="Select * from pre001 WHERE cod_presup='$cod_presup' and cod_fuente='$fuente_financ'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO NO EXISTE');  </script> <? }}
    else{$error=1; ?> <script language="JavaScript"> muestra('LONGITUD DE CODIGO PRESUPUESTARIO INVALIDA');</script><? }
    if($error==0){ $sSQL="Select * from PRE095 WHERE cod_fuente_financ='$fuente_financ'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE FUENTE NO EXISTE');</script><? }
    }
    if($error==0){$sfecha=formato_aaaammdd($fecha);
	  $sql="SELECT ACTUALIZA_SIA008(1, '$login','$cod_presup','$fuente_financ', '', '', '', '', '', 0, 0)";
	  $resultado=pg_exec($conn,$sql); $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61);    if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
    }
  }
}
pg_close();
if ($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script> <? }else {?>  <script language="JavaScript">history.back();</script> <? } ?>