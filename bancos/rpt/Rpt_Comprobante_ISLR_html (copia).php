<?include ("../../class/conect.php");  include ("../../class/funciones.php");$fecha_hoy=asigna_fecha_hoy(); 
if (!$_GET){$cedula_d=""; $cedula_h="";} else{$cedula_d=$_GET["cedula_d"];  $cedula_h=$_GET["cedula_h"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL BANCARIO (Comprobante Retenciones ISLR)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../../class/sia.css" type="text/css" rel=stylesheet>
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
<style type="text/css">
<!--
.Estilo2 {	font-family: Arial, Helvetica, sans-serif;	font-size: 14px;}
.Estilo3 {	font-family: Arial, Helvetica, sans-serif;font-size: 9px;}
.Estilo16 {font-family: Arial, Helvetica, sans-serif}
.Estilo19 {font-family: Arial, Helvetica, sans-serif; font-size: 7px;}
.Estilo20 {font-family: Arial, Helvetica, sans-serif; font-size: 10px}
.Estilo22 {font-family:  Arial, Helvetica, sans-serif; font-size: 12px; }
.Estilo23 {font-family:  Arial, Helvetica, sans-serif; font-size: 17px; }
.lineas {
border-top-width: 1px;
border-top-style: solid;
border-right-style: solid;
}
.lineas2 {border-left-width: 1px;
border-top-style: solid;
border-left-style: solid;
}
H1.SaltoDePagina{PAGE-BREAK-AFTER: always}
-->
</style>

</head>
<?
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }  $error=0;
$direccion_ag=""; $nombre=""; $nom_comp=""; $rif=""; $nit=""; $telefono_ag=""; $fax=""; $str1="NO"; $fecha_ini="2011-01-01"; $fecha_fin="2011-12-31"; $periodo="01"; $correo=""; $tasa_iva=0; $monto_ut=0; $definicion="N";
$sql="Select * from SIA000 order by campo001"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$cod_emp=$registro["campo001"];
$direccion_ag=$registro["campo006"]; $nombre=$registro["campo004"]; $nom_comp=$registro["campo005"]; $rif=$registro["campo007"]; $nit=$registro["campo008"];  $definicion=$registro["campo034"];
$telefono_ag=$registro["campo012"];$fax=$registro["campo013"]; $fecha_ini=$registro["campo031"];$fecha_fin=$registro["campo032"]; $periodo=$registro["campo033"]; $pagina=$registro["campo015"]; $parroquia=$registro["campo040"];
$region=$registro["campo041"];$estado=$registro["campo010"];$municipio=$registro["campo011"];$ciudad=$registro["campo009"]; $correo=$registro["campo014"]; $str1=$registro["campo049"]; $tasa_iva=$registro["campo056"]; $monto_ut=$registro["campo055"]; }
if($fecha_ini==""){$fecha_ini="";}else{$fecha_ini=formato_ddmmaaaa($fecha_ini);} if($fecha_fin==""){$fecha_fin="";}else{$fecha_fin=formato_ddmmaaaa($fecha_fin);}
$nombre_emp=$nombre;$ced_rif_emp=$rif; $nombre_agente=$nombre; $num_pag=0; $error=0;
$titulo1="REPUBLICA BOLIVARIANA DE VENEZUELA MINISTERIO DE HACIENDA DIRECCION GENERAL SECTORIAL DE RENTAS";
$titulo2="COMPROBANTE DE RETENCIONES VARIAS DEL IMPUESTO SOBRE LA RENTA AR-CB ( EXCEPTO SUELDOS, SALARIOS Y DEMAS REMUNERACIONES A PERSONAS NATURALES RESIDENTES SECTORIAL DE RENTAS";
$nombre_funcionario="T.S.U. YOLINA HERNANDEZ - Tesorera Gral. del Edo (E)"; $ced_funcionario="V-11.272.858";
$nombre_funcionario="LCDA. FATIMA LOPEZ - Tesorera Gral. del Edo (E)"; $ced_funcionario="V-04479304-7";

$ced_rif=""; $fecha_abono=""; $nombre=""; $cedula=""; $pasaporte=""; $direccion=""; $ciudad=""; $estado=""; $telefono="";  $cod_postal=""; $nacionalidad=""; $tipo_benef=""; $residente="SI"; 
$sql="SELECT ban019.ced_rif, pre099.Rif, pre099.Cedula, pre099.Pasaporte, pre099.Nombre, pre099.Direccion, pre099.Ciudad, pre099.Estado, pre099.Telefono, pre099.cod_postal, pre099.Tipo_Benef, pre099.Nacionalidad, pre099.Residente, ban019.Fecha_Abono, ban019.Cod_Retencion, ban019.Monto_Abonado, ban019.Monto_Objeto, ban019.Tasa, ban019.Monto_Retencion, ban019.Acum_Retenido, ban019.Acum_Objeto, ban019.Fecha_Enterado, ban019.Nombre_Banco_Ent  
FROM ban019, pre099 WHERE ban019.ced_rif = pre099.ced_rif And ban019.ced_rif>='$cedula_d' And ban019.ced_rif<='$cedula_h'and nombre_usuario='$usuario_sia' order by ban019.ced_rif,ban019.fecha_abono";
$res=pg_query($sql); $prev_ced="";
while(($registro=pg_fetch_array($res))and($error==0)){  $num_pag=$num_pag+1;  $ced_rif=$registro["ced_rif"];
  $fecha_abono=$registro["fecha_abono"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $pasaporte=$registro["pasaporte"]; 
  $direccion=$registro["direccion"]; $ciudad=$registro["ciudad"]; $tipo_benef=$registro["tipo_benef"];
  $nacionalidad=$registro["nacionalidad"]; $residente=$registro["residente"]; $estado=$registro["estado"];
  $telefono=$registro["telefono"]; $cod_postal=$registro["cod_postal"]; $cod_retencion=$registro["cod_retencion"]; $monto_abonado=$registro["monto_abonado"];
  $monto_objeto=$registro["monto_objeto"]; $tasa=$registro["tasa"];  $monto_retencion=$registro["monto_retencion"]; $acum_objeto=$registro["acum_objeto"];
  $acum_retenido=$registro["acum_retenido"]; $fecha_enterado=$registro["fecha_enterado"];  $nombre_banco_ent=$registro["nombre_banco_ent"];
 $nac=substr($nacionalidad,0,1); $tipoemp=substr($tipo_benef,0,1);
 if($nac=="V"){$nac1="X"; $nac2="&nbsp"; } else { $nac2="X"; $nac1="&nbsp";} 
 if($residente=="SI"){$res1="X"; $res2="&nbsp"; } else { $res2="X"; $res1="&nbsp";} 
 if($tipoemp=="N"){$tpe1="X"; $tpe2="&nbsp"; } else { $tpe2="X"; $tpe1="&nbsp";} 
  $cons1="X"; $cons2="&nbsp";
  if($prev_ced<>$ced_rif){ $prev_ced=$ced_rif;
?>
<body>
<?if($num_pag>1){?>
<H1 class=SaltoDePagina> </H1>
<?} ?>
<table width="1267" height="588" border="0" cellspacing="0">
  <tr>
    <td height="101"><table width="1256" height="89" border="0">
        <tr>
          <td width="500"><div align="center" class="Estilo22">REPUBLICA BOLIVARIANA DE VENEZUELA<br> MINISTERIO DEL PODER POPULAR PARA LA ECONOMIA Y FINANZAS <br> SERVICIO NACIONAL INTEGRADO DE ADMINISTRACION ADUANERA Y TRIBUTARIA <br> MINISTERIO DE FINANZAS</div></td>
          <td width="700"><table width="768" height="108" border="0">
              <tr>
                <td height="62" colspan="2"><table width="700" height="51" border="0">
                    <tr>
                      <td width="100" height="47" align="center" class="Estilo22">AR-CV</td>
                      <td width="600" align="center" class="Estilo23"><strong>COMPROBANTE DE RETENCIONES VARIAS <br>  DEL IMPUESTO SOBRE LA RENTA</strong></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td width="100" height="40" rowspan="2" align="center" class="Estilo19"><br>&nbsp; </td>
                <td width="599" height="21" align="center" class="Estilo19">( EXCEPTO SUELDOS, SALARIOS Y DEMAS REMUNERACIONES A PERSONAS NATURALES RESIDENTES )</td>
              </tr>
              <tr>
                <td align="center" class="Estilo19">&nbsp;</td>
              </tr>
          </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td height="194"><table width="1260" height="269" border="0" cellspacing="0">
      <tr>
        <td width="552" height="20"><div align="left" class="Estilo10"><strong>DATOS DEL AGENTE DE RETENCI&Oacute;N :</strong></div></td>
        <td width="22">&nbsp;</td>
        <td width="1373"><div align="left" class="Estilo10"><strong>DATOS DEL BENEFICIARIO :</strong></div> </td>
      </tr>
      <tr>
        <td height="249"><table width="549" height="250" border="1"  cellspacing="0" bordercolor="#000000">
            <tr>
              <td height="36"><table width="543"  height="30" border="0">
                  <tr>
                    <td width="164"><div align="center"><span class="Estilo3">Tipo de Agente <br> de Retencion</span></div></td>
                    <td width="114" class="Estilo3"><div align="center">1.Persona<br>
                    &nbsp; &nbsp; &nbsp; &nbsp; Natural [ &nbsp; ]</div></td>
                    <td width="122" class="Estilo3"><div align="center">2.Persona<br>
                    &nbsp; &nbsp; &nbsp; &nbsp; Juridica [ &nbsp; ]</div></td>
                    <td width="125" class="Estilo3"><div align="center">3.Persona<br>
                    &nbsp; &nbsp; &nbsp; &nbsp;Publica [ X ] </div></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td height="150"><table width="543" height="150" border="0" cellspacing="0" bordercolor="1">
                  <tr>
                    <td width="34" rowspan="7" class="Estilo5"><table width="34" height="150" border="0" cellspacing="0">
                        <tr>
                          <td width="23" height="150" bordercolor="#FFFFFF"><table width="14" height="150" border="0" cellspacing="0">
                              <tr>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td class="Estilo3"><div align="center">T</div></td>
                              </tr>
                              <tr>
                                <td class="Estilo3"><div align="center">I</div></td>
                              </tr>
                              <tr>
                                <td class="Estilo3"><div align="center">P</div></td>
                              </tr>
                              <tr>
                                <td class="Estilo3"><div align="center">O</div></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                              </tr>
                          </table></td>
                          <td width="14" bordercolor="#000000"><table width="14" height="150" border="0" cellspacing="0">
                              <tr>
                                <td class="Estilo3"  height="12" align="center">1</td>
                              </tr>
                              <tr>
                                <td class="Estilo3"  height="10" align="center">&nbsp;</td>
                              </tr>
                              <tr>
                                <td class="Estilo3" height="12" align="center">2</td>
                              </tr>
                              <tr>
                                <td class="Estilo3"  height="10" align="center">&nbsp;</td>
                              </tr>
                              <tr>
                                <td class="Estilo3" height="12" align="center">3</td>
                              </tr>
                               <tr>
                                <td class="Estilo3" height="12">&nbsp;</td>
                              </tr>
							  <tr>
                                <td class="Estilo3" height="12">&nbsp;</td>
                              </tr>
                          </table></td>
                        </tr>
                    </table></td>
				  </tr>
				  <tr>
                      <td height="150"><table width="500"  height="150" border="0">
						  <tr>	
							<td width="380" height="12" class="Estilo3">Apellido(s) Y Nombre(s): </td>
							<td width="120" class="Estilo3">N&uacute;mero de Rif</td>
						  </tr>
						  <tr>
							<td height="10" class="Estilo3">&nbsp;</td>
							<td class="Estilo3">&nbsp;</td>
						  </tr>
						  <tr>
							<td height="12" class="Estilo3">Apellido(s) Y Nombre(s): </td>
							<td class="Estilo3">N&uacute;mero de Rif </td>
						  </tr>
						  <tr>
							<td height="10" class="Estilo3">&nbsp;</td>
							<td class="Estilo3">&nbsp;</td>
						  </tr>
						  <tr>
							<td height="12" bordercolor="#000000" class="Estilo3"> Apellido(s) Y Nombre(s): </td>
							<td class="Estilo3">N&uacute;mero de Rif</td>
						  </tr>
						  <tr>
							<td height="12" class="Estilo20"><?echo $nombre_agente?></td>
							<td class="Estilo20"><?echo $rif?></td>
						  </tr>
						  <tr>
							<td height="12" bordercolor="#000000" class="Estilo3">Funcionario Autorizado para hacer la Retención: </td>
							<td class="Estilo3">N&uacute;mero de Rif</td>
						  </tr>
						  <tr>
							<td height="12" class="Estilo20"><?echo $nombre_funcionario?></td>
							<td class="Estilo20"><?echo $ced_funcionario?></td>
						  </tr>
				   </table></td>
				  </tr>
				  
				  <div  class="lineas" id="Layer1" style="position:absolute; width:509px; height:0.1px; z-index:1; top: 221px; left: 47px;"> </div>
				  <div  class="lineas" id="Layer2" style="position:absolute; width:509px; height:0.1px; z-index:1; top: 256px; left: 47px;"> </div>
				  <div  class="lineas" id="Layer2" style="position:absolute; width:509px; height:0.1px; z-index:1; top: 300px; left: 47px;"> </div>
				  
				  <div  class="lineas2" id="Layer3" style="position:absolute; width:0.01px; height:152px; z-index:1; top: 185px; left: 46px;"> </div>
				  <div  class="lineas2" id="Layer4" style="position:absolute; width:0.01px; height:211px; z-index:1; top: 185px; left: 420px;"> </div>
				  
				  <div  class="lineas2" id="Layer5" style="position:absolute; width:0.01px; height:90px; z-index:1; top: 195px; left: 815px;"> </div>
              </table></td>
            </tr>
            <tr>
              <td width="543" height="50"><table width="540" height="54" border="0">
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
        <td><table width="676" height="250" border="1" cellspacing="0" bordercolor="#000000">
            <tr>
              <td width="504" height="48"><table width="501" height="38" border="0">
                <tr>
                  <td height="17" class="Estilo3">Nombre o Razon Social : </td>
                </tr>
                <tr>
                  <td class="Estilo20" aling="left"><?echo $nombre?></td>
                </tr>
              </table></td>
              <td width="169"><table width="157" border="0">
                <tr>
                  <td width="167"  class="Estilo3">Tipo de empresa:</td>
                </tr>
                <td class="Estilo3">Natural [ <?echo $tpe1?> ] &nbsp;&nbsp;  Juridica [ <?echo $tpe2?> ]</td>
              </table></td>
            </tr>
            <tr>
              <td><table width="502" border="0">
                <tr>
                  <td width="251" class="Estilo3">Nacionalidad :</td>
                  <td width="260" class="Estilo3">Residente en el Pais :</td>
                </tr>
                <tr>
                  <td class="Estilo3">Venezolana [ <?echo $nac1?> ]  &nbsp;&nbsp; Extranjera [ <?echo $nac2?> ]</td>
                  <td class="Estilo3">Si [ <?echo $res1?> ] &nbsp;&nbsp;  No [ <?echo $res2?> ]</td>
                </tr>
              </table></td>
              <td><table width="157" border="0">
                <tr>
                  <td width="171" class="Estilo3">Constituida en el Pais :</td>
                </tr>
                 <td class="Estilo3">Si [ <?echo $cons1?> ] &nbsp;&nbsp;  No [ <?echo $cons2?> ]</td>
              </table></td>
            </tr>
            <tr>
              <td height="45"><table width="504" height="41" border="0">
                <tr>
                  <td width="251" class="Estilo3">Cedula de identidad:</td>
                  <td width="265" class="Estilo3">Numero de pasaporte:</td>
                </tr>
                <tr>
                  <td class="Estilo20" aling="left"><?echo $cedula?></td>
                  <td class="Estilo20" aling="left"><?echo $pasaporte?></td>
                </tr>
              </table></td>
              <td><table width="158" border="0">
			    <tr>
                  <td width="171" class="Estilo3">Numero de RIF :</td>
                </tr>
                <tr>
                  <td class="Estilo20" aling="left"><?echo $ced_rif?></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td height="108"><table width="503" height="92" border="0">
                <tr>
                  <td height="14" colspan="2" class="Estilo3">Direccion y Telefono(s):</td>
                </tr>
                 <tr valign="top">
                  <td height="30" colspan="2" class="Estilo20" aling="left"><?echo $direccion?></td>
                </tr>
                <tr>
                  <td width="262" height="20" class="Estilo20" ><?echo $ciudad?></td>
				  <td width="242" height="20" class="Estilo20" ><?echo $cod_postal?></td>
                </tr>
				<tr>
                  <td height="20" class="Estilo20" ><?echo $estado?></td>
                  <td height="20" class="Estilo20" ><?echo $telefono?></td>
				</tr>
              </table></td>
              <td><table width="157" height="101" border="0">
                <tr>
                  <td  class="Estilo3">Periodo a que corresponde<br>
                    las Remuneraciones Pagadas</td>
                </tr>
                <tr>
                  <td height="30"  class="Estilo3">Desde: <?echo $fecha_ini?></td>
                </tr>
                <tr>
                  <td height="30"  class="Estilo3">Hasta: <?echo $fecha_fin?></td>
                </tr>
              </table></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="20" class="Estilo10"><strong>INFORMACION DEL IMPUESTO RETENIDO Y ENTERADO :  </strong></td>
  </tr>
  <tr>
    <td height="52"><table width="1237" border="1" cellspacing="0" bordercolor="#000000">
      <tr>
        <td width="92"><div align="center"><span class="Estilo5">Fecha en Pago o<br> Abono en Cuenta</span><br></div></td>
        <td width="66"><div align="center"><span class="Estilo5">Codigo de <br>Retencion</span> </div></td>
        <td width="96"><div align="center"><span class="Estilo5">Total Cantidad Pagada o Abonada</span> </div></td>
        <td width="87"><div align="center"><span class="Estilo5">Cantidad Objeto de Retencion</span> </div></td>
        <td width="61"><div align="center"><span class="Estilo5">% o <br>Tarifa</span> </div></td>
        <td width="102"><div align="center"><span class="Estilo5">Impuesto Retenido</span> </div></td>
        <td width="133"><div align="center"><span class="Estilo5">Total Cantidad Objeto Retencion Acumulada</span> </div></td>
        <td width="98"><div align="center"><span class="Estilo5">Impuesto Retenido Acumulado</span> </div></td>
        <td colspan="2"><table width="370" height="54" border="0">
            <tr>
              <td colspan="2"><div align="center"><span class="Estilo5">Impuesto Enterado</span> </div></td>
            </tr>
            <tr>
              <td width="97"><div align="center"><span class="Estilo5">En Fecha</span> </div></td>
              <td width="263"><span class="Estilo5">Banco</span></td>
            </tr>
        </table></td>
      </tr>
      <? $total_monto_abonado=0; $total_monto_objeto=0; $total_monto_retencion=0; $total_acum_objeto=0; $total_acum_retenido=0; 
	  
$sqld="Select * from ban019 where ced_rif='$ced_rif' and nombre_usuario='$usuario_sia'"; $resd=pg_query($sqld);
while(($regd=pg_fetch_array($resd))and($error==0)){ 
 $fecha_abono=$regd["fecha_abono"]; $cod_retencion=$regd["cod_retencion"]; $fecha_enterado=$regd["fecha_enterado"];  $nombre_banco_ent=$regd["nombre_banco_ent"];
 $monto_abonado=formato_monto($regd["monto_abonado"]); $monto_objeto=formato_monto($regd["monto_objeto"]); $monto_retencion=formato_monto($regd["monto_retencion"]);
$acum_objeto=formato_monto($regd["acum_objeto"]); $acum_retenido=formato_monto($regd["acum_retenido"]);  $total_monto_abonado=$total_monto_abonado+$regd["monto_abonado"]; $total_monto_objeto=$total_monto_objeto+$regd["monto_objeto"]; $total_monto_retencion=$total_monto_retencion+$regd["monto_retencion"]; $total_acum_objeto=$total_acum_objeto+$regd["acum_objeto"]; $total_acum_retenido=$total_acum_retenido+$regd["acum_retenido"];
$fecha_a=formato_ddmmaaaa($fecha_abono); $fecha_e=formato_ddmmaaaa($fecha_enterado); $tasa=$regd["tasa"];


?>
      <tr>
        <td class="Estilo5" align="center"><?echo $fecha_a?></td>
        <td class="Estilo5" align="center"><?echo $cod_retencion?></td>
        <td class="Estilo5" align="right"><?echo $monto_abonado?> </td>
        <td class="Estilo5" align="right"><?echo $monto_objeto?> </td>
        <td class="Estilo5" align="center"><?echo $tasa?> </td>
        <td class="Estilo5" align="right"><?echo $monto_retencion?> </td>
        <td class="Estilo5" align="right"><?echo $acum_objeto?> </td>
        <td class="Estilo5" align="right"><?echo $acum_retenido?> </td>
        <td width="99" class="Estilo5" align="center"><?echo $fecha_e?> </td>
        <td width="361" class="Estilo5"><?echo $nombre_banco_ent?></td>
      </tr>
      <? }
 $total_monto_abonado=formato_monto($total_monto_abonado);  $total_monto_objeto=formato_monto($total_monto_objeto);  $total_monto_retencion=formato_monto($total_monto_retencion);
$total_acum_objeto=formato_monto($total_acum_objeto); $total_acum_retenido=formato_monto($total_acum_retenido);
?>
      <tr>
        <td colspan="2"><div align="right" class="Estilo5"><strong>TOTALES --->  </strong></div></td>
        <td class="Estilo5" align="right"><strong><?echo $total_monto_abonado?> </strong></td>
        <td class="Estilo5" align="right"><strong><?echo $total_monto_objeto?> </strong></td>
        <td>&nbsp;</td>
        <td class="Estilo5" align="right"><strong><?echo $total_monto_retencion?> </strong></td>
        <td class="Estilo5" align="right"><strong><?echo $acum_objeto?> </strong></td>
        <td class="Estilo5" align="right"><strong><?echo $acum_retenido?> </strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="10">&nbsp;</td>
  </tr>
  <tr>
    <td><table width="1240" height="28" border="0" cellpadding="2">
      <tr>
        <td width="405">&nbsp;</td>
        <td width="405"><table width="384" height="69" border="1" cellspacing="0" bordercolor="#000000">
          <tr>
            <td width="378" valign="top" class="Estilo3">AGENTE DE RETENCI&Oacute;N (SELLO, FECHA Y FRIMA): </td>
          </tr>
        </table></td>
        <td width="406"><table width="373" height="69" border="1" cellspacing="0" bordercolor="#000000">
          <tr>
            <td width="367" valign="top" class="Estilo3">PARA USO DE LA ADMINISTRACION DE HACIENDA : </td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<? }} ?>
</body>
</html>
