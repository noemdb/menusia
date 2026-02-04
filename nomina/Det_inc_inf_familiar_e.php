<?include ("../class/conect.php");  include ("../class/funciones.php"); if (!$_GET){$codigo_mov='';} else{$codigo_mov=$_GET["codigo_mov"];}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Detalles Informaci&oacute;n Familiar)</title>
<LINK href="../class/sia.css" type="text/css"  rel="stylesheet">
</head>
<script language="JavaScript" type="text/JavaScript">
function Llama_Modificar(codigo_mov,ci_part){var murl;
  if(ci_part==""){alert("Informacion debe ser Seleccionada");}
  else{murl="Mod_inf_familiar_e.php?codigo_mov="+codigo_mov+"&cedula="+ci_part; document.location=murl;}
}
</script>
<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="left"><table width="840" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="222" align="center" valign="middle"><input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Informaci&oacute;n Familiar" onclick="javascript:LlamarURL('Inc_inf_familiar_e.php?codigo_mov=<?echo $codigo_mov?>')"></td>
            <td width="255" align="center">&nbsp;</td>
            <td width="215" align="center">&nbsp;</td>
            <td width="215" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar la Informaci&oacute;n Familiar"></td>
          </tr>
      </table></td>
    </tr>
    <tr><td>&nbsp;</td></tr>
   <tr>
     <td>
<?php $sql="SELECT * FROM NOM069 where codigo_mov='$codigo_mov' order by ci_partida"; $res=pg_query($sql);
?>
       <table width="840"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="90" align="center" bgcolor="#99CCFF"><strong>C&eacute;dula</strong></td>
           <td width="340" align="center" bgcolor="#99CCFF"><strong>Nombre</strong></td>
           <td width="90" align="center" bgcolor="#99CCFF" ><strong>Parentesco </strong></td>
           <td width="50" align="center" bgcolor="#99CCFF" ><strong>Sexo </strong></td>
           <td width="90" align="center" bgcolor="#99CCFF" ><strong>Fecha Nacimiento </strong></td>
           <td width="50" align="center" bgcolor="#99CCFF" ><strong>Edad (A&ntilde;os)</strong></td>
		   <td width="80" align="center" bgcolor="#99CCFF" ><strong>Tiene HCM </strong></td>
           </tr>
<? while($registro=pg_fetch_array($res)){ $edad=$registro["edad"]; $edad=floor($edad); $sfecha=$registro["fecha_nac"];  $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4);
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<? echo $codigo_mov; ?>','<? echo $registro["ci_partida"]; ?>');">
           <td width="90" align="left"><? echo $registro["ci_partida"]; ?></td>
           <td width="340" align="left"><? echo $registro["nombre"]; ?></td>
           <td width="90" align="left"><? echo $registro["parentesco"]; ?></td>
           <td width="50" align="left"><? echo $registro["sexo"]; ?></td>
           <td width="90" align="left"><? echo $fecha; ?></td>
           <td width="50" align="right"><? echo  $edad ?></td>
		   <td width="80" align="center"><? echo $registro["status"]; ?></td>
           </tr>
         <?}
?>
       </table></td>
   </tr>

 </table>
 <p>&nbsp;</p>
</body>
</html>
<?  pg_close();?>