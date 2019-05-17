<?include ("../class/conect.php");  include ("../class/funciones.php"); if (!$_GET){$codigo_mov='';} else{$codigo_mov=$_GET["codigo_mov"];}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA N&oacute;MINA Y PERSONAL (Detalles Hoja de Vida)</title>
<LINK href="../class/sia.css" type="text/css"  rel="stylesheet">
</head>
<script language="JavaScript" type="text/JavaScript">
function Llama_Modificar(codigo_mov,fecha){var murl;
  if(fecha==""){alert("Informacion debe ser Seleccionada");}
  else{murl="Mod_hoja_vida.php?codigo_mov="+codigo_mov+"&fecha="+fecha; document.location=murl;}
}
</script>
<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="left"><table width="840" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="222" align="center" valign="middle"><input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Hoja de Vida" onclick="javascript:LlamarURL('Inc_hoja_vida.php?codigo_mov=<?echo $codigo_mov?>')"></td>
            <td width="255" align="center">&nbsp;</td>
            <td width="215" align="center">&nbsp;</td>
            <td width="215" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar Hoja de Vida"></td>
          </tr>
      </table></td>
    </tr>
    <tr><td>&nbsp;</td></tr>
   <tr>
     <td>
<?php $sql="SELECT * FROM NOM071 where codigo_mov='$codigo_mov' order by fecha"; $res=pg_query($sql);
?>
       <table width="840"  border="1" cellspacing='0' cellpadding='0' align="left" id="inc_observacion">
         <tr height="20" class="Estilo5">
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Fecha </strong></td>
           <td width="700" align="center" bgcolor="#99CCFF"><strong>Observaci&oacute;n</strong></td>
         </tr>
<? while($registro=pg_fetch_array($res)){$sfecha=$registro["fecha"]; $fechac=formato_ddmmaaaa($sfecha);
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<? echo $codigo_mov; ?>','<? echo $sfecha; ?>');">
           <td width="100" align="left"><? echo $fechac; ?></td>
           <td width="700" align="left"><? echo $registro["observacion"]; ?></td>
         </tr>
         <?}?>
       </table></td>
   </tr>
 </table>
</body>
</html>
<?  pg_close();?>