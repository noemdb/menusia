<?include ("../class/conect.php");  include ("../class/funciones.php"); if (!$_GET){$codigo_mov='';} else{$codigo_mov=$_GET["codigo_mov"];}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Detalles Informaci&oacute;n Curricular)</title>
<LINK href="../class/sia.css" type="text/css"  rel="stylesheet">
</head>
<script language="JavaScript" type="text/JavaScript">
function Llama_Modificar(codigo_mov,fecha){var murl;
  if(fecha==""){alert("Informacion debe ser Seleccionada");}
  else{murl="Mod_inf_curr_e.php?codigo_mov="+codigo_mov+"&fecha="+fecha; document.location=murl;}
}
</script>
<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="left"><table width="840" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="222" align="center" valign="middle"><input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Informaci&oacute;n Curricular" onclick="javascript:LlamarURL('Inc_inf_curr_e.php?codigo_mov=<?echo $codigo_mov?>')"></td>
            <td width="255" align="center">&nbsp;</td>
            <td width="215" align="center">&nbsp;</td>
            <td width="215" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar la Informaci&oacute;n Curricular"></td>
          </tr>
      </table></td>
    </tr>
    <tr><td>&nbsp;</td></tr>
   <tr>
     <td>
<?php $sql="SELECT * FROM NOM067 where codigo_mov='$codigo_mov' order by fecha"; $res=pg_query($sql);
?>
       <table width="840"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Fecha </strong></td>
           <td width="200" align="center" bgcolor="#99CCFF"><strong>Titulo Obtenido/Estudio</strong></td>
           <td width="250" align="center" bgcolor="#99CCFF" ><strong>Nombre Instituto </strong></td>
           <td width="250" align="center" bgcolor="#99CCFF" ><strong>Descripci&oacute;n </strong></td>
           </tr>
<? while($registro=pg_fetch_array($res)){$sfecha=$registro["fecha"]; $fechac=formato_ddmmaaaa($sfecha);
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<? echo $codigo_mov; ?>','<? echo $sfecha; ?>');">
           <td width="50" align="left"><? echo $fechac; ?></td>
           <td width="110" align="left"><? echo $registro["titulo"]; ?></td>
           <td width="150" align="left"><? echo $registro["instituto"]; ?></td>
           <td width="250" align="left"><? echo $registro["descripcion"]; ?></td>
           </tr>
         <?}?>
       </table></td>
   </tr>
 </table>
</body>
</html>
<?  pg_close();  ?>