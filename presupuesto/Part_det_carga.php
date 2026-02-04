<?php include ("../class/conect.php"); include ("../class/funciones.php");
if (!$_GET){ $cod_presup=''; $cod_fuente='00'; $SIA_Definicion="N";$sql="SELECT * FROM codigos ORDER BY cod_presup,cod_fuente";}else {$codigo=$_GET["Gcodigo"]; $SIA_Definicion=substr($codigo,0,1);$cod_fuente=substr($codigo,1,2);$cod_presup=substr($codigo,3,32);}
$codigo=$SIA_Definicion.$cod_fuente.$cod_presup;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA(Codigos Cargar Partidas)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function CargarUrl(mcodigo,mcod_pre) {var murl;
   murl="Mod_cod_carga.php?codigo="+mcodigo+"&cod_presup="+mcod_pre;   document.location = murl;}
</script>
</head>
<body>
<div id="Layer1" style="position:absolute; width:805px; height:300px; z-index:1; top:0px; left:0px;">
 <table width="804">
   <tr>
     <td>
<?php
$sql="SELECT * FROM PRE032 where cod_categoria='$cod_presup' and cod_fuente='$cod_fuente' order by cod_presup";$res=pg_query($sql);
?>
       <table width="800"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_comprobante">
         <tr height="20" class="Estilo5">
           <td width="75" align="left" bgcolor="#99CCFF"><strong>Codigo Presupuestario</strong></td>
           <td width="60" align="right" bgcolor="#99CCFF" ><strong>Monto </strong></td>
           <td width="205" align="left" bgcolor="#99CCFF"><strong>Denominacion</strong></td>
           <td width="60" align="left" bgcolor="#99CCFF"><strong>Cuenta</strong></td>
         </tr>
         <?php  $total=0;
while($registro=pg_fetch_array($res)){ $monto=$registro["asignado"]; $total=$total+$monto; $monto=formato_monto($monto);
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:CargarUrl('<?php  echo $codigo ?>','<?php  echo $registro["cod_presup"]; ?>');">
           <td width="75" align="left"><?php  echo $registro["cod_presup"]; ?></td>
           <td width="60" align="right"><?php  echo $monto; ?></td>
           <td width="205" align="left"><?php  echo $registro["denominacion"]; ?></td>
           <td width="60" align="left"><?php  echo $registro["cod_contable"]; ?></td>
         </tr>
         <?php } $total=formato_monto($total);
?>
       </table></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td><table width="290" border="0">
       <tr>
         <td width="70"><span class="Estilo5">TOTAL  :</span></td>
         <td width="220"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr>
               <td align="right" class="Estilo5"><?php  echo $total; ?></td>
             </tr>
         </table></td>

       </tr>
     </table></td>
   </tr>
 </table>
 </div>
</body>
</html>
<?php   pg_close($conn);?>