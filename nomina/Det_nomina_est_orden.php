<?include ("../class/conect.php");  include ("../class/funciones.php");$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (N&oacute;mina EStructura Orden)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="750" border="0" cellspacing="0" cellpadding="0">
    <tr><td>&nbsp;</td></tr>
   <tr>   <td width="750">
<?php if (!$_GET){$criterio='N';}else{$criterio=$_GET["criterio"];} $tp_calculo=substr($criterio,0,1); $cod_estructura=substr($criterio,1,8);
if($tp_calculo=="N"){$sql="SELECT tipo_nomina,descripcion,bloqueada,bloqueada_ext FROM NOM001 WHERE ((cod_relac_nom='$cod_estructura') or (cod_relac_apo='$cod_estructura') or (cod_relac_vac='$cod_estructura'))";}
 else{$sql="SELECT tipo_nomina,descripcion,bloqueada,bloqueada_ext FROM NOM001 WHERE (cod_relac_ext='$cod_estructura') or (cod_relac_apo='$cod_estructura')";}$res=pg_query($sql);
?>
       <table width="740"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="120" align="center" bgcolor="#99CCFF"><strong>C&oacute;digo n&oacute;mina</strong></td>
           <td width="620" align="center" bgcolor="#99CCFF"><strong>Denominaci&oacute;n</strong></td>
         </tr>
         <?
if($cod_estructura<>''){		 
while($registro=pg_fetch_array($res)){ $v=0; if($tp_calculo=="N"){if($registro["bloqueada"]=="N"){$v=1;}}else{if($registro["bloqueada_ext"]=="N"){$v=1;}}   if($v==1){
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="120" align="left"><? echo $registro["tipo_nomina"]; ?></td>
           <td width="620" align="left"><? echo $registro["descripcion"]; ?></td>
         </tr>
<?}} }?>
       </table>   
	   </td>
   </tr>
</table>
 <p>&nbsp;</p>
</body>
</html>
<?   pg_close(); ?>