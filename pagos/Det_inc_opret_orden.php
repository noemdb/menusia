<?include ("../class/conect.php");  include ("../class/funciones.php");  include ("../class/configura.inc"); if (!$_GET){$codigo_mov='';} else{$codigo_mov=$_GET["codigo_mov"];}
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else{ $Nom_Emp=busca_conf(); }
$tipo_ret_d="001"; $tipo_ret_h="999"; if (isset($_GET['tipo_ret_d'])) { $tipo_ret_d=$_GET["tipo_ret_d"];}  if (isset($_GET['tipo_ret_h'])) { $tipo_ret_h=$_GET["tipo_ret_h"];} 
//echo $tipo_ret_d." ".$tipo_ret_h;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGO (Incluir Ordenes de Retencion Canceladas)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llama_Cargar_Codigos(mcodigo_mov){var murl; var tipo_ret_d=document.form1.txttipo_ret_d.value; var tipo_ret_h=document.form1.txttipo_ret_h.value; 
  murl="Carga_Orden_Cancelar.php?codigo_mov="+mcodigo_mov+"&tipo_ret_d="+tipo_ret_d+"&tipo_ret_h="+tipo_ret_h; document.location=murl;
}
function Llama_seleccion(mcodigo_mov,n_orden,tipo_ret,cod_cont,selec){var murl;
  murl="Selec_Orden_Cancelar.php?codigo_mov="+mcodigo_mov+"&nro_orden="+n_orden+"&tipo_ret="+tipo_ret+"&cod_cont="+cod_cont+"&selec="+selec;   document.location=murl;
}
</script>
</head>
<body>
 <table width="904" border="0" cellspacing="0" cellpadding="0">
   <form name="form1" >
   <tr>
     <td colspan="4"><table width="900" border="0">
       <tr>
         <td width="150"><span class="Estilo5">TIPO DE RETENCION DESDE :</span></td>
		  <td width="50"><span class="Estilo5"><input class="Estilo10" name="txttipo_ret_d" type="text" id="txttipo_ret_d" size="4" maxlength="3"  onFocus="encender(this)" onBlur="apagar(this)"   value="<?echo $tipo_ret_d?>" > </span></td>
		  <td width="50"><span class="Estilo5"><input class="Estilo10" name="Catalogo3" type="button" id="Catalogo3" title="Abrir Catalogo de Tipos de Retenciones" onClick="VentanaCentrada('Cat_tipo_retd.php?criterio=','SIA','','750','500','true')" value="...">  </span></td>
          <td width="50"><span class="Estilo5">HASTA :</span></td>
		  <td width="50"><span class="Estilo5"><input class="Estilo10" name="txttipo_ret_h" type="text" id="txttipo_ret_h" size="4" maxlength="3"  onFocus="encender(this)" onBlur="apagar"   value="<?echo $tipo_ret_h?>" > </span></td>
		  <td width="90"><span class="Estilo5"><input class="Estilo10" name="Catalogo4" type="button" id="Catalogo4" title="Abrir Catalogo de Tipos de Retenciones" onClick="VentanaCentrada('Cat_tipo_reth.php?criterio=','SIA','','750','500','true')" value="...">  </span></td>
        <td width="220"><input name="btCargar" type="button" id="btCargar" value="Cargar" title="Cargar Ordenes de Retencion a Cancelar" onclick="javascript:Llama_Cargar_Codigos('<?echo $codigo_mov?>')"></td>
        <td width="220"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar las Ordenes Retencion a cancelar"></td>
        <td width="60">&nbsp;</td>
       </tr>
     </table></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td>
<?php
$sql="SELECT * FROM ord_ret_canc  where codigo_mov='$codigo_mov' and (tipo_retencion>='$tipo_ret_d' and tipo_retencion<='$tipo_ret_h')order by nro_orden_ret,tipo_retencion";$res=pg_query($sql);
?>
       <table width="1200"  border="1" cellspacing='0' cellpadding='0' align="left" id="ord_ret_canceladas">
         <tr height="20" class="Estilo5">
           <!-- <td width="20"  align="left" bgcolor="#99CCFF"><strong>N.</strong></td> -->
           <td width="20"  align="left" bgcolor="#99CCFF"><strong>Sel.</strong></td>
           <td width="80"  align="left" bgcolor="#99CCFF"><strong>Orden</strong></td>
           <td width="500" align="left" bgcolor="#99CCFF"><strong>Concepto</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF"><strong>Monto</strong></td>
           <td width="30" align="left" bgcolor="#99CCFF"><strong>Tipo</strong></td>
           <td width="300" align="left" bgcolor="#99CCFF"><strong>Descripcion</strong></td>
           <td width="150" align="left" bgcolor="#99CCFF" ><strong>Codigo Cont.</strong></td>
         </tr>
         <? $total=0; $monto=0;$i=0;
          while($registro=pg_fetch_array($res)){$monto=$registro["monto_retencion"];
          if($registro["seleccionada"]=='N'){$selec=' ';}else{$selec='*';$total=$total+$registro["monto_retencion"];} $monto=formato_monto($monto);
         ?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_seleccion('<?echo $codigo_mov?>','<? echo $registro["nro_orden_ret"]; ?>','<? echo $registro["tipo_retencion"]; ?>','<? echo $registro["cod_contable_ret"]; ?>','<? echo $registro["seleccionada"]; ?>');" >
           <!-- <td width="20" align="left"><? echo ++$i; ?></td> -->
           <td width="20" align="left"><? echo $selec; ?></td>
           <td width="90" align="left"><? echo $registro["nro_orden_ret"]; ?></td>
           <td width="500" align="left"><? echo substr($registro["concepto"],0,100);  ?></td>
           <td width="100" align="right"><? echo $monto; ?></td>
           <td width="50" align="left"><? echo $registro["tipo_retencion"]; ?></td>
           <td width="300" align="left"><? echo $registro["descripcion_ret"]; ?></td>
           <td width="150" align="left"><? echo $registro["cod_contable_ret"]; ?></td>
         </tr>
<?}  $total=formato_monto($total); ?>
       </table></td>
   </tr>
   <tr>
     <td colspan="4">&nbsp;</td>
   </tr>
   <tr>
     <td colspan="4"><table width="800" border="0">
       <tr>
         <td width="500">&nbsp;</td>
         <td width="100"><span class="Estilo5">TOTAL  :</span></td>
         <td width="160"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr>
               <td align="right" class="Estilo5"><? echo $total; ?></td>
             </tr>
         </table></td>
       </tr>
     </table></td>
   </tr>
   </form>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?
  pg_close();
?>