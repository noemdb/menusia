<?php include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$linea='';$tipo_informe='';} else{$linea=$_GET["linea"];$tipo_informe=$_GET["cod_informe"];}
$sql="SELECT * FROM CON006 where (tipo_informe='$cod_informe') and (linea='$linea')";  $res=pg_query($sql);$filas=pg_num_rows($res);  
$codigo_cuenta=""; $nombre_cuenta=""; 
if($filas>=1){$registro=pg_fetch_array($res,0); $codigo_cuenta=$registro["codigo_cuenta"]; $nombre_cuenta=$registro["nombre_cuenta"]; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP CONTABILIDAD FINANCIERA (Detalles Calculo Informes Contables)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="904" border="0" cellspacing="0" cellpadding="0">
   <tr>
		<td><table width="840">
		   <tr>
			 <td width="70"><span class="Estilo5">LINEA :</span></td>
			 <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtlinea" type="text" id="txtlinea" size="10" maxlength="10"  value="<?php echo $linea?>" readonly></span></td>
			 <td width="160"><span class="Estilo5"><input class="Estilo10" name="txtcodigo_cuenta" type="text" id="txtcodigo_cuenta" size="20" maxlength="30"  value="<?php echo $codigo_cuenta?>" readonly></span></td>
			 <td width="510"><span class="Estilo5"> <input class="Estilo10" name="txtnombre_cuenta" type="text" id="txtnombre_cuenta" size="80" maxlength="100"  value="<?php echo $nombre_cuenta?>" readonly></span></td>
		   </tr>
		</table></td>
   </tr>
   <tr><td>&nbsp;</td></tr>
   <tr>
      <td align="left"><table width="840" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="280" align="center" valign="middle"><input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Cuenta al Calulo" onclick="javascript:llamar_agregar()"></td>
            <td width="280" align="center" valign="middle"><input name="btretornar" type="button" id="btretornar" value="Retornar Def. Informe" title="Regresar a Definicion de Informes" onclick="javascript:llamar_anterior()"></td>
            <td width="280" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar Cuentas"></td>
          </tr>
      </table></td>
    </tr>
    <tr><td>&nbsp;</td></tr>
   <tr>
     <td>
<?php 
$sql="SELECT con007.codigo_cuenta,con007.operacion,con007.status_c,con001.nombre_cuenta FROM con007 left join con001 on (con007.codigo_cuenta=con001.codigo_cuenta) where tipo_informe='$tipo_informe' and linea='$linea' order by codigo_cuenta";$res=pg_query($sql);
?>
       <table width="800"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_comprobante">
         <tr height="20" class="Estilo5">
		   <td width="150" align="left" bgcolor="#99CCFF"><strong>Codigo Cuenta</strong></td>
           <td width="490" align="center" bgcolor="#99CCFF" ><strong>Denominacion </strong></td>
           <td width="80" align="center" bgcolor="#99CCFF" ><strong>Operacion</strong></td>
           <td width="80" align="center" bgcolor="#99CCFF" ><strong>D/C/S</strong></td>
         </tr>
         <?php  
while($registro=pg_fetch_array($res)){ ?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_modifica('<?php  echo $registro["codigo_cuenta"]; ?>');" >
           <td width="150" align="left"><?php  echo $registro["codigo_cuenta"]; ?></td>
           <td width="490" align="left"><?php  echo $registro["nombre_cuenta"]; ?></td>
           <td width="80" align="center"><?php  echo $registro["operacion"]; ?></td>
           <td width="80" align="center"><?php  echo $registro["status_c"]; ?></td>
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

<script language="JavaScript" type="text/JavaScript">

function llamar_anterior(){ document.location ='Det_inc_inf_contables.php?criterio=<?php echo $tipo_informe?>'; }
function llamar_agregar(){ var minforme='<?php echo $tipo_informe?>';  var mlinea='<?php echo $linea?>';  
 document.location='Inc_cal_inf_contab.php?tipo_informe=<?php echo $tipo_informe?>'+'&linea='+mlinea; }


function Llama_modifica(mcodigo){var murl; var minforme='<?php echo $tipo_informe?>'; var mlinea='<?php echo $linea?>';  
  document.location='Mod_cal_inf_contab.php?tipo_informe=<?php echo $tipo_informe?>'+'&linea='+mlinea+'&codigo='+mcodigo;
}
</script>