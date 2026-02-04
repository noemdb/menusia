<?php include ("../class/conect.php");  include ("../class/funciones.php");include ("../class/configura.inc"); $equipo=getenv("COMPUTERNAME");
if (!$_GET){$codigo_mov=""; $cod_banco=""; $mcod_m="BAN05L".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49); $monto_d=0; $monto_h=9999999999.99; $solop="NO";} 
else{ $codigo_mov=$_GET["codigo_mov"];$cod_banco=$_GET["cod_banco"];$referencia=$_GET["referencia"];$tipo_mov=$_GET["tipom"];$fecha=$_GET["fecha"]; $monto_d=$_GET["monto_d"]; $monto_h=$_GET["monto_h"]; $solop=$_GET["solop"];
} echo $fecha;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Seleccionar Movimiento)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function Llama_Modificar(codigo_mov,cbanco,refe,tipom){var murl;
   murl="Selec_mov_carga.php?codigo_mov="+codigo_mov+"&cod_banco="+cbanco+"&referencia="+refe+"&tipom="+tipom+"&fecha=<?php echo $fecha?>&solop=<?php echo $solop?>&monto_d=<?php echo $monto_d?>&monto_h=<?php echo $monto_h?>"; document.location=murl;
}
function Llamar_Incluir(){  document.form2.submit(); }
</script>
</head>
<?php 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?php }else{ $Nom_Emp=busca_conf(); }
$monto=0; $fecha_mov=""; $nomb_benef=""; $mes_c=""; $descripcion="";
$sql="SELECT * FROM carga_libros where codigo_mov='$codigo_mov' and cod_banco='$cod_banco' and referencia='$referencia' and tipo_mov_libro='$tipo_mov'"; $res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){ $sfecha=$registro["fecha_mov_libro"]; $fecha_mov=substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4); 
 $monto=$registro["monto_mov_libro"]; $referencia=$registro["referencia"]; $nomb_benef=$registro["nombre"]; if($nomb_benef==""){$nomb_benef=$registro["campo_str2"];}
 $mes_c=$registro["mes_conciliacion"];   $monto=formato_monto($monto); $descripcion=$registro["descrip_mov_libro"]; }
$graba_directo="N"; $sfechad=formato_aaaammdd($fecha); $sfechad=substr($sfechad,0,8)."01"; $sfechah=formato_aaaammdd($fecha);
if($mes_c=="99"){if(($sfecha>=$sfechad)and($sfecha<=$sfechah)){$graba_directo="S";}}  if($Cod_Emp=="61"){$graba_directo="N";}
echo $graba_directo." ".$sfecha." ".$sfechad." ".$sfechah." ".$mes_c;
?>
<body>

<form name="form2" method="post" action="Insert_mov_carga.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtreferencia" type="hidden" id="txtreferencia" value="<?php echo $referencia?>" ></td>
     <td width="5"><input name="txttipo_mov" type="hidden" id="txttipo_mov" value="<?php echo $tipo_mov?>" ></td>
     <td width="5"><input name="txtbeneficiario" type="hidden" id="txtbeneficiario" value="<?php echo $nomb_benef?>" ></td>
     <td width="5"><input name="txtfecha_mov" type="hidden" id="txtfecha_mov" value="<?php echo $fecha_mov?>" ></td>
     <td width="5"><input name="txtmonto" type="hidden" id="txtmonto" value="<?php echo $monto?>" ></td>
     <td width="5"><input name="txtmes" type="hidden" id="txtmes" value="<?php echo $mes_c?>" ></td>	 
     <td width="17"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>"></td>
     <td width="10"><input name="txtcod_banco" type="hidden" id="txtcod_banco" value="<?php echo $cod_banco?>"></td>
	 <td width="20"><input name="txtfecha" type="hidden" id="txtfecha" value="<?php echo $fecha?>"></td>
	 <td width="10"><input name="txtmonto_d" type="hidden" id="txtmonto_d" value="<?php echo $monto_d?>"></td>
	 <td width="10"><input name="txtmonto_h" type="hidden" id="txtmonto_h" value="<?php echo $monto_h?>"></td>
	<td width="10"><input name="txtsolop" type="hidden" id="txtsolop" value="<?php echo $solop?>"></td>
	 <td width="40"><input name="txtdescripcion" type="hidden" id="txtdescripcion" value="<?php echo $descripcion?>"></td>    
  </tr>
</table>
</form>
<form name="form1" method="post">
<?php  if ($graba_directo=="N"){?> <script language="JavaScript" type="text/JavaScript">Llama_Modificar('<?php  echo $codigo_mov; ?>','<?php  echo $cod_banco; ?>','<?php  echo $referencia; ?>','<?php  echo $tipo_mov; ?>');	</script>
<?php }else{?>  <script language="JavaScript" type="text/JavaScript">Llamar_Incluir();	</script> <?php }?>	
</form>
</body>
</html>