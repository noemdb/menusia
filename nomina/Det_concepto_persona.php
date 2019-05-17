<?include ("../class/conect.php");  include ("../class/funciones.php");
if (!$_GET){$codigo="";} else{$codigo=$_GET["Gcodigo"];} $tipo_nomina=substr($codigo,0,2);$cod_concepto=substr($codigo,2,3);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Detalles Trabajadores Asignar Concepto)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<script language="JavaScript" type="text/JavaScript">
function Llama_Modificar(codigo,cod_emp){var murl;
  if(cod_emp==""){alert("Informacion debe ser Seleccionada");}
  else{murl="Insert_concepto_persona.php?codigo="+codigo+"&cod_emp="+cod_emp; document.location=murl;}
}
</script>
<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="left"><table width="840" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="222" align="center">&nbsp;</td>
            <td width="255" align="center">&nbsp;</td>
            <td width="215" align="center">&nbsp;</td>
            <td width="215" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar la Informaci&oacute;n Familiar"></td>
          </tr>
      </table></td>
    </tr>
    <tr><td>&nbsp;</td></tr>
   <tr>
     <td>
<?$sql="SELECT NOM006.cod_empleado,NOM006.cedula,NOM006.nombre,NOM006.tipo_nomina,NOM006.status,NOM006.calculo_grupos,NOM006.fecha_ingreso,NOM006.cod_categoria FROM NOM006 Where (NOM006.status='ACTIVO' or NOM006.status='VACACIONES' or NOM006.status='REPOSO') And (NOM006.tipo_nomina='$tipo_nomina') And (NOM006.cod_empleado not in (select NOM011.cod_empleado from NOM011 Where NOM011.tipo_nomina='$tipo_nomina' and NOM011.cod_concepto='$cod_concepto')) ORDER BY NOM006.cod_empleado";   $res=pg_query($sql);
?>
       <table width="840"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="100" align="center" bgcolor="#99CCFF"><strong>C&oacute;digo</strong></td>
           <td width="90" align="center" bgcolor="#99CCFF"><strong>Cedula</strong></td>
           <td width="440" align="center" bgcolor="#99CCFF"><strong>Nombre</strong></td>
           <td width="90" align="center" bgcolor="#99CCFF" ><strong>Fecha Ingreso </strong></td>
           <td width="90" align="center" bgcolor="#99CCFF" ><strong>Cod.Categoria</strong></td>
           </tr>
<? while($registro=pg_fetch_array($res)){ $sfecha=$registro["fecha_ingreso"];  $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4); ?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<? echo $codigo; ?>','<? echo $registro["cod_empleado"]; ?>');">
           <td width="100" align="left"><? echo $registro["cod_empleado"]; ?></td>
           <td width="90" align="left"><? echo $registro["cedula"]; ?></td>
           <td width="440" align="left"><? echo $registro["nombre"]; ?></td>
           <td width="90" align="left"><? echo $fecha; ?></td>
           <td width="90" align="left"><? echo $registro["cod_categoria"]; ?></td>
           </tr>
         <?}?>
       </table></td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?  pg_close();?>