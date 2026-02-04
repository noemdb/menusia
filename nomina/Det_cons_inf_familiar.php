<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP N&oacute;MINA Y PERSONAL (Detalles Informaci&oacute;n Familiar)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
<?php if (!$_GET){$cod_empleado='';} else{$cod_empleado=$_GET["cod_empleado"];}
$sql="SELECT * FROM NOM009 where cod_empleado='$cod_empleado' order by ci_partida"; $res=pg_query($sql);
?>
       <table width="840"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="90" align="center" bgcolor="#99CCFF"><strong>C&eacute;dula</strong></td>
           <td width="340" align="center" bgcolor="#99CCFF"><strong>Nombre</strong></td>
           <td width="90" align="center" bgcolor="#99CCFF" ><strong>Parentesco </strong></td>
           <td width="50" align="center" bgcolor="#99CCFF" ><strong>Sexo </strong></td>
           <td width="90" align="center" bgcolor="#99CCFF" ><strong>Fecha Nacimiento </strong></td>
           <td width="50" align="center" bgcolor="#99CCFF" ><strong>Edad (A&ntilde;os)</strong></td>
		   <td width="80" align="center" bgcolor="#99CCFF" ><strong>Tiene HCM </strong></td>
           </tr>
<? while($registro=pg_fetch_array($res)){ $sfecha=$registro["fecha_nac"];  $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4);
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="90" align="left"><? echo $registro["ci_partida"]; ?></td>
           <td width="340" align="left"><? echo $registro["nombre"]; ?></td>
           <td width="90" align="center"><? echo $registro["parentesco"]; ?></td>
           <td width="50" align="center"><? echo $registro["sexo"]; ?></td>
           <td width="90" align="left"><? echo $fecha; ?></td>
           <td width="50" align="right"><? echo round($registro["edad"],0); ?></td>
		   <td width="80" align="center"><? echo $registro["status"]; ?></td>
           </tr>
         <?}
?>
       </table></td>
   </tr>

 </table>
 <p>&nbsp;</p>
</body>
</html>
<?  pg_close();?>