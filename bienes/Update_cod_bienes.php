<?include ("../class/conect.php");  include ("../class/funciones.php");?>
<?include ("Ver_dispon.php");
$codigo_mov=$_POST["txtcodigo_mov"];
$cod_bien=$_POST["txtcod_bien_mue"];
$monto_c=$_POST["txtmonto"];
print_r($monto_c);
if(is_numeric($monto_c)){$monto=$monto_c;} else{$monto=0;}
$equipo = getenv("COMPUTERNAME");
$MInf_Usuario = $equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR MODIFICANDO....","<br>";
$url="Det_inc_bienes.php?codigo_mov=".$codigo_mov;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");;$error=0;
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{
      $sSQL="Select * from BIEN015 WHERE cod_bien_mue='$cod_bien'";
      $resultado=pg_query($sSQL);
      $filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEL BIEN NO EXISTE');</script><? }
  if($error==0)
    {
      $resultado=pg_exec($conn,"SELECT MODIFICA_BIEN050('$codigo_mov','$cod_bien','$monto_c')");
      $error=pg_errormessage($conn);
      $error="ERROR GRABANDO: ".substr($error,0,91); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('MODIFICO EXITOSAMENTE');</script><?}
    }
  }
pg_close();
if ($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script> <? }
else {?>  <script language="JavaScript">history.back();</script> <? } ?>

