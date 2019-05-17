<?include ("../class/conect.php");  include ("../class/funciones.php");  error_reporting(E_ALL); $fecha_recep=$_POST["txtfecha_recep"]; $cod_banco=$_POST["txtcod_banco"]; $num_cheque=$_POST["txtnum_cheque"]; $opcion=$_POST["txtopcion"]; $ced_rif_recib=$_POST["txtced_rif_recib"]; $nombre_recib=$_POST["txtnombre_recib"];
$equipo = getenv("COMPUTERNAME");  $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");   echo "ESPERE POR FAVOR MODIFICANDO....","<br>";$error=0; $fecha=asigna_fecha_hoy(); if($fecha==""){$sfecha="2014-01-01";}else{$sfecha=formato_aaaammdd($fecha);}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?>  <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{  $sSQL="Select * from ban006 WHERE (cod_banco='$cod_banco') And (num_cheque='$num_cheque')";  $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?>  <script language="JavaScript">  muestra('NUMERO DE CHEQUE NO EXISTE EN ESTADO DE CHEQUES');  </script> <? }
   else{$registro=pg_fetch_array($resultado); $entregado=$registro["entregado"];  $anulado=$registro["anulado"];  $fecha_anulado=$registro["fecha_anulado"]; $fecha=$registro["fecha"]; $error=0;}
  if($error==0){$fechar=formato_aaaammdd($fecha_recep); if (checkData($fecha_recep)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA NO ES VALIDA');</script><? } }
  if($error==0){if($fechar<$fecha){$error=1; ?> <script language="JavaScript">muestra('FECHA NO PUEDE SER MENOR A FECHA DEL CHEQUE');</script><? } }
  if($error==0){
   if($opcion=="R"){$nombre_recib=$usuario_sia; if(($entregado=="P")and($anulado=="N")){$error=0;}else{$error=1;?><script language="JavaScript">muestra('ESTADO DE CHEQUE NO VALIDO');</script><?}}
   if($opcion=="D"){$nombre_recib=$usuario_sia; if($entregado=="S"){$error=0;}else{$error=1;?><script language="JavaScript">muestra('ESTADO DE CHEQUE NO VALIDO');</script><?}}
   if($opcion=="E"){if(($entregado=="N")or($entregado=="C")){$error=0;}else{$error=1;?><script language="JavaScript">muestra('ESTADO DE CHEQUE NO VALIDO');</script><?}}
  }
  if($error==0){ $sSQL="SELECT ACTUALIZA_BAN006('$opcion','$cod_banco','$num_cheque','$fechar','$ced_rif_recib','$nombre_recib')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);$error=substr($error,0,91);
     if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('MODIFICO EXITOSAMENTE'); </script><?} }
 }
pg_close();error_reporting(E_ALL ^ E_WARNING); if($error==0){?><script language="JavaScript">window.close(); window.opener.location.reload();</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? } ?>
