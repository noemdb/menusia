<?include ("../class/conect.php");  include ("../class/funciones.php");  include ("../presupuesto/Ver_dispon.php"); $codigo_mov=$_GET["codigo_mov"]; 
?>
<html>
<head>  <title>PEGAR TRASPASO</title>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Inc_Orden(){ document.form3.submit(); }
</script>
</head>
<body>
<?$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
echo "ESPERE POR FAVOR PEGANDO MODIFICACIONES.... ","<br>";
$res=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");$error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }

$mconf="";$Ssql="Select * from SIA005 where campo501='05'";$resultado=pg_query($Ssql);
if ($registro=pg_fetch_array($resultado,0)){$mconf=$registro["campo502"];}$nro_aut=substr($mconf,10,1);$fecha_aut=substr($mconf,11,1);
$preg_t=substr($mconf,12,1); $corr_m=substr($mconf,13,1); $modif_apr=substr($mconf,15,1);
$nro_aut="N"; $fecha_aut="N";  $fecha_hoy=asigna_fecha_hoy(); 

$cod_busca="PRE009".$usuario_sia;

$descripcion="";$fecha_registro="";$modif_i_e="";$fecha_modif="";$modif_aprob="N";$inf_usuario="";$aprobada_por="";$nro_documento="";$fecha_documento="";
$referencia_modif=""; $tipo_modif="";

$sql="Select * from pre030 Where codigo_mov='$cod_busca'"; $res=pg_query($sql); $filas=pg_num_rows($res);
if($filas>0){$registro=pg_fetch_array($res); $referencia_modif=$registro["referencia_comp"]; $tipo_modif=$registro["tipo_compromiso"];
   $fecha_registro=$registro["fecha_compromiso"];  $fecha_modif=$registro["fecha_aep"]; $descripcion=$registro["descripcion_comp"]; $inf_usuario=$registro["inf_usuario"];   
   $modif_i_e=$registro["unidad_sol"];  $nro_documento=$registro["nro_documento"]; $fecha_documento=$registro["fecha_anu"];
  }
if($fecha_registro==""){$fecha_registro="";}else{$fecha_registro=formato_ddmmaaaa($fecha_registro);} 
if($fecha_modif==""){$fecha_modif="";}else{$fecha_modif=formato_ddmmaaaa($fecha_modif);}
if($fecha_documento==""){$fecha_documento="";}else{$fecha_documento=formato_ddmmaaaa($fecha_documento);}

	   
$sql="Select * from pre034 Where codigo_mov='$cod_busca' order by cod_presup,fuente_financ";$res=pg_query($sql); 
while($registro=pg_fetch_array($res)){ 
  $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; $grupo=$registro["cod_comp"]; 
  $denominacion="";  $monto=$registro["monto"]; $sfecha=$registro["fecha_compromiso"];
  $operacion=$registro["tipo_imput_presu"];   $monto_credito=0;    
  $resultado=pg_exec($conn,"SELECT INCLUYE_PRE026('$codigo_mov','$cod_presup','$fuente_financ','','0000','','0000','','0000','','0000','$operacion','$grupo','','','','','$sfecha','C','P','$grupo','$sfecha',$monto,0,$monto_credito,0)");
}

echo $referencia_modif." ".$fecha_registro,"<br>";

?>

<form name="form3" method="post" action="Inc_adicion.php">
<table width="10">
  <tr>     
     <td width="5"><input name="txtuser2" type="hidden" id="txtuser2" value="<?echo $user?>" ></td>
     <td width="5"><input name="txtpassword2" type="hidden" id="txtpassword2" value="<?echo $password?>" ></td>
     <td width="5"><input name="txtdbname2" type="hidden" id="txtdbname2" value="<?echo $dbname?>" ></td>
	 <td width="5"><input name="txtport2" type="hidden" id="txtport2" value="<?echo $port?>" ></td>	 
	 <td width="5"><input name="txthost2" type="hidden" id="txthost2" value="<?echo $host?>" ></td>
     <td width="5"><input name="txtnro_aut2" type="hidden" id="txtnro_aut2" value="<?echo $nro_aut?>" ></td>
	 <td width="5"><input name="txtcorr_m2" type="hidden" id="txtcorr_m2" value="<?echo $corr_m?>" ></td>
     <td width="5"><input name="txtfecha_aut2" type="hidden" id="txtfecha_aut2" value="<?echo $fecha_aut?>" ></td>
     <td width="5"><input name="txtcodigo_mov2" type="hidden" id="txtcodigo_mov2" value="<?echo $codigo_mov?>" ></td>
	 <td width="5"><input name="txtfechac2" type="hidden" id="txtfechac2" value="<?echo $fecha_registro?>"></td>	 
	 <td width="5"><input name="txtfechar2" type="hidden" id="txtfechar2" value="<?echo $fecha_registro?>"></td>
	 <td width="5"><input name="txtfecham2" type="hidden" id="txtfecham2" value="<?echo $fecha_modif?>"></td>
	 <td width="5"><input name="txtfechad2" type="hidden" id="txtfechad2" value="<?echo $fecha_documento?>"></td>
	 <td width="5"><input name="txtnro_docr2" type="hidden" id="txtnro_doc2" alue="<?echo $nro_documento?>"></td>	 
	 <td width="5"><input name="txtconcepto_r2" type="hidden" id="txtconcepto_r2" value="<?echo $descripcion?>"></td>
	 <td width="5"><input name="txtmodie2" type="hidden" id="txtmodie2" value="I"></td>
	 <td width="5"><input name="txtref_modif2" type="hidden" id="txtref_modif2" value="<?echo $referencia_modif?>"></td>
	 <td width="5"><input name="txttipo_modif2" type="hidden" id="txttipo_modif2"  value="<?echo $tipo_modif?>"></td>
  </tr>
</table>
</form>

<?

pg_close();
if ($error==0){?><script language="JavaScript">alert('Modificacion Pegada'); Llamar_Inc_Orden();</script> <? }else {?>  <script language="JavaScript">history.back();</script> <? }
?>