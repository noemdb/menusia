<?php include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$criterio=''; $tipo_informe=''; } else{$criterio=$_GET["criterio"]; $tipo_informe=substr($criterio,0,2);}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP CONTABILIDAD FINANCIERA (Detalles Informes Contables)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>

<script language="JavaScript" type="text/JavaScript">
function Llama_mostrar(mlinea,mcalculable){var murl; var minforme='<?php echo $tipo_informe?>';
  if(mcalculable=="S"){ murl='Cons_cal_informes.php?linea='+mlinea+"&cod_informe="+minforme;  Ventana_002(murl,'SIPAP','','650','300','true');  }  
}
</script>
<body>
 <table width="904" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
<?php 
$sql="SELECT * FROM CON006 where (tipo_informe='$tipo_informe') order by linea"; $res=pg_query($sql);
?>
       <table width="900"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_comprobante">
         <tr height="20" class="Estilo5">
           <td width="60"  align="left" bgcolor="#99CCFF"><strong>Linea</strong></td>
           <td width="150" align="left" bgcolor="#99CCFF"><strong>Codigo Cuenta</strong></td>
           <td width="150" align="center" bgcolor="#99CCFF"><strong>Codigo</strong></td>
           <td width="300" align="center" bgcolor="#99CCFF" ><strong>Denominacion </strong></td>
           <td width="50" align="center" bgcolor="#99CCFF"><strong>Calculable</strong></td>
		   <td width="50" align="center" bgcolor="#99CCFF"><strong>Status</strong></td>
		   <td width="50" align="center" bgcolor="#99CCFF"><strong>Operacion</strong></td>
		   <td width="50" align="center" bgcolor="#99CCFF"><strong>Columna</strong></td>
		   <td width="40" align="center" bgcolor="#99CCFF"><strong>Estilo</strong></td>
         </tr>
         <?php  
while($registro=pg_fetch_array($res)){ ?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_mostrar('<?php  echo $registro["linea"]; ?>','<?php  echo $registro["calculable"]; ?>');" >
           <td width="60" align="left"><?php  echo $registro["linea"]; ?></td>
		   <?php  if ($registro["codigo_cuenta"]=="") {?>
           <td width="150" align="left">&nbsp;</td>
           <?php }else{?>
		   <td width="150" align="left"><?php  echo $registro["codigo_cuenta"]; ?></td>
		   <?php }?>
           <?php  if ($registro["cod_cuenta"]=="") {?>
		   <td width="150" align="left">&nbsp;</td>
           <?php }else{?>
		   <td width="150" align="left"><?php  echo $registro["cod_cuenta"]; ?></td>
		    <?php }?>
           <td width="300" align="left"><?php  echo $registro["nombre_cuenta"]; ?></td>
           <td width="50" align="center"><?php  echo $registro["calculable"]; ?></td>
           <td width="50" align="center"><?php  echo $registro["status_linea"]; ?></td>
           <td width="50" align="center"><?php  echo $registro["moperacion"]; ?></td>
		   <td width="50" align="center"><?php  echo $registro["columna"]; ?></td>
		   <td width="40" align="center"><?php  echo $registro["status"]; ?></td>
         </tr>
    <?php } ?>
       </table></td>
   </tr>
   <tr> <td>&nbsp;</td>  </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?php   pg_close($conn); ?>