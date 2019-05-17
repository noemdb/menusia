<?include ("../class/conect.php");  include ("../class/funciones.php"); if (!$_GET){$codigo_mov='';}else{$codigo_mov=$_GET["codigo_mov"];}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Conceptos N&oacute;mina Extraordinaria)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>

<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="left"><table width="840" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="210" align="center" valign="middle"><input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Concepto al Calculo" onclick="javascript:LlamarURL('Inc_conc_nom_ext.php?codigo_mov=<?echo $codigo_mov?>')"></td>
            <td width="215" align="center">&nbsp;</td>
            <td width="210" align="center" valign="middle"><input name="btAgregar" type="button" id="btcesta" value="Conceptos CESTATICKET" title="Agregar Concepto de Cesta Ticket" onclick="javascript:LlamarURL('Inc_conc_cesta.php?codigo_mov=<?echo $codigo_mov?>')"></td>
            
            <td width="210" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar los Codigos de los Conceptos"></td>
          </tr>
      </table></td>
    </tr>
    <tr height="5">
      <td> <p>&nbsp;</p></td>
    </tr>
   <tr>
     <td>
<?php
$sql="Select * from nom066 where codigo_mov='$codigo_mov' order by cod_concepto"; $res=pg_query($sql);
?>
       <table width="910"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Concepto</strong></td>
           <td width="400" align="center" bgcolor="#99CCFF"><strong>Denominacion Concepto</strong></td>
           <td width="130" align="center" bgcolor="#99CCFF" ><strong>Asignacion</strong></td>
           <td width="130" align="center" bgcolor="#99CCFF" ><strong>Oculta</strong></td>
           <td width="160" align="center" bgcolor="#99CCFF" ><strong>Frecuencia</strong></td>
       </tr>
         <? $total=0;
while($registro=pg_fetch_array($res)) {$frec=$registro["frecuencia"]; if($frec=="1"){$frecuencia="PRIMERA QUINCENA";} if($frec=="2"){$frecuencia="SEGUNDA QUINCENA";} if($frec=="3"){$frecuencia="PRIMERA Y SEGUNDA QUINC.";}
if($frec=="4"){$frecuencia="PRIMERA SEMANA";} if($frec=="5"){$frecuencia="SEGUNDA SEMANA";} if($frec=="6"){$frecuencia="TERCERA SEMANA";}
if($frec=="7"){$frecuencia="CUARTA SEMANA";} if($frec=="8"){$frecuencia="TODAS LAS SEMANAS";} if($frec=="9"){$frecuencia="ULTIMA SEMANA";}
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Eliminar('<? echo $codigo_mov; ?>','<? echo $registro["cod_concepto"]; ?>');" >
            <td width="100" align="left"><? echo $registro["cod_concepto"]; ?></td>
           <td width="350" align="left"><? echo $registro["denominacion"]; ?></td>
           <td width="30" align="center"><? echo $registro["asignacion"]; ?></td>
           <td width="30" align="center"><? echo $registro["oculto"]; ?></td>
           <td width="170" align="left"><? echo $frecuencia; ?></td>
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
  r=confirm("Esta seguro en Eliminar el Codigo de Concepto del Calculo ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar el Codigo de Concepto del Calculo ?");
    if (r==true) { url="Delete_conc_ext.php?codigo_mov="+cod_est+"&cod_concepto="+codigo;
	   document.location=url;
	   }    }
   else { url="Cancelado, no elimino"; }
}
</script>

<?   pg_close(); ?>