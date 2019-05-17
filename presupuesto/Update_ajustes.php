<?include ("../class/conect.php");  include ("../class/funciones.php");error_reporting(E_ALL);
$referencia_ajuste=$_POST["txtreferencia_ajuste"];$tipo_ajuste=$_POST["txttipo_ajuste"];
$referencia_pago=$_POST["txtreferencia_pago"];$tipo_pago=$_POST["txttipo_pago"];
$referencia_caus=$_POST["txtreferencia_caus"];$tipo_causado=$_POST["txttipo_causado"];
$referencia_comp=$_POST["txtreferencia_comp"];$tipo_compromiso=$_POST["txttipo_compromiso"];
$fecha_ajuste=$_POST["txtfecha"];$descripcion_ajuste=$_POST["txtdescrip_aju"];

$equipo = getenv("COMPUTERNAME");$minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a");
$tipo_ajuste_p="0003";$tipo_ajuste_a="0002";$tipo_ajuste_c="0001";echo "ESPERE POR FAVOR MODIFICANDO....","<br>";
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from pre011 WHERE referencia_ajuste='$referencia_ajuste' and tipo_ajuste='$tipo_ajuste' and tipo_pago='$tipo_pago' and referencia_pago='$referencia_pago' and tipo_causado='$tipo_causado' and referencia_caus='$referencia_caus' and  tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp'" ;
  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE AJUSTE  NO EXISTE');</script><?}
   else{$registro=pg_fetch_array($resultado);  $fecha_ajuste=$registro["fecha_ajuste"];  $adescripcion=$registro["descripcion"];    $error=0;
    $sSQL="Select * from pre005 WHERE refierea='COMPROMISO'";
    $resultado=pg_exec($conn,$sSQL);    $filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('DOCUMENTO DE AJUSTE A COMPROMISO NO EXISTE');</script><?}
      else{ $registro=pg_fetch_array($resultado); $tipo_ajuste_c=$registro["tipo_ajuste"]; }
    $sSQL="Select * from pre005 WHERE refierea='CAUSADO'";
    $resultado=pg_exec($conn,$sSQL);   $filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('DOCUMENTO DE AJUSTE A CAUSADO NO EXISTE');</script><?}
      else{ $registro=pg_fetch_array($resultado); $tipo_ajuste_a=$registro["tipo_ajuste"]; }
    $sSQL="Select * from pre005 WHERE refierea='PAGO'";
    $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('DOCUMENTO DE AJUSTE A PAGO NO EXISTE');</script><?}
      else{ $registro=pg_fetch_array($resultado); $tipo_ajuste_p=$registro["tipo_ajuste"]; }
   }
  if($error==0){$sql="SELECT * FROM codigos_ajustes where referencia_ajuste='$referencia_ajuste' and tipo_ajuste='$tipo_ajuste' and tipo_pago='$tipo_pago' and referencia_pago='$referencia_pago' and referencia_caus='$referencia_caus' and tipo_causado='$tipo_causado' and tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp' order by cod_presup";
     $res=pg_query($sql); $total=0;$desc_cod="";
     while($registro=pg_fetch_array($res)){ $total=$total+$registro["monto"];
       $desc_cod=$desc_cod.", CÓDIGO:".$registro["cod_presup"]." FUENTE:".$registro["fuente_financ"]." MONTO:".$registro["monto"];
     }
     $sfecha=$fecha_ajuste;
     $resultado=pg_exec($conn,"SELECT MODIFICA_PRE011('$referencia_ajuste','$tipo_ajuste','$referencia_pago','$tipo_pago','$referencia_caus','$tipo_causado','$referencia_comp','$tipo_compromiso','$descripcion_ajuste')");
     $error=pg_errormessage($conn);$error=substr($error, 0, 61);
     if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
      else{?><script language="JavaScript">muestra('MODIFICO EXITOSAMENTE');</script><?
         $desc_doc="MOV.AJUSTE: DOCUMENTO AJUSTE:".$tipo_ajuste.", REFERENCIA AJUSTE:".$referencia_ajuste.", DOCUMENTO PAGO:".$tipo_pago.", REFERENCIA PAGO:".$referencia_pago.", DOCUMENTO CAUSADO:".$tipo_causado.", REFERENCIA CAUSADO:".$referencia_caus.", DOCUMENTO COMPROMISO:".$tipo_compromiso.", REFERENCIA COMPROMISO:".$referencia_comp.", DESCRIPCION:".$adescripcion.", TOTAL:".$total;
         $desc_doc=$desc_doc.$desc_cod;
         $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('05','$usuario_sia','$usuario_sia','$equipo','Modifico','$sfecha','$desc_doc')");
         $error=pg_errormessage($conn);  $error=substr($error, 0, 61);
         if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }}
  }
}
pg_close();error_reporting(E_ALL ^ E_WARNING);
if ($error==0){?><script language="JavaScript">document.location ='Act_ajustes.php?Gcriterio=<? echo $tipo_ajuste.$referencia_ajuste.$tipo_pago.$referencia_pago.$tipo_causado.$referencia_caus.$tipo_compromiso.$referencia_comp; ?>';</script> <? }
else {?>  <script language="JavaScript">history.back();</script> <? } ?>