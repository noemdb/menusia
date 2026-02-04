<?php include ("../class/seguridad.inc");include ("../class/conects.php");include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $cod_modulo="02";
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
<title>SIA CONFIGURACI&Oacute;N CONTROL BANCARIO</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
</script>
<script language="JavaScript" type="text/JavaScript">
function revisar(){
var f=document.form1;
    if(f.txtLogin.value==""){alert("Login no puede estar Vacio");return false;}  else{f.txtLogin.value=f.txtLogin.value.toUpperCase();}
document.form1.submit;
return true;}
function LlamarURL(url) {document.location = url;}
</script>
</head>
<?php
$tipo_chq=""; $periodo="01"; $campo502="";
$sql="Select * from SIA005 where campo501='$cod_modulo'";$resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$cod_modulo=$registro["campo501"]; $campo502=$registro["campo502"]; $periodo=$registro["campo503"];
$tipo_chq=$registro["campo504"];$tipo_chqd=$registro["campo505"];$tipo_ndb=$registro["campo507"];$tipo_ndbd=$registro["campo508"]; $des_chq=$registro["campo510"]; $cta_det=$registro["campo511"]; $un_trib=$registro["campo534"]; $dias_caduca=$registro["campo549"];
} IF($periodo=="  "){$periodo="01";}
?>
<body>
<table width="1002" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="72"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="835"><div align="center" class="Estilo2 Estilo6">CONFIGURACI&Oacute;N CONTROL BANCARIO</div></td>
    <td width="81" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="1000" height="510" border="1">
  <tr>
    <td width="92"><table width="92" height="506" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick=javascript:LlamarURL('usuarios.php');
          onMouseOut="this.style.backgroundColor='#EAEAEA';" height="35"  bgColor=#EAEAEA><A class=menu href="menu_conf.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA';" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu Principal</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="892"><div id="Layer1" style="position:absolute; width:889px; height:501px; z-index:1; top: 65px; left: 112px;">
      <form name="form1" method="post" action="Update_conf_bancos.php" onSubmit="return revisar()">
        <table width="864" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="860"><table width="858" border="1" cellspacing="2" cellpadding="0">
              <tr>
                <td width="428" height="19"><table width="428" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="358"><span class="Estilo5">PERIODO TRABAJO DESDE DEL MODULO: </span></td>
                      <td width="70"><span class="Estilo5"><input class="Estilo10" name="txtperiodo" type="text" id="txtperiodo"  size="3" maxlength="2" value="<?php echo $periodo ?>"  onFocus="encender(this)" onBlur="apagar(this)"> </span> </td>
                    </tr>
                </table></td>
                <td width="428"><table width="428" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="358"><span class="Estilo5"> DESEA SOBREGIRAR SALDO DE BANCOS :</span> </td>
                      <td width="70"><div align="center"><span class="Estilo5"><select name="txtsobregira" size="1"> <?php if(substr($campo502,0,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?> </span></div></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="864"  border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="860"><table width="858" border="1" cellspacing="2" cellpadding="0">
              <tr>
                <td width="428" height="19"><table width="428" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="358"><span class="Estilo5">DOCUMENTO DE ORDEN EN CONCEPTO DE CHEQUE: </span></td>
                       <td width="70"><div align="center"><span class="Estilo5"><select name="txtdoc_orden" size="1"> <?php if(substr($campo502,5,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?> </span></div></td>
                      </tr>
                </table></td>
                <td width="428"><table width="428" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="358"><span class="Estilo5">PAGO DE RETENCIONES AFECTAN PRESUPUESTO :</span> </td>
                      <td width="70"><div align="center"><span class="Estilo5"><select name="txtret_presup" size="1"> <?php if(substr($campo502,6,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?> </span></div></td>
                   </tr>
                </table></td>
              </tr>
            </table></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="867" height="17" border="1" cellpadding="0" cellspacing="1">
              <tr>
                <td width="860"><table width="858" height="19" border="0" cellpadding="0">
                    <tr>
                      <td width="347"><span class="Estilo5">COLOCAR ANTES DE LA DESCRIPCI&Oacute;N DEL CHEQUE:</span></td>
                       <td width="500"><input class="Estilo10" name="txtdes_chq" type="text" id="txtdes_chq" size="50" maxlength="30"  value="<?php echo $des_chq ?>" onFocus="encender(this)" onBlur="apagar(this)"></td>

                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr><td>&nbsp;</td></tr>
          <tr>
            <td><table width="864"  border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="860"><table width="858" border="1" cellspacing="2" cellpadding="0">
                                  <td width="428" height="19"><table width="428" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="348"><span class="Estilo5">CANTIDAD UNIDAD TRIBUTARIA PARA NOTIFICACI&Oacute;N :</span></td>
                      <td width="80"><span class="Estilo5">
                          <input class="Estilo10" name="txtcant_ut" type="text" id="txtcant_ut"  size="6" maxlength="6" value="<?php echo $un_trib ?>" onFocus="encender(this)" onBlur="apagar(this)">
                      </span></td>
                    </tr>
                              </table></td>
                                  <td width="428"><table width="428" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="348"><span class="Estilo5">N&Uacute;MERO DE DIAS A CADUCAR CHEQUES :</span> </td>
                      <td width="80"><span class="Estilo5">
                        <input class="Estilo10" name="txtnum_dias" type="text" id="txtnum_dias"  size="4" maxlength="3" value="<?php echo $dias_caduca ?>" onFocus="encender(this)" onBlur="apagar(this)">
                      </span></td>
                   </tr>
                  </table></td>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="867" height="17" border="1" cellpadding="0" cellspacing="1">
              <tr>
                <td width="860"><table width="841" height="19" border="0" cellpadding="0">
                    <tr>
                      <td width="421"><p class="Estilo5">C&Oacute;DIGO CONTABLE FONDO POR DEPOSITAR TRANSFERENCIAS :</p>
                          </td>
                      <td width="414"><span class="Estilo5">
                          <input class="Estilo10" name="txtcod_transf" type="text" id="txtcod_transf" size="30" maxlength="32" value="<?php echo $cta_det ?>" onFocus="encender(this)" onBlur="apagar(this)">
                      </span></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr> <td>&nbsp;</td></tr>
          <tr>
             <td><table width="864"  border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="860"><table width="858" border="1" cellspacing="2" cellpadding="0">
                                  <td width="428" height="19"><table width="428" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="348"><span class="Estilo5">PLANILLA RETENCION IMPUESTO CON CHEQUE: </span></td>
                                          <td width="80"><div align="center"><span class="Estilo5">
                        <select name="txtret_imp" size="1"> <?php if(substr($campo502,4,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                      </span></div></td>
                    </tr>
                                  </table></td>
                                  <td width="428" height="19"><table width="428" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td width="348"><span class="Estilo5">AL EMITIR COLOCAR CHEQUE EN PROCESO: </span></td>
                                          <td width="80"><div align="center"><span class="Estilo5">
                        <select name="txtchq_proc" size="1"> <?php if(substr($campo502,7,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                      </span></div></td>
                                        </tr>
                                  </table></td>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr> <td>&nbsp;</td> </tr>
          <tr>
            <td><table width="864"  border="0" cellpadding="0" cellspacing="0">
              <tr>
                            <td width="860"><table width="858" border="1" cellspacing="2" cellpadding="0">
                  <td width="428"><table width="428" height="19" border="0" cellpadding="0">
                    <tr>
                      <td width="348"><span class="Estilo5">CORRELATIVO N&Uacute;MERO COMPROBANTE IVA POR A&Ntilde;O:</span></td>
                      <td width="80"><div align="center"><span class="Estilo5">
                        <select name="txtcorr_iva" size="1"> <?php if(substr($campo502,8,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                      </span></div></td>
                      </tr>
                  </table></td>
                  <td width="428"><table width="428" height="19" border="0" cellpadding="0">
                    <tr>
                      <td width="348"><span class="Estilo5">COMPROBANTE RETENCION IVA CON CHEQUE:</span></td>
                      <td width="80"><div align="center"><span class="Estilo5">
                        <select name="txtcomp_iva" size="1"> <?php if(substr($campo502,9,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                      </span></div></td>
                    </tr>
                                  </table></td>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr> <td>&nbsp;</td> </tr>
          <tr>
            <td><table width="864"  border="0" cellpadding="0" cellspacing="0">
              <tr>
                            <td width="860"><table width="858" border="1" cellspacing="2" cellpadding="0">
                  <td width="428"><table width="428" height="19" border="0" cellpadding="0" dwcopytype="CopyTableRow">
                    <tr>
                      <td width="348"><span class="Estilo5">TIPO DOCUMENTO CHEQUE VOUCHER:</span></td>
                      <td width="80"><div align="center"> <span class="Estilo5">
                          <input class="Estilo10" name="txtdoc_chq" type="text" id="txtdoc_chq"  size="4" maxlength="4" value="<?php echo $tipo_chq ?>" onFocus="encender(this)" onBlur="apagar(this)">
                      </span></div></td>
                    </tr>
                  </table></td>
                  <td width="428"><table width="428" height="19" border="0" cellpadding="0" dwcopytype="CopyTableRow">
                    <tr>
                      <td width="285"><span class="Estilo5">TIPO DOCUMENTO CHEQUE NO AFECTA:</span></td>
                      <td width="130"><div align="center"> <span class="Estilo5">
                        <input class="Estilo10" name="txtdoc_chqf" type="text" id="txtdoc_chqf" size="4" maxlength="4" value="<?php echo $tipo_chqd ?>" onFocus="encender(this)" onBlur="apagar(this)">
                      </span></div></td>
                    </tr>
                  </table></td>
                                </table></td>
              </tr>
              <tr>
                            <td width="860"><table width="858" border="1" cellspacing="2" cellpadding="0">
                  <td width="428"><table width="428" height="19" border="0" cellpadding="0" dwcopytype="CopyTableRow">
                    <tr>
                      <td width="348"><span class="Estilo5">TIPO DOCUMENTO NOTA DEBITO:</span></td>
                      <td width="80"><div align="center"> <span class="Estilo5">
                          <input class="Estilo10" name="txtdoc_ndb" type="text" id="txtdoc_ndb"  size="4" maxlength="4" value="<?php echo $tipo_ndb ?>"  onFocus="encender(this)" onBlur="apagar(this)">
                      </span></div></td>
                    </tr>
                  </table></td>
                  <td width="428"><table width="428" height="19" border="0" cellpadding="0" dwcopytype="CopyTableRow">
                    <tr>
                      <td width="285"><span class="Estilo5">TIPO DOCUMENTO NOTA DEBITO DIRECTA:</span></td>
                      <td width="130"><div align="center"> <span class="Estilo5">
                        <input class="Estilo10" name="txtdoc_ndbd" type="text" id="txtdoc_ndbd" size="4" maxlength="4" value="<?php echo $tipo_ndbd ?>"   onFocus="encender(this)" onBlur="apagar(this)">
                      </span></div></td>
                    </tr>
                  </table></td>
                                </table></td>
              </tr>

            </table></td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <table width="768">
          <tr>
            <td width="630">&nbsp;</td>
            <td width="50"><input  name="txtcod_modulo" type="hidden" id="txtcod_modulo" value="<?php echo $cod_modulo?>" ></td>
            <td width="88" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
          </tr>
        </table>
        </form>
    </div>
  </tr>
</table>
</body>
</html>
<?php pg_close(); ?>
