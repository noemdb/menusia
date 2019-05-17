<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA BIENES NACIONALES (Detalles  Transferencia Componentes Bienes Muebles)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
<?if (!$_GET){$criterio='';$referencia_transf='';}else{$criterio=$_GET["criterio"];$referencia_transf=substr($criterio,0,8);}
$sql="SELECT * FROM bien057 where referencia_transf_c='$referencia_transf' order by cod_bien_mue,cod_componente";$res=pg_query($sql);
?>
       <table width="840"  border="1" cellspacing='0' cellpadding='0' align="left" id="codigos">
         <tr height="20" class="Estilo5">
           <td width="150"  align="left" bgcolor="#99CCFF"><strong>Codigo Bien Emisor</strong></td>
		   <td width="100"  align="left" bgcolor="#99CCFF"><strong>Codigo</strong></td>
           <td width="440" align="left" bgcolor="#99CCFF"><strong>Denominacion Componente</strong></td>
           <td width="150"  align="left" bgcolor="#99CCFF"><strong>Codigo Bien Receptor</strong></td>
         </tr>
         <? while($registro=pg_fetch_array($res)){ ?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:enviar('<? echo $codigo_mov; ?>','<? echo $registro["cod_bien_mue"]; ?>');">
           <td width="150" align="left"><? echo $registro["cod_bien_mue"]; ?></td>
		   <td width="100" align="left"><? echo $registro["cod_componente"]; ?></td>
           <td width="440" align="left"><? echo $registro["des_componente"]; ?></td>
		   <td width="150" align="left"><? echo $registro["cod_bien_mue_r"]; ?></td>
         </tr>
         <?} ?>
       </table></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?  pg_close(); ?>
