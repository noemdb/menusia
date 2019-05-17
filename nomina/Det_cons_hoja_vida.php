<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA N&oacute;MINA Y PERSONAL (Detalles Hoja de Vida)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
<?php if (!$_GET){$cod_empleado='';} else{$cod_empleado=$_GET["cod_empleado"];}
$sql="SELECT * FROM NOM013 where cod_empleado='$cod_empleado' order by fecha"; $res=pg_query($sql);
?>
       <table width="840"  border="1" cellspacing='0' cellpadding='0' align="left" id="cons_observacion">
         <tr height="20" class="Estilo5">
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Fecha </strong></td>
           <td width="700" align="center" bgcolor="#99CCFF"><strong>Observaci&oacute;n</strong></td>
           </tr>
<? while($registro=pg_fetch_array($res)){$sfecha=$registro["fecha"]; $fechac=formato_ddmmaaaa($sfecha);
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="100" align="left"><? echo $fechac; ?></td>
           <td width="700" align="left"><? echo $registro["observacion"]; ?></td>
           </tr>
         <?}?>
       </table></td>
   </tr>
 </table>
</body>
</html>
<?
  pg_close();
?>