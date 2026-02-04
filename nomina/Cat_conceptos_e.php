<?include ("../class/conect.php");  include ("../class/funciones.php"); if (!$_GET){$cod_arch_banco='';}else{$cod_arch_banco=$_GET["cod_arch_banco"];}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Conceptos N&oacute;mina Extraordinaria)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>

<body>
 <table width="630" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="left"><table width="630" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="210" align="center" valign="middle"><input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Concepto a la Lista" onclick="javascript:LlamarURL('Inc_conceptos_e.php?cod_arch_banco=<?echo $cod_arch_banco?>&cod_concepto=&denominacion=')"></td>
            <td width="210" align="center" valign="middle"><input name="btCerrar" type="button" id="btCerrar" value="Cerrar" title="Cerrar  Ventas Lista concepto" onclick="javascript: window.close(); "></td>
            
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
//$sql="Select distinct nom061.cod_concepto,nom002.denominacion from nom061 left join nom002 on (nom002.cod_concepto=nom061.cod_concepto) where nom061.cod_arch_banco='$cod_arch_banco' order by nom061.cod_concepto"; $res=pg_query($sql);
$sql="Select * from nom061  where nom061.cod_arch_banco='$cod_arch_banco' order by nom061.cod_concepto"; $res=pg_query($sql);

?>
       <table width="610"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Concepto</strong></td>
           <td width="400" align="center" bgcolor="#99CCFF"><strong>Denominacion Concepto</strong></td>
       </tr>
         <? while($registro=pg_fetch_array($res)) { $denominacion=""; $cod_concepto=$registro["cod_concepto"]; 
		   $sqlb="Select * from NOM002 WHERE cod_concepto='$cod_concepto'"; $resb=pg_query($sqlb);  $filasb=pg_num_rows($resb);  if($filasb>0){$regb=pg_fetch_array($resb,0); $denominacion=$regb["denominacion"]; }
        ?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Eliminar('<? echo $cod_arch_banco; ?>','<? echo $registro["cod_concepto"]; ?>');" >
            <td width="100" align="left"><? echo $registro["cod_concepto"]; ?></td>
           <td width="400" align="left"><? echo $denominacion; ?></td>
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
  r=confirm("Esta seguro en Eliminar el Codigo de Concepto de la Lista ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar el Codigo de la Lista ?");
    if (r==true) { url="Delete_conc_e.php?cod_arch_banco="+cod_est+"&cod_concepto="+codigo;
	   document.location=url;
	   }    }
   else { url="Cancelado, no elimino"; }
}
</script>

<?   pg_close(); ?>