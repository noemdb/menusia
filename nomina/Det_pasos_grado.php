<?include ("../class/conect.php");  include ("../class/funciones.php"); if (!$_GET){$cod_tipo_personal='';} else{$cod_tipo_personal=$_GET["Gcodigo"];}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Detalles Pasos y Grados)</title>
<LINK href="../class/sia.css" type="text/css"  rel="stylesheet">
</head>
<script language="JavaScript" type="text/JavaScript">
function Llama_Modificar(cod_tipo_personal,paso,grado){var murl;
  if(cod_tipo_personal==""){alert("Informacion debe ser Seleccionada");}
  else{murl="Mod_paso_grado.php?cod_tipo_personal="+cod_tipo_personal+"&paso="+paso+"&grado="+grado; document.location=murl;}
}
</script>
<body>
 <table width="840" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="left"><table width="840" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="222" align="center" valign="middle"><input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Pasos y Grados al Tipo" onclick="javascript:LlamarURL('Inc_paso_grado.php?cod_tipo_personal=<?echo $cod_tipo_personal?>')"></td>
            <td width="255" align="center">&nbsp;</td>
            <td width="215" align="center">&nbsp;</td>
            <td width="215" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar Tabla de pasos y Grados"></td>
          </tr>
      </table></td>
    </tr>
    <tr><td>&nbsp;</td></tr>
   <tr>
     <td>
<?php $sql="SELECT * FROM NOM040 where cod_tipo_personal='$cod_tipo_personal' order by grado,paso"; $res=pg_query($sql);?>
       <table width="320"  border="1" cellspacing='0' cellpadding='0' align="left" id="inc_asigna">
         <tr height="20" class="Estilo5">
           <td width="50" align="center" bgcolor="#99CCFF"><strong>Grado</strong></td>
           <td width="50" align="center" bgcolor="#99CCFF"><strong>Paso</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>Fecha</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Monto</strong></td>
         </tr>
<? while($registro=pg_fetch_array($res)){$sfecha=$registro["fecha_aprobacion"]; $fechaa=formato_ddmmaaaa($sfecha);  $monto_s=formato_monto($registro["monto"]);
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<? echo $cod_tipo_personal; ?>','<? echo $registro["paso"]; ?>','<? echo $registro["grado"]; ?>');">
           <td width="50" align="left"><? echo $registro["grado"]; ?></td>   
           <td width="50" align="left"><? echo $registro["paso"]; ?></td>
		   <td width="100" align="left"><? echo $fechaa; ?></td>
                   
           <td width="100" align="right"><? echo $monto_s; ?></td>
         </tr>
         <?}?>
       </table></td>
   </tr>
 </table>
</body>
</html>
<?  pg_close();?>