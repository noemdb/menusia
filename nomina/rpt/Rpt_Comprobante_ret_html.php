<?include ("../../class/conect.php");  include ("../../class/funciones.php");
if (!$_GET){$cedula_d=""; $cedula_h="";} else{$cedula_d=$_GET["codigo_d"];  $cedula_h=$_GET["codigo_h"];}
$fecha_hoy=asigna_fecha_hoy(); 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Comprobante Retenciones ISLR)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel=stylesheet>
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
<style type="text/css">
<!--
.Estilo2 {	font-family: Arial, Helvetica, sans-serif;	font-size: 14px;}
.Estilo3 {	font-family: Arial, Helvetica, sans-serif;font-size: 9px;}
.Estilo16 {font-family: Arial, Helvetica, sans-serif}
.Estilo19 {font-family: Arial, Helvetica, sans-serif; font-size: 7px;}
.Estilo20 {font-family: Arial, Helvetica, sans-serif; font-size: 10px}
.Estilo22 {font-family:  Arial, Helvetica, sans-serif; font-size: 14px; }
.Estilo23 {font-family:  Arial, Helvetica, sans-serif; font-size: 17px; }
.lineas {border-top-width: 1px; border-top-style: solid; border-right-style: solid;}
.lineas2 {border-left-width: 1px; border-top-style: solid; border-left-style: solid;}
H1.SaltoDePagina{PAGE-BREAK-AFTER: always}
-->
</style>

</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }  $error=0;
$direccion_ag=""; $nombre=""; $nom_comp=""; $rif=""; $nit=""; $telefono_ag=""; $fax=""; $str1="NO"; $fecha_ini="2011-01-01"; $fecha_fin="2011-12-31"; $periodo="01"; $correo=""; $tasa_iva=0; $monto_ut=0; $definicion="N";
$sql="Select * from SIA000 order by campo001"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$cod_emp=$registro["campo001"];
$direccion_ag=$registro["campo006"]; $nombre=$registro["campo004"]; $nom_comp=$registro["campo005"]; $rif=$registro["campo007"]; $nit=$registro["campo008"];  $definicion=$registro["campo034"];
$telefono_ag=$registro["campo012"];$fax=$registro["campo013"]; $fecha_ini=$registro["campo031"];$fecha_fin=$registro["campo032"]; $periodo=$registro["campo033"]; $pagina=$registro["campo015"]; $parroquia=$registro["campo040"];
$region=$registro["campo041"];$estado=$registro["campo010"];$municipio=$registro["campo011"];$ciudad=$registro["campo009"]; $correo=$registro["campo014"]; $str1=$registro["campo049"]; $tasa_iva=$registro["campo056"]; $monto_ut=$registro["campo055"]; }
if($fecha_ini==""){$fecha_ini="";}else{$fecha_ini=formato_ddmmaaaa($fecha_ini);} if($fecha_fin==""){$fecha_fin="";}else{$fecha_fin=formato_ddmmaaaa($fecha_fin);}
$nombre_emp=$nombre;$ced_rif_emp=$rif; $nombre_agente=$nombre; $num_pag=0; $error=0;
$ced_rif=""; $fecha_abono=""; $nombre=""; $cedula=""; $pasaporte=""; $direccion=""; $ciudad=""; $estado=""; $telefono=""; $rif_empleado=""; $cod_postal=""; $nacionalidad=""; $tipo_benef=""; $residente="SI"; 
$sql="SELECT ban019.ced_rif, a.rif_empleado, a.cedula, a.nombre, a.direccion, a.ciudad, a.estado, a.telefono, a.cod_postal, a.nacionalidad, ban019.Fecha_Abono, ban019.Cod_Retencion, ban019.Monto_Abonado, ban019.Monto_Objeto, ban019.Tasa, ban019.Monto_Retencion, ban019.Acum_Retenido, ban019.Acum_Objeto, ban019.Fecha_Enterado, ban019.Nombre_Banco_Ent  
FROM ban019, trabajadores a WHERE ban019.ced_rif = a.cod_empleado And ban019.ced_rif>='$cedula_d' And ban019.ced_rif<='$cedula_h' and nombre_usuario='$usuario_sia' ORDER BY ban019.Fecha_Abono, ban019.ced_rif";
$res=pg_query($sql); $prev_ced="";
while(($registro=pg_fetch_array($res))and($error==0)){ $num_pag=$num_pag+1;
  $ced_rif=$registro["ced_rif"]; $fecha_abono=$registro["fecha_abono"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $rif_empleado=$registro["rif_empleado"];
  $direccion=$registro["direccion"]; $ciudad=$registro["ciudad"];   $nacionalidad=$registro["nacionalidad"];  $estado=$registro["estado"];
  $telefono=$registro["telefono"]; $cod_postal=$registro["cod_postal"]; $cod_retencion=$registro["cod_retencion"]; $monto_abonado=$registro["monto_abonado"];
  $monto_objeto=$registro["monto_objeto"]; $tasa=$registro["tasa"];
  $monto_retencion=$registro["monto_retencion"]; $acum_objeto=$registro["acum_objeto"];
  $acum_retenido=$registro["acum_retenido"]; $fecha_enterado=$registro["fecha_enterado"];
  $nombre_banco_ent=$registro["nombre_banco_ent"];
 $nac=substr($nacionalidad,0,1); $tipoemp=substr($tipo_benef,0,1);
 if($nac=="V"){$nac1="X"; $nac2="&nbsp"; } else { $nac2="X"; $nac1="&nbsp";} 
 if($residente=="SI"){$res1="X"; $res2="&nbsp"; } else { $res2="X"; $res1="&nbsp";} 
 if($tipoemp=="N"){$tpe1="X"; $tpe2="&nbsp"; } else { $tpe2="X"; $tpe1="&nbsp";}   $cons1="X"; $cons2="&nbsp";
 if($prev_ced<>$ced_rif){ $prev_ced=$ced_rif;
?>
<body>
<?if($num_pag>1){?>
<H1 class=SaltoDePagina> </H1>
<?} ?>
<table width="1038" height="603" border="0" cellspacing="0">
  <tr>
    <td height="101"><table width="1018" height="89" border="0">
        <tr>
          <td width="124" height="105"><img src="../../imagenes/Logo_empresa.gif" width="103" height="85" border="0"></td>
          <td width="45"><div align="center" class="Estilo22"></div></td>
          <td width="1073"><table width="768" height="108" border="0">
              <tr>
                <td height="62" colspan="2"><table width="757" height="51" border="0">
                    <tr>
                      <td width="24" height="47" align="center" class="Estilo22">&nbsp;</td>
                      <td width="723" align="center" class="Estilo23"><strong>COMPROBANTE DE RETENCIONES <br>  
                      DEL IMPUESTO SOBRE LA RENTA</strong></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td width="24" height="40" rowspan="2" align="center" class="Estilo19"><br>
                  &nbsp; </td>
                <td width="734" height="21" align="center"><span class="Estilo10">Periodo Desde: <?echo $fecha_ini?> Hasta: <?echo $fecha_fin?></span></td>
              </tr>
              <tr>
                <td align="center" class="Estilo19">&nbsp;</td>
              </tr>
          </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td height="194"><table width="1029" height="220" border="0" cellspacing="0">
      <tr>
        <td width="552" height="20"><div align="left" class="Estilo10"><strong>DATOS DEL AGENTE DE RETENCI&Oacute;N :</strong></div></td>
        <td width="22">&nbsp;</td>
        <td width="1373"><div align="left" class="Estilo10"><strong>DATOS DEL TRABAJADOR :</strong></div> </td>
      </tr>
      <tr>
        <td height="222"><table width="549" height="191" border="1"  cellspacing="0" bordercolor="#000000">
            <tr>
              <td height="36"><table width="543" border="0">
                  <tr>
                    <td width="116"><div align="center"><span class="Estilo3">Tipo de Agente <br> de Retencion</span></div></td>
                    <td width="118" class="Estilo3"><div align="center">1.Persona<br>
                    &nbsp; &nbsp; &nbsp; &nbsp; Natural [ &nbsp; ]</div></td>
                    <td width="126" class="Estilo3"><div align="center">2.Persona<br>
                    &nbsp; &nbsp; &nbsp; &nbsp; Juridica [ &nbsp; ]</div></td>
                    <td width="165" class="Estilo3"><div align="center">3.Persona<br>
                    &nbsp; &nbsp; &nbsp; &nbsp;Publica [ X ] </div></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td height="58"><table width="543" height="49" border="0" cellspacing="0" bordercolor="1">
                  <tr>
                    <td width="382" height="20" bordercolor="#000000" class="Estilo3"> Nombre: </td>
                    <td width="121" class="Estilo3">N&uacute;mero de Rif</td>
                  </tr>
                  <tr>
                    <td height="25" class="Estilo20"><?echo $nombre_agente?></td>
                    <td class="Estilo20"><?echo $rif?></td>
                  </tr>
				  
              </table></td>
            </tr>
            <tr>
              <td width="543" height="87"><table width="540" height="73" border="0">
                  <tr>
                    <td width="414" height="12" class="Estilo3">Direccion y Telefono(s): </td>
                    <td width="118" class="Estilo3">Fecha Cierre del Ejercicio </td>
                  </tr>
                  <tr>
                    <td height="30" valign="top" class="Estilo20"><?echo $direccion_ag." ".$telefono_ag ?></td>
                    <td class="Estilo20" aling="left"><?echo $fecha_fin?></td>
                  </tr>
              </table></td>
            </tr>
        </table></td>
        <td>&nbsp;</td>
        <td><table width="461" height="193" border="1" cellspacing="0" bordercolor="#000000">
            <tr>
              <td width="504" height="48"><table width="450" height="38" border="0">
                <tr>
                  <td width="444" height="17" class="Estilo3">Apellido(s) Y Nombre(s): </td>
                </tr>
                <tr>
                  <td class="Estilo20" aling="left"><?echo $nombre?></td>
                </tr>
              </table></td>
              </tr>
            <tr>
              <td height="45"><table width="451" height="41" border="0">
                <tr>
                  <td width="150" class="Estilo3">Cedula de identidad:</td>
                  <td width="150" class="Estilo3">Numero de RIF :</td>
				  <td width="141" class="Estilo3">Nacionalidad :</td>
                </tr>
                <tr>
                  <td class="Estilo20" aling="left"><?echo $cedula?></td>
                  <td class="Estilo20" aling="left"><?echo $rif_empleado?></td>
				  <td class="Estilo20" aling="left"><?echo $nacionalidad?></td>
                </tr>
              </table></td>
              </tr>
            <tr>
              <td height="96"><table width="452" height="92" border="0">
                <tr>
                  <td height="14" colspan="2" class="Estilo3">Direccion y Telefono(s):</td>
                </tr>
                 <tr valign="top">
                  <td height="30" colspan="2" class="Estilo20" aling="left"><?echo $direccion?></td>
                </tr>
                <tr>
                  <td width="223" height="20" class="Estilo20" ><?echo $ciudad?></td>
				  <td width="219" height="20" class="Estilo20" ><?echo $estado?></td>
                </tr>
              </table></td>
              </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="20" class="Estilo10"><strong>INFORMACION DEL IMPUESTO RETENIDO :  </strong></td>
  </tr>
  <tr>
    <td height="52" align="center" ><table width="745" border="1" cellspacing="0" bordercolor="#000000">
      <tr>
        <td width="100"><div align="center"><span class="Estilo5">Mes de pago </span><br>
        </div></td>
        <td width="135"><div align="center"><span class="Estilo5">Remuneraciones Pagada<br>o Abonada</span> </div></td>
        <td width="70"><div align="center"><span class="Estilo5">Porcentaje <br>Retencion</span> </div></td>
        <td width="135"><div align="center"><span class="Estilo5">Impuesto Retenido</span> </div></td>
        <td width="135"><div align="center"><span class="Estilo5">Total Remuneraciones Pagada Acumulada</span> </div></td>
        <td width="135"><div align="center"><span class="Estilo5">Impuesto Retenido Acumulado</span> </div></td>
        </tr>
      <? $total_monto_abonado=0; $total_monto_objeto=0; $total_monto_retencion=0; $total_acum_objeto=0; $total_acum_retenido=0; 
	  
$sqld="Select * from ban019 where ced_rif='$ced_rif' and nombre_usuario='$usuario_sia' "; $resd=pg_query($sqld);
while(($regd=pg_fetch_array($resd))and($error==0)){ 
 $fecha_abono=$regd["fecha_abono"]; $cod_retencion=$regd["cod_retencion"]; $fecha_enterado=$regd["fecha_enterado"];  $nombre_banco_ent=$regd["nombre_banco_ent"]; $tasa=$regd["tasa"];
 $monto_abonado=formato_monto($regd["monto_abonado"]); $monto_objeto=formato_monto($regd["monto_objeto"]); $monto_retencion=formato_monto($regd["monto_retencion"]);
$acum_objeto=formato_monto($regd["acum_objeto"]); $acum_retenido=formato_monto($regd["acum_retenido"]);  $total_monto_abonado=$total_monto_abonado+$regd["monto_abonado"]; $total_monto_objeto=$total_monto_objeto+$regd["monto_objeto"]; $total_monto_retencion=$total_monto_retencion+$regd["monto_retencion"]; $total_acum_objeto=$total_acum_objeto+$regd["acum_objeto"]; $total_acum_retenido=$total_acum_retenido+$regd["acum_retenido"];
$fecha_a=formato_ddmmaaaa($fecha_abono); $fecha_e=formato_ddmmaaaa($fecha_enterado);
$mes_desde=substr($fecha_abono,5,2); $mesd="";
if ($mes_desde=="01"){$mesd="Enero";} if ($mes_desde=="02"){$mesd="Febrero";} if ($mes_desde=="03"){$mesd="Marzo";} 
if ($mes_desde=="04"){$mesd="Abril";} if ($mes_desde=="05"){$mesd="Mayo";}    if ($mes_desde=="06"){$mesd="Junio";}
if ($mes_desde=="07"){$mesd="Julio";} if ($mes_desde=="08"){ $mesd="Agosto"; }  if ($mes_desde=="09"){$mesd="Septiembre";}
if ($mes_desde=="10"){$mesd="Octubre";} if ($mes_desde=="11"){$mesd="Noviembre";} if ($mes_desde=="12"){$mesd="Diciembre";}
?>
      <tr>
        <td class="Estilo5" align="center"><?echo $mesd?></td>
        <td class="Estilo5" align="right"><?echo $monto_abonado?> </td>
        <td class="Estilo5" align="center"><?echo $tasa?> </td>
        <td class="Estilo5" align="right"><?echo $monto_retencion?> </td>
        <td class="Estilo5" align="right"><?echo $acum_objeto?> </td>
        <td class="Estilo5" align="right"><?echo $acum_retenido?> </td>
        </tr>
      <? }
 $total_monto_abonado=formato_monto($total_monto_abonado);  $total_monto_objeto=formato_monto($total_monto_objeto);  $total_monto_retencion=formato_monto($total_monto_retencion);
$total_acum_objeto=formato_monto($total_acum_objeto); $total_acum_retenido=formato_monto($total_acum_retenido);
?>
      <tr>
        <td><div align="right" class="Estilo5"><strong>TOTALES --->  </strong></div></td>
        <td class="Estilo5" align="right"><strong><?echo $total_monto_abonado?> </strong></td>
        <td>&nbsp;</td>
        <td class="Estilo5" align="right"><strong><?echo $total_monto_retencion?> </strong></td>
        <td class="Estilo5" align="right"><strong><?echo $acum_objeto?> </strong></td>
        <td class="Estilo5" align="right"><strong><?echo $acum_retenido?> </strong></td>
        </tr>
    </table>    </td>
  </tr>
  <tr>
    <td height="29">&nbsp;</td>
  </tr>
  <tr>
    <td><table width="859" height="28" border="0" cellpadding="2">
      <tr>
        <td width="313">&nbsp;</td>
        <td width="390"><table width="384" height="69" border="1" cellspacing="0" bordercolor="#000000">
          <tr>
            <td width="378" valign="top" class="Estilo3">AGENTE DE RETENCI&Oacute;N (SELLO, FECHA Y FIRMA): </td>
          </tr>
        </table></td>
        <td width="136">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<? } } ?>
</body>
</html>
