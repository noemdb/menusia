<?include ("../class/conect.php");  include ("../class/funciones.php");
if (!$_GET){$codigo="";} else{$codigo=$_GET["Gcodigo"];}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Detalles Cargos del Departamento)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<script language="JavaScript" type="text/JavaScript">
function Llama_Modificar(cod_dep,cod_cargo){var murl;
  if(cod_dep==""){alert("Informacion debe ser Seleccionada");}
  else{murl="Mod_cargo_dep.php?cod_dep="+cod_dep+"&cod_cargo="+cod_cargo; document.location=murl;}
}
</script>
<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="left"><table width="840" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="222" align="center" valign="middle"><input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Cargo al Departamento" onclick="javascript:LlamarURL('Inc_cargo_dep.php?codigo=<?echo $codigo?>')"></td>
            <td width="255" align="center">&nbsp;</td>
            <td width="215" align="center">&nbsp;</td>
            <td width="215" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar Cargos del Departamento"></td>
          </tr>
      </table></td>
    </tr>
    <tr><td>&nbsp;</td></tr>
   <tr>
     <td>
<?$sql="SELECT * from cargos_dep  where codigo_departamento='$codigo'";   $res=pg_query($sql);
?>
       <table width="840"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Cargo</strong></td>
           <td width="240" align="center" bgcolor="#99CCFF"><strong>Denominaci&oacute;n</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Tipo Personal</strong></td>
           <td width="210" align="center" bgcolor="#99CCFF" ><strong>Descripci&oacute;n</strong></td>
           <td width="90" align="center" bgcolor="#99CCFF" ><strong>Cant.Cargos</strong></td>
           </tr>
<? while($registro=pg_fetch_array($res)){  ?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<? echo $codigo; ?>','<? echo $registro["codigo_cargo"]; ?>');">
           <td width="100" align="left"><? echo $registro["codigo_cargo"]; ?></td>
           <td width="240" align="left"><? echo $registro["denominacion"]; ?></td>
           <td width="100" align="left"><? echo $registro["cod_tipo_personal"]; ?></td>
           <td width="210" align="left"><? echo $registro["des_tipo_personal"];  ?></td>
           <td width="90" align="left"><? echo $registro["nro_cargos"]; ?></td>
           </tr>
         <?}?>
       </table></td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?  pg_close();?>