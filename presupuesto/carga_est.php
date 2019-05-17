<?include ("../class/conect.php");  include ("../class/funciones.php");  include ("../class/configura.inc");
$codigo_mov=$_POST["txtcodigo_mov"]; $desest=$_POST["txtdescripcion_est"]; $codest=$_POST["txtcod_est"]; $ref_comp=$_POST["txtref_comp"]; $fecha_hoy=asigna_fecha_hoy(); 
?>
<html>
<head>  <title>CARGAR ESTRUCTURA DE ORDEN</title>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Inc_Comp(mop){  document.form2.submit();  }
</script>
</head>
<body>
<?$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else{ $Nom_Emp=busca_conf(); }
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
$mconf="";$Ssql="Select * from SIA005 where campo501='05'";$resultado=pg_query($Ssql);
if ($registro=pg_fetch_array($resultado,0)){$mconf=$registro["campo502"];}$nro_aut=substr($mconf,1,1); $fecha_aut=substr($mconf,2,1); $aprueba_comp=substr($mconf,15,1);
$cedrif="";$tipo_ord="";$nomb="";$concepto_est="";$fecha_d="";$fecha_h="";$tipo_doc="";$nro_doc="";$cod_cat="";$referencia="";
$sql="SELECT * FROM ESTRUCTURA_ORD where cod_estructura='$codest'";$res=pg_query($sql);  if ($registro=pg_fetch_array($res,0)) {
$cedrif=$registro["ced_rif_est"]; $nomb=$registro["nombre"]; $tipo_ord=$registro["cod_tipo_ord"]; $concepto_est=$registro["concepto_est"]; $fecha_d=$registro["fecha_desde_est"];  $fecha_h=$registro["fecha_hasta_est"]; $tipo_doc=$registro["tipo_documento"]; $nro_doc=$registro["nro_documento"];}
if($ref_comp=="N"){$resultado=pg_exec($conn,"SELECT CARGA_PAG006('$codigo_mov','$codest')");}
$fecha_f=formato_ddmmaaaa($Fec_Fin_Ejer);  if(FDate($fecha_hoy)>FDate($fecha_f)){$fecha_hoy=$fecha_f;}
if($fecha_d==""){$fecha_d="";}else{$fecha_d=formato_ddmmaaaa($fecha_d);}  if($fecha_h==""){$fecha_h="";}else{$fecha_h=formato_ddmmaaaa($fecha_h);}
$resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(1,'$codigo_mov','$referencia','0000','','','$cod_cat','NO')");
?>

<form name="form2" method="post" action="Inc_compromisos.php">
<table width="10">
  <tr>
     <td width="5"><input class="Estilo10" name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input class="Estilo10" name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input class="Estilo10" name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtport" type="hidden" id="txtport" value="<?echo $port?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txthost" type="hidden" id="txthost" value="<?echo $host?>" ></td>	
     <td width="5"><input name="txtnro_aut" type="hidden" id="txtnro_aut" value="<?echo $nro_aut?>" ></td>
     <td width="5"><input name="txtfecha_aut" type="hidden" id="txtfecha_aut" value="<?echo $fecha_aut?>" ></td>
     <td width="5"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtdoc_comp" type="hidden" id="txtdoc_comp" value=""></td>
	 <td width="5"><input class="Estilo10" name="txtabrev_comp" type="hidden" id="txtabrev_comp" value=""></td>
     <td width="5"><input class="Estilo10" name="txtref_comp" type="hidden" id="txtref_comp" value=""></td>
	 <td width="5"><input class="Estilo10" name="txtcod_cat" type="hidden" id="txtcod_cat" value=""></td>
     <td width="5"><input class="Estilo10" name="txtnomb_cat" type="hidden" id="txtnomb_cat" value=""></td>	 
	 <td width="5"><input class="Estilo10" name="txttipo_comp" type="hidden" id="txttipo_comp" value="000000"></td>
     <td width="5"><input class="Estilo10" name="txtdes_tipo_comp" type="hidden" id="txtdes_tipo_comp" value="COMPROMISOS"></td>
	 <td width="5"><input class="Estilo10" name="txtcon_est" type="hidden" id="txtcon_est" value="00000000" ></td>	 
	 <td width="5"><input name="txtfecha_ini" type="hidden" id="txtfecha_ini" value="<?echo $fecha_d?>" ></td>
	 <td width="5"><input name="txtfecha_fin" type="hidden" id="txtfecha_fin" value="<?echo $fecha_h?>" ></td>	 
	 <td width="5"><input name="txtced_r" type="hidden" id="txtced_r" value="<?echo $cedrif?>"></td>
     <td width="5"><input name="txtnomb_r" type="hidden" id="txtnomb_r" value="<?echo $nomb?>"></td>
	 <td width="5"><input name="txtconcepto_r" type="hidden" id="txtconcepto_r" value="<?echo $concepto_est?>"></td>
	 <td width="5"><input name="txtcod_est" type="hidden" id="txtcod_est" value="<?echo $codest?>" ></td>
	 <td width="5"><input name="txtfechac" type="hidden" id="txtfechac" value="<?echo $fecha_hoy?>"></td>
	 <td width="5"><input name="txtnro_doc" type="hidden" id="txtnro_doc" value=""></td>
	 <td width="5"><input name="txtfechav" type="hidden" id="txtfechav" value="<?echo $fecha_hoy?>"></td>
	 <td width="5"><input name="txttiene_ant" type="hidden" id="txttiene_ant" value="NO"></td>
	 <td width="5"><input name="txtfunc_inv" type="hidden" id="txtfunc_inv" value="C"></td>
	 <td width="5"><input name="txttasa_ant" type="hidden" id="txttasa_ant" value=""></td>
	 <td width="5"><input name="txtcod_cuenta" type="hidden" id="txtcod_cuenta" value=""></td>
  </tr>
</table>
</form>


</body>
</html>
<?pg_close();
if ($error==0){?><script language="JavaScript">Llamar_Inc_Comp('<? echo $ref_comp; ?>');</script> <? }
else {?>  <script language="JavaScript">history.back();</script> <? }
?>