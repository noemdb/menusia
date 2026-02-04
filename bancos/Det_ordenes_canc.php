<?php include ("../class/conect.php");  include ("../class/funciones.php"); $fechac=asigna_fecha_hoy(); $fechac=formato_aaaammdd($fechac);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$codigo_mov='';$orden="N";$mostrar="S";}else{$codigo_mov=$_GET["codigo_mov"];$orden=$_GET["orden"];$mostrar=$_GET["mostrar"];}  $fecha_hoy=asigna_fecha_hoy();
$multiple="N"; $StrSQL="select * from ban030 where codigo_mov='$codigo_mov'"; $res=pg_query($StrSQL);$filas=pg_num_rows($res);
if($filas>=1){$registro=pg_fetch_array($res,0); $multiple=$registro["status_1"]; $fechac=$registro["fecha"]; if ($multiple=="S"){$orden="R";} }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Detalles Emision de Cheques)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<script language="JavaScript" type="text/JavaScript">
function Llama_Modificar(codigo_mov,rif,orden,tipo,selec,mord,mult,mmost,mfechac,mtipor){var murl;
   murl="Selec_Orden_Cancelar.php?codigo_mov="+codigo_mov+"&ced_rif="+rif+"&nro_orden="+orden+"&tipo="+tipo+"&selec="+selec+'&orden='+mord+"&multiple="+mult+'&mostrar='+mmost+'&fechac='+mfechac+'&tipo_ret='+mtipor; document.location=murl;
}
function Act_Multiple(codigo_mov,mult){var murl;   murl="Act_multiple_chq.php?codigo_mov="+codigo_mov+"&multiple="+mult; document.location=murl;}
function Camb_Orden(codigo_mov,mord,mmost){
var murl;   if (mord=="N"){mord="R";} else {mord="N";}
   murl="Det_ordenes_canc.php?codigo_mov="+codigo_mov+'&orden='+mord+'&mostrar='+mmost;  document.location=murl;
}
function Emitir_chq(codigo_mov,mord,mult){var murl;   murl="Emite_chq.php?codigo_mov="+codigo_mov+'&orden='+mord+"&multiple="+mult; document.location=murl;}
</script>
<style type="text/css">
<!--
.Estilo19 {color: #0000CC; font-weight: bold; font-size: 13pt; }
-->
</style>
<body>
<table width="1000" border="0" cellspacing="0" cellpadding="0">
    <tr>
     <td width="50">&nbsp;</td>
     <?php  if($mostrar=="S"){ ?>
     <td width="200"><input name="btMultiple" type="button" id="btMultiple" value="Multiple" title="Seleccionar Ordenes Multiples" onclick="javascript:Act_Multiple('<?php  echo $codigo_mov; ?>','<?php  echo $multiple; ?>');"></td>
     <td width="250"><input name="btOrden" type="button" id="btOrden" value="Cambiar Orden" title="Cambiar M�todo de Ordenaci�n" onclick="javascript:Camb_Orden('<?php  echo $codigo_mov; ?>','<?php  echo $orden; ?>','<?php  echo $mostrar; ?>');"></td>
     <?php }else{ ?> <td width="450">&nbsp;</td> <?php }?>
     <td width="250">&nbsp;</td>
     <td width="200"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar las Ordenes Retenci�n a cancelar"></td>
  </tr>
    <tr height="5">
      <td><p>&nbsp;</p></td>
    </tr>
</table>
<?php
if ($orden=="N"){$ordenar="order by nro_orden,tipo_causado";} else {$ordenar="order by ced_rif,nro_orden,tipo_causado";}
$sql="SELECT * FROM pag027 where codigo_mov='$codigo_mov' ".$ordenar; $res=pg_query($sql);
?>
 <table width="2010" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="2000">
       <table width="2000"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_orden">
         <tr height="20" class="Estilo5">
           <td width="20"  align="left" bgcolor="#99CCFF"><strong>Sel.</strong></td>
           <td width="80"  align="left" bgcolor="#99CCFF"><strong>Orden</strong></td>
           <td width="80" align="left" bgcolor="#99CCFF"><strong>Fecha</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>Descripcion</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Monto</strong></td>
		   <?php  if($mostrar=="S"){ ?>
		   <td width="60" align="left" bgcolor="#99CCFF" ><strong>Tipo Ord.</strong></td>
		   <?php }else{ ?>
		   <td width="60" align="left" bgcolor="#99CCFF" ><strong>Tipo Ret.</strong></td>
		   <?php } ?>
           <td width="120" align="left" bgcolor="#99CCFF" ><strong>Ced.Rif</strong></td>
           <td width="200" align="left" bgcolor="#99CCFF" ><strong>Nombre Benef.</strong></td>          
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Retencion</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Ajuste</strong></td>
           <td width="120" align="left" bgcolor="#99CCFF" ><strong>Tipo Documento</strong></td>
           <td width="140" align="left" bgcolor="#99CCFF" ><strong>Nro. Documento</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Amortiza</strong></td>
           <td width="120" align="left" bgcolor="#99CCFF" ><strong>Cta.Amort.</strong></td>
           <td width="60"  align="center" bgcolor="#99CCFF"><strong>Gen.Comp</strong></td>
           <td width="140" align="left" bgcolor="#99CCFF" ><strong>Cod.Orden</strong></td>
         </tr>
         <?php  $total=0; $cant=0;
while($registro=pg_fetch_array($res)) { $monto=$registro["monto_orden"];  $nomb_benef=$registro["nombre"];
if($registro["seleccionada"]=='S'){$selec='*';$total=$total+$registro["monto_orden"]; $cant=$cant+1;}else{$selec='';} $monto=formato_monto($monto);
$sfecha=$registro["fecha"];  $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4);
$monto_r=formato_monto($registro["total_retencion"]);  $monto_a=formato_monto($registro["total_ajuste"]);  $amortiza=formato_monto($registro["monto_am_ant"]);
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<?php  echo $codigo_mov; ?>','<?php  echo $registro["ced_rif"]; ?>','<?php  echo $registro["nro_orden"]; ?>','<?php  echo $registro["tipo_causado"]; ?>','<?php  echo $registro["seleccionada"]; ?>','<?php  echo $orden; ?>','<?php  echo $multiple; ?>','<?php  echo $mostrar; ?>','<?php  echo $fechac; ?>','<?php  echo $registro["campo_str2"]; ?>');">
           <?php  if ($selec=="*") {?><td width="20" align="left"><?php  echo $selec; ?></td>
           <?php }else{?> <td width="20" align="left">&nbsp;</td> <?php }?>
           <td width="80" align="left"><?php  echo $registro["nro_orden"]; ?></td>
           <td width="80" align="left"><?php  echo $fecha; ?></td>
           <td width="400" align="left"><?php  echo substr($registro["concepto"],0,100); ?></td>
           <td width="100" align="right"><?php  echo $monto; ?></td>
		   <?php  if($mostrar=="S"){ ?>
		    <td width="60" align="left"><?php  echo $registro["tipo_orden"]; ?></td>
		   <?php }else{ ?>
		   <td width="60" align="left"><?php  echo $registro["campo_str2"]; ?></td>
		   <?php } ?>
           <td width="120" align="left"><?php  echo $registro["ced_rif"]; ?></td>
           <td width="200" align="left"><?php  echo $nomb_benef ?></td>           
           <td width="100" align="right"><?php  echo $monto_r; ?></td>
           <td width="100" align="right"><?php  echo $monto_a; ?></td>
           <td width="100" align="left"><?php  echo $registro["tipo_documento"]; ?></td>
           <?php  if ($registro["nro_documento"]=="") {?>
           <td width="140" align="left">&nbsp;</td>
           <?php }else{?>
           <td width="140" align="left"><?php  echo substr($registro["nro_documento"],1,40); ?></td>
           <?php }?>
           <td width="100" align="right"><?php  echo $amortiza; ?></td>
           <?php  if ($registro["campo_str1"]=="") {?>
           <td width="120" align="left">&nbsp;</td>
           <?php }else{?>
           <td width="120" align="left"><?php  echo $registro["campo_str1"]; ?></td>
           <?php }?>
           <td width="60" align="center"><?php  echo $registro["genera_comp"]; ?></td>
           <td width="140" align="left"><?php  echo $registro["cod_contable_o"]; ?></td>
         </tr>
         <?php }
 $total=formato_monto($total);
?>
       </table></td>
   </tr>   
   <tr> <td>&nbsp;</td> </tr>
   <tr>
     <td><table width="830" border="0">
       <tr>
         <?php if ($multiple=="N"){?> <td width="530">&nbsp;</td>
         <?php }else{?>  <td width="530"><span class="Estilo19">MULTIPLE :  <?php  echo $cant; ?></span></td> <?php }?>
         <td width="150" align="center"><span class="Estilo5">TOTAL :</span></td>
         <td><table width="125" border="1" cellspacing="0" cellpadding="0">
           <tr> <td width="123" align="right" class="Estilo5"><?php  echo $total; ?></td> </tr>
         </table></td>
       </tr>
     </table></td>
   </tr>
   <a name="abajo"></a>
 </table>
</body>
</html>
<?php  pg_close($conn); ?>