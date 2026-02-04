<?include ("../class/conect.php");  include ("../class/funciones.php"); if (!$_GET){$codigo_mov='';} else{$codigo_mov=$_GET["codigo_mov"];}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Detalles Asignaci&oacute;n de Cargo)</title>
<LINK href="../class/sia.css" type="text/css"  rel="stylesheet">
</head>

<body>
 <table width="840" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="left"><table width="840" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="222" align="center" valign="middle"><input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Asignacion de Cargo" onclick="javascript:Llama_Incluir('<?echo $codigo_mov?>')"></td>
            <td width="255" align="center">&nbsp;</td>
            <td width="215" align="center">&nbsp;</td>
            <td width="215" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar la Asignacion de Cargos"></td>
          </tr>
      </table></td>
    </tr>
    <tr><td>&nbsp;</td></tr>
   <tr>
     <td>
<?php $sql="SELECT * FROM NOM068 where codigo_mov='$codigo_mov' order by fecha_asigna"; $res=pg_query($sql);?>
       <table width="1220"  border="1" cellspacing='0' cellpadding='0' align="left" id="inc_asigna">
         <tr height="20" class="Estilo5">
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Codigo Cargo</strong></td>
           <td width="200" align="center" bgcolor="#99CCFF"><strong>Descripcion Cargo</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>Fecha Asignacion</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>Codigo Depart.</strong></td>
           <td width="200" align="center" bgcolor="#99CCFF" ><strong>Descripcion Departamento </strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Tipo de Personal</strong></td>
           <td width="50" align="center" bgcolor="#99CCFF"><strong>Grado</strong></td>
           <td width="50" align="center" bgcolor="#99CCFF"><strong>Paso</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Sueldo</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Compensacion</strong></td>
		   <td width="100" align="right" bgcolor="#99CCFF" ><strong>Prima</strong></td>
         </tr>
<? while($registro=pg_fetch_array($res)){$sfecha=$registro["fecha_asigna"]; $fechaa=formato_ddmmaaaa($sfecha);  $monto_s=formato_monto($registro["sueldo"]); $monto_c=formato_monto($registro["compensacion"]); $monto_p=formato_monto($registro["prima"]);
        $cod_tipo_personal=$registro["cod_tipo_personal"];  $grado=$registro["grado"]; $paso=$registro["paso"];
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<? echo $codigo_mov; ?>','<? echo $registro["fecha_asigna"]; ?>');">
           <td width="100" align="left"><? echo $registro["cod_cargo"]; ?></td>
           <td width="200" align="left"><? echo $registro["des_cargo"]; ?></td>
           <td width="100" align="left"><? echo $fechaa; ?></td>
           <td width="100" align="left"><? echo $registro["cod_departamento"]; ?></td>
           <td width="200" align="left"><? echo $registro["des_departamento"]; ?></td>
           <td width="100" align="left"><? echo $registro["cod_tipo_personal"]; ?></td>
           <td width="50" align="left"><? echo $registro["grado"]; ?></td>
           <td width="50" align="left"><? echo $registro["paso"]; ?></td>
           <td width="100" align="right"><? echo $monto_s; ?></td>
           <td width="100" align="right"><? echo $monto_c; ?></td>
		   <td width="100" align="right"><? echo $monto_p; ?></td>
         </tr>
         <?}?>
       </table></td>
   </tr>
 </table>
</body>
</html>
<?  pg_close();?>

<script language="JavaScript" type="text/JavaScript">
var mcodigo_mov='<?php echo $codigo_mov ?>';
function Llama_Incluir(codigo_mov){var murl;
    murl="Inc_asig_cargo.php?codigo_mov="+codigo_mov; document.location=murl;
}
function Llama_Modificar(codigo_mov,fecha){var murl;
  if(fecha==""){alert("Informacion debe ser Seleccionada");} else{murl="Mod_asig_cargo.php?codigo_mov="+codigo_mov+"&fecha="+fecha; document.location=murl;}
}


</script>