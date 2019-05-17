<?include ("../class/conect.php"); include ("../class/funciones.php");
$campo501=$_POST["txtcod_modulo"]; $campo502="S"; $campo503=$_POST["txtperiodo"];  $campo506="";  $campo573="S";
$campo504=$_POST["txtdoc_comp"]; $campo507=$_POST["txttip_comp"]; $campo505=$_POST["txtdoc_comps"]; $campo508=$_POST["txttip_comps"];$campo509=$_POST["txtcod_impuesto"]; $campo510=$_POST["txtdoc_ajus"];
$campo=$_POST["txtnro_req"];$campo=substr($campo,0,1);$campo502=$campo502.$campo;$campo=$_POST["txtreq_ap"];$campo=substr($campo,0,1);$campo502=$campo502.$campo;
$campo=$_POST["txtref_aut"];$campo=substr($campo,0,1);$campo502=$campo502.$campo;$campo=$_POST["txtfecha_aut"];$campo=substr($campo,0,1);$campo502=$campo502.$campo;
$campo=$_POST["txtval_marca"];$campo=substr($campo,0,1);$campo502=$campo502.$campo;$campo=$_POST["txtmod_cod_presup"];$campo=substr($campo,0,1);$campo502=$campo502.$campo;

$campo="NS";$campo=substr($campo,0,2);$campo502=$campo502.$campo;
$campo=$_POST["txtnro_reqs"];$campo=substr($campo,0,1);$campo502=$campo502.$campo;$campo=$_POST["txtreq_aps"];$campo=substr($campo,0,1);$campo502=$campo502.$campo;
$campo=$_POST["txtref_auts"];$campo=substr($campo,0,1);$campo502=$campo502.$campo;$campo=$_POST["txtfecha_auts"];$campo=substr($campo,0,1);$campo502=$campo502.$campo;
$campo=$_POST["txtmod_cod_presups"];$campo=substr($campo,0,1);$campo502=$campo502.$campo; $campo="S";$campo=substr($campo,0,1);$campo502=$campo502.$campo;
$campo=$_POST["txtref_autr"];$campo=substr($campo,0,1);$campo502=$campo502.$campo;$campo=$_POST["txtfecha_autr"];$campo=substr($campo,0,1);$campo502=$campo502.$campo;
$campo="NNN";$campo=substr($campo,0,3);$campo502=$campo502.$campo;

$campo=$_POST["txtimp_unico"];$campo=substr($campo,0,1);$campo573=$campo573.$campo;IF($_POST["txtcod_imp"]=="PARTIDA"){$campo="S";}else{$campo="N";}$campo573=$campo573.$campo;
$campo="NN";$campo=substr($campo,0,2);$campo573=$campo573.$campo;

$url="Act_Conf_Compras.php"; echo "ESPERE POR FAVOR MODIFICANDO....","<br>"; $error=0; $fecha=asigna_fecha_hoy(); if($fecha==""){$sfecha="2007-01-01";}else{$sfecha=formato_aaaammdd($fecha);}
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $sSQL="Select * from SIA005 where campo501='$campo501'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CONFIGURACIÓN NO EXISTE');</script> <? }
   else{$sql="SELECT MODIFICA_SIA005('$campo501','$campo502','$campo503','$campo504','$campo505','$campo506','$campo507','$campo508','$campo509','$campo510','','','','','','','','','','','','','','','','','','','','','','','',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','','','','','$campo573')"; $resultado=pg_exec($conn,$sql);$error=pg_errormessage($conn); $error=substr($error, 0, 61);
     if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? } else{ ?> <script language="JavaScript"> muestra('MODIFICO EXITOSAMENTE'); </script><? $error=0; }
  }
}pg_close(); ?>  <script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>

