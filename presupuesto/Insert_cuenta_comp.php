<?include ("../class/conect.php");  include ("../class/funciones.php");
$codigo_cuenta=$_POST["txtCodigo_Cuenta"]; $nombre_cuenta=$_POST["txtNombre_Cuenta"];$codigo_mov=$_POST["txtcodigo_mov"];$debito_credito=$_POST["txtDeb_Cre"];
$descripcion_a="CAUSADO PRESUPUESTARIO";$monto=formato_numero($_POST["txtmonto"]);if(is_numeric($monto)){ $monto_asiento=$monto;} else{$monto_asiento=0;}
$equipo = getenv("COMPUTERNAME");$MInf_Usuario = $equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
   else{   $error=0;   $sSQL="Select * from con001 WHERE codigo_cuenta='$codigo_cuenta'";
      $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado); if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA NO EXISTE');</script><? }
      else{ $registro=pg_fetch_array($resultado);   if ($registro["cargable"]=="N"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA NO ES CARGABLE');</script><?} }
      if ($error==0){ $sSQL="Select * from CON008 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$codigo_cuenta' and debito_credito='$debito_credito'";
         $resultado=pg_exec($conn,$sSQL);   $filas=pg_numrows($resultado);  if ($filas>0){ $error=1;?> <script language="JavaScript">muestra('CODIGO DE CUENTA YA EXISTE');</script> <? }
      }
      if ($error==0){ $resultado=pg_exec($conn,"SELECT INCLUYE_CON008('$codigo_mov','00000000','$debito_credito','$codigo_cuenta','00000','',$monto_asiento,'D','C','S','01','0','$descripcion_a')");
         $error=pg_errormessage($conn);      $error="ERROR GRABANDO: ".substr($error, 0, 61);     if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
      }
}
pg_close();
if ($error==0){?><script language="JavaScript">document.location ='Det_inc_comp_caus.php?codigo_mov=<?echo $codigo_mov?>';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? } ?>
