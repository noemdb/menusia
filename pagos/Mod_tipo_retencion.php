<?include ("../class/conect.php");  include ("../class/funciones.php"); 
if (!$_GET){  $tipo_retencion='';  $sql="SELECT * FROM RETENCIONES ORDER BY tipo_retencion";}
else {$tipo_retencion = $_GET["Gtipo_retencion"];  $sql="Select * from RETENCIONES where tipo_retencion='$tipo_retencion'";}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGOS (Modificar Tipos de Retenci&oacute;n)</title>
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
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function revisar(){var f=document.form1;
    if(f.txttipo_retencion.value==""){alert("Tipo de Retencion no puede estar Vacio");return false;}
    if(f.txtdescripcion_ret.value==""){alert("Descripción Tipo de Retencion no puede estar Vacia");return false; } else{f.txtdescripcion_ret.value=f.txtdescripcion_ret.value.toUpperCase();}
    if(f.txttipo_retencion.value.length==3){f.txttipo_retencion.value=f.txttipo_retencion.value.toUpperCase();}  else{alert("Longitud Tipo de Retencion Invalida");return false;}
document.form1.submit;
return true;}
function LlamarURL(url){  document.location = url; }
function chequea_fondo(mform){var mref;
   mref=mform.txtcod_fondo.value;   mref = Rellenarizq(mref,"0",3);   mform.txtcod_fondo.value=mref;
return true;}
</script>

</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){  $registro=pg_fetch_array($res,0);  $tipo_retencion=$registro["tipo_retencion"];  $descripcion_ret=$registro["descripcion_ret"];
  $ret_anticipo=$registro["ret_anticipo"];  $ret_grupo=$registro["ret_grupo"];  $cod_contable=$registro["cod_contable"];  $cod_fondo=$registro["cod_fondo"];
  $ced_rif=$registro["ced_rif_ret"];  $tasa=$registro["tasa"];  $base_imponible=$registro["base_imponible"];  $pago_mayor=$registro["pago_mayor"];
  $sustraendo=$registro["sustraendo"];  $red_operacion=$registro["red_operacion"];  $status_1=$registro["status_1"];  $status_2=$registro["status_2"];
  $nombre=$registro["nombre"];  $nombre_cuenta=$registro["nombre_cuenta"];  $inf_usuario=$registro["inf_usuario"];
}
$tasa=formato_monto($tasa); $base_imponible=formato_monto($base_imponible); $pago_mayor=formato_monto($pago_mayor);$sustraendo=formato_monto($sustraendo);
if($ret_grupo=="O"){$ret_grupo="OTROS";}if($ret_grupo=="N"){$ret_grupo="NOMINA";}
if($ret_grupo=="I"){$ret_grupo="ISLR";}if($ret_grupo=="A"){$ret_grupo="IVA";}
if($ret_grupo=="L"){$ret_grupo="LABORAL";}if($ret_grupo=="F"){$ret_grupo="FIEL CUMPLIMIENTO";}
if($ret_grupo=="R"){$ret_grupo="RESPONSABILIDAD";}if($ret_grupo=="T"){$ret_grupo="TIMBRE FISCAL";}
if($ret_grupo=="M"){$ret_grupo="MINERALES";} if($ret_grupo=="E"){$ret_grupo="ACT ECONOMICA";}
if($red_operacion=="S"){$red_operacion="SI";}else{$red_operacion="NO";}
if($status_1=="S"){$status_1="SI";}else{$status_1="NO";}
if($status_2=="S"){$status_2="SI";}else{$status_2="NO";}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR TIPOS DE RETENCIONES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="440" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="438" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_tipo_retencion.php?Gtipo_retencion=<? echo $tipo_retencion; ?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_tipo_retencion.php?Gtipo_retencion=<? echo $tipo_retencion; ?>">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
          <div id="Layer1" style="position:absolute; width:872px; height:346px; z-index:1; top: 65px; left: 112px;">
      <form name="form1" method="post" action="Update_tipo_retencion.php" onSubmit="return revisar()">
        <table width="808" height="252" border="0" align="center" >
          <tr>
            <td height="14">&nbsp;</td>
          </tr>
          <tr>
            <td height="14"><table width="844" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="59"><span class="Estilo5">TIPO :</span></td>
                  <td width="93"><div align="left"><span class="Estilo5"> <input class="Estilo10" name="txttipo_retencion" type="text" id="txttipo_retencion" size="6" maxlength="3" value="<?echo $tipo_retencion?>" readonly> </span></div></td>
                  <td width="113"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                  <td width="562"><span class="Estilo5"><input class="Estilo10" name="txtdescripcion_ret" type="text" id="txtdescripcion_ret" size="80" value="<?echo $descripcion_ret?>"  onFocus="encender(this)" onBlur="apagar(this)">  </span></td>
                  <td width="17">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="14">&nbsp;</td>
          </tr>
          <tr>
            <td height="14"><table width="835" height="18" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="60"><span class="Estilo5">TASA :</span></td>
                  <td width="167"><span class="Estilo5"><input class="Estilo10" name="txttasa" type="text" id="txttasa" size="8" maxlength="6"  value="<?echo $tasa?>" onFocus="encender(this)" onBlur="apagar(this)" style="text-align:right" onKeypress="return validarNum(event)" >    </span></td>
                  <td width="130"><span class="Estilo5">BASE IMPONIBLE :</span></td>
                  <td width="168"><span class="Estilo5"><input class="Estilo10" name="txtbase_imponible" type="text" id="txtbase_imponible" size="8" maxlength="6"  value="<?echo $base_imponible?>" onFocus="encender(this)" onBlur="apagar(this)" style="text-align:right" onKeypress="return validarNum(event)">  </span></td>
                  <td width="136"><span class="Estilo5">PAGOS MAYOR A :</span></td>
                  <td width="174"><span class="Estilo5"> <input class="Estilo10" name="txtpago_mayor" type="text" id="txtpago_mayor" size="18" maxlength="16"  value="<?echo $pago_mayor?>" onFocus="encender(this)" onBlur="apagar(this)" style="text-align:right" onKeypress="return validarNum(event)">  </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="14">&nbsp;</td>
          </tr>
          <tr>
            <td height="14"><table width="835" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="100"><span class="Estilo5">SUSTRAENDO:</span></td>
                  <td width="164"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtsustraendo" type="text" id="txtsustraendo" size="18" maxlength="15"  value="<?echo $sustraendo?>" onFocus="encender(this)" onBlur="apagar(this)" style="text-align:right" onKeypress="return validarNum(event)">  </span></div></td>
                  <td width="159"><span class="Estilo5">REDONDEA OPERACI&Oacute;N: </span></td>
                  <td width="95"><span class="Estilo5"><select name="txtred_operacion" size="1" id="txtred_operacion" onFocus="encender(this)" onBlur="apagar(this)">
                      <option>NO</option> <option>SI</option>       </select> </span></td>
<script language="JavaScript" type="text/JavaScript">
function asig_grupo(mvalor){
var f=document.form1;
    if(mvalor=="OTROS"){document.form1.txtret_grupo.options[0].selected = true;}
    if(mvalor=="NOMINA"){document.form1.txtret_grupo.options[1].selected = true;}
    if(mvalor=="ISLR"){document.form1.txtret_grupo.options[2].selected = true;}
    if(mvalor=="IVA"){document.form1.txtret_grupo.options[3].selected = true;}
    if(mvalor=="LABORAL"){document.form1.txtret_grupo.options[4].selected = true;}
    if(mvalor=="FIEL CUMPLIMIENTO"){document.form1.txtret_grupo.options[5].selected = true;}	
	if(mvalor=="TIMBRE FISCAL"){document.form1.txtret_grupo.options[6].selected = true;}
	if(mvalor=="RESPONSABILIDAD"){document.form1.txtret_grupo.options[7].selected = true;}
	if(mvalor=="MINERALES"){document.form1.txtret_grupo.options[8].selected = true;}
    if(mvalor=="ACT ECONOMICA"){document.form1.txtret_grupo.options[9].selected = true;}
}
</script>
                  <td width="151"><span class="Estilo5">GRUPO DE RETENCI&Oacute;N :</span></td>
                  <td width="166"><div align="left"><span class="Estilo5"><select name="txtret_grupo" size="1" id="txtret_grupo" onFocus="encender(this)" onBlur="apagar(this)">
                      <option selected>OTROS</option> <option>NOMINA</option>
                       <option>ISLR</option> <option>IVA</option>
                      <option>LABORAL</option>          <option>FIEL CUMPLIMIENTO</option>
					  <option>TIMBRE FISCAL</option>    <option>RESPONSABILIDAD</option>  <option>MINERALES</option> <option>ACT ECONOMICA</option>
                    </select></span></div></td>
<script language="JavaScript" type="text/JavaScript"> asig_grupo('<?echo $ret_grupo;?>');</script>                  
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="14">&nbsp;</td>
          </tr>
          <tr>
            <td height="14"><table width="824" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="136"><span class="Estilo5">C&Oacute;DIGO CONTABLE :</span></td>
                  <td width="185"><span class="Estilo5"> <input class="Estilo10" name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta" size="25" maxlength="25" value="<?echo $cod_contable?>" onFocus="encender(this)" onBlur="apagar(this)">  </span></td>
                  <td width="49"><div align="left"><span class="Estilo5"><input class="Estilo10" name="btcuentas" type="button" id="btcuentas" title="Abrir Catalogo C&oacute;digo de Cuentas"  onClick="VentanaCentrada('../contabilidad/Cat_cuentas_cargables.php?criterio=','SIA','','750','500','true')" value="..."> </span></div></td>
                  <td width="454"><span class="Estilo5"><input class="Estilo10" name="txtNombre_Cuenta" type="text" id="txtNombre_Cuenta" value="<?echo $nombre_cuenta?>" size="67" readonly>  </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td width="883" height="14">&nbsp;</td>
          </tr>
          <tr>
            <td><table width="834">
                <tr>
                  <td width="154"><span class="Estilo5">CED./RIF BENEFICIARIO:</span></td>
                  <td width="138"><span class="Estilo5"><input class="Estilo10" name="txtced_rif" type="text" id="txtced_rif" size="20" maxlength="15" value="<?echo $ced_rif?>" onFocus="encender(this)" onBlur="apagar(this)">  </span></td>
                  <td width="52"><span class="Estilo5"> <input class="Estilo10" name="btced_rif" type="button" id="btced_rif" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('../presupuesto/Cat_beneficiarios.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                  <td width="470"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="70" value="<?echo $nombre?>" readonly> </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="14">&nbsp;</td>
          </tr>
          <tr>
            <td height="24"><table width="843" border="0" cellspacing="0" cellpadding="0">
                <tr>
<script language="JavaScript" type="text/JavaScript">
function asig_genera(mvalor){var f=document.form1;
    if(mvalor=="SI"){document.form1.txtstatus_1.options[0].selected = true;}else{document.form1.txtstatus_1.options[1].selected = true;}}
</script>
                  <td width="276" height="22"><span class="Estilo5">GENERAR ASIENTO EN EL COMPROBANTE :</span></td>
                  <td width="230"><div align="left"><span class="Estilo5"><select name="txtstatus_1" size="1" id="txtstatus_1" onFocus="encender(this)" onBlur="apagar(this)">
                      <option>SI</option>   <option>NO</option> </select></span></div></td>
<script language="JavaScript" type="text/JavaScript"> asig_genera('<?echo $status_1;?>');</script>
                  
                  <td width="148"><span class="Estilo5">RETENCI&Oacute;N PARCIAL :</span></td>
                  <td width="189"><span class="Estilo5"><select name="txtstatus_2" size="1" id="txtstatus_2" onFocus="encender(this)" onBlur="apagar(this)">
                      <option>NO</option>     <option>SI</option></select></span></td>
                </tr>
            </table></td>
          </tr>
          <tr><td height="14">&nbsp;</td></tr>
		  <tr>
                  <td height="24"><table width="843" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="300" height="22"><span class="Estilo5">CODIGO DEL CONCEPTO DE RETENCION  :</span></td>
                      <td width="543"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtcod_fondo" type="text" id="txtcod_fondo" size="6" maxlength="3" value="<?echo $cod_fondo?>"  onFocus="encender(this)" onBlur="apagar(this)"  onchange="chequea_fondo(this.form);">
                      </span></div></td>
                    </tr>
                  </table></td>
           </tr>
          <tr>
            <td height="14">&nbsp;</td>
          </tr>
        </table>
        <table width="768">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="88"><input name="Submit2" type="reset" value="Blanquear"></td>
          </tr>
        </table>
        <p>&nbsp;</p>
        </form>
    </div>
    </td>
  </tr>
</table>
</body>
</html>
