<?include ("../class/conect.php");  include ("../class/funciones.php"); if (!$_GET){$codigo_mov='';}else{$codigo_mov=$_GET["codigo_mov"];}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Trabajadores Nomina Extraordonaria)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>

<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="left"><table width="840" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="222" align="center" valign="middle"><input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Trabajadores al Calculo" onclick="javascript:LlamarURL('Inc_trab_nom_ext.php?codigo_mov=<?echo $codigo_mov?>')"></td>
            <td width="255" align="center">&nbsp;</td>
            <td width="215" align="center">&nbsp;</td>
            <td width="215" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar los Codigos de los Trabajadores"></td>
          </tr>
      </table></td>
    </tr>
    <tr height="5">
      <td> <p>&nbsp;</p></td>
    </tr>
   <tr>
   <tr>
     <td>
       <?php
 $sql="Select * from nom072 where codigo_mov='$codigo_mov' Order by cod_empleado";$res=pg_query($sql); 
?>
       <table width="920"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="120" align="center" bgcolor="#99CCFF"><strong>C&oacute;digo</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>C&eacute;dula</strong></td>
           <td width="500" align="center" bgcolor="#99CCFF"><strong>Nombre Trabajador</strong></td>
       </tr>
         <? $total=0;
while($registro=pg_fetch_array($res)) {?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Eliminar('<? echo $codigo_mov; ?>','<? echo $registro["cod_empleado"]; ?>');" >
           <td width="100" align="left"><? echo $registro["cod_empleado"]; ?></td>
           <td width="100" align="left"><? echo $registro["cedula"]; ?></td>
           <td width="500" align="left"><? echo $registro["nombre"]; ?></td>
          </tr>
         <?} ?>
       </table></td>
   </tr>
   <tr><td>&nbsp;</td>  </tr>
 </table>
</body>
</html>

<script language="JavaScript" type="text/JavaScript">

function Llama_Eliminar(cod_est,codigo){var url; var r;
  r=confirm("Esta seguro en Eliminar el Codigo de Trabajador del Calculo ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar el Codigo de Trabajador del Calculo ?");
    if (r==true) { url="Delete_trab_ext.php?codigo_mov="+cod_est+"&cod_empleado="+codigo;
	   document.location=url;
	   }    }
   else { url="Cancelado, no elimino"; }
}
</script>
<?   pg_close(); ?>