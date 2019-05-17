<?include ("../class/conect.php"); include ("../class/funciones.php"); 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<script language="JavaScript" type="text/JavaScript">
function Llama(mcodigo,modu,dopcion){ url="Act_opcion.php?opcion="+mcodigo+"&modulo="+modu+"&des_opcion="+dopcion; document.location = url;}
 </script>
<title>SIA CONFIGURACI&Oacute;N Y MANTENIMIENTO (Detalles Accesos)</title>
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="930" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
<?php
if (!$_GET){$criterio=''; } else{$criterio=$_GET["modulo"]; }$modulo=substr($criterio, 0, 2);$musuario=substr($criterio, 2, 15);
$sql="SELECT * FROM SIA007 where campo701='$modulo'";
$sql="SELECT campo701,campo702,campo703,campo704,campo705,campo706,campo707,campo708,campo709,campo710,campo711,campo712,campo713,campo714,campo715,campo716,campo717,campo718,campo719,campo720,campo721,campo722,campo723,campo724,campo725,campo607,campo608,campo609,campo610,campo611,campo612,campo613,campo614,campo615,campo616,campo617,campo618,campo619,campo620,campo621,campo622,campo623,campo624,campo625,campo626,CAMPO706,campo707,campo708,campo709,campo710,campo711,campo712,campo713,campo714,campo715,campo716,campo717,campo718,campo719,campo720,campo721,campo722,campo723,campo724,campo725  FROM SIA007 LEFT JOIN SIA006 ON (SIA006.CAMPO602=SIA007.CAMPO701) And (SIA006.CAMPO603=SIA007.CAMPO702)  And (SIA006.CAMPO601 ='$musuario') Where (SIA007.CAMPO701='$modulo') Order By SIA007.CAMPO702";
$res=pg_query($sql); //echo $sql;
?>
       <table width="920"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_comprobante">
         <tr height="20" class="Estilo5">
           <td width="500"  align="left" bgcolor="#99CCFF"><strong>Opcion</strong></td>
           <td width="340" align="left" bgcolor="#99CCFF"><strong>Derechos</strong></td>
                   <td width="80" align="left" bgcolor="#99CCFF"><strong>Codigo</strong></td>
         </tr>
         <? $t_debe=0; $t_haber=0;
while($registro=pg_fetch_array($res))
{ $derechos="";
  if(($registro["campo607"]=="S")and($registro["campo706"]!="")) {$derechos=$derechos."-".$registro["campo706"];}
  if(($registro["campo608"]=="S")and($registro["campo707"]!="")) {$derechos=$derechos."-".$registro["campo707"];}
  if(($registro["campo609"]=="S")and($registro["campo708"]!="")) {$derechos=$derechos."-".$registro["campo708"];}
  if(($registro["campo610"]=="S")and($registro["campo709"]!="")) {$derechos=$derechos."-".$registro["campo709"];}
  if(($registro["campo611"]=="S")and($registro["campo710"]!="")) {$derechos=$derechos."-".$registro["campo710"];}
  if(($registro["campo612"]=="S")and($registro["campo711"]!="")) {$derechos=$derechos."-".$registro["campo711"];}
  if(($registro["campo613"]=="S")and($registro["campo712"]!="")) {$derechos=$derechos."-".$registro["campo712"];}
  if(($registro["campo614"]=="S")and($registro["campo713"]!="")) {$derechos=$derechos."-".$registro["campo713"];}
  if(($registro["campo615"]=="S")and($registro["campo714"]!="")) {$derechos=$derechos."-".$registro["campo714"];}
  if(($registro["campo616"]=="S")and($registro["campo715"]!="")) {$derechos=$derechos."-".$registro["campo715"];}
  if(($registro["campo617"]=="S")and($registro["campo716"]!="")) {$derechos=$derechos."-".$registro["campo716"];}
  if(($registro["campo618"]=="S")and($registro["campo717"]!="")) {$derechos=$derechos."-".$registro["campo717"];}
  if(($registro["campo619"]=="S")and($registro["campo718"]!="")) {$derechos=$derechos."-".$registro["campo718"];}
  if(($registro["campo620"]=="S")and($registro["campo719"]!="")) {$derechos=$derechos."-".$registro["campo719"];}
  if($derechos==""){$derechos="-";}
    else $derechos=substr($derechos, 1, 150);
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama('<? echo $registro["campo702"]; ?>','<? echo $criterio;?>','<? echo $registro["campo703"]; ?>');" >
           <td width="500" align="left"><? echo $registro["campo703"]; ?></td>
           <td width="320" align="center"><? echo $derechos; ?></td>
                   <td width="80" align="left"><? echo $registro["campo702"]; ?></td>
         </tr>
         <?}
?>
       </table></td>
   </tr>
 </table>
</body>
</html>
<?
  pg_close();
?>
