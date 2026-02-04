<?php include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $cod_modulo="05";
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
<title>SIA CONFIGURACI&Oacute;N Y MANTENIMIENTO</title>
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
function revisar(){var f=document.form1;
    if(f.txtformato_pre.value==""){alert("Formato no puede estar Vacio");return false;} else{f.txtformato_pre.value=f.txtformato_pre.value.toUpperCase();}
document.form1.submit;
return true;}
function LlamarURL(url) {document.location = url;}
</script>
</head>
<?php
$formato_pre=""; $titulo=""; $periodo="01"; $campo572=""; $nivel=0; $long_cat=0; $nombcat1=""; $abrevcat1=""; $nombcat2=""; $abrevcat2=""; $nombcat3=""; $abrevcat3=""; $nombcat4=""; $abrevcat4=""; $nombcat5=""; $abrevcat5=""; $nombpar1=""; $abrevpar1=""; $nombpar2=""; $abrevpar2="";$nombpar3=""; $abrevpar3="";$nombpar4=""; $abrevpar4="";$nombpar5=""; $abrevpar5=""; $porc_traspaso=0; $campo502="";
$sql="Select * from SIA005 where campo501='$cod_modulo'";$resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$cod_modulo=$registro["campo501"]; $campo502=$registro["campo502"]; $periodo=$registro["campo503"]; $nivel=$registro["campo552"]; $long_cat=$registro["campo550"]; $formato_pre=$registro["campo504"]; $titulo=$registro["campo525"];  $porc_traspaso=$registro["campo534"]; $nivel_traspaso=$registro["campo553"];
$nombcat1=$registro["campo505"]; $abrevcat1=$registro["campo506"]; $nombcat2=$registro["campo507"]; $abrevcat2=$registro["campo508"]; $nombcat3=$registro["campo509"]; $abrevcat3=$registro["campo510"]; $nombcat4=$registro["campo511"]; $abrevcat4=$registro["campo512"]; $nombcat5=$registro["campo513"]; $abrevcat5=$registro["campo514"];
$nombpar1=$registro["campo515"]; $abrevpar1=$registro["campo516"]; $nombpar2=$registro["campo517"]; $abrevpar2=$registro["campo518"]; $nombpar3=$registro["campo519"]; $abrevpar3=$registro["campo520"]; $nombpar4=$registro["campo521"]; $abrevpar4=$registro["campo522"]; $nombpar5=$registro["campo523"]; $abrevpar5=$registro["campo524"];
$campo572=$registro["campo572"];
}
?>
<body>
<table width="1006" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CONFIGURACI&Oacute;N CONTABILIDAD PRESUPUESTARIA </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="1006" height="887" border="1">
  <tr>
    <td width="92" height="881"><table width="92" height="874" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
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
    <td width="898" align="center"><div id="Layer1" style="position:absolute; width:869px; height:890px; z-index:1; top: 68px; left: 116px;">
      <form name="form1" method="post" action="Update_conf_presup.php" onSubmit="return revisar()">
        <table width="824" height="836" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="67"><table width="892" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="539"><table width="531" border="0" cellpadding="0">
                      <tr>
                        <td width="250"><span class="Estilo5">FORMATO C&Oacute;DIGO PRESUPUESTARIO:</span></td>
                        <td width="275"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtformato_pre" type="text" id="txtformato_pre" size="40" maxlength="32" value="<?php echo $formato_pre?>" onFocus="encender(this)" onBlur="apagar(this)"></span></div></td>
                      </tr>
                  </table></td>

                  <td width="347"><table width="333" border="0" cellpadding="0">
                      <tr>
                        <td width="289"><span class="Estilo5">NIVEL A CONTROLAR LA DISPONIBILIDAD:</span></td>
                        <td width="38"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtnivel" type="text" id="txtnivel"  size="3" maxlength="2" value="<?php echo $nivel?>" onFocus="encender(this)" onBlur="apagar(this)"></span></div></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="530" border="0" cellpadding="0">
                      <tr>
                        <td width="249"><span class="Estilo5">TITULO C&Oacute;DIGO PRESUPUESTARIO:</span></td>
                        <td width="275"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txttitulo" type="text" id="txttitulo" readonly value="<?php echo $titulo?>" size="40" maxlength="32"></span></div></td>
                      </tr>
                  </table></td>

                  <td><table width="333" border="0" cellpadding="0">
                      <tr>
                        <td width="289"><span class="Estilo5">LONGITUD DE CATEGORIAS PROGRAMATICAS:</span></td>
                        <td width="38"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtlong_cat" type="text" id="txtlong_cat" size="3" maxlength="2"  value="<?php echo $long_cat?>" onFocus="encender(this)" onBlur="apagar(this)"> </span></div></td>
                      </tr>
                  </table></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="860" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="430"><div align="center"><span class="Estilo14">CATEGORIAS</span></div></td>
                  <td width="430"><div align="center"><span class="Estilo14">PARTIDAS</span></div></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="850" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="340" align="center"><span class="Estilo13">Nombre Extendido</span></td>
                  <td width="84"><span class="Estilo13">Abreviado</span></td>
                  <td width="342" align="center"><span class="Estilo13">Nombre Extendido</span></td>
                  <td width="84"><span class="Estilo13">Abreviado</span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="158"><table width="860" border="1" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="430"><table width="420"  border="0" cellpadding="0">
                      <tr>
                        <td width="344" valign="middle"><div align="center"><span class="Estilo5">
                          <input class="Estilo10" name="txtnombcat1" type="text" id="txtnombcat1" size="40" maxlength="50"  value="<?php echo $nombcat1?>" onFocus="encender(this)" onBlur="apagar(this)">
                        </span></div></td>
                        <td width="70" valign="middle"><div align="center"><span class="Estilo5">
                            <input class="Estilo10" name="txtabrevcat1" type="text" id="txtabrevcat1" size="4" maxlength="4" value="<?php echo $abrevcat1?>" onFocus="encender(this)" onBlur="apagar(this)">
                        </span></div></td>
                      </tr>
                  </table></td>
                  <td width="430"><table width="420" border="0" cellpadding="0">
                      <tr>
                        <td width="344"><div align="center"><span class="Estilo5">
                          <input class="Estilo10" name="txtnombpar1" type="text" id="txtnombpar1" size="40" maxlength="50" value="<?php echo $nombpar1?>" onFocus="encender(this)" onBlur="apagar(this)">
                        </span></div></td>
                        <td width="70"><div align="center"><span class="Estilo5">
                            <input class="Estilo10" name="txtabrevpar1" type="text" id="txtabrevpar1" size="4" maxlength="4" value="<?php echo $abrevpar1?>" onFocus="encender(this)" onBlur="apagar(this)">
                        </span></div></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="420" border="0" cellpadding="0">
                      <tr>
                        <td width="344"><div align="center"><span class="Estilo5">
                          <input class="Estilo10" name="txtnombcat2" type="text" id="txtnombcat2" size="40" maxlength="50" value="<?php echo $nombcat2?>" onFocus="encender(this)" onBlur="apagar(this)">
                        </span></div></td>
                        <td width="70" valign="middle"><div align="center"><span class="Estilo5">
                            <input class="Estilo10" name="txtabrevcat2" type="text" id="txtabrevcat2" size="4" maxlength="4" value="<?php echo $abrevcat2?>" onFocus="encender(this)" onBlur="apagar(this)">
                        </span></div></td>
                      </tr>
                  </table></td>
                  <td><table width="420"  border="0" cellpadding="0">
                      <tr>
                        <td width="344"><div align="center"><span class="Estilo5">
                          <input class="Estilo10" name="txtnombpar2" type="text" id="txtnombpar2" size="40" maxlength="50" value="<?php echo $nombpar2?>" onFocus="encender(this)" onBlur="apagar(this)">
                        </span></div></td>
                        <td width="70"><div align="center"><span class="Estilo5">
                            <input class="Estilo10" name="txtabrevpar2" type="text" id="txtabrevpar2" size="4" maxlength="4"  value="<?php echo $abrevpar2?>" onFocus="encender(this)" onBlur="apagar(this)">
                        </span></div></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="420" border="0" cellpadding="0">
                      <tr>
                        <td width="344"><div align="center"><span class="Estilo5">
                          <input class="Estilo10" name="txtnombcat3" type="text" id="txtnombcat3"  size="40" maxlength="50"  value="<?php echo $nombcat3?>" onFocus="encender(this)" onBlur="apagar(this)">
                        </span></div></td>
                        <td width="70" valign="middle"><div align="center"><span class="Estilo5">
                            <input class="Estilo10" name="txtabrevcat3" type="text" id="txtabrevcat3" size="4" maxlength="4" value="<?php echo $abrevcat3?>" onFocus="encender(this)" onBlur="apagar(this)">
                        </span></div></td>
                      </tr>
                  </table></td>
                  <td><table width="420" border="0" cellpadding="0">
                      <tr>
                        <td width="344"><div align="center"><span class="Estilo5">
                          <input class="Estilo10" name="txtnombpar3" type="text" id="txtnombpar3" size="40" maxlength="50" value="<?php echo $nombpar3?>" onFocus="encender(this)" onBlur="apagar(this)">
                        </span></div></td>
                        <td width="70"><div align="center"><span class="Estilo5">
                            <input class="Estilo10" name="txtabrevpar3" type="text" id="txtabrevpar3"size="4" maxlength="4" value="<?php echo $abrevpar3?>" onFocus="encender(this)" onBlur="apagar(this)">
                        </span></div></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="420"  border="0" cellpadding="0">
                      <tr>
                        <td width="344"><div align="center"><span class="Estilo5">
                          <input class="Estilo10" name="txtnombcat4" type="text" id="txtnombcat4"  size="40" maxlength="50"  value="<?php echo $nombcat4?>" onFocus="encender(this)" onBlur="apagar(this)">
                        </span></div></td>
                        <td width="70" valign="middle"><div align="center"><span class="Estilo5">
                            <input class="Estilo10" name="txtabrevcat4" type="text" id="txtabrevcat4" size="4" maxlength="4" value="<?php echo $abrevcat4?>"  onFocus="encender(this)" onBlur="apagar(this)">
                        </span></div></td>
                      </tr>
                  </table></td>
                  <td><table width="420"  border="0" cellpadding="0">
                      <tr>
                        <td width="342"><div align="center"><span class="Estilo5">
                          <input class="Estilo10" name="txtnombpar4" type="text" id="txtnombpar4"  size="40" maxlength="50" value="<?php echo $nombpar4?>" onFocus="encender(this)" onBlur="apagar(this)">
                        </span></div></td>
                        <td width="70"><div align="center"><span class="Estilo5">
                            <input class="Estilo10" name="txtabrevpar4" type="text" id="txtabrevpar4" size="4" maxlength="4" value="<?php echo $abrevpar4?>" onFocus="encender(this)" onBlur="apagar(this)">
                        </span></div></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="420" border="0" cellpadding="0">
                      <tr>
                        <td width="344"><div align="center"><span class="Estilo5">
                          <input class="Estilo10" name="txtnombcat5" type="text" id="txtnombcat5" size="40" maxlength="50"  value="<?php echo $nombcat5?>" onFocus="encender(this)" onBlur="apagar(this)">
                        </span></div></td>
                        <td width="70" valign="middle"><div align="center"><span class="Estilo5">
                            <input class="Estilo10" name="txtabrevcat5" type="text" id="txtabrevcat5" size="4" maxlength="4" value="<?php echo $abrevcat5?>"  onFocus="encender(this)" onBlur="apagar(this)">
                        </span></div></td>
                      </tr>
                  </table></td>
                  <td><table width="420"  border="0" cellpadding="0">
                      <tr>
                        <td width="343"><div align="center"><span class="Estilo5">
                          <input class="Estilo10" name="txtnombpar5" type="text" id="txtnombpar5" size="40" maxlength="50" value="<?php echo $nombpar5?>" onFocus="encender(this)" onBlur="apagar(this)">
                        </span></div></td>
                        <td width="70"><div align="center"><span class="Estilo5">
                            <input class="Estilo10" name="txtabrevpar5" type="text" id="txtabrevpar5" size="4" maxlength="4" value="<?php echo $abrevpar5?>" onFocus="encender(this)" onBlur="apagar(this)">
                        </span></div></td>
                      </tr>
                  </table></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="863" border="1" cellspacing="1" cellpadding="0">
                <tr>
                  <td width="430"><table width="414" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="338" height="22"><span class="Estilo5">REFERENCIA SOLO N&Uacute;MERO :</span></td>
                      <td width="76"><div align="center"><span class="Estilo5">
                        <select name="txtsolo_num" size="1"> <?php if(substr($campo502,0,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                        </span></div></td>
                    </tr>
                  </table><span class="Estilo5"> </span></td>
                  <td width="430"><table width="411" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="299"><span class="Estilo5">PERIODO TRABAJO DESDE DEL MODULO :</span></td>
                        <td width="112"><div align="center"><span class="Estilo5">
                          <input class="Estilo10" name="txtperiodo" type="text" id="txtperiodo"  size="3" maxlength="2" value="<?php echo $periodo ?>"  onFocus="encender(this)" onBlur="apagar(this)">
                        </span></div></td>
                      </tr>
                  </table></td>
                </tr>
            </table></td>
          </tr>
          <tr> <td height="12">&nbsp;</td>  </tr>
          <tr>
            <td height="16"><table width="132" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="181" align="center"><span class="Estilo14">COMPROMISOS</span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="862" border="1" cellspacing="1" cellpadding="0">
                <tr>
                  <td width="423"><table width="413" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="335"><span class="Estilo5">REFERENCIA DE COMPROMISO AUTOMATICA : </span></td>
                        <td width="78" align="center"><span class="Estilo5">
                          <select name="txtref_comp" size="1" id="txtref_comp"><?php if(substr($campo502,1,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                        </span></td>
                        </tr>
                  </table></td>
                  <td width="427"><table width="412" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="302"><span class="Estilo5">FECHA COMPROMISO AUTOMATICA :</span></td>
                        <td width="110" align="center"><span class="Estilo5">
                          <select name="txtfecha_comp" size="1" id="txtfecha_comp"><?php if(substr($campo502,2,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                        </span></td>
                      </tr>
                  </table></td>
                </tr>
            </table></td>
          </tr>
		  <tr>
            <td><table width="861" border="1" cellpadding="0" cellspacing="1">
              <tr>
                <td width="423"><table width="413"  border="0" cellpadding="0">
                    <tr>
                      <td width="353"><span class="Estilo5"> APROBAR COMPROMISOS: </span></td>
                      <td width="60"><span class="Estilo5">
                        <select name="txtaprob_comp" size="1" id="txtaprob_comp"><?php if (substr($campo502,15,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                      </span></td>
                      </tr>
                </table></td>
				<td width="427"><table width="412" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="302"><span class="Estilo5">GENERAR COMPROBANTE DE COMPROMISO :</span></td>
                        <td width="110" align="center"><span class="Estilo5">
                          <select name="txtgen_comp" size="1" id="txtgen_comp"><?php if(substr($campo502,3,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                        </span></td>
                      </tr>
                  </table></td>
               </tr>
            </table></td>
          </tr>
          <tr><td height="12">&nbsp;</td> </tr>
          <tr>
            <td height="16"><table width="132" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="181" align="center"><span class="Estilo14">CAUSADOS</span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="862" border="1" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="422"><table width="407" border="0" cellspacing="1" cellpadding="0">
                      <tr>
                        <td width="336"><span class="Estilo5">REFERENCIA DE CAUSADO AUTOMATICA: </span></td>
                        <td width="71" align="center"><span class="Estilo5">
                          <select name="txtref_caus" size="1" id="txtref_caus"><?php if (substr($campo502,4,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                        </span></td>
                      </tr>
                  </table></td>
                  <td width="428"><table width="411" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="305"><span class="Estilo5">FECHA CAUSADO AUTOMATICA: </span></td>
                        <td width="106" align="center"><span class="Estilo5">
                          <select name="txtfecha_caus" size="1" id="txtfecha_caus"><?php if (substr($campo502,5,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                        </span></td>
                        </tr>
                  </table></td>
                </tr>
            </table></td>
          </tr>
          <tr><td height="12">&nbsp;</td> </tr>
          <tr>
            <td height="16"><table width="132" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="181" align="center"><span class="Estilo14">PAGOS</span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="860" border="1" cellspacing="1" cellpadding="0">
                <tr>
                  <td width="422"><table width="405" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="336"><span class="Estilo5">REFERENCIA DE PAGO AUTOMATICA: </span></td>
                        <td width="69" align="center"><span class="Estilo5">
                          <select name="txtref_pago" size="1" id="txtref_pago"><?php if (substr($campo502,6,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                        </span></td>
                        </tr>
                  </table></td>
                  <td width="426"><table width="414" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="307"><span class="Estilo5">FECHA PAGO AUTOMATICA: </span></td>
                        <td width="107" align="center"><span class="Estilo5">
                          <select name="txtfecha_pago" size="1" id="txtfecha_pago"><?php if (substr($campo502,7,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                        </span></td>
                        </tr>
                  </table></td>
                </tr>
            </table></td>
          </tr>
          <tr> <td height="12">&nbsp;</td> </tr>
          <tr>
            <td height="16"><table width="132" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="181" align="center"><span class="Estilo14">AJUSTES</span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="859" border="1" cellspacing="1" cellpadding="0">
                <tr>
                  <td width="422"><table width="406" height="17" border="0" cellpadding="0" >
                      <tr>
                        <td width="334"><span class="Estilo5">REFERENCIA DE AJUSTE AUTOMATICA: </span></td>
                        <td width="72" align="center"><span class="Estilo5">
                          <select name="txtref_ajuste" size="1" id="txtref_ajuste"><?php if (substr($campo502,8,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                        </span></td>
                        </tr>
                  </table></td>
                  <td width="425"><table width="411" border="0"  cellpadding="0">
                      <tr>
                        <td width="308"><span class="Estilo5">FECHA AJUSTE AUTOMATICA: </span></td>
                        <td width="103" align="center"><span class="Estilo5">
                          <select name="txtfecha_ajuste" size="1" id="txtfecha_ajuste"><?php if (substr($campo502,9,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                        </span></td>
                        </tr>
                  </table></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="12">&nbsp;</td>
          </tr>
          <tr>
            <td><table width="147" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="181" align="center"><span class="Estilo14">MODIFICACIONES</span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="860" border="1" cellspacing="1" cellpadding="0">
              <tr>
                <td width="437"><table width="425" border="0" cellpadding="0" >
                    <tr>
                      <td width="364"><span class="Estilo5">REFERENCIA DE MODIFICACIONES AUTOMATICA: </span></td>
                      <td width="61"><span class="Estilo5"> <select name="txtref_mod" size="1" id="txtref_mod"><?php if (substr($campo502,10,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                      </span></td>
                      </tr>
                </table></td>
                <td width="414"><table width="411"  border="0" cellpadding="0" >
                    <tr>
                      <td width="331"><span class="Estilo5">FECHA MODIFICACIONES AUTOMATICA: </span></td>
                      <td width="80"><span class="Estilo5"><select name="txtfecha_mod" size="1" id="txtfecha_mod"><?php if (substr($campo502,11,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                      </span></td>
                      </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="860" border="1" cellpadding="0" cellspacing="1">
              <tr>
                <td width="439" ><table width="429"  border="0" cellpadding="0">
                    <tr>
                      <td width="363"><span class="Estilo5"> MODIFICAR O ELIMINAR MODIFICACIONES APROBADAS :</span></td>
                      <td width="60"><span class="Estilo5"><select name="txtmodif_aprob" size="1" id="txtmodif_aprob"><?php if (substr($campo502,14,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                      </span></td>
                      </tr>
                </table></td>
                <td width="421" ><table width="396" border="0" cellpadding="0">
                  <tr>
                    <td width="320"><span class="Estilo5"> CORRELATIVO POR TIPO DE MODIFICACI&Oacute;N :</span></td>
                    <td width="59"><span class="Estilo5"> <select name="txtcorr_modif" size="1" id="txtcorr_modif"><?php if (substr($campo502,13,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                    </span></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          	  
		 <tr>
            <td><table width="860" border="1" cellpadding="0" cellspacing="1">
              <tr>
                <td width="439" ><table width="429"  border="0" cellpadding="0">
                    <tr>
                      <td width="363"><span class="Estilo5"> PREGUNTAR SI HAY TRASPASOS (+/-) DEL MISMO C&Oacute;DIGO:</span></td>
                      <td width="60"><span class="Estilo5"><select name="txtpreg_cod" size="1" id="txtpreg_cod"><?php if (substr($campo502,12,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?> </span></td>
                      </tr>
                </table></td>
                <td width="421" ><table width="396" border="0" cellpadding="0">
                  <tr>
                    <td width="320"><span class="Estilo5">TIPO DIFERIDO PARA MODIFICACI&Oacute;N :</span></td>
                    <td width="80"><span class="Estilo5"><input class="Estilo10" name="txtdoc_dif" type="text" id="txtdoc_dif"  size="4" maxlength="4" value="<?php echo $campo572 ?>" onFocus="encender(this)" onBlur="apagar(this)">  </span></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
		  
		  
          <tr>
            <td><table width="860"  border="1" cellpadding="0" cellspacing="1">
              <tr>
                <td width="430" ><table width="426"  border="0" cellpadding="0">
                    <tr>
                      <td width="345"><span class="Estilo5"> PORCENTAJE DE CONTROL DE TRASPASOS :</span></td>
                      <td width="80"><span class="Estilo5"><input class="Estilo10" name="txtporc_traspaso" type="text" id="txtporc_traspaso"  size="5" maxlength="5" value="<?php echo $porc_traspaso ?>"  onFocus="encender(this)" onBlur="apagar(this)">
                     </span></td>
                      </tr>
                </table></td>
                <td width="430" ><table width="425"  border="0" cellpadding="0">
                  <tr>
                    <td width="345"><span class="Estilo5"> NIVEL A CONTROLAR PORCENTAJE DE TRASPASO :</span></td>
                     <td width="80"><span class="Estilo5"><input class="Estilo10" name="txtnivel_traspaso" type="text" id="txtnivel_traspaso"  size="5" maxlength="5"  value="<?php echo $nivel_traspaso ?>"  onFocus="encender(this)" onBlur="apagar(this)">
                     </span></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr><td>&nbsp;</td></tr>
          <tr><td>&nbsp;</td></tr>
        </table>
        <table width="848">
          <tr>
            <td width="506">&nbsp;</td>
            <td width="50"><input name="txtcod_modulo" type="hidden" id="txtcod_modulo" value="<?php echo $cod_modulo?>" ></td>
            <td width="70" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="26">&nbsp;</td>
          </tr>
        </table>
      </form>
    </div>
  </tr>
</table>
</body>
</html>
<?php pg_close();?>
