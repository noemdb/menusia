<?php include ("../class/seguridad.inc");include ("../class/conects.php");include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{?><script language="JavaScript"> document.location='menu.php';</script><?}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONFIGURACI&Oacute;N Y MANTENIMIENTO (Configuracion General de Institucion)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<SCRIPT language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_emp.js" type="text/javascript"></script>
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
    if(f.txtnomb_abrev.value==""){alert("Nombre no puede estar Vacio");return false;} else{f.txtnomb_abrev.value=f.txtnomb_abrev.value.toUpperCase();}
    if(f.txtnombre_Comp.value==""){alert("Nombre Completo no puede estar Vacia");return false;} else{f.txtnombre_Comp.value=f.txtnombre_Comp.value.toUpperCase();}
    if(f.txtdireccion.value==""){alert("Direccion no puede estar Vacio");return false;} else{f.txtdireccion.value=f.txtdireccion.value.toUpperCase();}
document.form1.submit;
return true;}
function LlamarURL(url) {document.location = url;}
</script>
</head>
<?php
$direccion=""; $nombre=""; $nom_comp=""; $rif=""; $nit=""; $telefono=""; $fax=""; $str1="NO"; $str2="NO"; $fecha_ini="2011-01-01"; $fecha_fin="2011-12-31"; $periodo="01"; $correo=""; $tasa_iva=0; $monto_ut=0; $definicion="N"; $tam_logo=20;
$sql="Select * from SIA000 order by campo001";$resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$cod_emp=$registro["campo001"];
$direccion=$registro["campo006"]; $nombre=$registro["campo004"]; $nom_comp=$registro["campo005"]; $rif=$registro["campo007"]; $nit=$registro["campo008"];  $definicion=$registro["campo034"];
$telefono=$registro["campo012"];$fax=$registro["campo013"]; $fecha_ini=$registro["campo031"];$fecha_fin=$registro["campo032"]; $periodo=$registro["campo033"]; $pagina=$registro["campo015"]; $parroquia=$registro["campo040"]; $tam_logo=$registro["campo057"];
$region=$registro["campo041"];$estado=$registro["campo010"];$municipio=$registro["campo011"];$ciudad=$registro["campo009"]; $correo=$registro["campo014"]; $str1=$registro["campo049"]; $str2=$registro["campo050"]; $tasa_iva=$registro["campo056"]; $monto_ut=$registro["campo055"]; }
if($fecha_ini==""){$fecha_ini="";}else{$fecha_ini=formato_ddmmaaaa($fecha_ini);} if($fecha_fin==""){$fecha_fin="";}else{$fecha_fin=formato_ddmmaaaa($fecha_fin);}
$cod_estado="00"; $Ssql="SELECT * FROM pre091 where estado='".$estado."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$cod_estado=$registro["cod_estado"];}
if($municipio==""){$municipio="IRIBARREN";} if($ciudad==""){$ciudad="BARQUISIMETO";}
$monto_ut=formato_monto($monto_ut);$tasa_iva=formato_monto($tasa_iva); if($tam_logo==0){$tam_logo=20;}
?>
<script language="JavaScript" type="text/JavaScript">
function chequea_estado(mform){ var cod_edo="00"; cod_edo=mform.txtestado.value;
ajaxSenddoc('GET', 'cargamunicipio.php?municipio=<? echo $municipio;?>&cod_estado='+cod_edo, 'municipio', 'innerHTML');
ajaxSenddoc('GET', 'cargaciudad.php?ciudad=<? echo $ciudad;?>&cod_estado='+cod_edo, 'ciudad', 'innerHTML');
return true;}
</script>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CONFIGURACI&Oacute;N GENERAL DE LA INSTITUCION </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="590" border="1">
  <tr>
    <td width="92"><table width="92" height="590" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('menu_conf.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu_conf.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu Principal</A></td>
      </tr>
    <td>&nbsp;</td>
    </table></td> 
    <td width="869"><div id="Layer1" style="position:absolute; width:868px; height:348px; z-index:1; top: 65px; left: 121px;">
      <form name="form1" method="post" action="Update_configuracion.php" onSubmit="return revisar()">
        <table width="850" height="306" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="850" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="188"><span class="Estilo5">NOMBRE ABREV. O SIGLAS:</span> </td>
                <td width="632"><span class="Estilo5"><input class="Estilo10" name="txtnomb_abrev" type="text" id="txtnomb_abrev" title="Registre Nombre" size="100" maxlength="200" value="<?echo $nombre?>" readonly ></span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="850" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="188"><span class="Estilo5">NOMBRE COMPLETO : </span></td>
                <td width="632"><span class="Estilo5"><input class="Estilo10" name="txtnombre_Comp" type="text" id="txtnombre_Comp" title="Registre Nombre Completo" size="100" maxlength="200" value="<?echo $nom_comp?>" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="820" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="188"><span class="Estilo5">DIRECCION :</span></td>
                <td width="632"><span class="Estilo5"><textarea name="txtdireccion" cols="70" onFocus="encender(this)" onBlur="apagar(this)" class="headers" id="txtdireccion"><?echo $direccion?></textarea></span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="840" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="188"><span class="Estilo5">REGION :</span></td>
                <td width="310"><span class="Estilo5"><div id="region"><select name="txtregion" id="txtregion" onFocus="encender(this)" onBlur="apagar(this);">
                  <option><? echo $region;?></option> </div> </span></td>
                <script language="JavaScript" type="text/JavaScript">ajaxSenddoc('GET', 'cargaregiones.php?mregion=<? echo $region;?>', 'region', 'innerHTML'); </script>
                <td width="82"><span class="Estilo5">ESTADO :</span> </td>
                <td width="260"><span class="Estilo5"><div id="estado"><select name="txtestado" id="txtestado" onFocus="encender(this)" onBlur="apagar(this);"  onchange="chequea_estado(this.form)">
                <option value="<? echo $cod_estado;?>"><? echo $estado;?></option></div></span></td>
                <script language="JavaScript" type="text/JavaScript">ajaxSenddoc('GET', 'cargaentidades.php?mestado=<? echo $estado;?>', 'estado', 'innerHTML'); </script>
  </tr>
</table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="840" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="188"><span class="Estilo5">MUNICIPIO :</span></td>
                <td width="310"<div id="municipio"><select name="txtmunicipio" id="txtmunicipio" onFocus="encender(this)" onBlur="apagar(this);">
                  <option><? echo $municipio;?></option> </div></span></td>
                  <script language="JavaScript" type="text/JavaScript">var cod_e='01'; cod_e=document.form1.txtestado.value; ajaxSenddoc('GET', 'cargamunicipio.php?municipio=<? echo $municipio;?>&cod_estado='+cod_e, 'municipio', 'innerHTML'); </script>
                <td width="82"><span class="Estilo5">CUIDAD :</span></td>
                <td width="260"><div id="ciudad"><select name="txtciudad" id="txtciudad" onFocus="encender(this)" onBlur="apagar(this);">
                  <option><? echo $ciudad;?></option> </div></span></td>
                  <script language="JavaScript" type="text/JavaScript">var cod_e='01'; cod_e=document.form1.txtestado.value; ajaxSenddoc('GET', 'cargaciudad.php?ciudad=<? echo $ciudad;?>&cod_estado='+cod_e, 'ciudad', 'innerHTML'); </script>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="840" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableRow">
              <tr>
                <td width="188"><span class="Estilo5">RIF :</span></td>
                <td width="310"><span class="Estilo5"><input class="Estilo10" name="txtrif" type="text" id="txtrif" title="Registre Nùmero de Rif" size="28" maxlength="12"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $rif?>"></span></td>
                <td width="82"><span class="Estilo5">NIT :</span></td>
                <td width="260"><span class="Estilo5"><input class="Estilo10" name="txtnit" type="text" id="txtnit" title="Registre Nit" size="28" maxlength="12"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $nit?>"></span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="840" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableRow">
              <tr>
                <td width="188"><span class="Estilo5">TELEFONO :</span></td>
                <td width="310"><span class="Estilo5"><input class="Estilo10" name="txttelefono" type="text" id="txttelefono" title="Registre Numero de Telefono" size="28" maxlength="16"  onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $telefono?>" ></span></td>
                <td width="82"><span class="Estilo5">FAX :</span></td>
                <td width="260"><span class="Estilo5"><input class="Estilo10" name="txtfax" type="text" id="txtfax" title="Registre Numero de Fax" size="28" maxlength="16"  onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $fax?>" ></span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="844" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableRow">
              <tr>
                <td width="188"><span class="Estilo5">FECHA INICIO EJERCICIO :</span></td>
                <td width="259"><span class="Estilo5"><input class="Estilo10" name="txtfecha_ini" type="text" id="txtfecha_ini" title="Registre Fecha Inicio de Ejercicio" size="20" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_ini?>"></span></td>
                <td width="160"><span class="Estilo5">FECHA FINAL EJERCICO :</span></td>
                <td width="237"><span class="Estilo5"><input class="Estilo10" name="txtfecha_fin" type="text" id="txtfecha_fin" title="Registre Fecha Fin de Ejercicio" size="20" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_fin?>"></span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="844" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableRow">
              <tr>
                <td width="188"><span class="Estilo5">PERIODO TRABAJO DESDE:</span></td>
                <td width="261"><span class="Estilo5"><input class="Estilo10" name="txtperiodo" type="text" id="txtperiodo" title="Registre Periodo de Trabajo desde" size="4" maxlength="2"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $periodo?>"></span></td>
                <td width="76"><span class="Estilo5">EMAIL :</span></td>
                <td width="319"><span class="Estilo5"><input class="Estilo10" name="txtmail" type="text" id="txtmail" title="Registre Correo electronico" size="45" maxlength="50"  onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $correo?>"></span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="840" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableRow">
              <tr>
                <td width="194"><span class="Estilo5">MONTO UNIDAD TRIBUTARIA :</span></td>
                <td width="256"><span class="Estilo5"><input class="Estilo10" name="txtmonto_ut" type="text" id="txtmonto_ut" title="Registre Monto de la Unidad Tributaria" size="15" maxlength="20" aling="left" onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $monto_ut?>"></span></td>
                <td width="240"><span class="Estilo5">ALICUOTA (%) GENERAL DEL IVA :</span></td>
                <td width="150"><span class="Estilo5"><input class="Estilo10" name="txttasa_iva" type="text" id="txttasa_iva" title="Registre Monto de la Tasa del Iva" size="15" maxlength="5"  onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $tasa_iva?>"></span></td>
              </tr>
            </table></td>
          </tr>
          <tr> <td>&nbsp;</td>  </tr>
		   <tr>
            <td><table width="840" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableRow">
              <tr>
                <td width="320"><span class="Estilo5">REALIZAR CONVERSION A UTF8 EN REPORTES PDF :</span></td>				
                <td width="130"><span class="Estilo5"><select name="txtstr1" size="1"> <?if(substr($str1,0,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?}else{?><option>SI</option> <option selected>NO</option> </select> <?}?></span></td>
                <td width="290"><span class="Estilo5">UTILIZAR REPORTES PDF COMO PRINCIPAL :</span></td>
				<td width="100"><span class="Estilo5"><select name="txtstr2" size="1"> <?if(substr($str2,0,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?}else{?><option>SI</option> <option selected>NO</option> </select> <?}?></span></td>
                
              </tr>
            </table></td>
          </tr>
          <tr> <td height="12">&nbsp;</td>  </tr>
		  <tr>
            <td><table width="840" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableRow">
              <tr>
                <td width="194"><span class="Estilo5">TAMA&Ntilde;O LOGO DE REPORTES PDF :</span></td>
                <td width="256"><span class="Estilo5"><input class="Estilo10" name="txttam_logo" type="text" id="txttam_logo"  size="5" maxlength="5" onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $tam_logo?>"></span></td>
                <td width="390"><span class="Estilo5"></span></td>              
			  </tr>
            </table></td>
          </tr>
          <tr> <td>&nbsp;</td>  </tr>
        </table>
        <table width="800">
          <tr>
            <td width="28"><input class="Estilo10" name="txtcod_emp" type="hidden" id="txtcod_emp" value="<?echo $cod_emp?>" ></td>
            <td width="28"><input class="Estilo10" name="txtparroquia" type="hidden" id="txtparroquia" value="<?echo $parroquia?>" ></td>
            <td width="44"><input class="Estilo10" name="txtweb" type="hidden" id="txtweb" value="<?echo $pagina?>" ></td>
            <? if($definicion=="N"){?>  <td width="212">&nbsp;</td>
            <? } else { ?> <td width="212" align="center"><input  name="ABRIR ETAPA" type="button" id="ABRIR ETAPA" value="ABRIR ETAPA" onClick="JavaScript:LlamarURL('Act_definicion.php?Gdefinicion=N')"></td>
            <? } if($definicion=="N"){?>  <td width="212" align="center"><input name="CERRAR ETAPA" type="button" id="CERRAR ETAPA" value="CERRAR ETAPA" onClick="JavaScript:LlamarURL('Act_definicion.php?Gdefinicion=C')"></td>
            <? } else { ?>         <td width="212">&nbsp;</td>        <? } ?>
            <td width="130">&nbsp;</td>
            <td width="101" valign="middle"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
            <td width="8">&nbsp;</td>
          </tr>
        </table>
        <div align="right"></div>
        <div align="right"></div>
        <p>&nbsp;</p>
        </form>
    </div>
  </tr>
</table>
</body>
</html>
<? pg_close();?>
