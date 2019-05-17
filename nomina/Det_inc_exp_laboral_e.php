<?include ("../class/conect.php");  include ("../class/funciones.php"); if (!$_GET){$codigo_mov='';} else{$codigo_mov=$_GET["codigo_mov"];}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Detalles Experencia Laboral)</title>
<LINK href="../class/sia.css" type="text/css"  rel="stylesheet">
</head>
<script language="JavaScript" type="text/JavaScript">
function Llama_Modificar(codigo_mov,fecha){
var murl;
  if(fecha==""){alert("Informacion debe ser Seleccionada");}
  else{murl="Mod_exp_laboral_e.php?codigo_mov="+codigo_mov+"&fecha="+fecha; document.location=murl;}
}
</script>
<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="left"><table width="840" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="222" align="center" valign="middle"><input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Experiencia Laboral" onclick="javascript:LlamarURL('Inc_exp_laboral_e.php?codigo_mov=<?echo $codigo_mov?>')"></td>
            <td width="255" align="center">&nbsp;</td>
            <td width="215" align="center">&nbsp;</td>
            <td width="215" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar la Experiencia Laboral"></td>
          </tr>
      </table></td>
    </tr>
    <tr><td>&nbsp;</td></tr>
   <tr>
     <td>
<?php $sql="SELECT * FROM NOM070 where codigo_mov='$codigo_mov' order by fecha_desde"; $res=pg_query($sql);
?>
       <table width="840"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="80" align="center" bgcolor="#99CCFF"><strong>Fecha Desde</strong></td>
           <td width="80" align="center" bgcolor="#99CCFF"><strong>Fecha Hasta</strong></td>
           <td width="200" align="center" bgcolor="#99CCFF" ><strong>Nombre Empresa </strong></td>
           <td width="200" align="center" bgcolor="#99CCFF" ><strong>Departamento </strong></td>
           <td width="180" align="center" bgcolor="#99CCFF" ><strong>Ultimo Cargo </strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Sueldo</strong></td>
         </tr>
<? while($registro=pg_fetch_array($res)){$sfechad=$registro["fecha_desde"]; $fechad=formato_ddmmaaaa($sfechad); $sfechah=$registro["fecha_hasta"]; $fechah=formato_ddmmaaaa($sfechah); $monto_s=formato_monto($registro["sueldo"]);
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<? echo $codigo_mov; ?>','<? echo $sfechad; ?>');">
           <td width="80" align="left"><? echo $fechad; ?></td>
           <td width="80" align="left"><? echo $fechah; ?></td>
           <td width="200" align="left"><? echo $registro["empresa"]; ?></td>
           <td width="200" align="left"><? echo $registro["departamento"]; ?></td>
           <td width="180" align="left"><? echo $registro["cargo"]; ?></td>
           <td width="100" align="right"><? echo $monto_s; ?></td>
         </tr>
         <?}?>
       </table></td>
   </tr>
 </table>
</body>
</html>
<?  pg_close();?>