<?php include ("../class/seguridad.inc");include ("../class/conects.php");include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $cod_modulo="06";
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
<title>SIA CONFIGURACI&Oacute;N CONTABILIDAD FISCAL</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js"  type="text/javascript"></script>
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
    if(f.txtformato.value==""){alert("Formato no puede estar Vacio");return false;} else{f.txtformato.value=f.txtformato.value.toUpperCase();}
document.form1.submit;
return true;}
function LlamarURL(url) {document.location = url;}
</script> 
</head>
<?php
$formato=""; $periodo="01"; $campo502=""; $activo="";  $pasivo="";  $ingreso=""; $egreso=""; $resultado=""; $capital=""; 
$sit_finan="";  $sit_fiscal=""; $hacienda="";$ejec_presup="";  $superavit=""; $caja=""; $anticipo=""; $fondo_avance="";
$sql="Select * from SIA005 where campo501='$cod_modulo'";$resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$cod_modulo=$registro["campo501"]; $campo502=$registro["campo502"]; $periodo=$registro["campo503"]; $formato=$registro["campo504"];
$activot=$registro["campo505"]; $pasivot=$registro["campo506"]; $activoh=$registro["campo507"]; $pasivoh=$registro["campo508"];
$ingreso=$registro["campo510"]; $egreso=$registro["campo509"]; $resultado=$registro["campo511"]; $capital=$registro["campo512"]; 
$sit_finan=$registro["campo513"]; $sit_fiscal=$registro["campo514"]; $ejec_presup=$registro["campo515"]; $hacienda=$registro["campo516"]; 
$superavit=$registro["campo517"]; $caja=$registro["campo518"]; $anticipo=$registro["campo520"]; $fondo_avance=$registro["campo519"];
}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CONFIGURACI&Oacute;N CONTABILIDAD FISCAL </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="495" border="1">
  <tr>
    <td width="92"><table width="92" height="487" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
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
    <td width="870"><div id="Layer1" style="position:absolute; width:868px; height:473px; z-index:1; top: 65px; left: 112px;">
      <form name="form1" method="post" action="Update_conf_fiscal.php" onSubmit="return revisar()">
        <table width="824" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> <td>&nbsp;</td> </tr>          
          <tr>
            <td><table width="817" height="17" border="1" cellpadding="0" cellspacing="1" dwcopytype="CopyTableRow">
              <tr>
                <td width="523"><table width="518" height="19" border="0" cellpadding="0">
                    <tr>
                      <td width="269"><span class="Estilo5">FORMATO DE CUENTA CONTABLE  :</span></td>
                      <td width="243"><span class="Estilo5"> <input class="Estilo10" name="txtformato" type="text" id="txtformato"  size="40" maxlength="32" value="<?php echo $formato?>"  onFocus="encender(this)" onBlur="apagar(this)">
                      </span></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr> <td>&nbsp;</td> </tr>
          <tr>
            <td><table width="342" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="12">&nbsp;</td>
                <td width="330"><span class="Estilo11">DEFINICI&Oacute;N DE CUENTAS</span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="817" border="1" cellspacing="2" cellpadding="0">
              <tr>
                <td width="403"><table width="387" height="19" border="0" cellpadding="0">
                  <tr>
                    <td width="221"><span class="Estilo5">ACTIVOS DEL TESORO:</span></td>
                    <td width="149"><div align="left"><span class="Estilo5">
                      <input class="Estilo10" name="txtactivot" type="text" id="txtactivot" size="25" maxlength="25" value="<?php echo $activot?>"  onFocus="encender(this)" onBlur="apagar(this)">
                     </span></div></td>
                  </tr>
                </table></td>
                <td width="402"><table width="387" height="19" border="0" cellpadding="0">
                  <tr>
                    <td width="221"><span class="Estilo5">PASIVOS DEL TESORO :</span></td>
                    <td width="149"><div align="left"><span class="Estilo5">
                        <input class="Estilo10" name="txtpasivot" type="text" id="txtpasivot"  size="25" maxlength="25" value="<?php echo $pasivot?>"  onFocus="encender(this)" onBlur="apagar(this)">
                    </span></div></td>
                  </tr>
                </table></td>
              </tr>
			  
			  <tr>
                <td width="403"><table width="387" height="19" border="0" cellpadding="0">
                  <tr>
                    <td width="221"><span class="Estilo5">ACTIVOS DE LA HACIENDA:</span></td>
                    <td width="149"><div align="left"><span class="Estilo5">
                      <input class="Estilo10" name="txtactivoh" type="text" id="txtactivoh" size="25" maxlength="25" value="<?php echo $activoh?>"  onFocus="encender(this)" onBlur="apagar(this)">
                     </span></div></td>
                  </tr>
                </table></td>
                <td width="402"><table width="387" height="19" border="0" cellpadding="0">
                  <tr>
                    <td width="221"><span class="Estilo5">PASIVOS DE LA HACIENDA :</span></td>
                    <td width="149"><div align="left"><span class="Estilo5">
                        <input class="Estilo10" name="txtpasivoh" type="text" id="txtpasivoh"  size="25" maxlength="25" value="<?php echo $pasivoh?>"  onFocus="encender(this)" onBlur="apagar(this)">
                    </span></div></td>
                  </tr>
                </table></td>
              </tr>
			  
			  
              <tr>
                <td><table width="387" height="19" border="0" cellpadding="0">
                  <tr>
                    <td width="221"><span class="Estilo5">INGRESOS DEL PRESUPUESTO :</span></td>
                    <td width="149"><div align="left"><span class="Estilo5">
                        <input class="Estilo10" name="txtingreso" type="text" id="txtingreso" size="25" maxlength="25" value="<?php echo $ingreso?>"  onFocus="encender(this)" onBlur="apagar(this)">
                    </span></div></td>
                  </tr>
                </table></td>
                <td><table width="387" height="19" border="0" cellpadding="0">
                  <tr>
                    <td width="221"><span class="Estilo5">EGRESOS DEL PRESUPUESTO :</span></td>
                    <td width="149"><div align="left"><span class="Estilo5">
                        <input class="Estilo10" name="txtegreso" type="text" id="txtegreso" size="25" maxlength="25" value="<?php echo $egreso?>"  onFocus="encender(this)" onBlur="apagar(this)">
                    </span></div></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td><table width="387" height="19" border="0" cellpadding="0">
                  <tr>
                    <td width="221"><span class="Estilo5">RESULTADO DEL PRESUPUESTO :</span></td>
                    <td width="149"><div align="left"><span class="Estilo5">
                        <input class="Estilo10" name="txtresultado" type="text" id="txtresultado" size="25" maxlength="25"  value="<?php echo $resultado?>"  onFocus="encender(this)" onBlur="apagar(this)">
                    </span></div></td>
                  </tr>
                </table></td>
                <td><table width="387" height="19" border="0" cellpadding="0">
                  <tr>
                    <td width="221"><span class="Estilo5">PATRIMONIO :</span></td>
                    <td width="149"><div align="left"><span class="Estilo5">
                        <input class="Estilo10" name="txtcapital" type="text" id="txtcapital" size="25" maxlength="25" value="<?php echo $capital?>"  onFocus="encender(this)" onBlur="apagar(this)">
                    </span></div></td>
                  </tr>
                </table></td>
              </tr>
			  
			  
			  <tr>
                <td><table width="387" height="19" border="0" cellpadding="0">
                  <tr>
                    <td width="221"><span class="Estilo5">SITUAC. FINANCIERA DEL TESORO:</span></td>
                    <td width="149"><div align="left"><span class="Estilo5">
                        <input class="Estilo10" name="txtsit_finan" type="text" id="txtsit_finan" size="25" maxlength="25"  value="<?php echo $sit_finan?>"  onFocus="encender(this)" onBlur="apagar(this)">
                    </span></div></td>
                  </tr>
                </table></td>
                <td><table width="387" height="19" border="0" cellpadding="0">
                  <tr>
                    <td width="221"><span class="Estilo5">SITUAC. FISCAL DEL TESORO :</span></td>
                    <td width="149"><div align="left"><span class="Estilo5">
                        <input class="Estilo10" name="txtsit_fiscal" type="text" id="txtsit_fiscal" size="25" maxlength="25" value="<?php echo $sit_fiscal?>"  onFocus="encender(this)" onBlur="apagar(this)">
                    </span></div></td>
                  </tr>
                </table></td>
              </tr>
			  
              <tr>
                <td><table width="387" height="19" border="0" cellpadding="0">
                  <tr>
                    <td width="221"><span class="Estilo5">EJECUCION DEL PRESUPUESTO :</span></td>
                    <td width="149"><div align="left"><span class="Estilo5">
                        <input class="Estilo10" name="txtejec_presup" type="text" id="txtejec_presup" size="25" maxlength="25" value="<?php echo $ejec_presup?>"  onFocus="encender(this)" onBlur="apagar(this)">
                    </span></div></td>
                  </tr>
                </table></td>
                <td><table width="387" height="19" border="0" cellpadding="0">
                  <tr>
                    <td width="221"><span class="Estilo5">CUENTA DE LA HACIENDA :</span></td>
                    <td width="149"><div align="left"><span class="Estilo5">
                        <input class="Estilo10" name="txthacienda" type="text" id="txthacienda"  size="25" maxlength="25" value="<?php echo $hacienda?>" onFocus="encender(this)" onBlur="apagar(this)">
                    </span></div></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td><table width="387" height="19" border="0" cellpadding="0">
                  <tr>
                    <td width="221"><span class="Estilo5">SUPERAVIT/DEFICIT :</span></td>
                    <td width="149"><div align="left"><span class="Estilo5">
                        <input class="Estilo10" name="txtsuperavit" type="text" id="txtsuperavit" size="25" maxlength="25"  value="<?php echo $superavit?>" onFocus="encender(this)" onBlur="apagar(this)">
                    </span></div></td>
                  </tr>
                </table></td>
                <td><table width="387" height="19" border="0" cellpadding="0">
                  <tr>
                    <td width="221"><span class="Estilo5">CUENTA CAJA CHICA :</span></td>
                    <td width="149"><div align="left"><span class="Estilo5">
                        <input class="Estilo10" name="txtcaja" type="text" id="txtcaja" size="25" maxlength="25"  value="<?php echo $caja?>" onFocus="encender(this)" onBlur="apagar(this)">
                    </span></div></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td><table width="387" height="19" border="0" cellpadding="0">
                  <tr>
                    <td width="221"><span class="Estilo5">FONDOS EN AVANCE :</span></td>
                    <td width="149"><div align="left"><span class="Estilo5">
                        <input class="Estilo10" name="txtfondo_avance" type="text" id="txtfondo_avance" size="25" maxlength="25"  value="<?php echo $fondo_avance?>" onFocus="encender(this)" onBlur="apagar(this)">
                    </span></div></td>
                  </tr>
                </table></td>
                <td><table width="387" height="19" border="0" cellpadding="0">
                  <tr>
                    <td width="221"><span class="Estilo5">CUENTA DE ANTICIPO :</span></td>
                    <td width="149"><div align="left"><span class="Estilo5">
                        <input class="Estilo10" name="txtanticipo" type="text" id="txtanticipo" size="25" maxlength="25" value="<?php echo $anticipo?>" onFocus="encender(this)" onBlur="apagar(this)">
                    </span></div></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
		  <tr>
            <td><table width="817" height="17" border="1" cellpadding="0" cellspacing="1" dwcopytype="CopyTableRow">
              <tr>
                <td width="523"><table width="518" height="19" border="0" cellpadding="0">
                    <tr>
                      <td width="269"><span class="Estilo5">PERIODO TRABAJO DESDE DEL MODULO :</span></td>
                      <td width="243"><span class="Estilo5"> <input class="Estilo10" name="txtperiodo" type="text" id="txtperiodo"  size="3" maxlength="2" value="<?php echo $periodo ?>"  onFocus="encender(this)" onBlur="apagar(this)">
                        </span></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          
        
          <tr> <td height="12">&nbsp;</td>  </tr>
          
		  <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
        
        <table width="768">
          <tr>
            <td width="600">&nbsp;</td>
            <td width="100"><input name="txtcod_modulo" type="hidden" id="txtcod_modulo" value="<?php echo $cod_modulo?>" ></td>
            <td width="68" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
          </tr>
        </table>
        </form>
    </div>
  </tr>
</table>
</body>
</html>
<?php pg_close();?>
