<?php include ("../../class/conect.php");  include ("../../class/funciones.php");
if (!$_GET){$ano_fiscal=""; $mes_fiscal=""; $nro_comprobante=""; $critero="";} else{$critero=$_GET["criterio"]; $nro_comprobante=substr($criterio,6,8);  $ano_fiscal=substr($criterio,0,4);  $mes_fiscal=substr($criterio,4,2);}
$fecha_hoy=asigna_fecha_hoy();  $clave=$ano_fiscal.$mes_fiscal.$nro_comprobante;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (Comprobante Retenciones IVA)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel=stylesheet>
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->


</script>
<style type="text/css">
<!--
.Estilo19 {font-family: Arial, Helvetica, sans-serif; font-size: 7px;}
.Estilo20 {font-family: Arial, Helvetica, sans-serif; font-size: 10px}
.Estilo22 {font-family:  Arial, Helvetica, sans-serif; font-size: 7px; }
-->
</style>
<style type="text/css" media="print">
<!--
.page {writing-mode: tb-rl;height: 80%;margin: 10% 0%;}
-->
</style> 
</head>
<?php 
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }  $error=0;
$direccion="CALLE 48 CON CARRERA 13 EDIF HIDROLARA, PISO 2, LOCAL S/N, SECTOR SAN VICENTE-CAJA DE AGUA"; $nombre_emp="HIDROLARA C.A."; $ced_rif_emp="G-20009014-6";
$ced_rif="";  $nombre_benef=""; $fecha_e="";
$sql="Select * from COMP_IVA where ano_fiscal='$ano_fiscal' and  mes_fiscal='$mes_fiscal' and nro_comprobante='$nro_comprobante' and monto_iva_retenido>0"; $res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){ $fecha_e=$registro["fecha_emision"];  $ced_rif=$registro["ced_rif"];  $nombre_benef=$registro["nombre"]; $referencia=$registro["referencia"];  $inf_usuario=$registro["inf_usuario"];}
else{$error=1; ?> <script language="JavaScript">muestra('COMPROBANTE IVA NO LOCALIZADO');</script><?php }
if($fecha_e==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha_e);} $nro_comp=$ano_fiscal.'-'.$mes_fiscal.'-'.$nro_comprobante;
?>
<body>
 
<table width="1081" height="640" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<div id="Layer1" style="position:absolute; width:1070px; height:141px; z-index:1; top: 14px; left: 13px;">
      
      <table width="1064" height="137" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="355" height="72">&nbsp;</td>
            <td width="709"><div id="Layer2" style="position:absolute; width:118px; height:127px; z-index:2; left: 16px; top: 4px;"><img src="../../imagenes/Logo_empresa.gif" width="115" height="110" border="0"></div>
              <table width="696" height="120" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td height="80"><table width="695" height="70" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="222" height="38">&nbsp;</td>
                        <td width="242"><table width="215" height="47" border="1" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                              <td><table width="205" height="45" border="0" cellpadding="4" cellspacing="2">
                                  <tr>
                                    <td><span class="Estilo19"> 0.- NRO. DE COMPROBANTE</span></td>
                                  </tr>
                                  <tr>
                                    <td align="center"><span class="Estilo20"><?php echo $nro_comp?></span></td>
                                  </tr>
                              </table></td>
                            </tr>
                        </table></td>
                        <td width="231"><table width="215" height="47" border="1" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                              <td><table width="205" height="45" border="0" cellpadding="4" cellspacing="2">
                                  <tr>
                                    <td><span class="Estilo19">1.- FECHA </span></td>
                                  </tr>
                                  <tr>
                                    <td align="center"><span class="Estilo20"><?php echo $fecha?></span></td>
                                  </tr>
                              </table></td>
                            </tr>
                        </table></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="30"><span class="Estilo19">Ley IVA - At. 11: &quot;Ser&aacute;n responsables del pago del impuesto en calidad de agentes de retenci&oacute;n, los compradores o adquirientes de<br>
      determinados bienes muebles y los receptores de ciertos servicios, a quienes la Administraci&oacute;n designe como tal&quot;</span></td>
                </tr>
              </table></td>
          </tr>
      </table>
    </div></td>
  </tr>
  <tr><td><div id="Layer2" style="position:absolute; width:1067px; height:101px; z-index:2; top: 150px; left: 15px;">
   
   <table width="1055" height="69" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td><table width="1047" height="37" border="0" cellpadding="0" cellspacing="0">
         <tr>
           <td width="583"><table width="548" height="37" border="1" align="center" cellpadding="0" cellspacing="0">
             <tr>
               <td><table width="401" height="35" border="0" cellpadding="4" cellspacing="2">
                   <tr>
                     <td><span class="Estilo19"> 2.- NOMBRE O RAZ&Oacute;N SOCIAL DEL AGENTE DE RETENCI&Oacute;N</span></td>
                   </tr>
                   <tr>
                     <td><span class="Estilo20"><?php echo $nombre_emp?></span></td>
                   </tr>
               </table></td>
             </tr>
           </table></td>
           <td width="280"><table width="270" height="37" border="1" align="center" cellpadding="0" cellspacing="0">
             <tr>
               <td><table width="265" height="35" border="0" cellpadding="4" cellspacing="2">
                   <tr>
                     <td><span class="Estilo19"> 3.- REGISTRO DE INFORMACI&Oacute;N FISCAL DEL AGENTE DE RETENCI&Oacute;N</span></td>
                   </tr>
                   <tr>
                     <td><span class="Estilo20"><?php echo $ced_rif_emp?></span></td>
                   </tr>
               </table></td>
             </tr>
           </table></td>
           <td width="163"><table width="150" height="37" border="1" align="center" cellpadding="0" cellspacing="0">
             <tr>
               <td><table width="140" height="35" border="0" cellpadding="4" cellspacing="2">
                   <tr>
                     <td><span class="Estilo19"> 4.- PERIODO FISCAL</span></td>
                   </tr>
                   <tr>
                     <td><span class="Estilo20">A&Ntilde;O:<?php echo $ano_fiscal?>  MES:<?php echo $mes_fiscal?></span></td>
                   </tr>
               </table></td>
             </tr>
           </table></td>
         </tr>
       </table></td>
     </tr>
	 <tr><td>&nbsp;</td></tr>
     <tr>
       <td><table width="1013" height="37" border="1" align="center" cellpadding="0" cellspacing="0">
         <tr>
           <td width="938"><table width="923" height="35" border="0" cellpadding="4" cellspacing="2">
             <tr>
               <td width="911"><span class="Estilo19">5.- DIRECCI&Oacute;N FISCAL DEL AGENTE DE RETENCI&Oacute;N </span></td>
             </tr>
             <tr>
               <td><span class="Estilo20"><?php echo $direccion?></span></td>
             </tr>
           </table></td>
         </tr>
       </table></td>
     </tr>
	 <tr><td>&nbsp;</td>
	 </tr>
	 <tr>
       <td><table width="1046" height="37" border="0" cellpadding="2" cellspacing="2">
         <tr>
           <td width="583"><table width="550" height="35" border="1" align="center" cellpadding="0" cellspacing="0">
             <tr>
               <td><table width="401" height="35" border="0" cellpadding="4" cellspacing="2">
                   <tr>
                     <td><span class="Estilo19"> 2.- NOMBRE O RAZ&Oacute;N SOCIAL DEL SUJETO RETENIDO</span></td>
                   </tr>
                   <tr>
                     <td><span class="Estilo20"><?php echo $nombre_benef?></span></td>
                   </tr>
               </table></td>
             </tr>
           </table></td>
           <td width="280"><table width="270" height="37" border="1" align="center" cellpadding="0" cellspacing="0">
             <tr>
               <td><table width="265" height="35" border="0" cellpadding="4" cellspacing="2">
                   <tr>
                     <td><span class="Estilo19"> 3.- REGISTRO DE INFORMACI&Oacute;N FISCAL DEL SUJETO RETENIDO</span></td>
                   </tr>
                   <tr>
                     <td><span class="Estilo20"><?php echo $ced_rif?></span></td>
                   </tr>
               </table></td>
             </tr>
           </table></td>
           <td width="163"><table width="120" height="37" border="0" align="center" cellpadding="0" cellspacing="0">
             <tr>
               <td><table width="118" height="35" border="0" cellpadding="4" cellspacing="2">
                   <tr><td>&nbsp;</td></tr>
                   <tr><td>&nbsp;</td></tr>
               </table></td>
             </tr>
           </table></td>
         </tr>
       </table></td>
     </tr>
   </table>
  </div></td></tr>
  
  <tr><td><div id="Layer3" style="position:absolute; width:1067px; height:97px; z-index:2; top: 350px; left: 21px;">
  <table width="1065" height="80" border="0"  cellpadding="0" cellspacing="0">
    <tr><td><table width="1050" border="1"  height="30" cellpadding="3" cellspacing="0">
       <tr>
          <td width="40" align="center"><span class="Estilo19">OPER. No</span></td>
          <td width="55" align="center"><span class="Estilo19">FECHA DE LA FACTURA</span></td>
          <td width="90" align="center"><span class="Estilo22">NUMERO DE LA FACTURA</span></td>
          <td width="80" align="center"><span class="Estilo19">NUMERO CONTROL DE LA FACTURA</span></td>
          <td width="70" align="center"><span class="Estilo19">NUMERO NOTA DEBITO</span></td>
		  <td width="70" align="center"><span class="Estilo19">NUMERO NOTA CREDITO</span></td>
          <td width="50" align="center"><span class="Estilo19">TIPO DE TRANSACC.</span></td>
          <td width="75" align="center"><span class="Estilo19">NUMERO DE FACTURA AFECTADA</span></td>
          <td width="77" align="center"><span class="Estilo19">TOTAL COMPRAS INCLUYENDO IVA</span></td>
		  <td width="77" align="center"><span class="Estilo19">COMPRAS SIN DERECHO A CREDITO IVA</span></td>
		  <td width="77" align="center"><span class="Estilo19">BASE IMPONIBLE</span></td>
          <td width="30" align="center"><span class="Estilo19">% ALIC.</span></td>
          <td width="75" align="center"><span class="Estilo19">IMPUESTO IVA</span></td>
          <td width="70" align="center"><span class="Estilo19">IVA RETENIDO</span></td>
		</tr>
<?php  $total_d=0;  $total_e=0;  $total_b=0;  $total_iva=0;  $total_ret=0;
$sql="SELECT * FROM BAN027 where ano_fiscal='$ano_fiscal' and  mes_fiscal='$mes_fiscal' and nro_comprobante='$nro_comprobante' order by nro_operacion"; $res=pg_query($sql);
while(($registro=pg_fetch_array($res))and($error==0)){ $sfecha=$registro["fecha_documento"]; $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4);
$monto=formato_monto($registro["monto_documento"]); $montob=formato_monto($registro["base_imponible"]);  $montos=formato_monto($registro["monto_exento_iva"]);
$retenc=formato_monto($registro["tasa_retencion"]); $montoi=formato_monto($registro["monto_iva"]); $tasa=formato_monto($registro["tasa_iva"]); $montor=formato_monto($registro["monto_iva_retenido"]);
$total_d=$total_d+$registro["monto_documento"]; $total_e=$total_e+$registro["monto_exento_iva"]; $total_b=$total_b+$registro["base_imponible"];
$total_iva=$total_iva+$registro["monto_iva"]; $total_ret=$total_ret+$registro["monto_iva_retenido"];

 $espacio=" ";
$nro_fact="<pre>".$espacio."</pre>"; $nro_ndb=""; $nro_ncr="";  if($registro["tipo_documento"]=="01"){$nro_fact=$registro["nro_documento"];}
if($registro["tipo_documento"]=="02"){$nro_ndb=$registro["nro_documento"];} if($registro["tipo_documento"]=="03"){$nro_ncr=$registro["nro_documento"];}
if($nro_ndb==""){$nro_ndb="<pre>".$espacio."</pre>";} if($nro_ncr==""){$nro_ncr="<pre>".$espacio."</pre>";}
$nro_fact_af=$registro["nro_doc_afectado"]; if($nro_fact_af==""){$nro_fact_af="<pre>".$espacio."</pre>";}
?>
        <tr>
		   <td width="40" align="center"><span class="Estilo19"><?php  echo $registro["nro_operacion"]; ?></span></td>
           <td width="55" align="center"><span class="Estilo19"><?php  echo $fecha; ?></span></td>
           <td width="90" align="left"><span class="Estilo19"><?php  echo $nro_fact; ?></span></td>
           <td width="80" align="left"><span class="Estilo19"><?php  echo $registro["nro_con_documento"]; ?></span></td>
		   <td width="70" align="left"><span class="Estilo19"><?php  echo $nro_ndb; ?></span></td>
           <td width="70" align="left"><span class="Estilo19"><?php  echo $nro_ncr; ?></span></td> 
           <td width="55" align="center"><span class="Estilo19"><?php  echo $registro["tipo_transaccion"]; ?></span></td>
           <td width="75" align="left"><span class="Estilo19"><?php  echo $nro_fact_af ?></span></td>
           <td width="77" align="right"><span class="Estilo19"><?php  echo $monto; ?></td>
           <td width="77" align="right"><span class="Estilo19"><?php  echo $montos; ?></td>
           <td width="77" align="right"><span class="Estilo19"><?php  echo $montob; ?></td>
           <td width="30" align="right"><span class="Estilo19"><?php  echo $tasa; ?></td>
           <td width="75" align="right"><span class="Estilo19"><?php  echo $montoi; ?></td>
           <td width="70" align="right"><span class="Estilo19"><?php  echo $montor; ?></td>
		</tr>
<?php }
 $total_d=formato_monto($total_d); $total_e=formato_monto($total_e); $total_b=formato_monto($total_b);
 $total_ret=formato_monto($total_ret); $total_iva=formato_monto($total_iva);
?>         
       </table></td>  
      </tr>
	  <tr>
	  <td><table width="1050" border="1"  height="30" cellpadding="3" cellspacing="0">
	    <tr>
          <td width="588" align="center">&nbsp;</td>
          <td width="77" align="right"><span class="Estilo19"><?php  echo $total_d; ?></span></td>
		  <td width="77" align="right"><span class="Estilo19"><?php  echo $total_e; ?></span></td>
		  <td width="77" align="right"><span class="Estilo19"><?php  echo $total_b; ?></span></td>
          <td width="30" align="center"><span class="Estilo19">&nbsp;</span></td>
          <td width="75" align="right"><span class="Estilo19"><?php  echo $total_iva; ?></span></td>
          <td width="70" align="right"><span class="Estilo19"><?php  echo $total_ret; ?></span></td>
		</tr>
	  </table></td> 
	  </tr> 
	  
	  <tr>
	  <td><table width="1050" border="0"  height="90" cellpadding="3" cellspacing="0">
	    <tr>
          <td width="588" align="center">&nbsp;</td>         
		</tr>
	  </table></td> 
	  </tr> 
	  <tr>
	  <td><table width="1050" border="0" cellpadding="3" cellspacing="0">
	    <tr>
          <td width="107"></td>
          <td width="191"><span class="Estilo20">FIRMA DEL AGENTE DE RETENCION:</span></td>
          <td width="363">&nbsp;</td>
          <td width="204"><span class="Estilo20">FIRMA DEL CONTRIBUYENTE:</span></td>
          <td width="168"></td>
		</tr>
		<tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td><span class="Estilo20">FECHA:</span></td>
              <td>&nbsp;</td>
            </tr>
	  </table></td> 
	  </tr>
  </table>
  </div></td></tr>
  <tr><td>&nbsp;</td>
  </tr>
</table>

