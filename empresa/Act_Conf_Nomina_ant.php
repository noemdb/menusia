<?php include ("../class/seguridad.inc"); include ("../class/conects.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $cod_modulo="04";
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?php }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{?><script language="JavaScript"> document.location='menu.php';</script><?php }

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONFIGURACI&Oacute;N NOMINA Y PERSONAL</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../class/sia.js" type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
</script>
<script language="JavaScript" type="text/JavaScript">
function revisar(){var f=document.form1;
    if(f.txtLogin.value==""){alert("Login no puede estar Vacio");return false;}  else{f.txtLogin.value=f.txtLogin.value.toUpperCase();}
document.form1.submit;
return true;}
function LlamarURL(url) {document.location = url;}
</script>
<style type="text/css">
<!--
.Estilo5 {font-size: 12px}
.Estilo10 {color: #000099; font-weight: bold;}
-->
</style>
</head>
<?php
$formato_trab=""; $periodo="01"; $campo502="";$sql="Select * from SIA005 where campo501='$cod_modulo'";$resultado=pg_query($sql);
if($registro=pg_fetch_array($resultado,0)){$cod_modulo=$registro["campo501"]; $campo502=$registro["campo502"]; $periodo=$registro["campo503"]; $formato_trab=$registro["campo504"];$formato_cargo=$registro["campo505"];$formato_dep=$registro["campo506"];}
?>
<body>
<table width="988" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CONFIGURACI&Oacute;N N&Oacute;MINA Y PERSONAL </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="988" height="584" border="1">
  <tr>
    <td width="92"><table width="92" height="573" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick=javascript:LlamarURL('menu_conf.php');
          onMouseOut="this.style.backgroundColor='#EAEAEA';" height="35"  bgColor=#EAEAEA><A class=menu href="menu_conf.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA';" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu Principal</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="878"><div id="Layer1" style="position:absolute; width:871px; height:554px; z-index:1; top: 68px; left: 119px;">
      <form name="form1" method="post" action="Update_conf_nomina.php" onSubmit="return revisar()">
        <table width="854" height="481" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="852"><table width="850">
              <tr>
                  <td width="250"><span class="Estilo5">FORMATO C&Oacute;DIGO DEL TRABAJADOR: </span></td>
                  <td width="600"><span class="Estilo5"><input name="txtformato_trab" type="text" id="txtformato_trab"  size="15" maxlength="15" value="<?php echo $formato_trab ?>"  onFocus="encender(this)" onBlur="apagar(this)"> </span> </td>
               </tr>
            </table></td>
          </tr>
          <tr>
             <td width="852"><table width="850">
              <tr>
                   <td width="250"><span class="Estilo5">FORMATO C&Oacute;DIGO DEL CARGO: </span></td>
                  <td width="194"><span class="Estilo5"><input name="txtformato_cargo" type="text" id="txtformato_cargo"  size="10" maxlength="10" value="<?php echo $formato_cargo ?>"  onFocus="encender(this)" onBlur="apagar(this)"> </span> </td>
                  <td width="287"><span class="Estilo5">FORMATO C&Oacute;DIGO DEL DEPARTAMENTO: </span></td>
                  <td width="105"><span class="Estilo5"><input name="txtformato_dep" type="text" id="txtformato_dep"  size="10" maxlength="10" value="<?php echo $formato_dep ?>"  onFocus="encender(this)" onBlur="apagar(this)"> </span> </td>
               </tr>
            </table></td>
          </tr>
         <tr>
            <td><table width="850" height="24" border="0" cellpadding="0" cellspacing="0">
             <tr>
              <td><table width="850" height="24" border="1" cellspacing="2" cellpadding="0">
                          <tr>
                                <td width="425"><table width="425" height="24"border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="354"><span class="Estilo5">TIPO DE NOMINA PERTECE AL C&Oacute;DIGO:</span></td>
                                          <td width="70"><div align="center"><span class="Estilo5"><select name="txtnom_cod" size="1"> <?php if(substr($campo502,8,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?> </span></div></td>
                                         </tr>
                                </table></td>
                                <td width="425"><table width="425" height="24" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="354"><span class="Estilo5">CODIGO IGUAL A CEDULA :</span> </td>
                                          <td width="70"><div align="center"><span class="Estilo5"><select name="txtcod_ced" size="1"> <?php if(substr($campo502,6,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?> </span></div></td>
                                   </tr>
                                </table></td>
                          </tr>
              </table></td>
             </tr>
            </table></td>
          </tr>
                  <tr>
            <td><table width="850" height="24" border="0" cellpadding="0" cellspacing="0">
             <tr>
              <td><table width="850" height="24" border="1" cellspacing="2" cellpadding="0">
                          <tr>
                                <td width="425"><table width="425" height="24"border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="354"><span class="Estilo5">TRABAJA CON PASOS Y GRADOS:</span></td>
                                          <td width="70"><div align="center"><span class="Estilo5"><select name="txtpaso" size="1"> <?php if(substr($campo502,9,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?> </span></div></td>
                                         </tr>
                                </table></td>
                                <td width="425"><table width="425" height="24" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="354"><span class="Estilo5">N&Uacute;MERO DE LUNES MENSUAL:</span> </td>
                                          <td width="70"><div align="center"><span class="Estilo5"><select name="txtlunes" size="1"> <?php if(substr($campo502,13,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?> </span></div></td>
                                   </tr>
                                </table></td>
                          </tr>
              </table></td>
             </tr>
            </table></td>
          </tr>
                  <tr>
            <td><table width="850" height="24" border="0" cellpadding="0" cellspacing="0">
             <tr>
              <td><table width="850" height="24" border="1" cellspacing="2" cellpadding="0">
                          <tr>
                                <td width="425"><table width="425" height="24"border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="354"><span class="Estilo5">TRABAJADOR PRIMERO EL APELLIDO:</span></td>
                                          <td width="70"><div align="center"><span class="Estilo5"><select name="txtapellido" size="1"> <?php if(substr($campo502,18,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?> </span></div></td>
                                         </tr>
                                </table></td>
                                <td width="425"><table width="425" height="24" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="354"><span class="Estilo5">RECIBO DOS COLUMNAS:</span> </td>
                                          <td width="70"><div align="center"><span class="Estilo5"><select name="txtrecibo" size="1"> <?php if(substr($campo502,7,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?> </span></div></td>
                                   </tr>
                                </table></td>
                          </tr>
              </table></td>
             </tr>
            </table></td>
          </tr>
          <tr><td>&nbsp;</td></tr>
          <tr>
            <td height="12"><table width="230" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="166"><span class="Estilo14 Estilo10">PRESTACIONES</span></td>
              </tr>
            </table></td>
          </tr>
                  <tr>
            <td><table width="850" height="24" border="0" cellpadding="0" cellspacing="0">
             <tr>
              <td><table width="850" height="24" border="1" cellspacing="2" cellpadding="0">
                          <tr>
                                <td width="425"><table width="425" height="24"border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="354"><span class="Estilo5">CALCULA INTERESES DE FIDEICOMISO:</span></td>
                                          <td width="70"><div align="center"><span class="Estilo5"><select name="txtintereses" size="1"> <?php if(substr($campo502,10,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?> </span></div></td>
                                         </tr>
                                </table></td>
                                <td width="425"><table width="425" height="24" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="354"><span class="Estilo5">CAPITALIZAR INTERESES DE FIDEICOMISO MENSUAL:</span> </td>
                                          <td width="70"><div align="center"><span class="Estilo5"><select name="txtint_mensual" size="1"> <?php if(substr($campo502,0,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?> </span></div></td>
                                   </tr>
                                </table></td>
                          </tr>
              </table></td>
             </tr>
            </table></td>
          </tr>
                  <tr>
            <td><table width="850" height="24" border="0" cellpadding="0" cellspacing="0">
             <tr>
              <td><table width="850" height="24" border="1" cellspacing="2" cellpadding="0">
                          <tr>
                                <td width="425"><table width="425" height="24"border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="354"><span class="Estilo5">CAPITALIZAR INTERESES DE FIDEICOMISO ANUAL:</span></td>
                                          <td width="70"><div align="center"><span class="Estilo5"><select name="txtint_anual" size="1"> <?php if(substr($campo502,16,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?> </span></div></td>
                                         </tr>
                                </table></td>
                                <td width="425"><table width="425" height="24" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="354"><span class="Estilo5">COMENZAR A DEPOSITAR EN EL TERCER MES:</span> </td>
                                          <td width="70"><div align="center"><span class="Estilo5"><select name="txttecer_mes" size="1"> <?php if(substr($campo502,3,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?> </span></div></td>
                                   </tr>
                                </table></td>
                          </tr>
              </table></td>
             </tr>
            </table></td>
          </tr>
                  <tr>
            <td><table width="850" height="24" border="0" cellpadding="0" cellspacing="0">
             <tr>
              <td><table width="850" height="24" border="1" cellspacing="2" cellpadding="0">
                          <tr>
                                <td width="425"><table width="425" height="24"border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="354"><span class="Estilo5">DEPOSITAR DIAS ADICIONALES PRIMER A&Ntilde;O:</span></td>
                                          <td width="70"><div align="center"><span class="Estilo5"><select name="txtdep_primer" size="1"> <?php if(substr($campo502,2,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?> </span></div></td>
                                         </tr>
                                </table></td>
                                <td width="425"><table width="425" height="24" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="354"><span class="Estilo5">ACUMULA DIAS ADICIONALES ANTIGUEDAD:</span> </td>
                                          <td width="70"><div align="center"><span class="Estilo5"><select name="txtacumula_dias" size="1"> <?php if(substr($campo502,4,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?> </span></div></td>
                                   </tr>
                                </table></td>
                          </tr>
              </table></td>
             </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="850" height="24" border="0" cellpadding="0" cellspacing="0">
             <tr>
              <td><table width="850" height="24" border="1" cellspacing="2" cellpadding="0">
                          <tr>
                                <td width="425"><table width="425" height="24"border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="354"><span class="Estilo5">SUELDO PROMEDIO (A&Ntilde;O) DIAS ADICIONALES:</span></td>
                                          <td width="70"><div align="center"><span class="Estilo5"><select name="txtsueldo_prom" size="1"> <?php if(substr($campo502,11,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?> </span></div></td>
                                         </tr>
                                </table></td>
                                <td width="425"><table width="425" height="24" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="354"><span class="Estilo5">DEP. DIFERENCIA DIAS PRIMER A&Ntilde;O PRESTACIONES:</span> </td>
                                          <td width="70"><div align="center"><span class="Estilo5"><select name="txtacumula_dias" size="1"> <?php if(substr($campo502,1,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?> </span></div></td>
                                   </tr>
                                </table></td>
                          </tr>
              </table></td>
             </tr>
            </table></td>
          </tr>
                  <tr>
            <td><table width="850" height="24" border="0" cellpadding="0" cellspacing="0">
             <tr>
              <td><table width="850" height="24" border="1" cellspacing="2" cellpadding="0">
                          <tr>
                                <td width="425"><table width="425" height="24"border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="354"><span class="Estilo5">DEPOSITAR PRESTACIONES AL FINAL DEL MES:</span></td>
                                          <td width="70"><div align="center"><span class="Estilo5"><select name="txtpresta_fmes" size="1"> <?php if(substr($campo502,12,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?> </span></div></td>
                                         </tr>
                                </table></td>
                                <td width="425"><table width="425" height="24" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td> </td>   </tr>
                                </table></td>
                          </tr>
              </table></td>
             </tr>
            </table></td>
          </tr>
                  <tr><td>&nbsp;</td></tr>
                   <tr>
            <td height="12"><table width="230" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="166"><span class="Estilo14 Estilo10">VACACIONES</span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="850" height="24" border="0" cellpadding="0" cellspacing="0">
             <tr>
              <td><table width="850" height="24" border="1" cellspacing="2" cellpadding="0">
                          <tr>
                                <td width="425"><table width="425" height="24"border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="354"><span class="Estilo5">PROCESAR VACACIONES EN NOMINA:</span></td>
                                          <td width="70"><div align="center"><span class="Estilo5"><select name="txtvac_nom" size="1"> <?php if(substr($campo502,5,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?> </span></div></td>
                                         </tr>
                                </table></td>
                                <td width="425"><table width="425" height="24" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="354"><span class="Estilo5">ASIGNAR CANTIDADES DE BONO VACACIONAL:</span> </td>
                                          <td width="70"><div align="center"><span class="Estilo5"><select name="txtcant_bono" size="1"> <?php if(substr($campo502,14,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?> </span></div></td>
                                   </tr>
                                </table></td>
                          </tr>
              </table></td>
             </tr>
            </table></td>
          </tr>
                  <tr>
            <td><table width="850" height="24" border="0" cellpadding="0" cellspacing="0">
             <tr>
              <td><table width="850" height="24" border="1" cellspacing="2" cellpadding="0">
                          <tr>
                                <td width="425"><table width="425" height="24"border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="354"><span class="Estilo5">RETORNAR CON FECHA ADELANTADA:</span></td>
                                          <td width="70"><div align="center"><span class="Estilo5"><select name="txtret_vac" size="1"> <?php if(substr($campo502,17,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?> </span></div></td>
                                         </tr>
                                </table></td>
                                <td width="425"><table width="425" height="24" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="354"><span class="Estilo5">DIAS ADICIONAL BONO VACACIONAL:</span> </td>
                                          <td width="70"><div align="center"><span class="Estilo5"><select name="txtdias_ad_vac" size="1"> <?php if(substr($campo502,19,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?> </span></div></td>
                                   </tr>
                                </table></td>
                          </tr>
              </table></td>
             </tr>
            </table></td>
          </tr>
<script language="JavaScript" type="text/JavaScript">
function asig_monto_bono(mvalor){var f=document.form1;
        if(mvalor=="S"){document.form1.txtmonto_bono_vac.options[0].selected = true;}
        if(mvalor=="A"){document.form1.txtmonto_bono_vac.options[1].selected = true;}
        if(mvalor=="C"){document.form1.txtmonto_bono_vac.options[2].selected = true;}
        if(mvalor=="N"){document.form1.txtmonto_bono_vac.options[3].selected = true;}
}</script>
                  <tr>
            <td><table width="862" height="24" border="0" cellpadding="0" cellspacing="0">
             <tr>
              <td><table width="863" height="24" border="1" cellspacing="2" cellpadding="0">
                          <tr>
                                  <td width="357"><span class="Estilo5">CALCULAR BONO VACACIONAL CON MONTO:</span> </td>
                                  <td width="487"><span class="Estilo5"> <select name="txtmonto_bono_vac" size="1">
                                         <option>MES DE CAUSACION</option> <option>MES ANTERIOR AL DISFRUTE</option> <option>SUELDO+COMPENSACION ACTUAL</option> <option>POR CARGA</option> </select>
                                  </span></td>
<script language="JavaScript" type="text/JavaScript"> asig_monto_bono('<?php echo substr($campo502,15,1);?>');</script>
                          </tr>
              </table></td>
             </tr>
            </table></td>
           </tr>
        </table>
        <p>&nbsp;</p>
                <table width="768">
          <tr>
            <td width="600">&nbsp;</td>
            <td width="50"><input name="txtcod_modulo" type="hidden" id="txtcod_modulo" value="<?php echo $cod_modulo?>" ></td>
                        <td width="50"><input name="txtperiodo" type="hidden" id="txtperiodo" value="<?php echo $periodo?>" ></td>
            <td width="68" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
          </tr>
        </table>
        </form>
    </div>

  </tr>
</table>
</body>
</html>
