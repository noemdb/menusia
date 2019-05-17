<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc"); include ("../presupuesto/Ver_dispon.php"); $codigo_mov=$_GET["codigo_mov"]; ?>
<html>
<head>  <title>PEGAR MOVIMIENTO EN LIBRO EN LIBROS</title>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Inc_Orden(mref_comp){ if(mref_comp=="S"){document.form3.submit();}else{document.form2.submit();} }
</script>
</head>
<body>
<?$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else{ $Nom_Emp=busca_conf(); }
$resultado=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')"); $merror=pg_errormessage($conn); $merror=substr($merror, 0, 91);
$resultado=pg_exec($conn,"SELECT BORRAR_BAN035('$codigo_mov')");  $merror=pg_errormessage($conn); $merror=substr($merror, 0, 91);
$nombre_banco="";$nro_cuenta="";$des_tipo_mov="";$referencia="";$cod_banco=""; $tipo_mov="";$nombre_benef=""; $ced_rif=""; $descripcion=""; $monto_mov_libro=0; $fecha=""; $inf_usuario=""; $anulado="N"; $mes_conciliacion="00"; $fecha_anulado="";  $inf_anul=""; $por_emision=""; $cod_bancoa=""; $referenciaa=""; $mop='M';
$cod_busca="BAN004".$usuario_sia; $error=0;
$sql="Select * from pre030 Where codigo_mov='$cod_busca'"; $res=pg_query($sql); $filas=pg_num_rows($res);
if($filas>0){$registro=pg_fetch_array($res); 
  $referencia=$registro["referencia_comp"];  $cod_banco=$registro["tipo_compromiso"];  $tipo_mov=$registro["cod_comp"]; 
  $fecha=$registro["fecha_compromiso"];   $descripcion=$registro["descripcion_comp"]; $monto_mov_libro=$registro["monto_anticipo"];
  $referenciaa=$registro["ref_aep"];  $cod_bancoa=$registro["cod_tipo_comp"]; $ced_rif=$registro["ced_rif"];
  }
if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);} $monto_mov_libro=formato_monto($monto_mov_libro);
$sSQL="SELECT ced_rif,nombre from pre099 WHERE ced_rif='$ced_rif'"; $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
if ($filas>=1){$registro=pg_fetch_array($resultado); $nombre_benef=$registro["nombre"];}
$sSQL="SELECT * from ban002 WHERE cod_banco='$cod_banco'"; $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
if ($filas>=1){$registro=pg_fetch_array($resultado); $nombre_banco=$registro["nombre_banco"];$nro_cuenta=$registro["nro_cuenta"];}
$sSQL="SELECT * from ban003 WHERE tipo_movimiento='$tipo_mov'"; $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
if ($filas>=1){$registro=pg_fetch_array($resultado); $des_tipo_mov=$registro["descrip_tipo_mov"];}
$sql="Select * from pre034 Where codigo_mov='$cod_busca' order by cod_presup,fuente_financ";$res=pg_query($sql); 
while($registro=pg_fetch_array($res)){ $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"];  $monto=$registro["monto"]; $sfecha=$registro["fecha_compromiso"]; 
  $resultado=pg_exec($conn,"SELECT INCLUYE_CON010('$codigo_mov','00000000','$fuente_financ','$cod_presup','00000','',$monto,'D','B','S','01','0','$descripcion')");
}

?>
<form name="form2" method="post" action="Inc_Mov_Libros.php">
<table width="10">
  <tr>
     <td width="5"><input class="Estilo10" name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input class="Estilo10" name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input class="Estilo10" name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtport" type="hidden" id="txtport" value="<?echo $port?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txthost" type="hidden" id="txthost" value="<?echo $host?>" ></td>	      
     <td width="5"><input class="Estilo10" name="txtnro_aut" type="hidden" id="txtnro_aut" value="<?echo $nro_aut?>" ></td>
     <td width="5"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>" ></td>
     <td width="5"><input class="Estilo10" name="txtced_r" type="hidden" id="txtced_r" value="<?echo $ced_rif?>"></td>
     <td width="5"><input class="Estilo10" name="txtnomb" type="hidden" id="txtnomb" value="<?echo $nombre_benef?>"></td>
	 <td width="5"><input class="Estilo10" name="txtfecha_fin" type="hidden" id="txtfecha_fin" value="<?echo $Fec_Fin_Ejer?>"></td>	 
	 <td width="5"><input class="Estilo10" name="txtcod_b" type="hidden"  id="txtcod_b"  value="<?echo $cod_banco?>"></td>
	 <td width="5"><input class="Estilo10" name="txtnro_c" type="hidden"  id="txtnro_c"  value="<?echo $nro_cuenta?>"></td>
	 <td width="5"><input class="Estilo10" name="txtnombre_b" type="hidden"  id="txtnombre_b"  value="<?echo $nombre_banco?>"></td>
	 <td width="5"><input class="Estilo10" name="txtref" type="hidden"  id="txtref"  value="<?echo $referencia?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txttipo_m" type="hidden" id="txttipo_m"  value="<?echo $tipo_mov?>"></td>
	 <td width="5"><input class="Estilo10" name="txtdes_tipo_m" type="hidden" id="txtdes_tipo_m"  value="<?echo $des_tipo_mov?>"></td>
	 <td width="5"><input class="Estilo10" name="txtdesc" type="hidden" id="txtdesc" value="<?echo $descripcion?>"></td>
	 <td width="5"><input class="Estilo10" name="txtmonto_mov" type="hidden" id="txtmonto_mov" value="<?echo $monto_mov_libro?>"></td>
	 <td width="5"><input class="Estilo10" name="txtfecha_m" type="hidden" id="txtfecha_m" value="<?echo $fecha?>"></td>	
	 
  </tr>
</table>
</form>
<form name="form3" method="post" action="Inc_trans_Libros.php">
<table width="10">
  <tr>
     <td width="5"><input class="Estilo10" name="txtuser2" type="hidden" id="txtuser2" value="<?echo $user?>" ></td>
     <td width="5"><input class="Estilo10" name="txtpassword2" type="hidden" id="txtpassword2" value="<?echo $password?>" ></td>
     <td width="5"><input class="Estilo10" name="txtdbname2" type="hidden" id="txtdbname2" value="<?echo $dbname?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtport2" type="hidden" id="txtport2" value="<?echo $port?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txthost2" type="hidden" id="txthost2" value="<?echo $host?>" ></td>
     <td width="5"><input class="Estilo10" name="txtnro_aut2" type="hidden" id="txtnro_aut2" value="<?echo $nro_aut?>" ></td>
     <td width="5"><input class="Estilo10" name="txtcodigo_mov2" type="hidden" id="txtcodigo_mov2" value="<?echo $codigo_mov?>" ></td>
     <td width="5"><input class="Estilo10" name="txtced_r2" type="hidden" id="txtced_r2" value="<?echo $ced_rif?>"></td>
     <td width="5"><input class="Estilo10" name="txtnomb2" type="hidden" id="txtnomb2" value="<?echo $nombre_benef?>"></td>
	 <td width="5"><input class="Estilo10" name="txtfecha_fin2" type="hidden" id="txtfecha_fin2" value="<?echo $Fec_Fin_Ejer?>"></td>
	 <td width="5"><input class="Estilo10" name="txtcod_b2" type="hidden"  id="txtcod_b2"  value="<?echo $cod_banco?>"></td>
	 <td width="5"><input class="Estilo10" name="txtnro_c2" type="hidden"  id="txtnro_c2"  value="<?echo $nro_cuenta?>"></td>
	 <td width="5"><input class="Estilo10" name="txtnombre_b2" type="hidden"  id="txtnombre_b2"  value="<?echo $nombre_banco?>"></td>
	 <td width="5"><input class="Estilo10" name="txtref2" type="hidden"  id="txtref2"  value="<?echo $referencia?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txttipo_m2" type="hidden" id="txttipo_m2"  value="<?echo $tipo_mov?>"></td>
	 <td width="5"><input class="Estilo10" name="txtdes_tipo_m2" type="hidden" id="txtdes_tipo_m2"  value="<?echo $des_tipo_mov?>"></td>
	 <td width="5"><input class="Estilo10" name="txtdesc2" type="hidden" id="txtdesc" value="<?echo $descripcion?>"></td>
	  <td width="5"><input class="Estilo10" name="txtmonto_mov" type="hidden" id="txtmonto_mov" value="<?echo $monto_mov_libro?>"></td>
	  <td width="5"><input class="Estilo10" name="txtfecha_m2" type="hidden" id="txtfecha_m2" value="<?echo $fecha?>"></td>	
  </tr>
</table>
</form>
<?   
pg_close();
if ($error==0){?><script language="JavaScript">alert('Movimiento Pegado'); var mop='<?echo $mop?>';
if(mop=='M'){ document.form2.submit(); } if(mop=='T'){ document.form3.submit(); }</script> <? }
else {?>  <script language="JavaScript">history.back();</script> <? }
?>