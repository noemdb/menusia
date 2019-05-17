<?include ("../class/conect.php");  include ("../class/funciones.php");  include ("../class/configura.inc"); if (!$_GET){$codigo_mov='';}else{$codigo_mov=$_GET["codigo_mov"];}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }  else{ $Nom_Emp=busca_conf(); }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGO (Incluir Pasivos de la Orden)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_pag.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
var mcodigo_mov='<?php echo $codigo_mov ?>';
function Llama_Modificar(codigo_mov,codigo,dc){var murl;
  if (codigo=="") {alert("Retencion debe ser Seleccionada");}
  else{ murl="Mod_pas_orden.php?codigo_mov="+codigo_mov+"&cod_cuenta="+codigo+"&debito_credito="+dc; document.location=murl;}
}
function chequea_genera(mform){var mgen;
   mgen=mform.txtgenera_comprobante.value;
   ajaxSenddoc('GET','apasord.php?pasivo_comp='+mgen+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'formacomp', 'innerHTML');
return true;}
function llama_agregar(){var mref='NO';
   mref=document.form1.txtgenera_comprobante.value;
   LlamarURL('Inc_pas_orden.php?codigo_mov=<?echo $codigo_mov?>&pasivo_comp='+mref+'&password=<?echo $password?>&user=<?echo $user?>&dbname=<?echo $dbname?>')
return true;}
function asig_genera_comp(mvalor){var f=document.form1;
    if(mvalor=="NO"){document.form1.txtgenera_comprobante.options[0].selected = true;}else{document.form1.txtgenera_comprobante.options[1].selected = true;}
}

function llama_ctas_activo(){var mref='SI';
   document.form1.txtgenera_comprobante.value=mref;
   LlamarURL('Gen_cta_activo.php?codigo_mov=<?echo $codigo_mov?>&pasivo_comp='+mref+'&password=<?echo $password?>&user=<?echo $user?>&dbname=<?echo $dbname?>')
return true;}

</script>
</head>
<body>
<form name="form1"  method="post" >
<?php
if (!$_GET){$codigo_mov='';} else{$codigo_mov=$_GET["codigo_mov"];}
$StrSQL="select * from pag036 where codigo_mov='$codigo_mov'";$resultado=pg_query($StrSQL); $filas=pg_num_rows($resultado);
if($filas==0){$pasivo_comp='NO';}else{$registro=pg_fetch_array($resultado);$pasivo_comp=$registro["pasivo_comp"];}
$sql="SELECT * FROM cod_pasivo  where codigo_mov='$codigo_mov' order by cod_cuenta";$res=pg_query($sql);
?>
<table width="904" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
       <table width="850" >
         <tr>		 
			 <td width="300"><div id="formacomp"> <span class="Estilo5">CUENTAS FORMAN PARTE DEL COMPROBANTE:</span>  </div></td>
			 <td width="100"><span class="Estilo5">
			 <select name="txtgenera_comprobante" size="1" id="txtgenera_comprobante" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_genera(this.form);">
			   <option>NO</option>  <option>SI</option>  </select>
			   <script language="JavaScript" type="text/JavaScript"> asig_genera_comp('<?echo $pasivo_comp;?>');</script> </span></td>
			 <td width="180"><input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Cuentas a otros pasivos" onclick="javascript:llama_agregar();"></td>
			 <td width="180"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar los Codigos de otros Pasivos"></td>
			 <?if($Cod_Emp=="58"){?>
			 <td width="160"><input name="btActivos" type="button" id="btActivos" value="Activos" title="Agregar Cuentas de Activos Automatico" onclick="javascript:llama_ctas_activo();"></td>
			 <?} else {?>
			 <td width="160">&nbsp;</td>
			 <?}?>
		  </tr>	 
		</table> 
      </td>		
   </tr>
   <tr>
     <td>&nbsp;</table>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td colspan="4">
       <table width="820"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_pasivo">
         <tr height="20" class="Estilo5">
           <td width="180"  align="left" bgcolor="#99CCFF"><strong>Cuenta</strong></td>
           <td width="500" align="left" bgcolor="#99CCFF"><strong>Nombre</strong></td>
           <td width="35" align="center" bgcolor="#99CCFF"><strong>D/C</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Monto </strong></td>
         </tr>
         <? $total=0;
while($registro=pg_fetch_array($res))
{ $monto=$registro["monto_pasivo"]; $tipo_DC=$registro["debito_credito"];$total=$total+$monto;$monto=formato_monto($monto);
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<? echo $codigo_mov; ?>','<? echo $registro["cod_cuenta"]; ?>','<? echo $registro["debito_credito"]; ?>');">
           <td width="180" align="left"><? echo $registro["cod_cuenta"]; ?></td>
           <td width="500" align="left"><? echo $registro["nombre_cuenta"]; ?></td>
           <td width="35" align="center"><? echo $tipo_DC; ?></td>
           <td width="100" align="right"><? echo $monto; ?></td>
         </tr>
         <?}
 $total=formato_monto($total);
?>
       </table></td>
   </tr>
   <tr>
     <td colspan="4">&nbsp;</td>
   </tr>
   <tr>
     <td colspan="4"><table width="800" border="0">
       <tr>
         <td width="506">&nbsp;</td>
         <td width="113"><span class="Estilo5">TOTAL PASIVOS :</span></td>
         <td width="167"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr>
               <td align="right" class="Estilo5"><? echo $total; ?></td>
             </tr>
         </table></td>
       </tr>
     </table></td>
   </tr>
 </table>
 <p>&nbsp;</p>
 </form>
</body>
</html>
<?
  pg_close();
?>