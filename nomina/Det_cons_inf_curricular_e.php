<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP N&oacute;MINA Y PERSONAL (Detalles Informaci&oacute;n Curricular)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
<?php if (!$_GET){$cedula='';} else{$cedula=$_GET["cedula"];}
$sql="SELECT * FROM NOM056 where cedula='$cedula' order by fecha_ce"; $res=pg_query($sql);
?>
       <table width="840"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Fecha </strong></td>
           <td width="200" align="center" bgcolor="#99CCFF"><strong>Titulo Obtenido/Estudio</strong></td>
           <td width="250" align="center" bgcolor="#99CCFF" ><strong>Nombre Instituto </strong></td>
           <td width="250" align="center" bgcolor="#99CCFF" ><strong>Descripci&oacute;n </strong></td>
           </tr>
<? while($registro=pg_fetch_array($res)){$sfecha=$registro["fecha_ce"]; $fechac=formato_ddmmaaaa($sfecha);
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="50" align="left"><? echo $fechac; ?></td>
           <td width="110" align="left"><? echo $registro["titulo_ce"]; ?></td>
           <td width="150" align="left"><? echo $registro["instituto_ce"]; ?></td>
           <td width="250" align="left"><? echo $registro["descripcion_ce"]; ?></td>
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