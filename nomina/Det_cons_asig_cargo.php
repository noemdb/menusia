<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA N&oacute;MINA Y PERSONAL (Detalles Asignacion de Cargo)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="1225" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
<?php if (!$_GET){$cod_empleado='';} else{$cod_empleado=$_GET["cod_empleado"];}
$sql="SELECT * FROM ASIG_CARGO  where cod_empleado='$cod_empleado' order by fecha_asigna"; $res=pg_query($sql);
?>
       <table width="1220"  border="1" cellspacing='0' cellpadding='0' align="left" id="asig_cargo">
         <tr height="20" class="Estilo5">
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Codigo Cargo</strong></td>
           <td width="200" align="center" bgcolor="#99CCFF"><strong>Descripcion Cargo</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>Fecha Asignacion</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>Codigo Depart.</strong></td>
           <td width="200" align="center" bgcolor="#99CCFF" ><strong>Descripcion Departamento </strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Tipo de Personal</strong></td>
           <td width="50" align="center" bgcolor="#99CCFF"><strong>Grado</strong></td>
           <td width="50" align="center" bgcolor="#99CCFF"><strong>Paso</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Sueldo</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Compensacion</strong></td>
		   <td width="100" align="right" bgcolor="#99CCFF" ><strong>Prima</strong></td>
         </tr>
<? while($registro=pg_fetch_array($res)){$sfecha=$registro["fecha_asigna"]; $fechaa=formato_ddmmaaaa($sfecha);  $monto_s=formato_monto($registro["sueldo"]); $monto_c=formato_monto($registro["compensacion"]); $monto_p=formato_monto($registro["prima"]);
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="100" align="left"><? echo $registro["cod_cargo"]; ?></td>
           <td width="200" align="left"><? echo $registro["des_cargo"]; ?></td>
           <td width="100" align="left"><? echo $fechaa; ?></td>
           <td width="100" align="left"><? echo $registro["cod_departamento"]; ?></td>
           <td width="200" align="left"><? echo $registro["des_departamento"]; ?></td>
           <td width="100" align="left"><? echo $registro["cod_tipo_personal"]; ?></td>
           <td width="50" align="left"><? echo $registro["grado"]; ?></td>
           <td width="50" align="left"><? echo $registro["paso"]; ?></td>
           <td width="100" align="right"><? echo $monto_s; ?></td>
           <td width="100" align="right"><? echo $monto_c; ?></td>
		   <td width="100" align="right"><? echo $monto_p; ?></td>
         </tr>
         <?}?>
       </table></td>
   </tr>
 </table>
</body>
</html>
<? pg_close();?>