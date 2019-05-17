<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Detalles Informaci&oacute;n Laboral)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
<?php
if (!$_GET){$cedula='';} else{$cedula=$_GET["cedula"];} $sql="SELECT * FROM NOM063  where cedula='$cedula' order by fecha_asigna_cargo"; $res=pg_query($sql);
?>
       <table width="1650"  border="1" cellspacing='0' cellpadding='0' align="left" id="inf_ret">
         <tr height="20" class="Estilo5">
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Cod.Cargo</strong></td>
           <td width="200" align="center" bgcolor="#99CCFF"><strong>Descripci&oacute;n Cargo</strong></td>
           <td width="90" align="center" bgcolor="#99CCFF" ><strong>Fecha Asig.</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>Cod.Departa </strong></td>
           <td width="200" align="center" bgcolor="#99CCFF" ><strong>Descripci&oacute;n Departamento</strong></td>
           <td width="80" align="center" bgcolor="#99CCFF" ><strong>Tipo Per. </strong></td>
           <td width="40" align="center" bgcolor="#99CCFF" ><strong>Grado </strong></td>
           <td width="40" align="center" bgcolor="#99CCFF" ><strong>Paso </strong></td>
           <td width="120" align="center" bgcolor="#99CCFF" ><strong>Sueldo Base </strong></td>
           <td width="120" align="center" bgcolor="#99CCFF" ><strong>Compensaci&oacute;n</strong></td>
           <td width="120" align="center" bgcolor="#99CCFF" ><strong>Cod.Empleado</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>Fecha Ingreso </strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>Fecha Egreso</strong></td>
           <td width="200" align="center" bgcolor="#99CCFF" ><strong>Motivo Egreso</strong></td>
         </tr>
<? while($registro=pg_fetch_array($res)){  $fechaa=$registro["fecha_asigna_cargo"];  $fechaa=formato_ddmmaaaa($fechaa);  $fechai=$registro["fecha_ingreso"];  $fechai=formato_ddmmaaaa($fechai);  $fechae=$registro["fecha_egreso"];  $fechae=formato_ddmmaaaa($fechae);
 $sueldo=$registro["sueldo"]; $sueldo=formato_monto($sueldo); $compensacion=$registro["compensacion"]; $compensacion=formato_monto($compensacion);
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="100" align="left"><? echo $registro["cod_cargo"]; ?></td>
           <td width="200" align="left"><? echo $registro["des_cargo"]; ?></td>
           <td width="90" align="center"><? echo $fechaa; ?></td>
           <td width="100" align="left"><? echo $registro["cod_departam"]; ?></td>
           <td width="200" align="left"><? echo $registro["des_departamento"]; ?></td>
           <td width="80" align="center"><? echo $registro["cod_tipo_personal"]; ?></td>
           <td width="40" align="center"><? echo $registro["grado"]; ?></td>
           <td width="40" align="center"><? echo $registro["paso"]; ?></td>
           <td width="120" align="right"><? echo $sueldo; ?></td>
           <td width="120" align="right"><? echo $compensacion; ?></td>
           <td width="120" align="left"><? echo $registro["cod_empleado"]; ?></td>
           <td width="100" align="center"><? echo $fechai; ?></td>
           <td width="100" align="left"><? echo $fechae ?></td>
           <td width="200" align="left"><? echo $registro["motivo_egreso"]; ?></td>
          </tr>
         <?}?>
       </table></td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?   pg_close();  ?>