<?php include ("../class/seguridad.inc");include ("../class/conects.php");include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $cod_modulo="13";
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{?><script language="JavaScript"> document.location='menu.php';</script><?}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONFIGURACI&Oacute;N CONTROL BIENES NACIONALES</title>
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
    if(f.txtLogin.value==""){alert("Login no puede estar Vacio");return false;}          else{f.txtLogin.value=f.txtLogin.value.toUpperCase();}       
document.form1.submit;
return true;}
function LlamarURL(url) {document.location = url;}
</script>
</head>
<?php
$formato_bien=""; $long_num_bien=0; $periodo="01"; $campo502=""; $doc_caus_inm=""; $doc_caus_mue=""; $doc_caus_sem=""; $cod_fuente="00"; $doc_comp=""; $ref_comp="";
$sql="Select * from SIA005 where campo501='$cod_modulo'";$resultado=pg_query($sql);
if($registro=pg_fetch_array($resultado,0)){$cod_modulo=$registro["campo501"]; $campo502=$registro["campo502"]; $periodo=$registro["campo503"]; 
$formato_bien=$registro["campo504"];$long_num_bien=$registro["campo549"]; $cod_fuente=$registro["campo512"]; $doc_comp=$registro["campo513"];
$doc_caus_inm=$registro["campo509"]; $doc_caus_mue=$registro["campo510"]; $doc_caus_sem=$registro["campo511"]; $ref_comp=$registro["campo514"];
}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CONFIGURACI&Oacute;N CONTROL DE BIENES NACIONALES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="490" border="1">
  <tr>
    <td width="92"><table width="92" height="489" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick=javascript:LlamarURL('menu_conf.php');
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu_conf.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu Principal</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="892"><div id="Layer1" style="position:absolute; width:868px; height:491px; z-index:1; top: 65px; left: 112px;">
      <form name="form1" method="post" action="Update_conf_bienes.php" onSubmit="return revisar()">
        <table width="824" border="0" align="center" cellpadding="0" cellspacing="0">         
          <tr><td>&nbsp;</td></tr>
          <tr>
            <td><table width="820" border="1" cellspacing="2" cellpadding="0">
              <tr>
                <td width="800" height="24"><table width="800" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="150"><span class="Estilo5">FORMATO DEL BIEN:</span></td>
                    <td width="300"><input class="Estilo10" name="txtformato_bien" type="text" id="txtformato_bien" title="Formato del Bien" size="25" maxlength="30" value="<?echo $formato_bien ?>"  onFocus="encender(this)" onBlur="apagar(this)"></td>
                    <td width="230"><span class="Estilo5">LONGUITUD N&Uacute;MERO DEL BIEN:</span></td>
                    <td width="120"> <div align="left"><input class="Estilo10" name="txtlong_num_bien" type="text" id="txtlong_num_bien" title="Longitud Numero del Bien" size="4" maxlength="2" value="<?echo $long_num_bien ?>" onFocus="encender(this)" onBlur="apagar(this)"></div></td></tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr><td>&nbsp;</td></tr>          
          <tr>
            <td><table width="519" border="1" cellspacing="0" cellpadding="2">
              <tr>
                <td><table width="436" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					 <td width="356"><span class="Estilo5">GENERA CAUSADO PRESUPUESTARIO:</span></td>
					 <td width="70"><div align="center"><span class="Estilo5"><select name="txtgencaus_p" size="1"> <?if(substr($campo502,2,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?}else{?><option>SI</option> <option selected>NO</option> </select> <?}?> </span></div></td>
				 </tr>
                </table></td>
              </tr>
              <tr>
                <td><table width="512" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="379"><span class="Estilo5"> DOCUMENTO CAUSADO BIEN INMUEBLE:</span></td>
                    <td width="132"><input class="Estilo10" name="txtdoc_caus_inm" type="text" id="txtdoc_caus_inm"  size="6" maxlength="4" value="<?echo $doc_caus_inm ?>"  onFocus="encender(this)" onBlur="apagar(this)"></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td><table width="511" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="379"><span class="Estilo5"> DOCUMENTO CAUSADO BIEN MUEBLE:</span></td>
					<td width="132"><input class="Estilo10" name="txtdoc_caus_mue" type="text" id="txtdoc_caus_mue"  size="6" maxlength="4" value="<?echo $doc_caus_mue ?>"  onFocus="encender(this)" onBlur="apagar(this)"></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td><table width="510" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="378"><span class="Estilo5"> DOCUMENTO CAUSADO BIEN SEMOVIENTE:</span></td>
					<td width="132"><input class="Estilo10" name="txtdoc_caus_sem" type="text" id="txtdoc_caus_sem"  size="6" maxlength="4" value="<?echo $doc_caus_sem ?>"  onFocus="encender(this)" onBlur="apagar(this)"></td>
                  </tr>
                </table></td>
              </tr>
			  <tr>
                <td><table width="511" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="379"><span class="Estilo5"> FUENTE DE FINANCIAMIENTO DEL CAUSADO:</span></td>
					<td width="132"><input class="Estilo10" name="txtcod_fuente" type="text" id="txtcod_fuente"  size="4" maxlength="2" value="<?echo $cod_fuente ?>"  onFocus="encender(this)" onBlur="apagar(this)"></td>
                  </tr>
                </table></td>
              </tr>
			  <tr>
                <td><table width="511" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="211"><span class="Estilo5"> DOCUMENTO COMPROMISO :</span></td>
					<td width="100"><input class="Estilo10" name="txtdoc_comp" type="text" id="txtdoc_comp"  size="6" maxlength="4" value="<?echo $doc_comp ?>"  onFocus="encender(this)" onBlur="apagar(this)"></td>
					<td width="200"><span class="Estilo5"> REFERENCIA COMPROMISO :</span></td>
					<td width="100"><input class="Estilo10" name="txtref_comp" type="text" id="txtref_comp"  size="10" maxlength="8" value="<?echo $ref_comp ?>"  onFocus="encender(this)" onBlur="apagar(this)"></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
			
          </tr>
          <tr><td>&nbsp;</td></tr>
          <tr>
            <td><table width="520" height="17" border="1" cellpadding="0" cellspacing="1">
              <tr>
                <td><table width="436" height="19" border="0" cellpadding="0">
                    <tr>
                      <td width="356"><span class="Estilo5"> N&Uacute;MERO DEL BIEN UNICO :</span></td>
					  <td width="70"><div align="center"><span class="Estilo5"><select name="txtnumbien_unico" size="1"> <?if(substr($campo502,3,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?}else{?><option>SI</option> <option selected>NO</option> </select> <?}?> </span></div></td>
					 </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr><td>&nbsp;</td></tr>
		  <tr>
            <td><table width="520" height="17" border="1" cellpadding="0" cellspacing="1">
              <tr>
                <td><table width="436" height="19" border="0" cellpadding="0">
                    <tr>
                      <td width="356"><span class="Estilo5"> VALIDAR DESCRIPCI&Oacute;N DEL BIEN :</span></td>
					  <td width="70"><div align="center"><span class="Estilo5"><select name="txtvalida_des" size="1"> <?if(substr($campo502,4,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?}else{?><option>SI</option> <option selected>NO</option> </select> <?}?> </span></div></td>
					 </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr><td>&nbsp;</td></tr>
          <tr>
            <td><table width="520" height="17" border="1" cellpadding="0" cellspacing="1">
              <tr>
                <td><table width="436" height="19" border="0" cellpadding="0">
                    <tr>
                      <td width="356"><span class="Estilo5"> MODIFICAR DEPENDENCIA SOLO TRANSFERENCIA:</span></td>
					  <td width="70"><div align="center"><span class="Estilo5"><select name="txtmod_dep" size="1"> <?if(substr($campo502,6,1)=="S"){ ?><option selected>SI</option> <option>NO</option> </select><?}else{?><option>SI</option> <option selected>NO</option> </select> <?}?> </span></div></td>
					 </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>		  
          <tr><td>&nbsp;</td></tr>
          <tr>
            <td><table width="520" height="17" border="1" cellpadding="0" cellspacing="1" dwcopytype="CopyTableRow">
              <tr>
                <td ><table width="436" height="19" border="0" cellpadding="0">
                    <tr>
                      <td width="356"><span class="Estilo5">PERIODO TRABAJO DESDE DEL M&Oacute;DULO:</span></td>
                      <td width="70"><div align="center"><span class="Estilo5"><input class="Estilo10" name="txtperiodo" type="text" id="txtperiodo"  size="04" maxlength="200"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $periodo ?>">   </span></div></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr><td>&nbsp;</td></tr>
          <tr><td>&nbsp;</td></tr>
        </table>
        <table width="768">
          <tr>
            <td width="614">&nbsp;</td>
			<td width="50"><input  name="txtcod_modulo" type="hidden" id="txtcod_modulo" value="<?echo $cod_modulo?>" ></td>
            <td width="88" valign="middle"><input  name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="88"></td>
          </tr>
        </table>
        
        </form>
    </div>

  </tr>
</table>
</body>
</html>
<? pg_close(); ?>