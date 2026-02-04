<?php include ("../../class/conect.php");  include ("../../class/funciones.php");
$orden=$_GET["orden"];  $tipo_planilla=$_GET["tipo"];
$fecha_hoy=asigna_fecha_hoy();
$nombre_planilla="COMPROBANTE DE RETENCION DE IMPUESTO SOBRE LA RENTA";
if($tipo_planilla=="02"){$nombre_planilla="COMPROBANTE DE RETENCION DE 1*1000"; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (Comprobante Retenciones IVA)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
.Estilo21 {font-family: Arial, Helvetica, sans-serif; font-size: 14px}
.Estilo22 {font-family:  Arial, Helvetica, sans-serif; font-size: 7px; }
-->
</style>
</head>
<?php 
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$direccion="CALLE 48 CON CARRERA 13 EDIF HIDROLARA, PISO 2, LOCAL S/N, SECTOR VICENTE-CAJA DE AGUA"; $nombre_emp="HIDROLARA C.A."; $ced_rif_emp="G-20009014-6";
$nro_comp=""; $sustraendo=0; $descripcion_ret=""; $fechae=""; $tipo_en=""; $tipo_documento=""; $nro_documento=""; $nro_con_factura=""; $fecha=""; $descripcion=""; $tipo_operacion="A";
$ced_rif="";  $nombre_benef=""; $monto_r=0; $monto_o=0; $tasa=0; $error=0;
$sql="select * from planillas_ret where tipo_planilla='$tipo' and nro_orden='$orden' and anulada='N'"; $res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){  
  $orden=$registro["nro_orden"];  $aux_orden=$registro["aux_orden"]; $tipo_ret=$registro["tipo_retencion"];  $planilla=$registro["tipo_planilla"]; $nro_planilla=$registro["nro_planilla"]; $descripcion=$registro["descripcion"];
  $monto_r=formato_monto($registro["monto_retencion"]); $monto_o=formato_monto($registro["monto_objeto"]); $tasa=$registro["tasa"];
  $descripcion_ret=$registro["descripcion_ret"]; $tipo_en=$registro["tipo_en"];   $tipo_documento=$registro["tipo_documento"];
  $nro_documento=$registro["nro_documento"];  $nro_con_factura=$registro["nro_con_factura"]; $sfecha=$registro["fecha_factura"];
  $efecha=$registro["fecha_emision"]; $fechae = substr($efecha,8,2)."/".substr($efecha,5,2)."/".substr($efecha,0,4);
  $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4);
  $nro_comp=$nro_planilla; $ced_rif=$registro["ced_rif"];  $nombre_benef=$registro["nombre"];
  $sustraendo=$registro["sustraendo"];
} else{echo $sql;  $error=1; ?> <script language="JavaScript">muestra('COMPROBANTE  NO LOCALIZADO');</script><?php }

?>
<body>
<table width="930" height="546" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
        <div id="Layer1" style="position:absolute; width:777px; height:132px; z-index:1; top: 19px; left: 149px;">

      <table width="773" height="137" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="48" height="72">&nbsp;</td>
            <td width="835"><div id="Layer2" style="position:absolute; width:118px; height:127px; z-index:2; left: -129px; top: -5px;"><img src="../../imagenes/Logo_empresa.gif" width="115" height="110" border="0"></div>            <table width="761" height="120" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="808" height="80"><table width="745" height="76" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td height="38">&nbsp;</td>
                        <td><table width="180" height="47" border="1" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td><table width="175" height="45" border="0" cellpadding="4" cellspacing="2">
                                <tr>
                                  <td><span class="Estilo22"> 0.- NRO. DE COMPROBANTE</span></td>
                                </tr>
                                <tr>
                                  <td align="center"><span class="Estilo20"><?php echo $nro_comp?></span></td>
                                </tr>
                            </table></td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td width="537" height="38" align="center"><span class="Estilo21"><?php echo $nombre_planilla?></span></td>
                        <td width="208"><table width="180" height="47" border="1" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                              <td><table width="175" height="45" border="0" cellpadding="4" cellspacing="2">
                                  <tr>
                                    <td><span class="Estilo19">1.- FECHA </span></td>
                                  </tr>
                                  <tr>
                                    <td align="center"><span class="Estilo20"><?php echo $fechae?></span></td>
                                  </tr>
                              </table></td>
                            </tr>
                        </table></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="30">&nbsp;</td>
                </tr>
              </table></td>
          </tr>
      </table>
    </div></td>
  </tr>
  <tr><td><div id="Layer2" style="position:absolute; width:905px; height:101px; z-index:2; top: 150px; left: 15px;">

   <table width="895" height="69" border="0" cellpadding="0" cellspacing="0">
     <tr>
       <td><table width="878" height="27" border="0" cellpadding="0" cellspacing="0">
         <tr>
           <td width="583"><table width="548" height="47" border="1" align="center" cellpadding="0" cellspacing="0">
             <tr>
               <td><table width="401" height="45" border="0" cellpadding="4" cellspacing="2">
                   <tr>
                     <td><span class="Estilo19"> 2.- NOMBRE O RAZ&Oacute;N SOCIAL DEL AGENTE DE RETENCI&Oacute;N</span></td>
                   </tr>
                   <tr>
                     <td><span class="Estilo20"><?php echo $nombre_emp?></span></td>
                   </tr>
               </table></td>
             </tr>
           </table></td>
           <td width="280"><table width="270" height="47" border="1" align="center" cellpadding="0" cellspacing="0">
             <tr>
               <td><table width="265" height="45" border="0" cellpadding="4" cellspacing="2">
                   <tr>
                     <td><span class="Estilo19"> 3.- REGISTRO DE INFORMACI&Oacute;N FISCAL DEL AGENTE DE RETENCI&Oacute;N</span></td>
                   </tr>
                   <tr>
                     <td><span class="Estilo20"><?php echo $ced_rif_emp?></span></td>
                   </tr>
               </table></td>
             </tr>
           </table></td>

         </tr>
       </table></td>
     </tr>
         <tr><td>&nbsp;</td></tr>
     <tr> <td><table width="884" height="27" border="0" cellpadding="0" cellspacing="0">
         <tr>
       <td><table width="852" height="47" border="1" align="center" cellpadding="0" cellspacing="0">
         <tr>
           <td width="938"><table width="829" height="45" border="0" cellpadding="4" cellspacing="2">
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
       </table></td>
     </tr>
         <tr><td>&nbsp;</td>
         </tr>
         <tr>
       <td><table width="883" height="27" border="0" cellpadding="0" cellspacing="0">
         <tr>
           <td width="583"><table width="550" height="47" border="1" align="center" cellpadding="0" cellspacing="0">
             <tr>
               <td><table width="401" height="45" border="0" cellpadding="4" cellspacing="2">
                   <tr>
                     <td><span class="Estilo19"> 2.- NOMBRE O RAZ&Oacute;N SOCIAL DEL SUJETO RETENIDO</span></td>
                   </tr>
                   <tr>
                     <td><span class="Estilo20"><?php echo $nombre_benef?></span></td>
                   </tr>
               </table></td>
             </tr>
           </table></td>
           <td width="280"><table width="270" height="47" border="1" align="center" cellpadding="0" cellspacing="0">
             <tr>
               <td><table width="265" height="45" border="0" cellpadding="4" cellspacing="2">
                   <tr>
                     <td><span class="Estilo19"> 3.- REGISTRO DE INFORMACI&Oacute;N FISCAL DEL SUJETO RETENIDO</span></td>
                   </tr>
                   <tr>
                     <td><span class="Estilo20"><?php echo $ced_rif?></span></td>
                   </tr>
               </table></td>
             </tr>
           </table></td>
         </tr>
       </table></td>
     </tr>
   </table>
  </div></td></tr>

  <tr><td><div id="Layer3" style="position:absolute; width:897px; height:97px; z-index:2; top: 350px; left: 21px;">
  <table width="889" height="80" border="0"  cellpadding="0" cellspacing="0">
<?php if($tipo_documento=="FACTURA"){ ?>
    <tr><td><table width="865" border="1"  height="30" cellpadding="2" cellspacing="0">
       <tr>
          <td width="40" align="center"><span class="Estilo19">OPER. N.</span></td>
          <td width="55" align="center"><span class="Estilo19">FECHA DE LA FACTURA</span></td>
          <td width="90" align="center"><span class="Estilo22">NUMERO DE LA FACTURA</span></td>
          <td width="80" align="center"><span class="Estilo19">NUMERO CONTROL DE LA FACTURA</span></td>
          <td width="77" align="center"><span class="Estilo19">MONTO OPERACION</span></td>
                  <td width="77" align="center"><span class="Estilo19">BASE IMPONIBLE</span></td>
          <td width="30" align="center"><span class="Estilo19">% ALIC.</span></td>
          <td width="70" align="center"><span class="Estilo19">RETENIDO</span></td>
                </tr>
<?php  $total_d=0;  $total_s=0;  $total_b=0;  $total_iva=0;  $total_ret=0; $aplica_sust=1;
$monto_r="";$monto_o=""; $monto1=0; $monto2=0;  $nro_op=0;
if($tipo_planilla=="01"){$sql="SELECT * FROM PAG016  where nro_orden='$orden' order by nro_factura";}
else{$sql="SELECT * FROM PAG016  where nro_orden='$orden'  and status_2='N' order by nro_factura";}
$res=pg_query($sql);
while(($registro=pg_fetch_array($res))and($error==0)){  $sfecha=$registro["fecha_factura"]; $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4); $nro_op=$nro_op+1;
$nro_fact=$registro["nro_factura"]; $nro_control=$registro["nro_con_factura"];  $nro_fact=elimina_ceros($nro_fact);  $nro_control=elimina_ceros($nro_control);
$monto=$registro["monto_factura"]; $total_d=$total_d+$monto; $monto=formato_monto($monto);
$montos=$registro["monto_sin_iva"]; $total_s=$total_s+$montos; $montos=formato_monto($montos);
$tasa_iva=$registro["tasa_iva1"];  $tasa_iva=formato_monto($tasa_iva);
$montoo=$registro["monto_iva1_so"];  $montoo=formato_monto($montoo);
$montob=$registro["monto_iva4_so"];  $montor=($montob*$tasa)/100; $total_b=$total_b+$montob; $montob=formato_monto($montob);
if($aplica_sust==0){$montor=$montor-$sustraendo; $aplica_sust=1;}
$total_ret=$montor+$total_ret; $montor=formato_monto($montor);

?>
        <tr>
           <td width="40" align="center"><span class="Estilo19"><?php  echo $nro_op; ?></span></td>
           <td width="55" align="center"><span class="Estilo19"><?php  echo $fecha; ?></span></td>
           <td width="90" align="left"><span class="Estilo19"><?php  echo $nro_fact; ?></span></td>
           <td width="80" align="left"><span class="Estilo19"><?php  echo $nro_control; ?></span></td>
           <td width="77" align="right"><span class="Estilo19"><?php  echo $monto; ?></span></td>
           <td width="77" align="right"><span class="Estilo19"><?php  echo $montob; ?></span></td>
           <td width="30" align="right"><span class="Estilo19"><?php  echo $tasa; ?></span></td>
           <td width="70" align="right"><span class="Estilo19"><?php  echo $montor; ?></span></td>
                </tr>
<?php }
 $total_d=formato_monto($total_d); $total_s=formato_monto($total_s); $total_b=formato_monto($total_b);
 $prev_ret=$total_ret; $total_ret=formato_monto($total_ret); $total_iva=formato_monto($total_iva);
?>
       </table></td>
      </tr>
<?php }else { $total_d=$monto_o;  $total_s=0;  $total_b=$monto_o;  $total_iva=0;  $total_ret=$monto_r; $prev_ret=$total_ret;  $nro_op=1; ?>
    <tr><td><table width="865" border="1"  height="30" cellpadding="2" cellspacing="0">
       <tr>
          <td width="40" align="center"><span class="Estilo19">OPER. N.</span></td>
          <td width="55" align="center"><span class="Estilo19">FECHA DOCUMENTO</span></td>
          <td width="90" align="center"><span class="Estilo22">NUMERO DOCUMENTO</span></td>
          <td width="80" align="center"><span class="Estilo19">NUMERO CONTROL </span></td>
          <td width="77" align="center"><span class="Estilo19">MONTO OPERACION</span></td>
                  <td width="77" align="center"><span class="Estilo19">BASE IMPONIBLE</span></td>
          <td width="30" align="center"><span class="Estilo19">% ALIC.</span></td>
          <td width="70" align="center"><span class="Estilo19">RETENIDO</span></td>
      </tr>
      <tr>
                   <td width="40" align="center"><span class="Estilo19"><?php  echo $nro_op; ?></span></td>
           <td width="55" align="center"><span class="Estilo19"><?php  echo $fechae; ?></span></td>
           <td width="90" align="left"><span class="Estilo19"><?php  echo $nro_documento; ?></span></td>
           <td width="80" align="left"><span class="Estilo19"><?php  echo  $nro_con_factura; ?></span></td>
           <td width="77" align="right"><span class="Estilo19"><?php  echo $monto_o; ?></span></td>
           <td width="77" align="right"><span class="Estilo19"><?php  echo $monto_o; ?></span></td>
           <td width="30" align="right"><span class="Estilo19"><?php  echo $tasa; ?></span></td>
           <td width="70" align="right"><span class="Estilo19"><?php  echo $monto_r; ?></span></td>
                </tr>
   </table></td>
      </tr>
<?php }?>
          <tr>
          <td><table width="865" border="1"  height="30" cellpadding="2" cellspacing="0">
            <tr>
            <td width="433" align="right"><span class="Estilo19">TOTALES </span></td>
            <td width="120" align="right"><span class="Estilo19"><?php  echo $total_d; ?></span></td>
            <td width="122" align="right"><span class="Estilo19"><?php  echo $total_b; ?></span></td>
            <td width="46" align="center"><span class="Estilo19">&nbsp;</span></td>
            <td width="112" align="right"><span class="Estilo19"><?php  echo $total_ret; ?></span></td>
<?php if($sustraendo>0){ $total_sut=formato_monto($sustraendo); $prev_ret=$prev_ret-$sustraendo; $prev_ret=formato_monto($prev_ret);  ?>	
            <tr>
            <td width="433" align="right"><span class="Estilo19"></span></td>
            <td width="120" align="right"><span class="Estilo19"></span></td>
            <td width="122" align="right"><span class="Estilo19"></span></td>
            <td width="46" align="center"><span class="Estilo19"></span></td>
            <td width="112" align="right"><table width="110" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="60" align="left"><span class="Estilo19">Sustraendo:</span></td>
                <td width="50" align="right"><span class="Estilo19"><?php  echo $total_sut; ?></span></td>
              </tr>
            </table></td>
            </tr>
			<tr>
            <td width="433" align="right"><span class="Estilo19"></span></td>
            <td width="120" align="right"><span class="Estilo19"></span></td>
            <td width="122" align="right"><span class="Estilo19"></span></td>
            <td width="46" align="center"><span class="Estilo19"></span></td>
            <td width="112" align="right"><span class="Estilo19"><?php  echo $prev_ret; ?></span></td>
            </tr>
<?php }?>					
            </tr>
          </table></td>
          </tr>

          <tr>
          <td><table width="870" border="0"  height="90" cellpadding="3" cellspacing="0">
            <tr>
          <td width="588" align="center">&nbsp;</td>
                </tr>
          </table></td>
          </tr>
          <tr>
          <td><table width="870" border="0"  height="30" cellpadding="3" cellspacing="0">
            <tr>
			  <td width="70"></td>
			  <td width="200"><span class="Estilo20">FIRMA DEL AGENTE DE RETENCION:</span></td>
			  <td width="200">&nbsp;</td>
			  <td width="200"><span class="Estilo20">FIRMA DEL CONTRIBUYENTE:</span></td>
			  <td width="150"></td>
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
              <td><span class="Estilo20">FECHA</span></td>
              <td>&nbsp;</td>
            </tr>
          </table></td>
          </tr>

  </table>
  </div></td></tr>
  <tr><td height="147">&nbsp;</td></tr>
  <tr><td height="178">&nbsp;</td>
  </tr>
  <tr><td>&nbsp;</td></tr>
</table>
