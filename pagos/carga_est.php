<?include ("../class/conect.php");  include ("../class/funciones.php");  include ("../class/configura.inc"); $codigo_mov=$_POST["txtcodigo_mov"];
$desest=$_POST["txtdescripcion_est"]; $codest=$_POST["txtcod_est"]; $ref_comp=$_POST["txtref_comp"];  $det_trab=$_POST["txtdet_trab"]; $ced_trab=$_POST["txtced_trab"];
?>
<html>
<head>  <title>CARGAR ESTRUCTURA DE ORDEN</title>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Inc_Orden(mop){ if(mop=='N'){ document.form2.submit(); } else { document.form3.submit(); } }
</script>
</head>
<body>
<?$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }else{ $Nom_Emp=busca_conf(); }
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
$formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX"; $campo502=""; 
$sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];  $campo502=$registro["campo502"];}
$long_c=strlen($formato_presup); $c=strlen($formato_categoria)+2; $p=strlen($formato_partida);  $g_comprobante=substr($campo502,3,1);

$mconf="";$tipo_causd="0002";$tipo_causc="0001";$tipo_causf="0003";$campo502="";$Ssql="Select * from SIA005 where campo501='01'"; $resultado=pg_query($Ssql);
if ($registro=pg_fetch_array($resultado,0)){$mconf=$registro["campo502"];$tipo_causc=$registro["campo504"];$tipo_causd=$registro["campo505"];$tipo_causf=$registro["campo506"];}
$gen_ord_ret=substr($mconf,0,1);$gen_comp_ret=substr($mconf,1,1);$gen_pre_ret=substr($mconf,2,1);$nro_aut=substr($mconf,4,1); $fecha_aut=substr($mconf,5,1);   $comp_automatico=substr($mconf,13,1);
$cedrif="";$tipo_ord="";$nomb="";$concepto_est="";$fecha_d="";$fecha_h="";$tipo_doc="";$nro_doc="";
$sql="SELECT * FROM ESTRUCTURA_ORD where cod_estructura='$codest'";$res=pg_query($sql);  if ($registro=pg_fetch_array($res,0)) {
$cedrif=$registro["ced_rif_est"]; $nomb=$registro["nombre"]; $tipo_ord=$registro["cod_tipo_ord"]; $concepto_est=$registro["concepto_est"]; $fecha_d=$registro["fecha_desde_est"];  $fecha_h=$registro["fecha_hasta_est"]; $tipo_doc=$registro["tipo_documento"]; $nro_doc=$registro["nro_documento"];}
//if($ref_comp=="N"){
$sql="SELECT * FROM pag033 where cod_estructura='$codest' and ced_rif_est='$ced_trab'";$res=pg_query($sql);  if ($registro=pg_fetch_array($res,0)) {
$cedrif=$registro["ced_rif_est"]; $nomb=$registro["nombre_benef_e"]; }
//}
$cedrifest=$cedrif;
if($det_trab=="SI"){ 
if($ref_comp=="N"){$resultado=pg_exec($conn,"SELECT CARGA_PAG006_TRAB('$codigo_mov','$codest','$ced_trab')"); }
else{$resultado=pg_exec($conn,"SELECT CARGA_PAG006_COMP_TRAB('$codigo_mov','$codest','$ced_trab')"); }
echo "SELECT CARGA_PAG006_COMP_TRAB('$codigo_mov','$codest','$ced_trab')";
$reg_e="REGION CENTRO-OCCIDENTAL";$edo_e="LARA";$mun_e="IRIBARREN";$ciu_e="BARQUISIMETO";
$Ssql="Select * from SIA000"; $resultado=pg_query($Ssql);if ($registro=pg_fetch_array($resultado,0)){$reg_e=$registro["campo041"];$edo_e=$registro["campo010"];$mun_e=$registro["campo011"];$ciu_e=$registro["campo009"];}

$sqlb="Select * from PRE099 where ced_rif='$cedrif'"; $res=pg_query($sqlb);$filas=pg_num_rows($res);
if ($filas==0){ $equipo = getenv("COMPUTERNAME");$minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a"); 
  $sSQL="SELECT ACTUALIZA_PRE099(1,'$cedrif','$nomb','$cedrif','','','','','','','$ciu_e','$mun_e','$reg_e','$edo_e','VENEZUELA','','','','','','','','','','','','','','','','','','',0,0,'$minf_usuario')";
  $resultado=pg_exec($conn,$sSQL);  $merror=pg_errormessage($conn);$merror=substr($merror,0,91); 
}
}else{
if($ref_comp=="N"){$resultado=pg_exec($conn,"SELECT CARGA_PAG006('$codigo_mov','$codest')");}
else{$resultado=pg_exec($conn,"SELECT CARGA_PAG006_COMP('$codigo_mov','$codest')");} 
echo "SELECT CARGA_PAG006_COMP('$codigo_mov','$codest')";
}
$resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(1,'$codigo_mov','00000000','0000','$cedrif','$tipo_ord','','NO')");
if($fecha_d==""){$fecha_d="";}else{$fecha_d=formato_ddmmaaaa($fecha_d);}  if($fecha_h==""){$fecha_h="";}else{$fecha_h=formato_ddmmaaaa($fecha_h);}
if($ref_comp=='N'){$res=pg_exec($conn,"UPDATE PRE026 set tipo_compromiso='0000',referencia_comp='00000000' where codigo_mov='$codigo_mov'");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } }
else{if($g_comprobante=="S"){ $sql="Select referencia_comp,tipo_compromiso from pre026 where codigo_mov='$codigo_mov'  group by referencia_comp,tipo_compromiso";  $res=pg_query($sql);
    while(($registro=pg_fetch_array($res))){      $referencia_comp=$registro["referencia_comp"]; $tipo_compromiso=$registro["tipo_compromiso"];
	   $sqlp="Select * from pre006 where tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp'"; $resp=pg_query($sqlp);  
	   if ($regp=pg_fetch_array($resp,0)) { 
	     $genera_comprobante=$regp["genera_comprobante"]; $cod_con_g_pagar=$regp["cod_con_g_pagar"]; 
	     if(($genera_comprobante=="S")and($g_comprobante=="S")){ echo $genera_comprobante;
		 $sqlu="UPDATE PRE026 set cod_con_g_pagar='$cod_con_g_pagar'  where codigo_mov='$codigo_mov' and tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp'";
		 $resu=pg_exec($conn,$sqlu);  $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$resu){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } } 
	    }	   
	}
}}
?>
<form name="form2" method="post" action="Inc_orden_pago.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
	 <td width="5"><input name="txtport" type="hidden" id="txtport" value="<?echo $port?>" ></td>	 
	 <td width="5"><input name="txthost" type="hidden" id="txthost" value="<?echo $host?>" ></td>	 
     <td width="5"><input name="txtnro_aut" type="hidden" id="txtnro_aut" value="<?echo $nro_aut?>" ></td>
     <td width="5"><input name="txtfecha_aut" type="hidden" id="txtfecha_aut" value="<?echo $fecha_aut?>" ></td>
     <td width="5"><input name="txtgen_ord_ret" type="hidden" id="txtgen_ord_ret" value="<?echo $gen_ord_ret?>" ></td>
     <td width="5"><input name="txtgen_comp_ret" type="hidden" id="txtgen_comp_ret" value="<?echo $gen_comp_ret?>" ></td>
     <td width="5"><input name="txtgen_pre_ret" type="hidden" id="txtgen_pre_ret" value="<?echo $gen_pre_ret?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtcomp_automatico" type="hidden" id="txtcomp_automatico" value="<?echo $comp_automatico?>" ></td>
     <td width="5"><input name="txttipo_caus" type="hidden" id="txttipo_caus" value="<?echo $tipo_causd?>" ></td>
     <td width="5"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>" ></td>
     <td width="5"><input name="txtbloqueada" type="hidden" id="txtbloqueada" value="N" ></td>
     <td width="5"><input name="txtcod_est" type="hidden" id="txtcod_est" value="<?echo $codest?>" ></td>
     <td width="5"><input name="txtced_r" type="hidden" id="txtced_r" value="<?echo $cedrifest?>"></td>
     <td width="5"><input name="txtnomb_r" type="hidden" id="txtnomb_r" value="<?echo $nomb?>"></td>
     <td width="5"><input name="txtcon_est" type="hidden" id="txtcon_est" value="<?echo $concepto_est?>"></td>
     <td width="5"><input name="txttipo_doc" type="hidden" id="txttipo_doc" value="<?echo $tipo_doc?>"></td>
     <td width="5"><input name="txtnro_doc" type="hidden" id="txtnro_doc" value="<?echo $nro_doc?>"></td>
     <td width="5"><input name="txttipo_ord" type="hidden" id="txttipo_ord" value="<?echo $tipo_ord?>"></td>
     <td width="5"><input name="txtfecha_d" type="hidden" id="txtfecha_d" value="<?echo $fecha_d?>"></td>
     <td width="5"><input name="txtfecha_h" type="hidden" id="txtfecha_h" value="<?echo $fecha_h?>"></td>
	 <td width="5"><input name="txtfecha_fin" type="hidden" id="txtfecha_fin" value="<?echo $Fec_Fin_Ejer?>"></td>
	 <td width="5"><input name="txtfecha_v" type="hidden" id="txtfecha_v" value=""></td>	
	 <td width="5"><input name="txtcod_emp" type="hidden" id="txtcod_emp" value="<?echo $Cod_Emp?>" ></td> 
	 <td width="5"><input name="txtnro_ord" type="hidden" id="txtnro_ord" value=""></td>
  </tr>
</table>
</form>
<form name="form3" method="post" action="Inc_ord_pago_comp.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser2" type="hidden" id="txtuser2" value="<?echo $user?>" ></td>
     <td width="5"><input name="txtpassword2" type="hidden" id="txtpassword2" value="<?echo $password?>" ></td>
     <td width="5"><input name="txtdbname2" type="hidden" id="txtdbname2" value="<?echo $dbname?>" ></td>
	 <td width="5"><input name="txtport2" type="hidden" id="txtport2" value="<?echo $port?>" ></td>	 
	 <td width="5"><input name="txthost2" type="hidden" id="txthost2" value="<?echo $host?>" ></td>	 
     <td width="5"><input name="txtnro_aut2" type="hidden" id="txtnro_aut2" value="<?echo $nro_aut?>" ></td>
     <td width="5"><input name="txtfecha_aut2" type="hidden" id="txtfecha_aut2" value="<?echo $fecha_aut?>" ></td>
     <td width="5"><input name="txtgen_ord_ret2" type="hidden" id="txtgen_ord_ret2" value="<?echo $gen_ord_ret?>" ></td>
     <td width="5"><input name="txtgen_comp_ret2" type="hidden" id="txtgen_comp_ret2" value="<?echo $gen_comp_ret?>" ></td>
     <td width="5"><input name="txtgen_pre_ret2" type="hidden" id="txtgen_pre_ret2" value="<?echo $gen_pre_ret?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtcomp_automatico2" type="hidden" id="txtcomp_automatico2" value="<?echo $comp_automatico?>" ></td>
     <td width="5"><input name="txttipo_caus2" type="hidden" id="txttipo_caus2" value="<?echo $tipo_causc?>" ></td>
     <td width="5"><input name="txtcodigo_mov2" type="hidden" id="txtcodigo_mov2" value="<?echo $codigo_mov?>" ></td>
     <td width="5"><input name="txtbloqueada2" type="hidden" id="txtbloqueada2" value="S" ></td>
     <td width="5"><input name="txtcod_est2" type="hidden" id="txtcod_est2" value="<?echo $codest?>" ></td>
	 <td width="5"><input name="txtced_r2" type="hidden" id="txtced_r2" value="<?echo $cedrif?>"></td>
     <td width="5"><input name="txtnomb_r2" type="hidden" id="txtnomb_r2" value="<?echo $nomb?>"></td>
     <td width="5"><input name="txtcon_est2" type="hidden" id="txtcon_est2" value="<?echo $concepto_est?>"></td>
     <td width="5"><input name="txttipo_doc2" type="hidden" id="txttipo_doc2" value="<?echo $tipo_doc?>"></td>
     <td width="5"><input name="txtnro_doc2" type="hidden" id="txtnro_doc2" value="<?echo $nro_doc?>"></td>
     <td width="5"><input name="txttipo_ord2" type="hidden" id="txttipo_ord2" value="<?echo $tipo_ord?>"></td>
     <td width="5"><input name="txtfecha_d2" type="hidden" id="txtfecha_d2" value="<?echo $fecha_d?>"></td>
     <td width="5"><input name="txtfecha_h2" type="hidden" id="txtfecha_h2" value="<?echo $fecha_h?>"></td>
	 <td width="5"><input name="txtfecha_v2" type="hidden" id="txtfecha_v2" value=""></td>
	 <td width="5"><input name="txtfecha_fin2" type="hidden" id="txtfecha_fin2" value="<?echo $Fec_Fin_Ejer?>"></td>
	 <td width="5"><input name="txtcod_emp2" type="hidden" id="txtcod_emp2" value="<?echo $Cod_Emp?>" ></td>
	 <td width="5"><input name="txtnro_ord2" type="hidden" id="txtnro_ord2" value=""></td>
  </tr>
</table>
</form>
</body>
</html>
<?pg_close();
/* */
if ($error==0){?><script language="JavaScript">Llamar_Inc_Orden('<? echo $ref_comp; ?>');</script> <? }
else {?>  <script language="JavaScript">history.back();</script> <? }

?>