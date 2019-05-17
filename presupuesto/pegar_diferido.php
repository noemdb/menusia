<?include ("../class/conect.php");  include ("../class/funciones.php");  include ("../presupuesto/Ver_dispon.php"); $codigo_mov=$_GET["codigo_mov"]; include ("../class/configura.inc");
?>
<html>
<head>  <title>PEGAR DIFERIDO</title>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Inc_Orden(){ document.form2.submit(); }
</script>
</head>
<body>
<?$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else{ $Nom_Emp=busca_conf(); }
echo "ESPERE POR FAVOR PEGANDO DIFERIDO.... ","<br>";
$res=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);
$cod_busca="PRE023".$usuario_sia; $descripcion="";$fecha="";$nombre_abrev_dife="";  $referencia_dife=''; $tipo_diferido='';
$sql="Select * from pre030 Where codigo_mov='$cod_busca'"; $res=pg_query($sql); $filas=pg_num_rows($res);
if($filas>0){$registro=pg_fetch_array($res); $referencia_dife=$registro["referencia_comp"]; 
  $fecha=$registro["fecha_compromiso"];  $tipo_diferido=$registro["tipo_compromiso"]; $descripcion=$registro["descripcion_comp"]; $inf_usuario=$registro["inf_usuario"];
} if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
$sSQL="Select * from pre024 WHERE tipo_diferido='$tipo_diferido'";     $resultado=pg_exec($conn,$sSQL);    $filas=pg_numrows($resultado);
if ($filas>0){$registro=pg_fetch_array($resultado);  $nombre_tipo_dife=$registro["nombre_tipo_dife"]; $nombre_abrev_dife=$registro["nombre_abrev_dife"]; }
$nro_aut="N";
$sql="Select * from pre034 Where codigo_mov='$cod_busca' order by cod_presup,fuente_financ";$res=pg_query($sql); 
while($registro=pg_fetch_array($res)){ $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; $ref_imput_presu=$registro["ref_imput_presu"]; 
  $denominacion="";  $monto=$registro["monto"]; $sfecha=$registro["fecha_compromiso"]; $tipo_imput_presu=$registro["tipo_imput_presu"];   $monto_credito=$registro["monto_credito"];  
  $resultado=pg_exec($conn,"SELECT INCLUYE_PRE026('$codigo_mov','$cod_presup','$fuente_financ','','0000','','0000','','0000','','0000','','','','','','','$sfecha','C','$tipo_imput_presu','$ref_imput_presu','$sfecha',$monto,0,$monto_credito,0)");
}
?>
<form name="form2" method="post" action="Inc_diferidos.php">
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
	 <td width="5"><input name="txttipo_dif" type="hidden" id="txttipo_dif" value="<?echo $tipo_diferido?>"></td>
	 <td width="5"><input name="txtabrev_dif" type="hidden" id="txtabrev_dif" value="<?echo $nombre_abrev_dife?>"></td>
     <td width="5"><input name="txtref_dif" type="hidden" id="txtref_dif" value="<?echo $referencia_dife?>"></td>
	 <td width="5"><input name="txtfechad" type="hidden" id="txtfechad" value="<?echo $fecha?>"></td>	 
	 <td width="5"><input name="txtfecha_ini" type="hidden" id="txtfecha_ini" value="<?echo $fecha_hoy?>" ></td>
	 <td width="5"><input name="txtfecha_fin" type="hidden" id="txtfecha_fin" value="<?echo $Fec_Fin_Ejer?>"></td>
	 <td width="5"><input name="txtconcepto_r" type="hidden" id="txtconcepto_r" value="<?echo $descripcion ?>"></td> 
  </tr>
</table>
</form>
<?

pg_close();
if ($error==0){?><script language="JavaScript">alert('Diferido Pegado'); Llamar_Inc_Orden();</script> <? }else {?>  <script language="JavaScript">history.back();</script> <? }
?>