<?php include ("../class/seguridad.inc");include ("../class/conects.php");include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $cod_modulo="07";
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
<title>SIA CONFIGURACI&Oacute;N CONTROL DE INGRESOS</title>
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
    if(f.txtformato.value==""){alert("Formato no puede estar Vacio");return false;} else{f.txtformato.value=f.txtformato.value.toUpperCase();}
document.form1.submit;
return true;}
function LlamarURL(url) {document.location = url;}
</script>
</head>
<?php
$formato=""; $titulo=""; $periodo="01";  $nomb1=""; $abrev1=""; $nomb2=""; $abrev2=""; $nomb3=""; $abrev3=""; $nomb4=""; $abrev4=""; $nomb5=""; $abrev5=""; $nomb6=""; $abrev6="";  $nomb7=""; $abrev7=""; $nomb8=""; $abrev8=""; $campo502=""; $cta_ing_dep=""; $cta_dep_noiden=""; $cta_dep_ingade=""; $cta_imp_ret=""; $cta_imp_iva="";
$sql="Select * from SIA005 where campo501='$cod_modulo'";$resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$cod_modulo=$registro["campo501"]; $campo502=$registro["campo502"]; $periodo=$registro["campo503"]; $formato=$registro["campo504"]; $titulo=$registro["campo522"];  $porc_traspaso=$registro["campo534"]; $nivel_traspaso=$registro["campo553"];
$nomb1=$registro["campo505"]; $abrev1=$registro["campo506"]; $nomb2=$registro["campo507"]; $abrev2=$registro["campo508"]; $nomb3=$registro["campo509"]; $abrev3=$registro["campo510"]; $nomb4=$registro["campo511"]; $abrev4=$registro["campo512"]; $nomb5=$registro["campo513"]; $abrev5=$registro["campo514"];
$nomb6=$registro["campo515"]; $abrev6=$registro["campo516"]; $nomb7=$registro["campo517"]; $abrev7=$registro["campo518"]; $nomb8=$registro["campo519"]; $abrev8=$registro["campo520"]; $cta_ing_dep=$registro["campo521"]; $cta_dep_noiden=$registro["campo523"]; $cta_dep_ingade=$registro["campo526"]; $cta_imp_ret=$registro["campo524"]; 
$cta_imp_iva=$registro["campo525"]; $cta_fond_gar=$registro["campo527"]; $cta_fond_res=$registro["campo528"]; 
}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CONFIGURACI&Oacute;N CONTROL DE INGRESOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="600" border="1">
  <tr>
    <td width="92"><table width="92" height="595" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
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
    <td width="892"><div id="Layer1" style="position:absolute; width:868px; height:711px; z-index:1; top: 65px; left: 130px;">
      <form name="form1" method="post" action="Update_conf_ingreso.php" onSubmit="return revisar()">
        <table width="824" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td><table width="660" height="17" border="1" cellpadding="0" cellspacing="1">
              <tr>
                <td width="600"><table width="600" height="19" border="0" cellpadding="0">
                    <tr>
                      <td width="300"><span class="Estilo5">FORMATO C&Oacute;DIGO INGRESOS:</span></td>
                      <td width="300"><span class="Estilo5"><input class="Estilo10" name="txtformato" type="text" id="txtformato" size="20" maxlength="20" value="<?php echo $formato?>" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                    </tr>
					<tr>
                      <td width="300"><span class="Estilo5">TITULOS C&Oacute;DIGO INGRESOS:</span></td>
					  <td width="300"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txttitulo" type="text" id="txttitulo" readonly value="<?php echo $titulo?>" size="32" maxlength="32"></span></div></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr> <td>&nbsp;</td></tr>
          <tr>
            <td><table width="608" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="296">&nbsp;</td>
                <td width="312"><span class="Estilo11">NIVELES</span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="680" cellpadding="2">
              <tr>
                <td width="260"><span class="Estilo13">Nombre Extendido</span></td>
                <td width="80"><span class="Estilo13">Abreviado</span></td>
                <td width="260"><span class="Estilo13">Nombre Extendido</span></td>
                <td width="80"><span class="Estilo13">Abreviado</span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="660" border="1" cellspacing="1" cellpadding="0">
              <tr>
                <td><table width="330" height="19" border="0" cellpadding="0">
                    <tr>
                      <td width="280"><span class="Estilo5"> <input class="Estilo10" name="txtnomb1" type="text" id="txtnomb1" value="<?php echo $nomb1?>" size="20" maxlength="20"  onFocus="encender(this)" onBlur="apagar(this)">   </span></td>
                      <td width="50"><div align="right"><span class="Estilo5"><input class="Estilo10" name="txtabrev1" type="text" id="txtabrev1" value="<?php echo $abrev1?>" size="4" maxlength="4"  onFocus="encender(this)" onBlur="apagar(this)"> </span></div></td>
                    </tr>
                </table></td>
				<td><table width="330" height="19" border="0" cellpadding="0">
                    <tr>
                      <td width="280"><span class="Estilo5"> <input class="Estilo10" name="txtnomb5" type="text" id="txtnomb5"   value="<?php echo $nomb5?>" size="20" maxlength="20" onFocus="encender(this)" onBlur="apagar(this)">   </span></td>
                      <td width="50"><div align="right"><span class="Estilo5"><input class="Estilo10" name="txtabrev5" type="text" id="txtabrev5"  value="<?php echo $abrev5?>"  size="4" maxlength="4"  onFocus="encender(this)" onBlur="apagar(this)">  </span></div></td>
                    </tr>
                </table></td>
			   </tr>
			   
			   <tr>	
                <td width="330"><table width="330" height="19" border="0" cellpadding="0">
                    <tr>
                      <td width="280"><span class="Estilo5"><input class="Estilo10" name="txtnomb2" type="text" id="txtnomb2"  value="<?php echo $nomb2?>" size="20" maxlength="20" onFocus="encender(this)" onBlur="apagar(this)">     </span></td>
                      <td width="50"><div align="right"><span class="Estilo5"><input class="Estilo10" name="txtabrev2" type="text" id="txtabrev2"  value="<?php echo $abrev2?>"   size="4" maxlength="4"  onFocus="encender(this)" onBlur="apagar(this)">   </span></div></td>
                    </tr>
                </table></td>
                <td><table width="330" height="19" border="0" cellpadding="0">
                    <tr>
                      <td width="280"><span class="Estilo5"><input class="Estilo10" name="txtnomb6" type="text" id="txtnomb6"   value="<?php echo $nomb6?>" size="20" maxlength="20" onFocus="encender(this)" onBlur="apagar(this)">     </span></td>
                      <td width="50"><div align="right"><span class="Estilo5"><input class="Estilo10" name="txtabrev6" type="text" id="txtabrev6"  value="<?php echo $abrev6?>"  size="4" maxlength="4"  onFocus="encender(this)" onBlur="apagar(this)">    </span></div></td>
                    </tr>
                </table></td> 
              </tr>
			  
              <tr>
                <td><table width="330" height="19" border="0" cellpadding="0">
                    <tr>
                      <td width="280"><span class="Estilo5"><input class="Estilo10" name="txtnomb3" type="text" id="txtnomb3"   value="<?php echo $nomb3?>" size="20" maxlength="20" onFocus="encender(this)" onBlur="apagar(this)">   </span></td>
                      <td width="50"><div align="right"><span class="Estilo5"><input class="Estilo10" name="txtabrev3" type="text" id="txtabrev3"  value="<?php echo $abrev3?>"  size="4" maxlength="4"  onFocus="encender(this)" onBlur="apagar(this)">    </span></div></td>
                    </tr>
                </table></td>
                <td><table width="330" height="19" border="0" cellpadding="0">
                    <tr>
                      <td width="280"><span class="Estilo5"><input class="Estilo10" name="txtnomb7" type="text" id="txtnomb7"   value="<?php echo $nomb7?>" size="20" maxlength="20" onFocus="encender(this)" onBlur="apagar(this)">    </span></td>
                      <td width="50"><div align="right"><span class="Estilo5"><input class="Estilo10" name="txtabrev7" type="text" id="txtabrev7"  value="<?php echo $abrev7?>" size="4" maxlength="4"  onFocus="encender(this)" onBlur="apagar(this)">    </span></div></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td><table width="330" height="19" border="0" cellpadding="0">
                    <tr>
                      <td width="280"><span class="Estilo5"><input class="Estilo10" name="txtnomb4" type="text" id="txtnomb4"   value="<?php echo $nomb4?>" size="20" maxlength="20" onFocus="encender(this)" onBlur="apagar(this)">    </span></td>
                      <td width="50"><div align="right"><span class="Estilo5"><input class="Estilo10" name="txtabrev4" type="text" id="txtabrev4"  value="<?php echo $abrev4?>"   size="4" maxlength="4"  onFocus="encender(this)" onBlur="apagar(this)">     </span></div></td>
                    </tr>
                </table></td>
                <td><table width="330" height="19" border="0" cellpadding="0">
                    <tr>
                      <td width="280"><span class="Estilo5"><input class="Estilo10" name="txtnomb8" type="text" id="txtnomb8"  value="<?php echo $nomb8?>" size="20" maxlength="20" onFocus="encender(this)" onBlur="apagar(this)">   </span></td>
                      <td width="50"><div align="right"><span class="Estilo5"><input class="Estilo10" name="txtabrev8" type="text" id="txtabrev8"  value="<?php echo $abrev8?>"  size="4" maxlength="4"  onFocus="encender(this)" onBlur="apagar(this)">   </span></div></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr> 
          <tr> <td>&nbsp;</td></tr>
		  
		  <tr>
            <td><table width="660" height="17" border="1" cellpadding="0" cellspacing="1">
              <tr>
                <td width="600"><table width="600" height="19" border="0" cellpadding="0">   
                    <tr>
                      <td width="300"><span class="Estilo5">CUENTA DE INGRESOS POR DEPOSITAR :</span></td>
                      <td width="300"><span class="Estilo5"><input class="Estilo10" name="txtcta_ing_dep" type="text" id="txtcta_ing_dep" size="20" maxlength="20" value="<?php echo $cta_ing_dep?>" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                    </tr>
					<tr>
                      <td width="300"><span class="Estilo5">CUENTA INGRESO DEPOSITO NO IDENTIFICADO :</span></td>
					  <td width="300"><span class="Estilo5"><input class="Estilo10" name="txtcta_dep_noiden" type="text" id="txtcta_dep_noiden"  value="<?php echo $cta_dep_noiden?>" size="20" maxlength="20"></span></td>
                    </tr>
					<tr>
                      <td width="300"><span class="Estilo5">CUENTA INGRESO ADELANTADO POR CLIENTE :</span></td>
                      <td width="300"><span class="Estilo5"><input class="Estilo10" name="txtcta_dep_ingade" type="text" id="txtcta_dep_ingade" size="20" maxlength="20" value="<?php echo $cta_dep_ingade?>" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                    </tr>
					<tr>
                      <td width="300"><span class="Estilo5">CUENTA DE IMPUESTO RETENIDO :</span></td>
					  <td width="300"><span class="Estilo5"><input class="Estilo10" name="txtcta_imp_ret" type="text" id="txtcta_imp_ret"  value="<?php echo $cta_imp_ret?>" size="20" maxlength="20"></span></td>
                    </tr>
					<tr>
                      <td width="300"><span class="Estilo5">C&Oacute;DIGO PARTIDA DE INGRESOS IVA :</span></td>
					  <td width="300"><span class="Estilo5"><input class="Estilo10" name="txtcta_imp_iva" type="text" id="txtcta_imp_iva"  value="<?php echo $cta_imp_iva?>" size="20" maxlength="20"></span></td>
                    </tr>
					<tr>
                      <td width="300"><span class="Estilo5">CUENTA FONDO DE GARANTIA :</span></td>
                      <td width="300"><span class="Estilo5"><input class="Estilo10" name="txtcta_fond_gar" type="text" id="txtcta_fond_gar" size="20" maxlength="20" value="<?php echo $cta_fond_gar?>" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                    </tr>
					<tr>
                      <td width="300"><span class="Estilo5">CUENTA FONDO DE RESCATE :</span></td>
                      <td width="300"><span class="Estilo5"><input class="Estilo10" name="txtcta_fond_res" type="text" id="txtcta_fond_res" size="20" maxlength="20" value="<?php echo $cta_fond_res?>" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr><td>&nbsp;</td> </tr>
		  <tr>
            <td><table width="660" border="1" cellspacing="1" cellpadding="0">
                <tr>
                  <td width="330"><table width="330" border="0" cellspacing="1" cellpadding="0">
                    <tr>
                      <td width="280" height="22"><span class="Estilo5">REGISTRA DEPOSITO EN LIBRO: </span></td>
                      <td width="50"><div align="center"><span class="Estilo5"><select name="txtreg_mov" size="1"> <?php if(substr($campo502,0,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                        </span></div></td>
                    </tr>
                  </table><span class="Estilo5"> </span></td>
                  <td width="330"><table width="330" border="0" cellspacing="1" cellpadding="0">
                      <tr>
                        <td width="280"><span class="Estilo5">GENERA COMPROBANTE POR MOVIMIENTO:</span></td>
                        <td width="50"><div align="center"><span class="Estilo5"><select name="txtgen_comp" size="1"> <?php if(substr($campo502,1,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?php }else{?><option>SI</option> <option selected>NO</option> </select> <?php }?>
                        </span></div></td>
                      </tr>
                  </table></td>
                </tr>
            </table></td>
          </tr>
          <tr><td>&nbsp;</td></tr>
          <tr>
            <td><table width="330" height="17" border="1" cellpadding="0" cellspacing="1" >
              <tr>
                <td width="330"><table width="330" height="19" border="0" cellpadding="0">
                    <tr>
                      <td width="280"><span class="Estilo5">PERIODO TRABAJO DESDE DEL M&Oacute;DULO:</span></td>
                      <td width="50"><div align="right"><span class="Estilo5"><input class="Estilo10" name="txtperiodo" type="text" id="txtperiodo" size="3" maxlength="2" value="<?php echo $periodo ?>"  onFocus="encender(this)" onBlur="apagar(this)">
                      </span></div></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <table width="768">
          <tr>
            <td width="614">&nbsp;</td>
			<td width="50"><input class="Estilo10" name="txtcod_modulo" type="hidden" id="txtcod_modulo" value="<?php echo $cod_modulo?>" ></td>
            <td width="88" valign="middle"><input  name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="88">&nbsp;</td>
          </tr>
        </table>
        </form>
    </div>
  </tr>
</table>
</body>
</html>
