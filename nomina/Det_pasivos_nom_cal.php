<?include ("../class/conect.php");  include ("../class/funciones.php"); if(!$_GET){$codigo_mov='';}else{$codigo_mov=$_GET["codigo_mov"];}
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGO (Incluir Pasivos de la Orden)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language=JavaScript src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_pag.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
var mcodigo_mov='<?php echo $codigo_mov ?>';

</script>
</head>
<body>
<form name="form1"  method="post" >
<?php
$sql="SELECT * FROM cod_pasivo  where codigo_mov='$codigo_mov' order by cod_cuenta";$res=pg_query($sql);
?>
<table width="904" border="0" cellspacing="0" cellpadding="0">
   
   <tr>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td colspan="4">
       <table width="820"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_pasivo">
         <tr height="20" class="Estilo5">
           <td width="180"  align="left" bgcolor="#99CCFF"><strong>Cuenta</strong></td>
           <td width="500" align="left" bgcolor="#99CCFF"><strong>Nombre</strong></td>
           <td width="35" align="center" bgcolor="#99CCFF"><strong>D/C</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Monto </strong></td>
         </tr>
         <? $total=0;
while($registro=pg_fetch_array($res)){ $monto=$registro["monto_pasivo"]; $tipo_DC=$registro["debito_credito"];$total=$total+$monto;$monto=formato_monto($monto);
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<? echo $codigo_mov; ?>','<? echo $registro["cod_cuenta"]; ?>','<? echo $registro["debito_credito"]; ?>');">
           <td width="180" align="left"><? echo $registro["cod_cuenta"]; ?></td>
           <td width="500" align="left"><? echo $registro["nombre_cuenta"]; ?></td>
           <td width="35" align="center"><? echo $tipo_DC; ?></td>
           <td width="100" align="right"><? echo $monto; ?></td>
         </tr>
         <?}
 $total=formato_monto($total);
?>
       </table></td>
   </tr>
   <tr>
     <td colspan="4">&nbsp;</td>
   </tr>
   <tr>
     <td colspan="4"><table width="800" border="0">
       <tr>
         <td width="506">&nbsp;</td>
         <td width="113"><span class="Estilo5">TOTAL PASIVOS :</span></td>
         <td width="167"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr>
               <td align="right" class="Estilo5"><? echo $total; ?></td>
             </tr>
         </table></td>
       </tr>
     </table></td>
   </tr>
 </table>
 <p>&nbsp;</p>
 </form>
</body>
</html>
<?
  pg_close();
?>