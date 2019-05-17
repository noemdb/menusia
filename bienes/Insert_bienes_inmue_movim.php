<?include ("../class/conect.php");  include ("../class/funciones.php");include ("../class/configura.inc");error_reporting(E_ALL);
$codigo_mov=$_POST["txtcodigo_mov"];$cod_bien_inm=$_POST["txtcod_bien_inm"];$monto_c=$_POST["txtmonto"]; $codigo=$_POST["txtcodigo"];
$fecha=asigna_fecha_hoy();$monto_c=formato_numero($monto_c);if(is_numeric($monto_c)){$monto=$monto_c;} else{$monto=0;}
$equipo = getenv("COMPUTERNAME");$MInf_Usuario = $equipo." ".date("d/m/y H:i a"); $url="Det_inc_bienes_inmue_movimientos.php?codigo_mov=".$codigo_mov;
echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");$error=0;
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else { $tipo="I";
  $sSQL="Select * from BIEN050 WHERE codigo_mov='$codigo_mov' and cod_bien='$cod_bien_inm'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEL BIEN YA EXISTE EN EL MOVIMIENTO');</script><? }
  if($error==0){ $sSQL="Select * from BIEN014 WHERE cod_bien_inm='$cod_bien_inm'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEL BIEN NO EXISTE');</script><? }  
	    else{  $registro=pg_fetch_array($resultado); $desincorporado=$registro["desincorporado"];  $codigo_cuenta=$registro["cod_contablea"];
		       if($desincorporado=="S"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEL BIEN ESTA DESINCORPORADO');</script><?} }   }
  if($error==0){ $sSQL="Select denomina_tipo,tipo from BIEN003 WHERE codigo='$codigo'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
     if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO TIPO DE MOVIMIENTO NO EXISTE');</script> <? }
	    else{ $registro=pg_fetch_array($resultado); $tipo=$registro["tipo"];}
   }			   
  if($error==0){ $sfecha=formato_aaaammdd($fecha);
      $resultado=pg_exec($conn,"SELECT ACTUALIZA_BIEN050(1,'$codigo_mov','','$sfecha','$cod_bien_inm','$codigo','$tipo','',1,$monto_c,'','$codigo_cuenta',0,0)");
      $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61);
      if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
    }
  }
pg_close();
if ($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script> <? }
else {?>  <script language="JavaScript">history.back();</script> <? } ?>

