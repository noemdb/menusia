<?include ("../class/conect.php");  include ("../class/funciones.php"); $codigo_mov=$_POST["txtcodigo_mov"];
$desest=$_POST["txtdescripcion_est"]; $codest=$_POST["txtcod_est"]; $ref_comp=$_POST["txtref_comp"];
?>
<html>
<head>  <title>CARGAR ESTRUCTURA DE ORDEN</title>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Inc_Orden(mop){ if(mop=='N'){ document.form2.submit(); } else { document.form3.submit(); } }
</script>
</head>
<body>
<?$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if ($codigo_mov==""){$codigo_mov="";}
else{
 $res=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $res=pg_exec($conn,"SELECT BORRAR_PAG028('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $resultado=pg_exec($conn,"SELECT ELIMINA_CON008('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG029(4,'$codigo_mov','','','','','2007-01-01',0,0,0,0,0,0,0,0,0,0,0,0,0,0,'','','','','')");$error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(3,'$codigo_mov','00000000','0000','','','','NO')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG030 (4,'$codigo_mov','','',0)");  $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $resultado=pg_exec($conn,"SELECT BORRAR_PAG038 ('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
}
$mconf="";$tipo_causd="0002";$tipo_causc="0001";$tipo_causf="0003";$Ssql="Select * from SIA005 where campo501='01'"; $resultado=pg_query($Ssql);
if ($registro=pg_fetch_array($resultado,0)){$mconf=$registro["campo502"];$tipo_causc=$registro["campo504"];$tipo_causd=$registro["campo505"];$tipo_causf=$registro["campo506"];}
$gen_ord_ret=substr($mconf,0,1);$gen_comp_ret=substr($mconf,1,1);$gen_pre_ret=substr($mconf,2,1);$nro_aut=substr($mconf,4,1); $fecha_aut=substr($mconf,5,1);
$cedrif="";$tipo_ord="";$nomb="";$concepto_est="";$fecha_d="";$fecha_h="";$tipo_doc="";$nro_doc="";
$sql="SELECT * FROM ESTRUCTURA_ORD where cod_estructura='$codest'";$res=pg_query($sql);  if ($registro=pg_fetch_array($res,0)) {
$cedrif=$registro["ced_rif_est"]; $nomb=$registro["nombre"]; $tipo_ord=$registro["cod_tipo_ord"]; $concepto_est=$registro["concepto_est"]; $fecha_d=$registro["fecha_desde_est"];  $fecha_h=$registro["fecha_hasta_est"]; $tipo_doc=$registro["tipo_documento"]; $nro_doc=$registro["nro_documento"];}
if($ref_comp=="N"){$resultado=pg_exec($conn,"SELECT CARGA_PAG006('$codigo_mov','$codest')");}else{$resultado=pg_exec($conn,"SELECT CARGA_PAG006_COMP('$codigo_mov','$codest')"); echo "SELECT CARGA_PAG006_COMP('$codigo_mov','$codest')";}
$resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(1,'$codigo_mov','00000000','0000','$cedrif','$tipo_ord','','NO')");
if($fecha_d==""){$fecha_d="";}else{$fecha_d=formato_ddmmaaaa($fecha_d);}  if($fecha_h==""){$fecha_h="";}else{$fecha_h=formato_ddmmaaaa($fecha_h);}


?>
<form name="form2" method="post" action="Inc_orden_pago.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
     <td width="5"><input name="txtnro_aut" type="hidden" id="txtnro_aut" value="<?echo $nro_aut?>" ></td>
     <td width="5"><input name="txtfecha_aut" type="hidden" id="txtfecha_aut" value="<?echo $fecha_aut?>" ></td>
     <td width="5"><input name="txtgen_ord_ret" type="hidden" id="txtgen_ord_ret" value="<?echo $gen_ord_ret?>" ></td>
     <td width="5"><input name="txtgen_comp_ret" type="hidden" id="txtgen_comp_ret" value="<?echo $gen_comp_ret?>" ></td>
     <td width="5"><input name="txtgen_pre_ret" type="hidden" id="txtgen_pre_ret" value="<?echo $gen_pre_ret?>" ></td>
     <td width="5"><input name="txttipo_caus" type="hidden" id="txttipo_caus" value="<?echo $tipo_causd?>" ></td>
     <td width="5"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>" ></td>
     <td width="5"><input name="txtbloqueada" type="hidden" id="txtbloqueada" value="N" ></td>
     <td width="5"><input name="txtcod_est" type="hidden" id="txtcod_est" value="<?echo $codest?>" ></td>
     <td width="5"><input name="txtced_r" type="hidden" id="txtced_r" value="<?echo $cedrif?>"></td>
     <td width="5"><input name="txtnomb_r" type="hidden" id="txtnomb_r" value="<?echo $nomb?>"></td>
     <td width="5"><input name="txtcon_est" type="hidden" id="txtcon_est" value="<?echo $concepto_est?>"></td>
     <td width="5"><input name="txttipo_doc" type="hidden" id="txttipo_doc" value="<?echo $tipo_doc?>"></td>
     <td width="5"><input name="txtnro_doc" type="hidden" id="txtnro_doc" value="<?echo $nro_doc?>"></td>
     <td width="5"><input name="txttipo_ord" type="hidden" id="txttipo_ord" value="<?echo $tipo_ord?>"></td>
     <td width="5"><input name="txtfecha_d" type="hidden" id="txtfecha_d" value="<?echo $fecha_d?>"></td>
     <td width="5"><input name="txtfecha_h" type="hidden" id="txtfecha_h" value="<?echo $fecha_h?>"></td>
  </tr>
</table>
</form>
<form name="form3" method="post" action="Inc_ord_pago_comp.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser2" type="hidden" id="txtuser2" value="<?echo $user?>" ></td>
     <td width="5"><input name="txtpassword2" type="hidden" id="txtpassword2" value="<?echo $password?>" ></td>
     <td width="5"><input name="txtdbname2" type="hidden" id="txtdbname2" value="<?echo $dbname?>" ></td>
     <td width="5"><input name="txtnro_aut2" type="hidden" id="txtnro_aut2" value="<?echo $nro_aut?>" ></td>
     <td width="5"><input name="txtfecha_aut2" type="hidden" id="txtfecha_aut2" value="<?echo $fecha_aut?>" ></td>
     <td width="5"><input name="txtgen_ord_ret2" type="hidden" id="txtgen_ord_ret2" value="<?echo $gen_ord_ret?>" ></td>
     <td width="5"><input name="txtgen_comp_ret2" type="hidden" id="txtgen_comp_ret2" value="<?echo $gen_comp_ret?>" ></td>
     <td width="5"><input name="txtgen_pre_ret2" type="hidden" id="txtgen_pre_ret2" value="<?echo $gen_pre_ret?>" ></td>
     <td width="5"><input name="txttipo_caus2" type="hidden" id="txttipo_caus2" value="<?echo $tipo_causc?>" ></td>
     <td width="5"><input name="txtcodigo_mov2" type="hidden" id="txtcodigo_mov2" value="<?echo $codigo_mov?>" ></td>
     <td width="5"><input name="txtbloqueada2" type="hidden" id="txtbloqueada2" value="N" ></td>
     <td width="5"><input name="txtcod_est2" type="hidden" id="txtcod_est2" value="<?echo $codest?>" ></td>
	 <td width="5"><input name="txtced_r2" type="hidden" id="txtced_r2" value="<?echo $cedrif?>"></td>
     <td width="5"><input name="txtnomb_r2" type="hidden" id="txtnomb_r2" value="<?echo $nomb?>"></td>
     <td width="5"><input name="txtcon_est2" type="hidden" id="txtcon_est2" value="<?echo $concepto_est?>"></td>
     <td width="5"><input name="txttipo_doc2" type="hidden" id="txttipo_doc2" value="<?echo $tipo_doc?>"></td>
     <td width="5"><input name="txtnro_doc2" type="hidden" id="txtnro_doc2" value="<?echo $nro_doc?>"></td>
     <td width="5"><input name="txttipo_ord2" type="hidden" id="txttipo_ord2" value="<?echo $tipo_ord?>"></td>
     <td width="5"><input name="txtfecha_d2" type="hidden" id="txtfecha_d2" value="<?echo $fecha_d?>"></td>
     <td width="5"><input name="txtfecha_h2" type="hidden" id="txtfecha_h2" value="<?echo $fecha_h?>"></td>
  </tr>
</table>
</form>
</body>
</html>
<?pg_close();

if ($error==0){?><script language="JavaScript">Llamar_Inc_Orden('<? echo $ref_comp; ?>');</script> <? }
else {?>  <script language="JavaScript">history.back();</script> <? }

?>
